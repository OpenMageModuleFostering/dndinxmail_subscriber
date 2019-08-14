<?php
class Inx_Apiimpl_TriggerMailing_TriggerMailingImpl implements Inx_Api_TriggerMailing_TriggerMailing
{
	private $sc;

	private $mService;

	public $data;

	private $lock;

	public $contentHandler;

	public $changedAttrs;


	public function __construct( Inx_Apiimpl_SessionContext $sc, stdClass $data = null, $iListContextId = null, 
                $iFeatureId = null, Inx_Api_TriggerMailing_Descriptor_TriggerDescriptor $triggerDescriptor = null )
	{
		$this->sc = $sc;
		$this->mService = $this->sc->getService( Inx_Apiimpl_SessionContext::TRIGGER_MAILING_SERVICE );

                if($data != null)
                {
                    $this->refreshData( $data );
                }
                else
                {
                    $this->data = new stdClass();
                    $this->data->id = null;
                    $this->data->filterIds = null;
                    $this->data->filterConcatType = null;
                    $this->data->lazyData = new stdClass();
                    $this->data->lazyData->id = null;
                    $this->data->mailingState = Inx_Api_TriggerMailing_TriggerMailingState::DRAFT()->getId();
                    $this->data->active = false;
                    $this->updateTriggerDescriptor( $triggerDescriptor );
                    $this->updateListContextId( $iListContextId );
                    $this->updateFeatureId( $iFeatureId );
                    $this->setContentHandler( 'Inx_Api_Mailing_PlainTextContentHandler' );
                    
                    if($triggerDescriptor->getType() !== Inx_Api_TriggerMailing_Descriptor_TriggerType::ACTION_MAILING())
                    {
                        $this->data->triggerState = Inx_Api_TriggerMailing_TriggerState::INACTIVE()->getId();
                    }
                    else 
                    {
                        $this->data->triggerState = Inx_Api_TriggerMailing_TriggerState::UNSPECIFIED()->getId();
                    }
                }		
	}


	public function sendTestMail( $sTestAddress, $iRecipientId )
	{
		if( null === $sTestAddress )
		{
			throw new Inx_Api_IllegalArgumentException( "testAddress mustn't be null" );
		}

		try
		{
			$h = $this->mService->sendTestMailing( $this->sc->createCxt(), $this->getId(), 
                                $iRecipientId, $sTestAddress );
			$this->refreshData( $h->value );

			$desc = $h->mailingExcDesc;

			if( $desc != null )
			{
				if( $desc->type === Inx_Api_TriggerMail_TriggerMailingExceptionType::STATE()->getId() )
				{
					throw $this->createStateException( $desc );
				}

				if( $desc->type === Inx_Api_TriggerMail_TriggerMailingExceptionType::MAILING_FEATURE_DISABLED()->getId() )
				{
					throw new Inx_api_FeatureNotAvailableException( "" . Inx_Api_Features::MAILING_FEATURE_ID );
				}
				else
				{
					throw self::createSendException( $desc );
				}
			}
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->sc->notify( $x );
		}
	}


	public function sendTestMailWithTestprofile( $sTestAddress, $iTestprofileId )
	{
		if( null === $sTestAddress )
		{
			throw new Inx_Api_IllegalArgumentException( "testAddress mustn't be null" );
		}

		try
		{
			$h = $this->mService->sendTestMailingTestprofile( $this->sc->createCxt(), $this->getId(),
                                    $iTestprofileId, $sTestAddress );
			$this->refreshData( $h->value );

			$desc = $h->mailingExcDesc;

			if( $desc != null )
			{
				if( $desc->type() === Inx_Api_TriggerMail_TriggerMailingExceptionType::STATE()->getId() )
				{
					throw $this->createStateException( $this->desc );
				}

				if( $desc->type === Inx_Api_TriggerMail_TriggerMailingExceptionType::MAILING_FEATURE_DISABLED()->getId() )
				{
					throw new Inx_Api_FeatureNotAvailableException( "" . Inx_Api_Features::MAILING_FEATURE_ID );
				}
				else
				{
					throw self::createSendException( $desc );
				}
			}
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->sc->notify( $x );
		}
	}


	public function activateSending()
	{
		try
		{
			$h = $this->mService->activateSending( $this->sc->createCxt(), $this->getId() );
			$this->refreshData( $h->value );

			$desc = $h->mailingExcDesc;

			if( $desc != null )
			{
				if( $desc->type === Inx_Api_TriggerMail_TriggerMailingExceptionType::MAILING_FEATURE_DISABLED()->getId() )
				{
					throw new Inx_Api_FeatureNotAvailableException( "" . Inx_Api_Features::MAILING_FEATURE_ID );
				}

				throw $this->createStateException( $desc );
			}
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->sc->notify( $x );
		}
	}


	public function deactivateSending( $blStopActiveSending )
	{
		try
		{
			$h = $this->mService->deactivateSending( $this->sc->createCxt(), $this->getId(), $blStopActiveSending );
			$this->refreshData( $h->value );

			$desc = $h->mailingExcDesc;

			if( $desc != null )
			{
				if( $desc->type === Inx_Api_TriggerMail_TriggerMailingExceptionType::MAILING_FEATURE_DISABLED()->getId() )
				{
					throw new Inx_Api_FeatureNotAvailableException( "" . Inx_Api_Features::MAILING_FEATURE_ID );
				}

				throw $this->createStateException( $desc );
			}
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->sc->notify( $x );
		}
	}


	public function approveImmediately( $sComment )
	{
		try
		{
			$h = $this->mService->approveImmediately( $this->sc->createCxt(), $this->getId(), 
                            Inx_Apiimpl_TConvert::TConvert($sComment) );

			if( $h->updExcDesc != null )
			{
				throw new Inx_Api_UpdateException( $h->updExcDesc->msg, $h->updExcDesc->type, 
                                        $h->updExcDesc->source );
			}

			if( $h->mailingExcDesc != null )
			{
				throw $this->createStateException( $h->mailingExcDesc );
			}

			$this->refreshData( $h->value );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->sc->notify( $x );
		}
	}


	public function approve( $iApproverId, $sComment )
	{
		$this->appr( $iApproverId, $sComment, 0 );
	}


	public function denyApprove( $iApproverId, $sComment )
	{
		$this->appr( $iApproverId, $sComment, 1 );
	}


	private function appr( $iApproverId, $sComment, $iType )
	{
		try
		{
			$h = $this->mService->approveRequest( $this->sc->createCxt(), $this->getId(), 
                                $iApproverId, $iType, Inx_Apiimpl_TConvert::TConvert( $sComment ) );

			if( $h->updExcDesc != null )
			{
				throw new Inx_Api_UpdateException( $h->updExcDesc->msg, $h->updExcDesc->type, 
                                        $h->updExcDesc->source );
			}

			if( $h->mailingExcDesc != null )
			{
				throw $this->createStateException( $h->mailingExcDesc );
			}

			$this->refreshData( $h->value );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->sc->notify( $x );
		}
	}


	public function requestEscalationApproval( $sEscalationDate, $sDeadline, array $approverIds, array $recipientIds,
			$blIsTestRecipient, $sLocale )
	{
		$this->requestAppr( $sEscalationDate, $sDeadline, $approverIds, $recipientIds, $blIsTestRecipient, 
                        true, $sLocale );
	}


	public function requestIdenticalApproval( $sDeadline, array $approverIds, array $recipientIds,
			$blIsTestRecipient, $sLocale )
	{
		$this->requestAppr( null, $sDeadline, $approverIds, $recipientIds, $blIsTestRecipient, false, $sLocale );
	}


	private function requestAppr( $sEscalationDate, $sDeadline, array $approverIds, array $recipientIds,
			$blIsTestRecipient, $blIsEscalation, $sLocale )
	{
		if( $sLocale == null )
		{
			throw new Inx_Api_IllegalArgumentException( "locale of the approvers must be set" );
		}

		$approvalType = 0;

		if( $blIsEscalation )
		{
			$approvalType = 1;
		}

		try
		{
			$h = $this->mService->requestApproval( $this->sc->createCxt(), $this->getId(), $approvalType, 
                                Inx_Apiimpl_TConvert::TConvert($sEscalationDate), 
                                Inx_Apiimpl_TConvert::TConvert( $sDeadline ), 
                                Inx_Apiimpl_TConvert::arrToTArr( $approverIds ),
                                Inx_Apiimpl_TConvert::arrToTArr( $recipientIds ), $blIsTestRecipient, $sLocale );

			if( $h->updExcDesc != null )
			{
				throw new Inx_Api_UpdateException( $h->updExcDesc->msg, $h->updExcDesc->type, 
                                        $h->updExcDesc->source );
			}

			if( $h->mailingExcDesc != null )
			{
				throw $this->createStateException( $h->mailingExcDesc );
			}

			$this->refreshData( $h->value );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->sc->notify( $x );
		}
	}


	public function revokeApproval( $sComment = null )
	{
		try
		{
			$h = $this->mService->requestRevokeApproval( $this->sc->createCxt(), $this->getId(), 
                                Inx_Apiimpl_TConvert::TConvert( $sComment ) );

			if( $h->updExcDesc != null )
			{
				throw new Inx_Api_UpdateException( $h->updExcDesc->msg, $h->updExcDesc->type, 
                                        $h->updExcDesc->source );
			}

			if( $h->mailingExcDesc != null )
			{
				throw $this->createStateException( $h->mailingExcDesc );
			}

			$this->refreshData( $h->value );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->sc->notify( $x );
		}
	}


	public function lock()
	{
		try
		{
			$h = $this->mService->lock( $this->sc->createCxt(), $this->getId(), true, false );

			if( $h->mailingExcDesc != null )
			{
				throw $this->createStateException( $h->mailingExcDesc() );
			}

			if( !$h->lockReturn )
			{
				throw new Inx_Api_LockException( "trigger mailing is already locked", $this->lock );
			}

			$this->refreshData( $h->value );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->sc->notify( $x );
		}
	}


	public function unlock( $blForceForeignLock = false )
	{
		try
		{
			$h = $this->mService->lock( $this->sc->createCxt(), $this->getId(), false, $blForceForeignLock );
			$this->refreshData( $h->value );
			return $h->lockReturn;
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->sc->notify( $x );
			return false;
		}
	}


	public function getMailingState()
	{
		return Inx_Api_TriggerMailing_TriggerMailingState::byId($this->data->mailingState);
	}


	public function getTriggerState()
	{
		return Inx_Api_TriggerMailing_TriggerState::byId($this->data->triggerState);
	}
        
        
        public function isActive()
        {
                return $this->data->active;
        }


	public function isLocked()
	{
		return $this->lock != null;
	}


	public function getLockTicket()
	{
		return $this->lock;
	}


	public function getModificationDatetime()
	{
		return Inx_Apiimpl_TConvert::convert( $this->data->modDatetime );
	}


	public function getEscalationDatetime()
	{
		return Inx_Apiimpl_TConvert::convert( $this->data->escalationDatetime );
	}


	public function getDeadlineDatetime()
	{
		return Inx_Apiimpl_TConvert::convert( $this->data->deadlineDatetime );
	}


	public function getListContextId()
	{
		return $this->data->listContextId;
	}


	public function getSenderAddress()
	{
		$this->checkLazyData();
		return Inx_Apiimpl_TConvert::convert( $this->data->lazyData->senderAddress );
	}


	public function getReplyToAddress()
	{
		$this->checkLazyData();
		return Inx_Apiimpl_TConvert::convert( $this->data->lazyData->replyToAddress );
	}


	public function getFilterId()
	{
		if( empty($this->data->filterIds) )
		{
			return 0;
		}

		return $this->data->filterIds[0]->value;
	}


	public function updateFilterId( $iFilterId )
	{
                if (!is_int($iFilterId)) 
                {
                    throw new Inx_Api_IllegalArgumentException('Integer parameter $iFilterId expected, got '.gettype($iFilterId));
                }
            
		$this->checkWriteAccess();
		$this->data->filterIds = Inx_Apiimpl_TConvert::arrToTArr(array($iFilterId));
		$this->changedAttrs[Inx_Api_TriggerMailing_TriggerMailingAttribute::FILTER_ID()->getId()] = true;
	}


	public function getFilderIds()
	{
		$ints = $this->data->filterIds;

		if( empty($ints) )
		{
			return null;
		}

		return Inx_Apiimpl_TConvert::TArrToArr( $ints );
	}


	public function getFilterConcatinationType()
	{
		try
		{
			return Inx_Api_TriggerMailing_FilterConcatenationType::byId( $this->data->filterConcatType );
		}
		catch( Inx_Api_IllegalArgumentException $x )
		{
			return null;
		}
	}


	public function updateFilterIds( array $filterIds, Inx_Api_TriggerMailing_FilterConcatenationType $concatinationType )
	{
                if( $concatinationType === Inx_Api_TriggerMailing_FilterConcatenationType::UNKNOWN() )
			throw new Inx_Api_IllegalArgumentException( 'The UNKNOWN concatenation type is illegal' );
            
		$this->checkWriteAccess();
		$this->data->filterIds = Inx_Apiimpl_TConvert::arrToTArr( $filterIds );
		$this->data->filterConcatType = $concatinationType->getId();
		$this->changedAttrs[Inx_Api_TriggerMailing_TriggerMailingAttribute::FILTER_ID()->getId()] = true;
	}


	public function getPriority()
	{
		$this->checkLazyData();
		return Inx_Apiimpl_TConvert::convert( $this->data->lazyData->priority );
	}


	public function updatePriority( $iPriority )
	{
                if (!is_int($iPriority)) 
                {
                    throw new Inx_Api_IllegalArgumentException('Integer parameter $iPriority expected, got '.gettype($iPriority));
                }
            
		if( $iPriority !== null && ( $iPriority < 1 || $iPriority > 5 ) )
		{
			throw new Inx_Api_IllegalArgumentException( "illegal priority value: " . $iPriority );
		}

		$this->checkLazyData();
		$this->checkWriteAccess();
		$this->data->lazyData->priority = Inx_Apiimpl_TConvert::TConvert( $iPriority );
		$this->changedAttrs[Inx_Api_TriggerMailing_TriggerMailingAttribute::PRIORITY()->getId()] = true;
	}


	public function getSubject()
	{
		return Inx_Apiimpl_TConvert::convert( $this->data->subject );
	}


	public function updateSubject( $sSubject )
	{
		$this->checkWriteAccess();
		$this->data->subject = Inx_Apiimpl_TConvert::TConvert( $sSubject );
		$this->changedAttrs[Inx_Api_TriggerMailing_TriggerMailingAttribute::SUBJECT()->getId()] = true;
	}


	public function getName()
	{
		return Inx_Apiimpl_TConvert::convert( $this->data->name );
	}


	public function updateName( $sName )
	{
		$this->checkWriteAccess();
		$this->data->name = Inx_Apiimpl_TConvert::TConvert( $sName );
		$this->changedAttrs[Inx_Api_TriggerMailing_TriggerMailingAttribute::NAME()->getId()] = true;
	}


	public function getContentHandler()
	{
		$this->checkLazyData();

		if( $this->contentHandler == null )
		{
			$this->contentHandler = Inx_Apiimpl_TriggerMailing_TriggerMailingContentHandler::createContentHandler( $this );
		}

		return $this->contentHandler;
	}


	public function setContentHandler( $sContentHandlerClazz )
	{
		$this->checkLazyData();
		$this->checkWriteAccess();
		$newCh = Inx_Apiimpl_TriggerMailing_TriggerMailingContentHandler::createContentHandler( $this,
				$sContentHandlerClazz );

		if( $this->contentHandler !== null )
		{
			$this->contentHandler->destroy();
		}

		$this->contentHandler = $newCh;

		$this->data->contentMailType = $newCh->getMailingContentType()->getId();
		$this->changedAttrs[Inx_Api_TriggerMailing_TriggerMailingAttribute::INTERNAL_MAILING_CONTENT_MAIL_TYPE()->getId()] = true;
	}


	public function getCreationDatetime()
	{
		return Inx_Apiimpl_TConvert::convert( $this->data->createDatetime );
	}


	public function getTriggerDescriptor()
	{
		return self::convertToTriggerDescriptor( $this->data->triggerDescriptor );
	}


	public function updateTriggerDescriptor( Inx_Api_TriggerMailing_Descriptor_TriggerDescriptor $triggerDescriptor )
	{
		$this->checkWriteAccess();
		$this->data->triggerDescriptor = self::convertToSoapTriggerDescriptor( $triggerDescriptor );
		$this->changedAttrs[Inx_Api_TriggerMailing_TriggerMailingAttribute::DESCRIPTOR()->getId()] = true;
	}


	public function getTriggerType()
	{
		return Inx_Api_TriggerMailing_Descriptor_TriggerType::byTypeId( $this->data->triggerDescriptor->type );
	}


	public function getNextSending()
	{
		return Inx_Apiimpl_TConvert::convert( $this->data->nextSending );
	}


	public function getId()
	{
		return $this->data->id;
	}


	public function commitUpdate()
	{
		try
		{
                        $h = $this->mService->update( $this->sc->createCxt(), $this->data, 
                            Inx_Apiimpl_TConvert::arrToTArr( $this->changedAttrs ) );

			if( !empty($h->updExcDesc) )
			{
				throw new Inx_Api_UpdateException( $h->updExcDesc->msg, $h->updExcDesc->type, 
                                        $h->updExcDesc->source );
                        }

			if( !empty($h->value) )
			{
				$this->data = $h->value;
				$this->changedAttrs = null;

				if( $this->contentHandler !== null )
				{
					$this->contentHandler->destroy();
					$this->contentHandler = null;
				}

				$this->changedAttrs = null;
			}
			else
			{
				throw new Inx_Api_DataException( "deleted object" );
			}
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->sc->notify( $x );
		}

	}


	public function reload()
	{
		$this->changedAttrs = null;

		if( $this->contentHandler !== null )
		{
			$this->contentHandler->destroy();
			$this->contentHandler = null;
		}

		try
		{
			$retData = $this->mService->get( $this->sc->createCxt(), $this->data->id );

			if( $retData === null )
			{
				throw new Inx_Api_DataException( "deleted object" );
			}
			else
			{
				$this->data = $retData;
			}
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->sc->notify( $x );
		}
	}


	public static function convert( Inx_Apiimpl_SessionContext $sc, array $data )
	{
                if( empty($data) )
		{
			return array();
		}

		$ms = array();

		for( $i = 0; $i < sizeof($data); $i++ )
		{
			try
			{
				$ms[$i] = new Inx_Apiimpl_TriggerMailing_TriggerMailingImpl( $sc, $data[$i] );
			}
			catch( Inx_Api_DataException $x )
			{
				// ms[i] = null;
			}
		}
                
		return $ms;
	}


	private static function createStateException( stdClass $x )
	{
		return new Inx_Api_TriggerMailing_TriggerMailingStateException( $x->msg, 
                        Inx_Api_TriggerMailing_TriggerMailingState::byId($x->currentMailingState),
                        Inx_Api_TriggerMailing_TriggerState::byId($x->currentTriggerState), $x->currentLock );
	}


	private static function createSendException( stdClass $x )
	{
		return new Inx_Api_TriggerMailing_SendException( $x->msg );
	}


	function checkWriteAccess()
	{
		if( $this->changedAttrs === null && Inx_Api_TriggerMail_TriggerMailingConstants::TRIGGER_MAILING_MAX_CHANGEDATTR_SIZE > 0)
                {
                    $this->changedAttrs = array_fill(0, Inx_Api_TriggerMail_TriggerMailingConstants::TRIGGER_MAILING_MAX_CHANGEDATTR_SIZE, null);
                }
	}


	private function updateFeatureId( $iFeatureId )
	{
                if (!is_int($iFeatureId)) 
                {
                    throw new Inx_Api_IllegalArgumentException('Integer parameter $iListContextId expected, got '.gettype($iFeatureId));
                }
            
		$this->checkWriteAccess();
		$this->data->featureId = $iFeatureId;
		$this->changedAttrs[Inx_Api_TriggerMail_TriggerMailingConstants::INTERNAL_TRIGGER_MAILING_FEATURE_ID] = true;
	}


	private function updateListContextId( $iListContextId )
	{
                if (!is_int($iListContextId)) 
                {
                    throw new Inx_Api_IllegalArgumentException('Integer parameter $iListContextId expected, got '.gettype($iListContextId));
                }
            
		$this->checkWriteAccess();
		$this->data->listContextId = $iListContextId;
		$this->changedAttrs[Inx_Api_TriggerMail_TriggerMailingConstants::INTERNAL_TRIGGER_MAILING_LIST_ID] = true;
	}


	function checkLazyData()
	{
		try
		{
			if( $this->data->lazyData === null )
			{
				if( $this->data->id === Inx_Apiimpl_Constants::ID_UNSPECIFIED )
				{
					$this->data->lazyData = new stdClass();
				}
				else
				{
					$ms = $this->sc->getService( Inx_Apiimpl_SessionContext::TRIGGER_MAILING_SERVICE );
					$this->data->lazyData = $ms->getLazyData( $this->sc->createCxt(), $this->data->id );
				}
			}
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->sc->notify( $x );
		}
	}


	private function convertToTriggerDescriptor( stdClass $descriptor )
	{
		if( empty($descriptor) )
			return null;

		$type = Inx_Api_TriggerMailing_Descriptor_TriggerType::byTypeId($descriptor->type);
		$factory = Inx_Apiimpl_TriggerMailing_Descriptor_TriggerDescriptorBuilderFactoryImpl::getInstance();

		switch( $type )
		{
			case Inx_Api_TriggerMailing_Descriptor_TriggerType::ACTION_MAILING():
				return $factory->createActionTriggerDescriptorBuilder()->build();

			case Inx_Api_TriggerMailing_Descriptor_TriggerType::TIME_TRIGGER_BIRTHDAY_MAILING():
				$startDate = Inx_Apiimpl_TConvert::convert( $descriptor->startDate );
				$endDate = Inx_Apiimpl_TConvert::convert( $descriptor->endDate );
				$valueSetters = $this->extractValueSetters( $descriptor );
				$offset = $this->convertToOffset( $descriptor->offset );
				$attributeId = Inx_Apiimpl_TConvert::convert( $descriptor->attributeId );

				return $factory->createBirthdayTriggerDescriptorBuilder()->startDate( $startDate )->sendingTime( $startDate )
                                        ->endDate( $endDate )->attributeValueSetters( $valueSetters )->offset( $offset )
                                        ->attribute( $attributeId )->build();

			case Inx_Api_TriggerMailing_Descriptor_TriggerType::TIME_TRIGGER_FOLLOW_UP_MAILING():
				$startDate = Inx_Apiimpl_TConvert::convert( $descriptor->startDate );
				$endDate = Inx_Apiimpl_TConvert::convert( $descriptor->endDate );
				$valueSetters = $this->extractValueSetters( $descriptor );
				$offset = $this->convertToOffset( $descriptor->offset );
				$attributeId = Inx_Apiimpl_TConvert::convert( $descriptor->attributeId );

				return $factory->createFollowUpTriggerDescriptorBuilder()->startDate( $startDate )->sendingTime( $startDate )
                                        ->endDate( $endDate )->attributeValueSetters( $valueSetters )->offset( $offset )
                                        ->attribute( $attributeId )->build();

			case Inx_Api_TriggerMailing_Descriptor_TriggerType::TIME_TRIGGER_REMINDER_MAILING():
				$startDate = Inx_Apiimpl_TConvert::convert( $descriptor->startDate );
				$endDate = Inx_Apiimpl_TConvert::convert( $descriptor->endDate );
				$valueSetters = $this->extractValueSetters( $descriptor );
				$offset = $this->convertToOffset( $descriptor->offset );
				$attributeId = Inx_Apiimpl_TConvert::convert( $descriptor->attributeId );

				return $factory->createReminderTriggerDescriptorBuilder()->startDate( $startDate )->sendingTime( $startDate )
                                        ->endDate( $endDate )->attributeValueSetters( $valueSetters )->offset( $offset )
                                        ->attribute( $attributeId )->build();

			case Inx_Api_TriggerMailing_Descriptor_TriggerType::TIME_TRIGGER_ANNIVERSARY_MAILING():
				$startDate = Inx_Apiimpl_TConvert::convert( $descriptor->startDate );
				$endDate = Inx_Apiimpl_TConvert::convert( $descriptor->endDate );
				$valueSetters = $this->extractValueSetters( $descriptor );
				$offset = $this->convertToOffset( $descriptor->offset );
				$attributeId = Inx_Apiimpl_TConvert::convert( $descriptor->attributeId );
				$columnModificator = $this->convertToOffset( $descriptor->columnModificator );

				return $factory->createAnniversaryTriggerDescriptorBuilder()->startDate( $startDate )->sendingTime( $startDate )
                                        ->endDate( $endDate )->attributeValueSetters( $valueSetters )->offset( $offset )
                                        ->columnModificator( $columnModificator )->attribute( $attributeId )->build();

			case Inx_Api_TriggerMailing_Descriptor_TriggerType::TIME_TRIGGER_INTERVAL_MAILING():
				$startDate = Inx_Apiimpl_TConvert::convert( $descriptor->startDate );
				$endDate = Inx_Apiimpl_TConvert::convert( $descriptor->endDate );
				$valueSetters = $this->extractValueSetters( $descriptor );
				$interval = $this->convertToTriggerInterval( $descriptor->interval );

				return $factory->createIntervalTriggerDescriptorBuilder()->startDate( $startDate )->sendingTime( $startDate )
                                        ->endDate( $endDate )->attributeValueSetters( $valueSetters )->interval( $interval )->build();

			case Inx_Api_TriggerMailing_Descriptor_TriggerType::UNKNOWN():
			default:
				$startDate = Inx_Apiimpl_TConvert::convert( $descriptor->startDate );
				$endDate = Inx_Apiimpl_TConvert::convert( $descriptor->endDate );
				$valueSetters = $this->extractValueSetters( $descriptor );
				$offset = $this->convertToOffset( $descriptor->offset );
				$columnModificator = convertToOffset( $descriptor->columnModificator );
				$attribute = Inx_Apiimpl_TConvert::convert( $descriptor->attributeId );
				$interval = $this->convertToTriggerInterval( $descriptor->interval );

				return new Inx_Apiimpl_TriggerMailing_Descriptor_TriggerDescriptorImpl( $type, $startDate, $startDate, 
                                        $endDate, $attribute, $valueSetters, $offset, $columnModificator, $interval );
		}
	}


	private function convertToSoapTriggerDescriptor( Inx_Api_TriggerMailing_Descriptor_TriggerDescriptor $descriptor )
	{
		if( empty($descriptor) )
			return null;

		$type = $descriptor->getType()->getTypeId();
		$startDate = Inx_Apiimpl_TConvert::TConvert( $descriptor->getStartDate() );
		$endDate = Inx_Apiimpl_TConvert::TConvert( $descriptor->getEndDate() );
		$attributeValueSetters = $this->convertToSoapValueSetters( $descriptor->getAttributeValueSetters() );
		$attributeId = Inx_Apiimpl_TConvert::TConvert( $descriptor->getAttributeId() );
		$offset = $this->convertToSoapOffset( $descriptor->getOffset() );
		$columnModificator = $this->convertToSoapOffset( $descriptor->getColumnModificator() );
		$interval = $this->convertToSoapTriggerInterval( $descriptor->getInterval() );

                $ret = new stdClass();
                $ret->type = $type;
                $ret->startDate = $startDate;
                $ret->endDate = $endDate;
                $ret->attributeValueSetters = $attributeValueSetters;
                $ret->attributeId = $attributeId;
                $ret->offset = $offset;
                $ret->columnModificator = $columnModificator;
                $ret->interval = $interval;
                
		return $ret;
	}


	private function extractValueSetters( stdClass $descriptor )
	{
		if( empty($descriptor) )
			return null;

		$result = array();
		$setters = $descriptor->attributeValueSetters;
		$factory = new Inx_Apiimpl_Action_CommandFactoryImpl();

		foreach( $setters as $setter )
		{
			$attributeId = $setter->attributeId;
			$expression = $setter->expression;
			$cmd = null;

			switch( $setter->type )
			{
				case Inx_Api_Action_SetValueCommand::CMD_TYPE_ABSOLUTE:
					$cmd = $factory->createSetAbsoluteValueCmd( $attributeId, $expression );
					break;
				case Inx_Api_Action_SetValueCommand::CMD_TYPE_RELATIVE:
					$cmd = $factory->createSetRelativeValueCmd( $attributeId, $expression );
					break;
				case Inx_Api_Action_SetValueCommand::CMD_TYPE_FREE_EXPRESSION:
					$cmd = $factory->createSetValueCmd( $attributeId, $expression );
					break;

				default:
					$cmd = $factory->createSetValueCmd( $attributeId, $expression );
			}

			if( $cmd !== null )
				$result[] = $cmd;
		}

		return $result;
	}


	private function convertToSoapValueSetters( array $commands = null )
	{
		if( empty($commands) )
			return null;

		$result = array();

		for( $i = 0; $i < sizeof($commands); $i++ )
		{
			$command = $commands[$i];
			$result[$i] = new stdClass();
                        $result[$i]->attributeId = $command->getAttributeId();
                        $result[$i]->type = $command->getCmdType();
                        $result[$i]->expression = $command->getExpression();
		}

		return $result;
	}


	private function convertToOffset( stdClass $offset = null )
	{
		if( empty($offset) )
                    return null;

		return new Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffset( 
                        Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffsetType::byId( $offset->type ), 
                        Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::byId($offset->unit), 
                        $offset->value );
	}


	private function convertToSoapOffset( Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffset $offset = null )
	{
		if( empty($offset) )
                    return null;

                $ret = new stdClass();
                $ret->type = $offset->getType()->getId();
                $ret->unit = $offset->getUnit()->getId();
                $ret->value = $offset->getValue();
                
		return $ret;
	}


	private function convertToTriggerInterval( stdClass $interval = null )
	{
		if( empty($interval) )
                    return null;

		$factory = Inx_Apiimpl_TriggerMailing_Descriptor_TriggerIntervalBuilderFactoryImpl::getInstance();
		$unit = Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::byId($interval->intervalUnit);
		$intervalCount = $interval->intervalCount;

		switch( $unit )
		{
			case Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::DAY():
				return $factory->getDailyIntervalBuilder()->intervalCount( $intervalCount )->build();

			case Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::HOUR():
				return $factory->getHourlyIntervalBuilder()->intervalCount( $intervalCount )->build();

			case Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::MONTH():
				$dispatchIntervals = $this->convertToDispatchIntervals( $interval->dispatchIntervals );
                                $dispatchInterval = $dispatchIntervals[0];
                                $builder = $factory->getMonthlyIntervalBuilder()->intervalCount( $intervalCount )->dispatchInterval(
                                        $dispatchInterval );
                                
                                if($interval->day != null)
                                {
                                    $builder->day( Inx_Apiimpl_TConvert::convert( $interval->day ) );
                                }
                                
				return $builder->build();

			case Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::WEEK():
				$dispatchIntervals = $this->convertToDispatchIntervals( $interval->dispatchIntervals );
				return $factory->getWeeklyIntervalBuilder()->intervalCount( $intervalCount )->dispatchIntervals(
						$dispatchIntervals )->build();

			case Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::YEAR():
				$dispatchIntervals = $this->convertToDispatchIntervals( $interval->dispatchIntervals );
				return new Inx_Apiimpl_TriggerMailing_Descriptor_IntervalImpl( $unit, $intervalCount, 
                                        $dispatchIntervals, Inx_Apiimpl_TConvert::convert( $interval->day ) );
                                
			case Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::UNKNOWN():
				$dispatchIntervals = $this->convertToDispatchIntervals( $interval->dispatchIntervals );
				return new Inx_Apiimpl_TriggerMailing_Descriptor_IntervalImpl($unit, $intervalCount, 
                                        $dispatchIntervals, Inx_Apiimpl_TConvert::convert( $interval->day) );
		}

		return null;
	}


	private function convertToSoapTriggerInterval( Inx_Api_TriggerMailing_Descriptor_TriggerInterval $interval = null )
	{
		if( empty($interval) )
			return null;

                $ret = new stdClass();
                $ret->intervalUnit = $interval->getIntervalUnit()->getId();
                $ret->intervalCount = $interval->getIntervalCount();
                $ret->dispatchIntervals = $this->convertToSoapDispatchIntervals( $interval->getDispatchIntervals() );
                $ret->day = Inx_Apiimpl_TConvert::TConvert( $interval->getDayInterval() );
                
		return $ret;
	}


	private function convertToDispatchIntervals( array $intervals = null )
	{
		if( empty($intervals) )
                    return null;

		$result = array();

		foreach( Inx_Apiimpl_TConvert::TArrToArr( $intervals ) as $interval )
		{
                    $result[] = Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval::byId( $interval );
		}

		return $result;
	}


	private function convertToSoapDispatchIntervals( array $intervals = null )
	{
		if( empty($intervals) )
                    return null;

		$result = array();

		for( $i = 0; $i < sizeof($intervals); $i++ )
		{
			$result[$i] = Inx_Apiimpl_TConvert::TConvert( $intervals[$i]->getId() );
		}

		return $result;
	}


	private function refreshData( stdClass $data )
	{
		if( empty($data) )
		{
                    throw new Inx_Api_DataException( "mailing is orphaned" );
		}

		$this->data = $data;

		if( $this->data->lock === null )
		{
			$this->lock = null;
		}
		else
		{
			$ld = $this->data->lock;
			$this->lock = new Inx_Api_LockTicket( $ld->userId, $ld->userName, $ld->source, 
                                Inx_Apiimpl_TConvert::convert( $ld->datetime ), $ld->foreignLock );
		}
	}
}