<?php

/**
 * MailingImpl
 *
 * @version $Revision: 7335 $ $Date: 2007-09-10 14:58:22 +0200 (Mo, 10 Sep 2007) $ $Author: sbn $
 */
class Inx_Apiimpl_Mailing_MailingImpl implements Inx_Api_Mailing_Mailing
{

	/**
	 * Enter description here...
	 *
	 * @var Inx_Apiimpl_SessionContext
	 */
	public $oSc;

	protected $_oMService;

	/**
	 * Enter description here...
	 *
	 * @var stdClass
	 */
	public $oData;

	/**
	 * Enter description here...
	 *
	 * @var Inx_Api_LockTicket
	 */
	protected $oLock;

	/**
	 * Enter description here...
	 *
	 * @var Inx_Apiimpl_Mailing_MailingContentHandler
	 */
	public $oContentHandler;

	/**
	 * Enter description here...
	 *
	 * @var array
	 */
	public $_aChangedAttrs;


	/**
	 * Enter description here...
	 *
	 * @param Inx_Apiimpl_SessionContext $oSc
	 * @param stdClass $oData
	 * @param int $iListContextId
	 * @param int $iFeatureId
	 * throws Inx_Api_DataException
	 */
	public function __construct( Inx_Apiimpl_SessionContext $oSc, stdClass $oData = null, $iListContextId = null, $iFeatureId = null )
	{
		$this->oSc = $oSc;
		$this->_oMService = $this->oSc->getService( Inx_Apiimpl_SessionContext::MAILING6_SERVICE );
		
		if ( $oData != null ) {
			$this->refreshData( $oData );
		} else {
			$this->oData = new stdClass();
			$this->oData->id = null;
			$this->oData->filterIds = null;
			$this->oData->filterConcatType = 0;
			$this->oData->lazyData = new stdClass();
			$this->oData->lazyData->id = null;
			$this->oData->state = Inx_Api_Mailing_Mailing::STATE_DRAFT;
			$this->updateListContextId( $iListContextId );
			$this->updateFeatureId( $iFeatureId );
			$this->setContentHandler( 'Inx_Api_Mailing_PlainTextContentHandler' );
		}
	}
	 
	/**
	 * Enter description here...
	 *
	 * @param string $sTestAddress
	 * @param int $iRecipientId
	 * @return null
	 * @throws SendException, Inx_Api_Mailing_MailingStateException, Inx_Api_DataException
	 */
	public function sendTestMail( $sTestAddress, $iRecipientId )
	{
	    if (!is_int($iRecipientId)) {
	        throw new Inx_Api_IllegalArgumentException('Integer parameter $iRecipientId expected, got '.gettype($iRecipientId));
	    }
	    
	    if( $sTestAddress == null )
			throw new Inx_Api_IllegalArgumentException( "\$sTestAddress mustn't be null" );
		try
		{
			$h = $this->_oMService->sendMailing( $this->oSc->createCxt(), $this->getId(), true,
				Inx_Apiimpl_TConvert::TConvert( $iRecipientId ), Inx_Apiimpl_TConvert::TConvert( $sTestAddress ) );
			$this->refreshData( $h->value );
			 
			$oDesc = $h->mailingExcDesc;

			if( !empty($oDesc) )
			{
				if( $oDesc->type == Inx_Api_Mailing_MailingConstants::MAILING_EXCEPTION_TYPE_STATE )
					throw $this->createStateException( $oDesc );
				if( $oDesc->type == Inx_Api_Mailing_MailingConstants::MAILING_EXCEPTION_TYPE_MAILING_FEATURE_DISABLED )
					throw new Inx_Api_FeatureNotAvailableException( "" . Inx_Api_Features::MAILING_FEATURE_ID );
				else
					throw $this->createSendException( $oDesc );
			}
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->oSc->notify( $e );
		}
	}
	
	public function sendTestMailWithTestprofile( $sTestAddress, $iTestprofileId )
	{
	    if (!is_int($iTestprofileId)) {
	        throw new Inx_Api_IllegalArgumentException('Integer parameter $iTestprofileId expected, got '.gettype($iTestprofileId));
	    }
	    
	    if( $sTestAddress == null )
			throw new Inx_Api_IllegalArgumentException( "\$sTestAddress mustn't be null" );
		try
		{
			$h = $this->_oMService->sendTestMailingTestprofile( $this->oSc->createCxt(), $this->getId(), $iTestprofileId, $sTestAddress );
			$this->refreshData( $h->value );
			 
			$oDesc = $h->mailingExcDesc;

			if( !empty($oDesc) )
			{
				if( $oDesc->type == Inx_Api_Mailing_MailingConstants::MAILING_EXCEPTION_TYPE_STATE )
					throw $this->createStateException( $oDesc );
				if( $oDesc->type == Inx_Api_Mailing_MailingConstants::MAILING_EXCEPTION_TYPE_MAILING_FEATURE_DISABLED )
					throw new Inx_Api_FeatureNotAvailableException( "" . Inx_Api_Features::MAILING_FEATURE_ID );
				else
					throw $this->createSendException( $oDesc );
			}
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->oSc->notify( $e );
		}
	}

	/**
	 * Enter description here...
	 *
	 * @param int $iRecipientId
	 * @throws Inx_Api_Mailing_SendException, Inx_Api_Mailing_MailingStateException, Inx_Api_DataException
	 */
	public function sendSingleMail( $iRecipientId )
	{
	    if (!is_int($iRecipientId)) {
	        throw new Inx_Api_IllegalArgumentException('Integer parameter $iRecipientId expected, got '.gettype($iRecipientId));
	    }
	    try
		{	
			$h = $this->_oMService->sendMailing( $this->oSc->createCxt(), $this->getId(), false,
			Inx_Apiimpl_TConvert::TConvert( $iRecipientId ), null );
			$this->refreshData( $h->value );
			 
			$oDesc = $h->mailingExcDesc;
			if( $oDesc != null )
			{
				if( $oDesc->type == Inx_Api_Mailing_MailingConstants::MAILING_EXCEPTION_TYPE_STATE )
					throw $this->createStateException( $oDesc );
				if( $oDesc->type == Inx_Api_Mailing_MailingConstants::MAILING_EXCEPTION_TYPE_MAILING_FEATURE_DISABLED )
					throw new Inx_Api_FeatureNotAvailableException( Inx_Api_Features::MAILING_FEATURE_ID );
				else
					throw new Inx_Api_Mailing_SendException( $oDesc->msg );
			}
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->oSc->notify( $e );
		}
	}


	/**
	 * Enter description here...
	 * 
	 * @throws Inx_Api_Mailing_MailingStateException, Inx_Api_DataException
	 */
	public function startSending()
	{
		try
		{
			$h = $this->_oMService->sendMailing( $this->oSc->createCxt(), $this->getId(), false, null, null );
			$this->refreshData( $h->value );
			 
			$oDesc = $h->mailingExcDesc;
			if(! empty($oDesc) )
			{
				if( $oDesc->type == Inx_Api_Mailing_MailingConstants::MAILING_EXCEPTION_TYPE_MAILING_FEATURE_DISABLED )
					throw new Inx_Api_FeatureNotAvailableException( "" . Inx_Api_Features::MAILING_FEATURE_ID );
				throw $this->createStateException( $oDesc );
			}
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->oSc->notify( $e );
		}
	}

	/**
	 * @throws Inx_Api_Mailing_MailingStateException, Inx_Api_DataException
	 */
	public function stopSending()
	{
		try
		{
			$h = $this->_oMService->stopMailing( $this->oSc->createCxt(), $this->getId() );
			$this->refreshData( $h->value );
			 
			$oDesc = $h->mailingExcDesc;
			if(! empty($oDesc) )
			{
				if( $oDesc->type == Inx_Api_Mailing_MailingConstants::MAILING_EXCEPTION_TYPE_MAILING_FEATURE_DISABLED )
					throw new Inx_Api_FeatureNotAvailableException( "" . Inx_Api_Features::MAILING_FEATURE_ID );
				throw $this->createStateException( $oDesc );
			}
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->oSc->notify( $e );
		}
	}
	
	public function getSendingInfo()
	{
		try
		{
			$siDTO = $this->_oMService->getSendingInfo( $this->oSc->createCxt(), $this->getId() );
			if( !empty($siDTO->getExcDesc) )
				throw new DataException( "deleted object" );
			return new Inx_Apiimpl_Mailing_SendingInfoImpl( $siDTO->averageMailSize, $siDTO->deliveredMails, 
						$siDTO->notDeliveredMails, $siDTO->notSentMails, $siDTO->bouncedMails );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->oSc->notify( $e );
		}
		return new SendingInfoImpl( 0, 0, 0, 0, 0 );
	}


	public function approve( $approverId = 0, $comment=null )
	{
		#fixes XAPI-31: added $ signs
		$this->appr( $approverId, $comment, 0 );
	}


	public function denyApprove( $approverId, $comment ) 
	{
		#fixes XAPI-31: added $ signs
		$this->appr( $approverId, $comment, 1 );
	}


	private function appr( $approverId, $comment, $type ) 
	{

		if($approverId == 0 && empty($comment))
		{
			$this->changeState( Inx_Api_Mailing_Mailing::STATE_APPROVED );
			return;
		}	
		try
		{
			$h = $this->_oMService->approveRequest( $this->oSc->createCxt(), $this->getId(), $approverId, $type, 
											Inx_Apiimpl_TConvert::TConvert($comment) );
			if( !empty($h->updExcDesc) )
				throw new Inx_Api_UpdateException( $h->updExcDesc->msg, $h->updExcDesc->type,
								$h->updExcDesc->source );
			if( !empty($h->mailingExcDesc) )
				throw $this->createStateException( $h->mailingExcDesc );
			$this->refreshData( $h->value );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->oSc->notify( $x );
		}
	}
	
	public function requestEscalationApproval( $escalationDate, $deadline, $approverIds, $recipientIds,
			$isTestRecipient, $locale )
	{
		$this->requestAppr( $escalationDate, $deadline, $approverIds, $recipientIds, $isTestRecipient, true, $locale );

	}


	public function requestIdenticalApproval( $deadline, $approverIds, $recipientIds,
			$isTestRecipient, $locale ) 
	{
		$this->requestAppr( null, $deadline, $approverIds, $recipientIds, $isTestRecipient, false, $locale );
	}


	private function requestAppr( $escalationDate = null, $deadline, $approverIds, $recipientIds,
			$isTestRecipient, $isEscalation, $locale ) 
	{

		$approvalType = 0;
		if( $isEscalation )
			$approvalType = 1;
		try
		{
			//fixes XAPI-52: added $ signs
			$h = $this->_oMService->requestApproval( $this->oSc->createCxt(), $this->getId(), $approvalType, 
								Inx_Apiimpl_TConvert::TConvert( $escalationDate ), 
								Inx_Apiimpl_TConvert::TConvert( $deadline ), 
								Inx_Apiimpl_TConvert::arrToTArr( $approverIds ),
								Inx_Apiimpl_TConvert::arrToTArr( $recipientIds ), $isTestRecipient, $locale );
			if( !empty($h->updExcDesc) )
				throw new Inx_Api_UpdateException( $h->updExcDesc->msg, $h->updExcDesc->type,
								$h->updExcDesc->source );
			if( !empty($h->mailingExcDesc) )
				throw $this->createStateException( $h->mailingExcDesc );
			$this->refreshData( $h->value );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->oSc->notify( $x );
		}
	}
	
	/**
	 * Enter description here...
	 *
	 * @throws Inx_Api_Mailing_MailingStateException, Inx_Api_DataException
	 */
	public function requestApproval()
	{
		$this->changeState( Inx_Api_Mailing_Mailing::STATE_TO_BE_APPROVE );
	}
	
	
	public function revokeApproval( $comment=null )
	{
		if(empty($comment))
		{
			$this->changeState( Inx_Api_Mailing_Mailing::STATE_DRAFT );
			return;
		}
		
		try
		{
			$h = $this->_oMService->requestRevokeApproval(  $this->oSc->createCxt(), $this->getId(),
											Inx_Apiimpl_TConvert::TConvert($comment) );
			if( !empty($h->updExcDesc) )
				throw new Inx_Api_UpdateException( $h->updExcDesc->msg, $h->updExcDesc->type,
								$h->updExcDesc->source );
			if( !empty($h->mailingExcDesc) )
				throw $this->createStateException( $h->mailingExcDesc );
			$this->refreshData( $h->value );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->oSc->notify( $x );
		}

	}
	
	
	public function scheduleMailing( $scheduleTime = null )
	{
		try
		{
			$retObj = new stdClass();
			
			#fixes XAPI-31
			if(empty($scheduleTime))
			{
				$retObj->scheduleDate = Inx_Apiimpl_TConvert::TConvert($this->getScheduleDatetime());
			}
			else
			{
				$retObj->scheduleDate = Inx_Apiimpl_TConvert::TConvert($scheduleTime);
			}
    		
			$h = $this->_oMService->scheduleMailing( $this->oSc->createCxt(), $this->getId(), $retObj );
			if( !empty($h->mailingExcDesc) )
				throw $this->createStateException( $h->mailingExcDesc );
			$this->refreshData( $h->value );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->oSc->notify( $x );
		}
	}


	public function unscheduleMailing()
	{
		try
		{
			$h = $this->_oMService->unscheduleMailing( $this->oSc->createCxt(), $this->getId() );
			if( !empty($h->mailingExcDesc) )
				throw $this->createStateException( $h->mailingExcDesc );
			$this->refreshData( $h->value );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->oSc->notify( $x );
		}

	}

	/**
	 * Enter description here...
	 *
	 * @param int $iState
	 * @throws Inx_Api_Mailing_MailingStateException, Inx_Api_DataException
	 */
	private function changeState( $iState )
	{
	    if (!is_int($iState)) {
	        throw new Inx_Api_IllegalArgumentException('Integer parameter $iState expected, got '.gettype($iState));
	    }
	    try
		{
			$h = $this->_oMService->changeState( $this->oSc->createCxt(), $this->getId(), $iState );
			$this->refreshData( $h->value );
			
			if(! empty($h->mailingExcDesc) )
				throw $this->createStateException( $h->mailingExcDesc );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->oSc->notify( $e );
		}
	}

	/**
	 * Enter description here...
	 * @throws Inx_Api_Mailing_MailingStateException, LockException, Inx_Api_DataException
	 */
	public function lock()
	{
		try
		{
			$h = $this->_oMService->lock( $this->oSc->createCxt(), $this->getId(), true, false );
			
			$this->refreshData( $h->value );
			 
			if(! empty($h->mailingExcDesc) )
				throw $this->createStateException( $h->mailingExcDesc );
			if( !$h->lockReturn )
				throw new Inx_Api_LockException( "mailing is already locked", $this->oLock );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->oSc->notify( $e );
		}
	}

	/**
	 * Enter description here...
	 *
	 * @param boolean $blForceForeignLock
	 * @return unknown
	 * @throws Inx_Api_DataException
	 */
	public function unlock( $blForceForeignLock = false )
	{
		try
		{
			$h = $this->_oMService->lock( $this->oSc->createCxt(), $this->getId(), false, $blForceForeignLock );
			$this->refreshData( $h->value );
			return $h->lockReturn;
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->oSc->notify( $e );
			return false;
		}
	}


	/**
	 * Enter description here...
	 *
	 * @return int
	 */
	public function getId()
	{
		return $this->oData->id;
	}

	/**
	 * Enter description here...
	 *
	 * @return int
	 */
	public function getState()
	{
		return $this->oData->state;
	}

	/**
	 * Enter description here...
	 *
	 * @return boolean
	 */
	public function isLocked()
	{
		return ($this->oLock != null);
	}

	/**
	 * Enter description here...
	 *
	 * @return Inx_Api_LockTicket
	 */
	public function getLockTicket()
	{
		return $this->oLock;
	}

	/**
	 * Enter description here...
	 *
	 * @return Date
	 */
	public function getModificationDatetime()
	{
		return Inx_Apiimpl_TConvert::convert( $this->oData->modDatetime );
	}

	public function getScheduleDatetime()
	{
		return Inx_Apiimpl_TConvert::convert( $this->oData->scheduleDatetime );
	}

	/**
	 * Enter description here...
	 *
	 * @param Date $dtScheduleDatetime
	 */
	public function updateScheduleDatetime( $dtScheduleDatetime )
	{
		$this->checkWriteAccess();
		$this->oData->scheduleDatetime = Inx_Apiimpl_TConvert::TConvert( $dtScheduleDatetime );
		$this->_aChangedAttrs[ Inx_Api_Mailing_Mailing::ATTRIBUTE_SCHEDULE_DATETIME ] = true;
	}
	
	/**
	 * Enter description here...
	 *
	 * @return Date
	 */
	public function getSentDatetime()
	{
		return Inx_Apiimpl_TConvert::convert( $this->oData->sentDatetime );
	}
	
	public function getDeadlineDatetime()
	{
		return Inx_Apiimpl_TConvert::convert( $this->oData->deadlineDatetime );
	}
	
	
	public function getEscalationDatetime()
	{
		return Inx_Apiimpl_TConvert::convert( $this->oData->escalationDatetime );
	}
	
	public function getCreationDatetime()
	{
		return Inx_Apiimpl_TConvert::convert( $this->oData->createDatetime );
	}

	public function getListContextId()
	{
		return $this->oData->listContextId;
	}

	private function updateListContextId( $iListContextId )
	{
	    if (!is_int($iListContextId)) {
	        throw new Inx_Api_IllegalArgumentException('Integer parameter $iListContextId expected, got '.gettype($iListContextId));
	    }
	    $this->checkWriteAccess();
		$this->oData->listContextId = $iListContextId;
		$this->_aChangedAttrs[ Inx_Api_Mailing_MailingConstants::INTERNAL_MAILING_LIST_ID ] = true;
	}

	public function getFeatureId()
	{
		return $this->oData->featureId;
	}

	/**
	 * Enter description here...
	 *
	 * @param int $iFeatureId
	 */
	private function updateFeatureId( $iFeatureId )
	{
	    if (!is_int($iFeatureId)) {
	        throw new Inx_Api_IllegalArgumentException('Integer parameter $iListContextId expected, got '.gettype($iFeatureId));
	    }
	    $this->checkWriteAccess();
		$this->oData->featureId = $iFeatureId;
		$this->_aChangedAttrs[ Inx_Api_Mailing_MailingConstants::INTERNAL_MAILING_FEATURE_ID ] = true;
	}


	
	public function getFilterId()
	{
		if( empty($this->oData->filterIds) )
				return 0;
		return $this->oData->filterIds[0]->value;
	}


	public function updateFilterId( $iFilterId )
	{
		if (!is_int($iFilterId)) {
	        throw new Inx_Api_IllegalArgumentException('Integer parameter $iFilterId expected, got '.gettype($iFilterId));
	    }
	    $this->checkWriteAccess();
		$this->oData->filterIds = Inx_Apiimpl_TConvert::arrToTArr(array($iFilterId));
		$this->_aChangedAttrs[ Inx_Api_Mailing_Mailing::ATTRIBUTE_FILTER_ID ] = true;
	}


	public function getFilterConcatinationType()
	{
		return $this->oData->filterConcatType;
	}


	public function getFilterIds()
	{
		$ints = $this->oData->filterIds;
		if( empty($ints) )
			return null;
		return Inx_Apiimpl_TConvert::arrToTArr( $ints );
	}


	public function updateFilterIds( $filterIds, $concatinationType )
	{
		$this->checkWriteAccess();
		$this->oData->filterIds = Inx_Apiimpl_TConvert::arrToTArr($filterIds);
		$this->oData->filterConcatType = $concatinationType;
		$this->_aChangedAttrs[ Inx_Api_Mailing_Mailing::ATTRIBUTE_FILTER_ID ] = true;
	}
	

	public function getSubject()
	{
		return Inx_Apiimpl_TConvert::convert( $this->oData->subject );
	}

	/**
	 * Enter description here...
	 *
	 * @param String $sSubject
	 */
	public function updateSubject( $sSubject )
	{
		$this->checkWriteAccess();
		$this->oData->subject = Inx_Apiimpl_TConvert::TConvert( $sSubject );
		$this->_aChangedAttrs[ Inx_Api_Mailing_Mailing::ATTRIBUTE_SUBJECT ] = true;
	}
	
	public function getName()
	{
		return Inx_Apiimpl_TConvert::convert( $this->oData->name );
	}

	/**
	 * Enter description here...
	 *
	 * @param String $sName
	 */
	public function updateName( $sName )
	{
		$this->checkWriteAccess();
		$this->oData->name = Inx_Apiimpl_TConvert::TConvert( $sName );
		$this->_aChangedAttrs[ Inx_Api_Mailing_Mailing::ATTRIBUTE_NAME ] = true;
	}
	
	

	/**
	 * Enter description here...
	 *
	 * @return String
	 */
	public function getSenderAddress()
	{
		$this->checkLazyData();
		return Inx_Apiimpl_TConvert::convert( $this->oData->lazyData->senderAddress );
	}

	/**
	 * Enter description here...
	 *
	 * @param String $sSenderAddress
	 */
	public function updateSenderAddress( $sSenderAddress )
	{
		$this->checkLazyData();
		$this->checkWriteAccess();
		$this->oData->lazyData->senderAddress = Inx_Apiimpl_TConvert::TConvert( $sSenderAddress );
		$this->_aChangedAttrs[ Inx_Api_Mailing_Mailing::ATTRIBUTE_SENDER_ADDRESS ] = true;
	}

	public function getRecipientAddress()
	{
		$this->checkLazyData();
		return Inx_Apiimpl_TConvert::convert( $this->oData->lazyData->recipientAddress );
	}

	/**
	 * Enter description here...
	 *
	 * @param String $sRecipientAddress
	 */
	public function updateRecipientAddress( $sRecipientAddress )
	{
		$this->checkLazyData();
		$this->checkWriteAccess();
		$this->oData->lazyData->recipientAddress = Inx_Apiimpl_TConvert::TConvert( $sRecipientAddress );
		$this->_aChangedAttrs[ Inx_Api_Mailing_Mailing::ATTRIBUTE_RECIPIENT_ADDRESS ] = true;
	}

	public function getReplyToAddress()
	{
		$this->checkLazyData();
		return Inx_Apiimpl_TConvert::convert( $this->oData->lazyData->replyToAddress );
	}

	/**
	 * Enter description here...
	 *
	 * @param String $sReplyToAddress
	 */
	public function updateReplyToAddress( $sReplyToAddress )
	{
		$this->checkLazyData();
		$this->checkWriteAccess();
		$this->oData->lazyData->replyToAddress = Inx_Apiimpl_TConvert::TConvert( $sReplyToAddress );
		$this->_aChangedAttrs[ Inx_Api_Mailing_Mailing::ATTRIBUTE_REPLY_TO_ADDRESS ] = true;
	}

	/**
	 * Enter description here...
	 *
	 * @return Integer
	 */
	public function getPriority()
	{
		$this->checkLazyData();
		return Inx_Apiimpl_TConvert::convert( $this->oData->lazyData->priority );
	}

	/**
	 * Enter description here...
	 *
	 * @param Integer $iPriority
	 */
	public function updatePriority( $iPriority )
	{
	    if (!is_int($iPriority)) {
	        throw new Inx_Api_IllegalArgumentException('Integer parameter $iPriority expected, got '.gettype($iPriority));
	    }
	    if( $iPriority !== null && ($iPriority < 1 || $iPriority > 5 ) ) {
			throw new Inx_Api_IllegalArgumentException( "illegal priority value: " . $iPriority );
		}
		
		$this->checkLazyData();
		$this->checkWriteAccess();
		$this->oData->lazyData->priority = Inx_Apiimpl_TConvert::TConvert( $iPriority );
		$this->_aChangedAttrs[ Inx_Api_Mailing_Mailing::ATTRIBUTE_PRIORITY ] = true;
	}

	public function getContentHandler()
	{
		$this->checkLazyData();
		if( $this->oContentHandler == null )
			$this->oContentHandler = Inx_Apiimpl_Mailing_MailingContentHandler::createContentHandler( $this );
		return $this->oContentHandler;
	}

	/**
	 * Enter description here...
	 *
	 * @param string $sContentHandlerClazz
	 */
	public function setContentHandler( $sContentHandlerClazz )
	{
		$this->checkLazyData();
		$this->checkWriteAccess();
		$newCh = Inx_Apiimpl_Mailing_MailingContentHandler::createContentHandler( $this, $sContentHandlerClazz );
	  
		if( $this->oContentHandler != null )
			$this->oContentHandler = null;
			  
		$this->oContentHandler = $newCh;
	  
		$this->oData->contentMailType = $newCh->getMailingContentType();
		$this->_aChangedAttrs[ Inx_Api_Mailing_MailingConstants::INTERNAL_MAILING_CONTENT_MAIL_TYPE ] = true;
	}


	/**
	 * Enter description here...
	 * 
	 * @throws Inx_Api_UpdateException, Inx_Api_DataException
	 */
	public function commitUpdate()
	{
		try {
			$ms = $this->oSc->getService( Inx_Apiimpl_SessionContext::MAILING6_SERVICE );
			$h = $ms->update( $this->oSc->createCxt(), $this->oData, Inx_Apiimpl_TConvert::arrToTArr( $this->_aChangedAttrs ) );
			
			if(! empty($h->updExcDesc) )
				throw new Inx_Api_UpdateException( $h->updExcDesc->msg, $h->updExcDesc->type,
								$h->updExcDesc->source );
					
			if(! empty($h->value))
			{
				$this->oData = $h->value;
				$this->_aChangedAttrs = null;
				if( $this->oContentHandler != null ) {
					$this->oContentHandler->destroy();
					$this->oContentHandler=null;
				}
				$this->_aChangedAttrs = null;
			}
			else
				throw new Inx_Api_DataException( "deleted object" );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->oSc->notify( $e );
		}
	}


	/**
	 * @throws Inx_Api_DataException
	 */
	public function reload()
	{
		$this->_aChangedAttrs = null;
		if( $this->oContentHandler != null )
		{
			$this->oContentHandler = null;
		}

		$ms = $this->oSc->getService( Inx_Apiimpl_SessionContext::MAILING6_SERVICE );
		try
		{
			$oRetData = $ms->get( $this->oSc->createCxt(), $this->oData->id );
			if(empty($oRetData))
				throw new Inx_Api_DataException( "deleted object" );
			else
				$this->oData = $oRetData;
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->oSc->notify( $e );
		}
	}

	/**
	 * Enter description here...
	 *
	 * @param Inx_Apiimpl_SessionContext $oSc
	 * @param array $aData
	 * @return unknown
	 */
	public static function convert( Inx_Apiimpl_SessionContext $oSc, $aData )
	{
		if( $aData === null || sizeof($aData) == 0 ) {
			return array();
		}
	  
		$ms = array();
		
		foreach ($aData as $i => $value) {
			try {
				$ms[$i] = new Inx_Apiimpl_Mailing_MailingImpl($oSc, $value);
			} catch (Inx_Api_DataException $e) {
				$ms[$i] = null;
			}
		}
		return $ms;	
	}


	public function checkWriteAccess()
	{
		if( $this->_aChangedAttrs == null && Inx_Api_Mailing_MailingConstants::MAILING_MAX_CHANGEDATTR_SIZE>0)
			$this->_aChangedAttrs = array_fill(0, Inx_Api_Mailing_MailingConstants::MAILING_MAX_CHANGEDATTR_SIZE, null);
	}


	public function checkLazyData()
	{
		try
		{
			if( $this->oData->lazyData == null )
			{
				if( $this->oData->id == Inx_Apiimpl_Constants::ID_UNSPECIFIED )
				{
					$this->oData->lazyData = new stdClass(); // TODO review for new LazyData() instead of new stdClass()
				}
				else
				{
					$ms = $this->oSc->getService( Inx_Apiimpl_SessionContext::MAILING6_SERVICE );
					$this->oData->lazyData = $ms->getLazyData( $this->oSc->createCxt(), $this->oData->id );
				}
			}
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->oSc->notify( $e );
		}
	}


	/**
	 * Enter description here...
	 *
	 * @param stdClass $oData
	 * @throws Inx_Api_DataException
	 */
	protected function refreshData( stdClass $oData )
	{
		if( $oData == null )
			throw new Inx_Api_DataException( "mailing is orphaned" );
		$this->oData = $oData;
		if( empty($this->oData->lock) ) {
			$this->oLock = null;
		} else {
			$ld = $this->oData->lock;
			$this->oLock = new Inx_Api_LockTicket( $ld->userId, $ld->userName,
									$ld->source, $ld->datetime, $ld->foreignLock );
		}
	}

	/**
	 * Enter description here...
	 *
	 * @param stdClass $x
	 * @return Inx_Api_Mailing_MailingStateException
	 */
	protected static function createStateException( stdClass $x )
	{
		return new Inx_Api_Mailing_MailingStateException( $x->msg, $x->currentState, $x->currentLock );
	}

	/**
	 * Enter description here...
	 *
	 * @param stdClass $x
	 * @return Inx_Api_Mailing_SendException
	 */
	protected static function createSendException( stdClass $x )
	{
		return new Inx_Api_Mailing_SendException( $x->msg );
	}
}
