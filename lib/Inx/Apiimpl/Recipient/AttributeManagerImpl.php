<?php

/**
 * AttributeManagerImpl
 * 
 * <P>Copyright (c) 2005 Inxmail GmbH. All Rights Reserved.
 * @version $Revision: 2934 $ $Date: 2005-07-04 15:00:09 +0000 (Mo, 04 Jul 2005) $ $Author: bgn $
 */
class Inx_Apiimpl_Recipient_AttributeManagerImpl implements Inx_Api_Recipient_AttributeManager
{

	protected $_oSessionContext;

	protected $_oService;

	
	public function __construct( $oSessionContext )
	{
		$this->_oSessionContext = $oSessionContext;
		$this->_oService = $this->_oSessionContext->getService( Inx_Apiimpl_SessionContext::CORE_SERVICE );
	}
	
	
	public function create( $sAttributeName, $iDataType, $iMaxStringLenth )
	{
	    if (!is_int($iDataType)) {
	        throw new Inx_Api_IllegalArgumentException('Integer parameter type $iDataType expected, got '.gettype($iDataType));
	    }
	    if (!is_int($iMaxStringLenth)) {
	        throw new Inx_Api_IllegalArgumentException('Integer parameter type $iMaxStringLenth expected, got '.gettype($iMaxStringLenth));
	    }
	    try
		{
		    $r = $this->_oService->createAttribute( 
		    	$this->_oSessionContext->sessionId(), 
		    	$sAttributeName, 
		    	$iDataType, 
		    	$iMaxStringLenth
		    );
		    return $r->value;
		} 
		catch( Inx_Apiimpl_SoapException $e )
		{
			throw new Inx_Api_NameException( $e->getMessage(), $e->getCode() );			
		}
	}
	

	public function rename( Inx_Api_Recipient_Attribute $oAttribute, $sAttributeName )
	{
		try
		{
		    $r = $this->_oService->renameAttribute( $this->_oSessionContext->sessionId(), $oAttribute->getId(), $sAttributeName );
		    
		    return $r->value;
		}
		catch( Inx_Apiimpl_SoapException $e )
		{
			throw new Inx_Api_NameException( $e->getMessage(), $e->getCode() );
		}
	}

	
	public function remove( Inx_Api_Recipient_Attribute $oAttribute = null )
	{
		if ($oAttribute == null) {
			throw new Inx_Api_NullPointerException();
		}
		try
		{
		    $r = $this->_oService->removeAttribute( $this->_oSessionContext->sessionId(), $oAttribute->getId() );

		    return $r;
		}
		catch( Inx_Apiimpl_SoapException $e )
		{
			throw new Inx_Api_NameException( $e->getMessage(), $e->getCode() );
		}
	}

	
	public function isAttributeVisibleInList( Inx_Api_Recipient_Attribute $oAttribute, $iListId )
	{
		try
		{
			$r = $this->_oService->isAttributeVisibleInList( $this->_oSessionContext->sessionId(), $oAttribute->getId(), $iListId );
			return $r;
		}
		catch( Inx_Apiimpl_SoapException $e )
		{
			$_oSessionContext->notify($e);
			return false;
		}
	}
	
	
	public function areAttributesVisibleInList( $aAttributes, $iListId )
	{
		$aAttrIds = array();
	
		for( $i = 0; $i < count($aAttributes); $i++ )
		{
			$aAttrIds[$i] = $aAttributes[$i]->getId();
		}
	
		try
		{
			$aSource = $this->_oService->areAttributesVisibleInList( $this->_oSessionContext->sessionId(), 
				Inx_Apiimpl_TConvert::arrToTArr( $aAttrIds ), $iListId );
			$aTarget = array();
			$this->convertMap( $aSource, $aTarget );
	
			return $aTarget;
		}
		catch( Inx_Apiimpl_SoapException $e )
		{
			$this->_oSessionContext->notify($e);
			return null;
		}
	}
	
	
	public function setAttributeListVisibility( Inx_Api_Recipient_Attribute $oAttribute, $iListId, $blVisible )
	{
		try
		{
			$this->_oService->setAttributeListVisibility( $this->_oSessionContext->sessionId(), $oAttribute->getId(), 
				$iListId, $blVisible );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->rethrowIllegalArgumentException($e);
		}
	}
	
	
	public function setAttributeListVisibilities( $aAttributes, $iListId, $blVisible )
	{
		$aAttrIds = array();
	
		for( $i = 0; $i < count($aAttributes); $i++ )
		{
			$aAttrIds[$i] = $aAttributes[$i]->getId();
		}
	
		try
		{
			$this->_oService->setAttributesListVisibility( $this->_oSessionContext->sessionId(), 
				Inx_Apiimpl_TConvert::arrToTArr( $aAttrIds ), $iListId, $blVisible );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->rethrowIllegalArgumentException($e);
		}
	}
	
	
	public function setGlobalAttributeVisibility( Inx_Api_Recipient_Attribute $oAttribute, $blVisible )
	{
		try
		{
			$this->_oService->setGlobalAttributeVisibility( $this->_oSessionContext->sessionId(), $oAttribute->getId(), $blVisible );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->rethrowIllegalArgumentException($e);
		}
	}
	
	
	public function setGlobalAttributeVisibilities( $aAttributes, $blVisible )
	{
		$aAttrIds = array();
	
		for( $i = 0; $i < count($aAttributes); $i++ )
		{
			$aAttrIds[$i] = $aAttributes[$i]->getId();
		}
	
		try
		{
			$this->_oService->setGlobalAttributesVisibility( $this->_oSessionContext->sessionId(), 
				Inx_Apiimpl_TConvert::arrToTArr( $aAttrIds ), $blVisible );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->rethrowIllegalArgumentException($e);
		}
	}
	
	
	private function convertMap( $aSource, &$aTarget )
	{
		if( $aSource == null )
			return;
	
		$aKeys = $aSource->intKeys;
		if( $aKeys != null )
		{
			$aValues = $aSource->boolValues;
			for( $i = 0; $i < count($aValues); $i++ )
				$aTarget[$aKeys[$i]] = Inx_Apiimpl_TConvert::convert( $aValues[$i] );
		}
	}
	
	private function rethrowIllegalArgumentException($oException)
	{
		$msg = $oException->getMessage();
		
		if (isset($msg) && strpos($msg, 'java.lang.IllegalArgumentException')===0) 
		{
			throw new Inx_Api_IllegalArgumentException(substr($msg,
				strpos($msg, 'java.lang.IllegalArgumentException: ') + 
				strlen('java.lang.IllegalArgumentException: ')));
		}
		
		$this->_oSessionContext->notify($oException);
	}
}
