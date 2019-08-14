<?php

/**
 * The implementation of <code>RecipientContext</code>
 * 
 * <P>Copyright (c) 2005 Inxmail GmbH. All Rights Reserved.
 * @version $Revision: 4690 $ $Date: 2006-09-20 07:24:45 +0000 (Mi, 20 Sep 2006) $ $Author: bgn $
 */
class Inx_Apiimpl_Recipient_RecipientContextImpl extends Inx_Apiimpl_RemoteObject implements Inx_Api_Recipient_RecipientContext, Inx_Api_Recipient_RecipientMetaData
{
	
	protected $_oService;
	
	protected $_oServiceUnsubscription;

	protected $_aAttrNameMap = array();

	protected $_aAttrIdMap = array();

	protected $_blKeyUnique;
	
	/** Attribute meta data (inclusive id attribute) */
	protected $_aAttributes = array();

	protected $_oIdAttr;

	protected $_oKeyAttr;

	protected $_oEmailAttr;

	protected $_oLastModificationAttr;
	
	protected $_oHardbounceAttr;

	protected $_iStringAttrCount;
	protected $_iBooleanAttrCount;
	protected $_iIntegerAttrCount;
	protected $_iDoubleAttrCount;
	protected $_iDateAttrCount;
	protected $_iTimeAttrCount;
	protected $_iDatetimeAttrCount;

	/** Count of updateable attributes (without id attribute) */
	protected $_iUpdAttrCount;
	
    
	public function __construct( $oSessionContext, $oRecipientContextData )
	{
		parent::__construct( $oSessionContext, $oRecipientContextData->remoteRefId);
		$this->_oService = $oSessionContext->getService( Inx_Apiimpl_SessionContext::RECIPIENT_SERVICE );
		$this->_oServiceUnsubscription = $oSessionContext->getService( Inx_Apiimpl_SessionContext::UNSUBSCRIBER_SERVICE );
		$this->_blKeyUnique = $oRecipientContextData->keyUnique;
		
		$this->_iStringAttrCount = $oRecipientContextData->stringAttrCount;
		$this->_iBooleanAttrCount = $oRecipientContextData->booleanAttrCount;
		$this->_iIntegerAttrCount = $oRecipientContextData->integerAttrCount;
		$this->_iDoubleAttrCount = $oRecipientContextData->doubleAttrCount;
		$this->_iDateAttrCount = $oRecipientContextData->dateAttrCount;
		$this->_iTimeAttrCount = $oRecipientContextData->timeAttrCount;
		$this->_iDatetimeAttrCount = $oRecipientContextData->datetimeAttrCount;
		
		$this->_updAttrCount = $this->_iStringAttrCount + $this->_iBooleanAttrCount + $this->_iIntegerAttrCount + $this->_iDoubleAttrCount
			+ $this->_iDateAttrCount + $this->_iTimeAttrCount + $this->_iDatetimeAttrCount;
		
		$attrCount = $this->_updAttrCount + 1;

		$this->_aAttributes = array_fill(0, $attrCount, null);
		$this->_aAttrNameMap = array_fill(0, $attrCount * 2, null);
		$this->_aAttrIdMap = array_fill(0, $attrCount * 2, null);
		
		$this->initAllAttributes( $oRecipientContextData );
	}


	/**
	 * @see Inx_Api_Recipient_RecipientContext#select()
	 * @return Inx_Api_Recipient_RecipientRowSet
	 * @throws SelectException
	 */
	public function select(Inx_Api_List_ListContext $list=null, Inx_Api_Filter_Filter $oFilter=null, $sAdditionalFilter=null,
		Inx_Api_Recipient_Attribute $oOrderAttribute=null, $iOrderType=null)
	{
		return $this->findInList( $list, $oFilter, $sAdditionalFilter, $oOrderAttribute, (int)$iOrderType );
	}

	/**
	 * @return Inx_Api_Recipient_RecipientRowSet
	 * @throws SelectException
	 */
	private function findInList( Inx_Api_List_ListContext $oList=null, Inx_Api_Filter_Filter $oFilter=null, $sAdditionalFilter=null,
		Inx_Api_Recipient_Attribute $oOrderAttribute=null, $iOrderType=null )
	{
		
		try
		{
			$orderAttrId = (($oOrderAttribute != null) ? $oOrderAttribute->getId() : 
				Inx_Apiimpl_Constants::ID_UNSPECIFIED);
			
			$listContextId = $oList != null ? $oList->getId() : Inx_Apiimpl_Constants::ID_UNSPECIFIED;
			$filterId = $oFilter != null ? $oFilter->getId() : Inx_Apiimpl_Constants::ID_UNSPECIFIED;
			if( $sAdditionalFilter == null )
				$sAdditionalFilter = "";
			$data = $this->_oService->find1( $this->_sessionId(), $this->_refId(), $listContextId, 
					$filterId, $sAdditionalFilter, $orderAttrId, $iOrderType );
			if(! empty($data->selectExcDesc))
			    throw new Inx_Api_Recipient_SelectException( $data->selectExcDesc->msg, $data->selectExcDesc->type);
			
			return new Inx_Apiimpl_Recipient_RecipientRowSetImpl( $this, $data );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_notify( $e );
			return null;
		}
	}
	
	public function findByKey( $sKey )
	{
		try
		{
			$data = $this->_oService->findByKey( $this->_sessionId(), $this->_refId(), $sKey );
			return new Inx_Apiimpl_Recipient_RecipientRowSetImpl( $this, $data );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_notify( $x );
			return null;
		}
	}
	
	
	public function findAllByKey( $sKey )
	{
		try
		{
			$data = $this->_oService->findAllByKey( $this->_sessionId(), $this->_refId(), $sKey );
			return new Inx_Apiimpl_Recipient_RecipientRowSetImpl( $this, $data );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_notify( $x );
			return null;
		}
	}
	
	
	public function findByKeys( $aKeys )
	{
		try
		{
			$data = $this->_oService->findByKeys( $this->_sessionId(), $this->_refId(), Inx_Apiimpl_TConvert::arrToTarr($aKeys) );
			return new Inx_Apiimpl_Recipient_RecipientRowSetImpl( $this, $data );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_notify( $x );
			return null;
		}
	}
	
	
	public function findAllByKeys( $aKeys )
	{
		try
		{
			$data = $this->_oService->findAllByKeys( $this->_sessionId(), $this->_refId(), Inx_Apiimpl_TConvert::arrToTarr($aKeys) );
			return new Inx_Apiimpl_Recipient_RecipientRowSetImpl( $this, $data );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_notify( $x );
			return null;
		}
	}
	
	
	public function selectUnsubscriber(Inx_Api_List_ListContext $oList, Inx_Api_Filter_Filter $oFilter=null, $sAdditionalFilter=null,
		Inx_Api_Recipient_Attribute $oOrderAttribute=null, $iOrderType=null)
	{	
		try
		{
			$orderAttrId = (($oOrderAttribute != null) ? $oOrderAttribute->getId() : 
				Inx_Apiimpl_Constants::ID_UNSPECIFIED);
			
			$listContextId = $oList != null ? $oList->getId() : Inx_Apiimpl_Constants::ID_UNSPECIFIED;
			$filterId = $oFilter != null ? $oFilter->getId() : Inx_Apiimpl_Constants::ID_UNSPECIFIED;
			if( $sAdditionalFilter == null )
				$sAdditionalFilter = "";
			$iOrderType = (int)$iOrderType;
			$data = $this->_oServiceUnsubscription->selectUnsubscriber( $this->_sessionId(), $this->_refId(), $listContextId, 
					$filterId, $sAdditionalFilter, $orderAttrId, $iOrderType );
			if(! empty($data->selectExcDesc))
			    throw new Inx_Api_Recipient_SelectException( $data->selectExcDesc->msg, $data->selectExcDesc->type);
			
			return new Inx_Apiimpl_Recipient_UnsubscriptionRecipientRowSetImpl( $this, $data, $oList );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_notify( $e );
			return null;
		}
	}

	
    /**
     * @see Inx_Api_Recipient_RecipientContext#setAttributeValue(com.inxmail.xpro.api.recipient.Attribute, java.lang.Object)
     * @return boolean
     */
    public function setAttributeValue( Inx_Api_Recipient_Attribute $attr, stdClass $newValue )
    {
    	try
		{
			//fixes XAPI-36: replaced $newValue with $newValue->value
    		return $this->_oService->setAttributeValue( $this->_sessionId(), $this->_refId(),
    				$attr->createAttrUpdate( $newValue->value ) );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$attr->_notify( $e );
			return false;
		}
    }
    
	
	/**
	 * @see Inx_Api_Recipient_RecipientContext#createRowSet()
	 * @return RecipientRowSet
	 */
	public function createRowSet()
	{
		try
		{
			return new Inx_Apiimpl_Recipient_RecipientRowSetImpl( $this, $this->_oService->createRowSet( 
					$this->_sessionId(), $this->_refId() ) );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_notify( $e );
			return null;
		}
	}
	
	
	/**
	 * @see Inx_Api_Recipient_RecipientContext#isUpToDate()
	 * @return boolean
	 */
	public function isUpToDate()
	{
		try
		{
			return $this->_oService->isUpToDate( $this->_sessionId(), $this->_refId() );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_notify( $e );
			return false;
		}
	}
	
	/**
	 * @see Inx_Api_Recipient_RecipientContext#getMetaData()
	 * @return Inx_Apiimpl_Recipient_RecipientContextImpl
	 */
	public function getMetaData()
	{
		return $this;
	}
	
	/**
	 * @see Inx_Api_Recipient_RecipientContext#createBatchChannel(com.inxmail.xpro.api.recipient.Attribute)
	 * @return Inx_Api_Recipient_BatchChannel
	 */	
	public function createBatchChannel( Inx_Api_Recipient_Attribute $oSelectAttribute = null )
	{
		if( $oSelectAttribute == null )
			return new Inx_Apiimpl_Recipient_BatchChannelImpl( $this, $this->getKeyAttribute() );
	        //throw new IllegalArgumentException( "selectAttribute mustn't be null" );
		
		if( $oSelectAttribute->getDataType() == Inx_Api_Recipient_Attribute::DATA_TYPE_STRING
				|| $oSelectAttribute->getDataType() == Inx_Api_Recipient_Attribute::DATA_TYPE_INTEGER )
			return new Inx_Apiimpl_Recipient_BatchChannelImpl( $this, $oSelectAttribute );
		else
			throw new Inx_Api_IllegalArgumentException(
				"The type of the select attribute must be DATA_TYPE_STRING or DATA_TYPE_INTEGER" );
	}
	
	
	/**
	 * @see Inx_Api_Recipient_RecipientContext#close()
	 * @return void
	 */
	public function close()
	{
	    $this->_release( true );
	}
	
	
	/**
	 * @see Inx_Api_Recipient_RecipientContext#isKeyUnique()
	 * @return boolean
	 */
	public function isKeyUnique()
	{
		return $this->_blKeyUnique;
	}

	/**
	 * 
	 * @return RecipientData
	 */
	public function createNewRecipientData()
	{		
		
		$oRd = new stdClass();
		$oRd->id = 0;
		$strArr = ($this->_iStringAttrCount>0) ? array_fill(0, $this->_iStringAttrCount, null) : array();
		$boolArr = ($this->_iBooleanAttrCount>0) ? array_fill(0, $this->_iBooleanAttrCount, null) : array();
		$intArr = ($this->_iIntegerAttrCount>0) ? array_fill(0, $this->_iIntegerAttrCount, null) : array();
		$dblArr = ($this->_iDoubleAttrCount>0) ? array_fill(0, $this->_iDoubleAttrCount, null) : array();
		$dtArr = ($this->_iDateAttrCount>0) ? array_fill(0, $this->_iDateAttrCount, null) : array();
		$timeArr = ($this->_iTimeAttrCount>0) ? array_fill(0, $this->_iTimeAttrCount, null) : array();
		$dttimeArr = ($this->_iDatetimeAttrCount>0) ? array_fill(0, $this->_iDatetimeAttrCount, null) : array();
		$oRd->stringData = Inx_Apiimpl_TConvert::arrToTArr($strArr);
		$oRd->booleanData = Inx_Apiimpl_TConvert::arrToTArr($boolArr);
		$oRd->integerData = Inx_Apiimpl_TConvert::arrToTArr($intArr);
		$oRd->doubleData = Inx_Apiimpl_TConvert::arrToTArr($dblArr);
		$oRd->dateData = Inx_Apiimpl_TConvert::arrToTArr($dtArr);
		$oRd->timeData = Inx_Apiimpl_TConvert::arrToTArr($timeArr);
		$oRd->datetimeData = Inx_Apiimpl_TConvert::arrToTArr($dttimeArr);
		return $oRd;
		
	}

	/**
	 * @param RecipientData $oRd
	 * @param array changedAttrFlag
	 * @return RecipientUpdate
	 */
	public function createRecipientUpdate( $oRd, $aChangedAttrFlag )
	{	
		$aAttrIndeces = array();
    	$aTypeArrayIndeces = array();
    	$aStringAttrs = array();
    	$aBooleanAttrs = array();
    	$aIntegerAttrs = array();
    	$aDoubleAttrs = array();
    	$aDateAttrs = array();
    	$aTimeAttrs = array();
    	$aDatetimeAttrs = array();
    	$iCount = 0;
    	$iStringCount = 0;
    	$iBooleanCount = 0;
    	$iDoubleCount = 0;
    	$iIntegerCount = 0;
    	$iDateCount = 0;
    	$iTimeCount = 0;
    	$iDatetimeCount = 0;

    	foreach ( $aChangedAttrFlag as $i=>$value )
    	{
    		if( ! isset($aChangedAttrFlag[$i]) || ! $aChangedAttrFlag[$i] )
    			continue;
    		
    		$aAttrIndeces[$iCount] = $i;
    		switch( $this->_aAttributes[$i]->getDataType() )
			{
				case Inx_Api_Recipient_Attribute::DATA_TYPE_STRING:
					$aTypeArrayIndeces[ $iCount ] = $iStringCount;
					$aStringAttrs[ $iStringCount++ ] = $oRd->stringData[$this->_aAttributes[$i]->getTypeAttrIndex()];
					break;
				case Inx_Api_Recipient_Attribute::DATA_TYPE_BOOLEAN:
					$aTypeArrayIndeces[ $iCount ] = $iBooleanCount;
					$aBooleanAttrs[ $iBooleanCount++ ] = $oRd->booleanData[$this->_aAttributes[$i]->getTypeAttrIndex()];
					break;
				case Inx_Api_Recipient_Attribute::DATA_TYPE_INTEGER:
					$aTypeArrayIndeces[ $iCount ] = $iIntegerCount;
					$aIntegerAttrs[ $iIntegerCount++ ] = $oRd->integerData[$this->_aAttributes[$i]->getTypeAttrIndex()];
					break;
				case Inx_Api_Recipient_Attribute::DATA_TYPE_DOUBLE:
					$aTypeArrayIndeces[ $iCount ] = $iDoubleCount;
					$aDoubleAttrs[ $iDoubleCount++ ] = $oRd->doubleData[$this->_aAttributes[$i]->getTypeAttrIndex()];
					break;
				case Inx_Api_Recipient_Attribute::DATA_TYPE_DATE:
					$aTypeArrayIndeces[ $iCount ] = $iDateCount;
					$aDateAttrs[ $iDateCount++ ] = $oRd->dateData[$this->_aAttributes[$i]->getTypeAttrIndex()];
					break;
				case Inx_Api_Recipient_Attribute::DATA_TYPE_TIME:
					$aTypeArrayIndeces[ $iCount ] = $iTimeCount;
					$aTimeAttrs[ $iTimeCount++ ] = $oRd->timeData[$this->_aAttributes[$i]->getTypeAttrIndex()];
					break;
				case Inx_Api_Recipient_Attribute::DATA_TYPE_DATETIME:
					$aTypeArrayIndeces[ $iCount ] = $iDatetimeCount;
					$aDatetimeAttrs[ $iDatetimeCount++ ] = $oRd->datetimeData[$this->_aAttributes[$i]->getTypeAttrIndex()];
					break;
				default:
					throw new Inx_Api_IllegalStateException();
			}
    		$iCount++;
    	}
    	$ru = new stdClass();
    	$ru->id = $oRd->id;
    	$ru->attrIndices = Inx_Apiimpl_TConvert::arrToTArr(Inx_Apiimpl_Util_Utils::trimEnd( $aAttrIndeces, $iCount ));
    	$ru->typeArrayIndices =  Inx_Apiimpl_TConvert::arrToTArr( Inx_Apiimpl_Util_Utils::trimEnd( $aTypeArrayIndeces, $iCount ) );
    	
    	$ru->stringData = $aStringAttrs;
    	$ru->booleanData = $aBooleanAttrs;
    	$ru->integerData = $aIntegerAttrs;
    	$ru->doubleData = $aDoubleAttrs;
    	$ru->dateData = $aDateAttrs;
    	$ru->timeData = $aTimeAttrs;
    	$ru->datetimeData = $aDatetimeAttrs;
    	
		return $ru;
	}
	
	/**
	 * Enter description here...
	 *
	 * @return int
	 */
	public function getUpdateableAttributeCount()
	{
		return $this->_iUpdAttrCount;
	}
	
	
	/**
	 * @see Inx_Api_Recipient_RecipientMetaData#getIdAttribute()
	 * @return Attribute
	 */
	public function getIdAttribute()
	{
		return $this->_oIdAttr;
	}

	
	/**
	 * @see Inx_Api_Recipient_RecipientMetaData#getKeyAttribute()
	 * @return Attribute
	 */
	public function getKeyAttribute()
	{
		return $this->_oKeyAttr;
	}


	/**
	 * @see Inx_Api_Recipient_RecipientMetaData#getEmailAttribute()
	 * @return Attribute
	 */
	public function getEmailAttribute()
	{
		return $this->_oEmailAttr;
	}

	
	/**
	 * @see Inx_Api_Recipient_RecipientMetaData#getLastModificationAttribute()
	 * @return Attribute
	 */
	public function getLastModificationAttribute()
	{
		return $this->_oLastModificationAttr;
	}
	
	/**
	 * @see Inx_Api_Recipient_RecipientMetaData#getHardbounceAttribute()
	 * @return Attribute
	 */
	public function getHardbounceAttribute()
	{
		return $this->_oHardbounceAttr;
	}
	
	/**
	 * @see Inx_Api_Recipient_RecipientMetaData#getUserAttribute(java.lang.String)
	 * @return Attribute
	 * @throws Inx_Api_Recipient_AttributeNotFoundException
	 */
	public function getUserAttribute( $sAttributeName )
	{
		$oAttr = null;
		if (array_key_exists(strtolower($sAttributeName), $this->_aAttrNameMap)) {
			$oAttr = $this->_aAttrNameMap[strtolower($sAttributeName)];
		}
		if( ! empty($oAttr) )
			return $oAttr;
		throw new Inx_Api_Recipient_AttributeNotFoundException( "attribute name: " . $sAttributeName );
	}


	/**
	 * @see Inx_Api_Recipient_RecipientMetaData#getSubscriptionAttribute(com.inxmail.xpro.api.list.ListContext)
	 * @return Attribute
	 * @throws Inx_Api_Recipient_AttributeNotFoundException
	 */
	public function getSubscriptionAttribute( Inx_Api_List_ListContext $oList )
	{
		$key = "subscription_" . $oList->getId();
		if (array_key_exists($key, $this->_aAttrNameMap) && $this->_aAttrNameMap[$key]!=null) {
			return $this->_aAttrNameMap[$key];
		}
		throw new Inx_Api_Recipient_AttributeNotFoundException( "suscription attribute from list: " . $oList->getName() );
	}


	/**
	 * @see Inx_Api_Recipient_RecipientMetaData#getAttribute(int)
	 * @return Attribute
	 * @throws Inx_Api_Recipient_AttributeNotFoundException
	 */
	public function getAttribute( $iAttributeId )
	{
		if (!is_int($iAttributeId)) {
		    throw new Inx_Api_IllegalArgumentException('Wrong parameter $iAttributeId type, integer expected');
		}
	    $oAttr = $this->_aAttrIdMap[$iAttributeId];
		if( $oAttr != null )
			return $oAttr;
		throw new Inx_Api_Recipient_AttributeNotFoundException( "attribute id: " . $iAttributeId );
	}


	/**
	 * @see Inx_Api_Recipient_RecipientMetaData#getAttributeCount()
	 * @return int
	 */
	public function getAttributeCount()
	{
		return sizeof($this->_aAttributes);
	}
	
	
	/**
	 * @see Inx_Api_Recipient_RecipientMetaData::getAttributeIterator()
	 * @return Iterator
	 */
	public function getAttributeIterator()
	{
		return new Inx_Apiimpl_Recipient_RecipientContextImpl_AttributeIterator($this->_aAttributes);
	}

	
	protected function initAllAttributes( stdClass $oRCData )
	{
		
		// email and key attribute can be the same
		$iIdAttrId = $oRCData->idAttrId;
		$iEmailAttrId = $oRCData->emailAttrId;
		$iKeyAttrId = $oRCData->keyAttrId;
		$aAs = $oRCData->attrData; // first bulk of attr meta data
		


		try
		{
		    $iAttrCount = 0;
		    $iIndex = null;
			$iAttrId = null;
			while( $iAttrCount < sizeof($this->_aAttributes) )
			{
				if( $aAs == null || !sizeof($aAs) )
					$aAs = $this->_oService->fetchAttributes( $this->_sessionId(), $this->_refId(), $iAttrCount );
				foreach ($aAs as $i=>$oNode) 
				{
					$iAttrCount++;
				    $iAttrId = $oNode->id;
				   	
				    $iIndex = $oNode->arrayIndex;
				    
					switch( $oNode->dataType )
					{
						case Inx_Api_Recipient_Attribute::DATA_TYPE_STRING:
							$this->_aAttributes[$iIndex] = new Inx_Apiimpl_Recipient_ContextAttribute_String( $this, $oNode );
							break;
						case Inx_Api_Recipient_Attribute::DATA_TYPE_BOOLEAN:
							$this->_aAttributes[$iIndex] = new Inx_Apiimpl_Recipient_ContextAttribute_Boolean( $this, $oNode );
							break;
						case Inx_Api_Recipient_Attribute::DATA_TYPE_INTEGER:						
							if( $iAttrId == $iIdAttrId )
							{
							    $iIndex = sizeof($this->_aAttributes)-1;
							    $this->_oIdAttr = new Inx_Apiimpl_Recipient_ContextAttribute_Id( $this, $oNode );
							    $this->_aAttributes[$iIndex] = $this->_oIdAttr;
							}
							else if( $oNode->attrType == Inx_Api_Recipient_Attribute::HARDBOUNCE_ATTRIBUTE_TYPE )
							{
								$this->_oHardbounceAttr = new Inx_Apiimpl_Recipient_ContextAttribute_Hardbounce( $this, $oNode );
								$this->_aAttributes[$iIndex] = $this->_oHardbounceAttr;	
							}
							else	
								$this->_aAttributes[$iIndex] = new Inx_Apiimpl_Recipient_ContextAttribute_Integer( $this, $oNode );
							break;
						case Inx_Api_Recipient_Attribute::DATA_TYPE_DOUBLE:
							$this->_aAttributes[$iIndex] = new Inx_Apiimpl_Recipient_ContextAttribute_Double( $this, $oNode );
							break;
						case Inx_Api_Recipient_Attribute::DATA_TYPE_DATE:
							$this->_aAttributes[$iIndex] = new Inx_Apiimpl_Recipient_ContextAttribute_Date( $this, $oNode );
							break;
						case Inx_Api_Recipient_Attribute::DATA_TYPE_TIME:
							$this->_aAttributes[$iIndex] = new Inx_Apiimpl_Recipient_ContextAttribute_Time( $this, $oNode );
							break;
						case Inx_Api_Recipient_Attribute::DATA_TYPE_DATETIME:
							if( $oNode->attrType == Inx_Api_Recipient_Attribute::LAST_MODIFICATION_ATTRIBUTE_TYPE )
							{
								$this->_oLastModificationAttr = new Inx_Apiimpl_Recipient_ContextAttribute_LastModification( $this, $oNode );
								$this->_aAttributes[$iIndex] = $this->_oLastModificationAttr;
							}
							else
								$this->_aAttributes[$iIndex] = new Inx_Apiimpl_Recipient_ContextAttribute_Datetime( $this, $oNode );
							break;
						default:
							throw new Inx_Api_IllegalStateException();
					}
					$this->_aAttrNameMap[strtolower($oNode->name)] = $this->_aAttributes[$iIndex];
					$this->_aAttrIdMap[$iAttrId] = $this->_aAttributes[$iIndex];
					
					if( $iAttrId == $iKeyAttrId )
						$this->_oKeyAttr = $this->_aAttributes[$iIndex];
					if( $iAttrId == $iEmailAttrId )
						$this->_oEmailAttr = $this->_aAttributes[$iIndex];
				}
				$aAs = null;
			}
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_notify( $e );
		}

	}
}
