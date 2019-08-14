<?php


/**
 * BatchChannelImpl
 * 
 * <P>Copyright (c) 2005 Inxmail GmbH. All Rights Reserved.
 * @version $Revision: 3671 $ $Date: 2006-01-16 10:51:24 +0000 (Mo, 16 Jan 2006) $ $Author: bgn $
 */
class Inx_Apiimpl_Recipient_BatchChannelImpl implements Inx_Api_Recipient_BatchChannel
{

    const BATCH_CHANNEL_CMD_SELECT = 
		Inx_Apiimpl_Recipient_Constants::BATCH_CHANNEL_CMD_SELECT;

	const BATCH_CHANNEL_CMD_CREATE_AND_SELECT = 
		Inx_Apiimpl_Recipient_Constants::BATCH_CHANNEL_CMD_CREATE_AND_SELECT;

	const BATCH_CHANNEL_CMD_REMOVE = 
		Inx_Apiimpl_Recipient_Constants::BATCH_CHANNEL_CMD_REMOVE;

	const BATCH_CHANNEL_CMD_CREATE_OR_SELECT = 
		Inx_Apiimpl_Recipient_Constants::BATCH_CHANNEL_CMD_CREATE_OR_SELECT;

	const BATCH_CHANNEL_CMD_WRITE = 
		Inx_Apiimpl_Recipient_Constants::BATCH_CHANNEL_CMD_WRITE;

	const BATCH_CHANNEL_CMD_WRITE_IF_NULL = 
		Inx_Apiimpl_Recipient_Constants::BATCH_CHANNEL_CMD_WRITE_IF_NULL;
	
	
	const BATCH_CHANNEL_CMD_SUBSCRIBE_IF_NULL = 
		Inx_Apiimpl_Recipient_Constants::BATCH_CHANNEL_CMD_SUBSCRIBE_IF_NULL;
		
	const BATCH_CHANNEL_CMD_UNSUBSCRIBE = 
		Inx_Apiimpl_Recipient_Constants::BATCH_CHANNEL_CMD_UNSUBSCRIBE;
	
		
	protected $_oRecipientManager;
	
	protected $_oService;

	protected $_iChunkSize;
	
	protected $_oSelectAttribute;
	
	protected $_aPackedUpds = array();
	
	protected $_aCmds = array();
	protected $_aAttrIds = array();

	protected $_aStringData = array();
	protected $_aBooleanData = array();
	protected $_aIntegerData = array();
	protected $_aDoubleData = array();
	protected $_aDateData = array();
	protected $_aTimeData = array();
	protected $_aDatetimeData = array();
	

	// if a recipient selected, you can write attributes
	protected $_blRecSelected = false;
	
	
	public function __construct( Inx_Apiimpl_Recipient_RecipientContextImpl $oRecipientManager, Inx_Api_Recipient_Attribute $oSelectAttribute )
	{
		$this->_oRecipientManager = $oRecipientManager;
		$this->_oSelectAttribute = $oSelectAttribute;
		
		$this->_oService = $oRecipientManager->_remoteRef()->getService( 
				Inx_Apiimpl_SessionContext::RECIPIENT_SERVICE );
		$this->_iChunkSize = $oRecipientManager->_remoteRef()->getIntProperty(
		        Inx_Apiimpl_PropertyConstants::BATCH_CHANNEL_CHUNK_SIZE );
	}
	
	
	public function removeRecipient( $sKey )
	{
	    if( is_null($sKey) )
	        throw new Inx_Api_IllegalArgumentException( "key mustn't be null" );
		if( sizeof($this->_aCmds) > $this->_iChunkSize )
			$this->chunk();
		
		$this->_aCmds[] = self::BATCH_CHANNEL_CMD_REMOVE;
		$this->add( $this->_oSelectAttribute, $sKey );
		$this->_blRecSelected = false;
	}

	
	public function selectRecipient( $sKey )
	{
	    if( is_null($sKey) )
	        throw new Inx_Api_IllegalArgumentException( "key mustn't be null" );
		if( sizeof($this->_aCmds) > $this->_iChunkSize)
			$this->chunk();
		
		$this->_aCmds[] = self::BATCH_CHANNEL_CMD_SELECT;
		$this->add( $this->_oSelectAttribute, $sKey );
		$this->_blRecSelected = true;
	}

	
	public function createRecipient( $sKeyValue, $selectIfExistant )
	{
		
	    if( $sKeyValue == null )
	        throw new Inx_Api_IllegalArgumentException( "key mustn't be null" );
		if( sizeof($this->_aCmds) > $this->_iChunkSize )
			$this->chunk();
		
		if( $selectIfExistant ) {
			$this->_aCmds[] = self::BATCH_CHANNEL_CMD_CREATE_OR_SELECT;
		} else {
			$this->_aCmds[] = self::BATCH_CHANNEL_CMD_CREATE_AND_SELECT;
		}
		$this->add($this->_oSelectAttribute, $sKeyValue);
		
		$this->_blRecSelected = true;
	}

	
	public function write( Inx_Api_Recipient_Attribute $oAttribute, $sValue )
	{
	    if( is_null($oAttribute) )
	        throw new Inx_Api_IllegalArgumentException( "attribute mustn't be null" );
	    if(! $this->_blRecSelected )
	        throw new Inx_Api_IllegalStateException( 
				"no recipient is selected, first call selectRecipient() or createRecipient()" );
		$this->_aCmds[] = self::BATCH_CHANNEL_CMD_WRITE;
		$this->add( $oAttribute, $sValue );
	}
	
	
	public function writeIfNull( Inx_Api_Recipient_Attribute $oAttribute, $sValue )
	{
	    if( is_null($oAttribute) )
	        throw new Inx_Api_IllegalArgumentException( "attribute mustn't be null" );
	    if(! $this->_blRecSelected )
	        throw new Inx_Api_IllegalStateException( 
	        	"no recipient is selected, first call selectRecipient() or createRecipient()" );
		$this->_aCmds[] = self::BATCH_CHANNEL_CMD_WRITE_IF_NULL;
		$this->add( $oAttribute, $sValue );
	}
	
	
	public function subscribeIfNotUnsubscribed( Inx_Api_List_ListContext $lc, $subscriptionDate )
	{
		if( is_null($lc) )
	        throw new Inx_Api_IllegalArgumentException( "ListContext mustn't be null" );
	    if(! $this->_blRecSelected )
	        throw new Inx_Api_IllegalStateException( 
	        	"no recipient is selected, first call selectRecipient() or createRecipient()" );
		$this->_aCmds[] = self::BATCH_CHANNEL_CMD_SUBSCRIBE_IF_NULL;
		$this->add( $this->_oRecipientManager->getSubscriptionAttribute( $lc ), $subscriptionDate );
	}


	public function unsubscribe( Inx_Api_List_ListContext $lc )
	{
		if( is_null($lc) )
	        throw new Inx_Api_IllegalArgumentException( "ListContext mustn't be null" );
	    if(! $this->_blRecSelected )
	        throw new Inx_Api_IllegalStateException( 
	        	"no recipient is selected, first call selectRecipient() or createRecipient()" );
		$this->_aCmds[] = self::BATCH_CHANNEL_CMD_UNSUBSCRIBE;
		$this->add( $this->_oRecipientManager->getSubscriptionAttribute( $lc ), date("c") );
	}
	

	
	public function getContext()
	{
		return $this->_oRecipientManager;
	}
	
	
	/**
	 * Enter description here...
	 *
	 * @return array $aRetValue
	 */
	public function executeBatch()
	{
		if( sizeof($this->_aCmds)!= 0 )
			$this->chunk();
    	
		if( sizeof($this->_aPackedUpds) == 0 )
		{
		    $this->reset();
		    return array();
		}
		
		$aRetValue = array();
    	$oRef = $this->_oRecipientManager->_remoteRef();
    	try {
			while( sizeof($this->_aPackedUpds) > 0 ) {
				$aTmpRetValue = $this->_oService->batch( $oRef->sessionId(), $oRef->refId(),
						array_shift($this->_aPackedUpds));
				$aRetValue = array_merge($aRetValue, (array)$aTmpRetValue);
			}
			$this->reset();
			$this->_aPackedUpds = array();
			return Inx_Apiimpl_TConvert::TArrToArr($aRetValue);
		} catch( Inx_Api_RemoteException $e ) {
			$oRef->notify( $e );
			return null;
		}
		
		
	}
	
	
	protected function chunk()
	{
		$upd = new stdClass();

		$upd->cmdData = Inx_Apiimpl_TConvert::arrToTArr($this->_aCmds);
		$upd->attrIdData = Inx_Apiimpl_TConvert::arrToTArr($this->_aAttrIds);
		$upd->stringData = Inx_Apiimpl_TConvert::arrToTArr($this->_aStringData);
		$upd->booleanData = Inx_Apiimpl_TConvert::arrToTArr($this->_aBooleanData);
		$upd->integerData = Inx_Apiimpl_TConvert::arrToTArr($this->_aIntegerData);
		$upd->doubleData = Inx_Apiimpl_TConvert::arrToTArr($this->_aDoubleData);
		$upd->dateData = Inx_Apiimpl_TConvert::arrToTArr($this->_aDateData);
		$upd->timeData = Inx_Apiimpl_TConvert::arrToTArr($this->_aTimeData);
		$upd->datetimeData = Inx_Apiimpl_TConvert::arrToTArr($this->_aDatetimeData);
		$this->_aPackedUpds[] = $upd;
		$this->reset();
	}
	
	
	protected function add( Inx_Api_Recipient_Attribute $oAttribute, $value )
	{
		
		switch( $oAttribute->getDataType() )
		{
			case Inx_Api_Recipient_Attribute::DATA_TYPE_STRING:
				$this->_aStringData[] = $value;
				break;
			case Inx_Api_Recipient_Attribute::DATA_TYPE_INTEGER:
				if (! Inx_Apiimpl_Recipient_ContextAttribute_Integer::validate($value)) {
					throw new Inx_Api_IllegalArgumentException();
				}
				$this->_aIntegerData[] = $value;
				break;
			case Inx_Api_Recipient_Attribute::DATA_TYPE_BOOLEAN:
				if (! Inx_Apiimpl_Recipient_ContextAttribute_Boolean::validate($value)) {
					throw new Inx_Api_IllegalArgumentException();
				}
				$this->_aBooleanData[] = Inx_Apiimpl_Recipient_ContextAttribute_Boolean::getValue($value);
				break;
			case Inx_Api_Recipient_Attribute::DATA_TYPE_DOUBLE:
				if (! Inx_Apiimpl_Recipient_ContextAttribute_Double::validate($value)) {
					throw new Inx_Api_IllegalArgumentException("illegal attribute value");
				}
				$this->_aDoubleData[] = Inx_Apiimpl_Recipient_ContextAttribute_Double::getValue($value);
				break;
			case Inx_Api_Recipient_Attribute::DATA_TYPE_DATETIME:
				$this->_aDatetimeData[] = Inx_Apiimpl_Recipient_ContextAttribute_Datetime::getValue($value);
				break;
			case Inx_Api_Recipient_Attribute::DATA_TYPE_DATE:
				$this->_aDateData[] = Inx_Apiimpl_Recipient_ContextAttribute_Date::getValue($value);
				break;
			case Inx_Api_Recipient_Attribute::DATA_TYPE_TIME:
				$this->_aTimeData[] = Inx_Apiimpl_Recipient_ContextAttribute_Time::getValue($value);
				break;
			default:
				throw new Inx_Api_IllegalArgumentException( "illegal attribute type" );
		}
		$this->_aAttrIds[] = (int)$oAttribute->getId();
	}

	
	protected function reset()
	{
		$this->_aCmds = array();
		$this->_aAttrIds = array();
		$this->_aStringData = array();
		$this->_aBooleanData = array();
		$this->_aIntegerData = array();
		$this->_aDoubleData = array();
		$this->_aDateData = array();
		$this->_aTimeData = array();
		$this->_aDatetimeData = array();
		$this->_blRecSelected = false;
	}
}
