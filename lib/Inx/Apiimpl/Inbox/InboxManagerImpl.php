<?php
class Inx_Apiimpl_Inbox_InboxManagerImpl implements Inx_Api_Inbox_InboxManager, Inx_Apiimpl_Core_BOResultSetDelegate
{

	private $_oSessionContext;

	private $_oService;


	public function __construct( Inx_Apiimpl_SessionContext $oSessionContext )
	{
		$this->_oSessionContext = $oSessionContext;
		$this->_oService = $this->_oSessionContext->getService( Inx_Apiimpl_SessionContext::INBOX_SERVICE );
	}


	public function selectAfter( $sSearchDate, Inx_Api_Recipient_RecipientContext $rc, $aAttributes )
	{
		try
		{
			$rcId = "-1";
			if( $rc != null )
				$rcId = $rc->_remoteRef()->refId();
			$attrIds = $this->convertAttributesToIds( $aAttributes );
			$rs = $this->_oService->selectAfter( $this->_oSessionContext->createCxt(), 
				Inx_Apiimpl_TConvert::TConvert( $sSearchDate ), $rcId, $attrIds );

			return new Inx_Apiimpl_Inbox_InboxMessageDelegateResultSet( $this->_oSessionContext, $this, $rs, 
				$rc, $aAttributes );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}


	public function selectBefore( $sSearchDate, Inx_Api_Recipient_RecipientContext $rc, $aAttributes )
	{
		try
		{
			$rcId = "-1";
			if( $rc != null )
				$rcId = $rc->_remoteRef()->refId();
			$attrIds = $this->convertAttributesToIds( $aAttributes );
			$rs = $this->_oService->selectBefore( $this->_oSessionContext->createCxt(), 
				Inx_Apiimpl_TConvert::TConvert( $sSearchDate ), $rcId, $attrIds );

			return new Inx_Apiimpl_Inbox_InboxMessageDelegateResultSet( $this->_oSessionContext, $this, $rs, 
				$rc, $aAttributes );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}


	public function selectBetween( $sStartDate, $sStopDate, Inx_Api_Recipient_RecipientContext $rc, $aAttributes )
	{
		try
		{
			$rcId = "-1";
			if( $rc != null )
				$rcId = $rc->_remoteRef()->refId();
			$attrIds = $this->convertAttributesToIds( $aAttributes );
			$rs = $this->_oService->selectBetween( $this->_oSessionContext->createCxt(), 
				Inx_Apiimpl_TConvert::TConvert( $sStartDate ), Inx_Apiimpl_TConvert::TConvert( $sStopDate ), 
				$rcId, $attrIds );
			return new Inx_Apiimpl_Inbox_InboxMessageDelegateResultSet( $this->_oSessionContext, $this, $rs, 
				$rc, $aAttributes );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}


	public function get( $iId )
	{
		try
		{
			$message = Inx_Apiimpl_Inbox_InboxMessageImpl::convert( $this->_oSessionContext, 
				$this->_oService->get( $this->_oSessionContext->createCxt(), $iId ) );
			if( $message == null )
				throw new Inx_Api_DataException( "inbox message deleted" );
			return $message;
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}


	public function remove( $iId )
	{
		try
		{
			return $this->_oService->remove( $this->_oSessionContext->createCxt(), $iId );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return false;
		}
	}


	public function selectAllInboxMessages( Inx_Api_Recipient_RecipientContext $rc = null, $aAttributes = null )
	{
		try
		{
			$rcId = "-1";
			if( $rc != null )
				$rcId = $rc->_remoteRef()->refId();
			$attrIds = $this->convertAttributesToIds( $aAttributes );
			$rs = $this->_oService->selectAll( $this->_oSessionContext->createCxt(), $rcId, $attrIds );

			return new Inx_Apiimpl_Inbox_InboxMessageDelegateResultSet( $this->_oSessionContext, $this, $rs, 
				$rc, $aAttributes );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}
	
	public function selectAll( )
	{
		return $this->selectAllInboxMessages(null, null);
	}


	public function fetchInboxMessages( Inx_Apiimpl_RemoteRef $resultSetRef, $iIndex, $iDirection )
	{
		return $this->_oService->fetch( $resultSetRef->createCxt(), $resultSetRef->refId(), $iIndex, $iDirection );
	}


	public function removeBOs( Inx_Apiimpl_RemoteRef $resultSetRef, $aIndexRanges )
	{
		return $this->_oService->removeSelection( $resultSetRef->createCxt(), $resultSetRef->refId(), $aIndexRanges );
	}


	private function convertAttributesToIds( $aAttributes )
	{
		if( $aAttributes == null )
			return array();
		$attrIds = array();
		for( $i = 0; $i < count($aAttributes); $i++ )
		$attrIds[$i] = $aAttributes[$i]->getId();
		return $attrIds;
	}


	public function fetchBOs( Inx_Apiimpl_RemoteRef $resultSetRef, $iIndex, $iDirection )
	{
		//do nothing...
	}
}