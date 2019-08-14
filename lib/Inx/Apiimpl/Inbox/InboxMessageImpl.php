<?php
class Inx_Apiimpl_Inbox_InboxMessageImpl implements Inx_Api_Inbox_InboxMessage
{

	private $_oData;

	private $_oSessionContext;

	private $_oService;

	private $_oRecipientContext;

	private $_aAttrGetterMapping;


	public function __construct( Inx_Apiimpl_SessionContext $oSessionContext, stdClass $oData, 
			Inx_Api_Recipient_RecipientContext $oRecipientContext, $aAttrGetterMapping )
	{
		$this->_oSessionContext = $oSessionContext;
		$this->_oData = $oData;
		$this->_oService = $this->_oSessionContext->getService( Inx_Apiimpl_SessionContext::INBOX_SERVICE );
		$this->_oRecipientContext = $oRecipientContext;
		$this->_aAttrGetterMapping = $aAttrGetterMapping;
	}


	public function getCategory()
	{
		return $this->_oData->category;
	}


	public function getHeaders()
	{
		try
		{
			return $this->_oService->getHeaders( $this->_oSessionContext->createCxt(), $this->_oData->id );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}


	public function getMIMEMessageAsStream()
	{
		try
		{
			$streamRefId = $this->_oService->createStream( $this->_oSessionContext->createCxt(), $this->_oData->id);
			return new Inx_Apiimpl_Core_RemoteInputStream( $this->_oSessionContext->createRemoteRef( $streamRefId ) );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}


	public function getReceptionDate()
	{
		return Inx_Apiimpl_TConvert::convert( $this->_oData->receptionDate );
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
			return $this->_oService->getSubject( $this->_oSessionContext->createCxt(), $this->_oData->id );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}


	public function getTextContent()
	{
		try
		{
			return $this->_oService->getFlatText( $this->_oSessionContext->createCxt(), $this->_oData->id );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}


	public function commitUpdate()
	{
		throw new Inx_Api_UpdateException( Inx_Api_UpdateException::ERROR_TYPE_ILLEGAL_OPERATION,
				Inx_Api_UpdateException::ERROR_SOURCE_NOT_SPECIFIED, "No updates are allowed for inbox messages." );
	}


	public function getId()
	{
		return $this->_oData->id;
	}


	public function reload()
	{
		try
		{
			$this->_oData = $this->_oService->get( $this->_oSessionContext->createCxt(), $this->_oData->id );
			if( $this->_oData == null )
				throw new Inx_Api_DataException( "inbox message deleted" );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
		}
	}


	public function getBoolean( Inx_Api_Recipient_Attribute $oAttribute )
	{
		return $this->checkReadAccess( $oAttribute )->getBoolean( $this->_oData );
	}


	public function getDate( Inx_Api_Recipient_Attribute $oAttribute )
	{
		return $this->checkReadAccess( $oAttribute )->getDate( $this->_oData );
	}


	public function getDatetime( Inx_Api_Recipient_Attribute $oAttribute )
	{
		return $this->checkReadAccess( $oAttribute )->getDateTime( $this->_oData );
	}


	public function getDouble( Inx_Api_Recipient_Attribute $oAttribute )
	{
		return $this->checkReadAccess( $oAttribute )->getDouble( $this->_oData );
	}


	public function getInteger( Inx_Api_Recipient_Attribute $oAttribute )
	{
		return $this->checkReadAccess( $oAttribute )->getInteger( $this->_oData );
	}


	public function getRecipientState()
	{
		return $this->_oData->recipientState;
	}


	public function getString( Inx_Api_Recipient_Attribute $oAttribute )
	{
		return $this->checkReadAccess( $oAttribute )->getString( $this->_oData );
	}


	public function getTime( Inx_Api_Recipient_Attribute $oAttribute )
	{
		return $this->checkReadAccess( $oAttribute )->getTime( $this->_oData );
	}


	public function getObject( Inx_Api_Recipient_Attribute $oAttribute )
	{
		return $this->checkReadAccess( $oAttribute )->getObject( $this->_oData );
	}


	private function checkReadAccess( Inx_Api_Recipient_Attribute $oAttribute )
	{
		if( $this->_oRecipientContext == null || $this->_aAttrGetterMapping == null )
			throw new Inx_Api_IllegalArgumentException( "attribute not in fetch profile" );
		
		//fixes XAPI-118: throw Inx_Api_UnknownRecipientException if recipient is unknown
		if ($this->_oData->recipientState == Inx_Api_Inbox_InboxMessage::RECIPIENT_STATE_UNKNOWN)
			throw new Inx_Api_UnknownRecipientException("recipient state is unknown; cannot fetch recipient data");
		
		if( $oAttribute->getContext() === $this->_oRecipientContext )
		{
			$ret = $this->_aAttrGetterMapping[ $oAttribute->getId() ];
			if($ret === null)
				throw new Inx_Api_IllegalArgumentException( "attribute not in fetch profile" );
				
			return $ret;
		}
		
		throw new Inx_Api_IllegalStateException( "wrong context" );
	}


	public function getMatchedEmailAddress()
	{
		return $this->_oData->matchedEmail;
	}


	protected static function convert( Inx_Apiimpl_SessionContext $oSessionContext, stdClass $oMessageData )
	{
		if( $oMessageData == null )
			return null;
		return new Inx_Apiimpl_Inbox_InboxMessageImpl( $oSessionContext, $oMessageData, null, null );
	}
}
