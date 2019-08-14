<?php

/**
 * BounceMailImpl
 * 
 * @version 
 */
class Inx_Apiimpl_Bounce_BounceImpl implements Inx_Api_Bounce_Bounce
{
	protected $_oSc;
    
    protected $_oData;
    
    private $service;
    
    private $_aAttrGetterMapping;
    
    private $_oRecipientContext = null;
	
    
    public function __construct( $oSc, stdClass $oData, $rc=null, $_aAttrGetterMapping=null  )
    {
	    $this->_oSc = $oSc;
	    $this->_oData = $oData;
	    $this->service = $oSc->getService( Inx_Apiimpl_SessionContext::BOUNCE2_SERVICE );
	    $this->_aAttrGetterMapping = $_aAttrGetterMapping;
	    $this->_oRecipientContext = $rc;
	}
	
	public function getCategory()
	{
		return $this->_oData->category;
	}


	public function getHeaders()
	{
		try
		{
			return $this->service->getHeaders( $this->_oSc->createCxt(), $this->_oData->id );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSc->notify( $e );
		}
	}


	public function getListId()
	{
		return $this->_oData->listId;
	}


	public function getMIMEMessageAsStream()
	{
		try
		{
				$sStreamRefId = $this->service->createStream( $this->_oSc->createCxt(), $this->_oData->id );
				return new Inx_Apiimpl_Core_RemoteInputStream( $this->_oSc->createRemoteRef( $sStreamRefId ) );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSc->notify( $e );
		}
	}


	public function getMailingId()
	{
		return $this->_oData->mailingId;
	}


	public function getReceptionDate()
	{
		return Inx_Apiimpl_TConvert::convert($this->_oData->receptionDate);
	}


	public function getRecipientId()
	{
		return $this->_oData->recipientId;
	}


	public function getSender()
	{
		return $this->_oData->sender;
	}


	public function getSubject()
	{
		try
		{
			return $this->service->getSubject( $this->_oSc->createCxt(), $this->_oData->id );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSc->notify( $e );
		}
	}


	public function getTextContent()
	{
		try
		{
			return $this->service->getFlatText( $this->_oSc->createCxt(), $this->_oData->id );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSc->notify( $e );
		}
	}
	
	
	public function getId()
	{
		return $this->_oData->id;
	}

	
	
	public function commitUpdate()
	{
		throw new Inx_Api_UpdateException( 
			"No updates are allowed for bounces.",
		    Inx_Api_UpdateException::ERROR_TYPE_ILLEGAL_OPERATION,
			Inx_Api_UpdateException::ERROR_SOURCE_NOT_SPECIFIED );
	}

	
	public function reload()
	{
		try
	    {
			$this->_oData = $this->service->get( $this->_oSc->createCxt(), $this->_oData->id );
		   
			
			if( empty($this->_oData) )
			    throw new Inx_Api_DataException( "bounce deleted" );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSc->notify( $e );
		}
	}
	
	public function getMatchedEmailAddress()
	{
		return $this->_oData->matchedEmail;
	}
	
	public function getRecipientState()
	{
		return $this->_oData->recipientState;
	}
	
	public function getDate( $attr )
	{
		
		return $this->_checkReadAccess( $attr )->getDate( $this->_oData );
	}
 	/**
     * @throws Inx_Api_DataException
     */
	public function getBoolean( $attr ) 
	{
		return $this->_checkReadAccess( $attr )->getBoolean( $this->_oData );
	}
	/**
	 * @throws Inx_Api_DataException
	 */
	public function getDatetime( $attr )
	{
		return $this->_checkReadAccess( $attr )->getDateTime( $this->_oData );
	}
	
    /**
	 * @throws Inx_Api_DataException
	 */
	public function getDouble( $attr )
	{
		return $this->_checkReadAccess( $attr )->getDouble( $this->_oData );
	}
	
    /**
	 * @throws Inx_Api_DataException
	 */
	public function getInteger( $attr ) 
	{
		return $this->_checkReadAccess( $attr )->getInteger( $this->_oData );
	}

	/**
	 * @throws DataException
	 */
	public function getString( $attr )
	{
		return $this->_checkReadAccess( $attr )->getString( $this->_oData );
	}

	/**
	 * @throws DataException
	 */
	public function getTime( $attr ) 
	{
		return $this->_checkReadAccess( $attr )->getTime( $this->_oData );
	}
	
	/**
	 * @throws DataException
	 */
	public function getObject( $attr ) 
	{
		return $this->_checkReadAccess( $attr )->getObject( $this->_oData );
	}
	
	public static function convert( Inx_Apiimpl_SessionContext $oSc, /*stdClass*/ $oData ) 
	{
		if( $oData === null )
			return null;
		
		return new Inx_Apiimpl_Bounce_BounceImpl( $oSc, $oData );
	}
	
	private function _checkReadAccess( Inx_Api_Recipient_Attribute $attr ) 
	{
		if( $this->_oRecipientContext === null ||  $this->_aAttrGetterMapping === null )
    		throw new Inx_Api_IllegalArgumentException( "attribute not in fetch profile" );
			
		if( $attr->getContext() === $this->_oRecipientContext )
		{
			$ret = $this->_aAttrGetterMapping[ $attr->getId() ];
			if($ret === null)
				throw new Inx_Api_IllegalArgumentException( "attribute not in fetch profile" );
			
			return $ret;
		}
		
		throw new IllegalStateException( "wrong context" );
		
	}
}
