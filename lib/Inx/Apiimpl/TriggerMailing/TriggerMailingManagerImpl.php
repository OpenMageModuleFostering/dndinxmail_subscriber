<?php
class Inx_Apiimpl_TriggerMailing_TriggerMailingManagerImpl 
        implements Inx_Api_TriggerMailing_TriggerMailingManager
{
	private $sc;

	private $mService;


	public function __construct( Inx_Apiimpl_SessionContext $sc )
	{
		$this->sc = $sc;
		$this->mService = $sc->getService( Inx_Apiimpl_SessionContext::TRIGGER_MAILING_SERVICE );
	}


	public function get( $iId )
	{
		try
		{
			$md = $this->mService->get( $this->sc->createCxt(), $iId );

			if( empty($md) )
			{
                            throw new Inx_Api_DataException( "mailing is orphaned" );
			}

			return new Inx_Apiimpl_TriggerMailing_TriggerMailingImpl($this->sc, $md);
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->sc->notify( $x );
			return null;
		}
	}


	public function remove( $iId )
	{
		try
		{
                        return $this->mService->remove( $this->sc->createCxt(), $iId );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->sc->notify( $x );
			return false;
		}
	}


	public function selectAll()
	{
		try
		{
			return new Inx_Apiimpl_TriggerMailing_TriggerMailingResultSet( $this->sc, 
                                $this->mService->selectAll( $this->sc->createCxt() ) );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->sc->notify( $x );
			return null;
		}
	}


	public function selectByState( Inx_Api_List_ListContext $listContext, Inx_Api_TriggerMailing_StateFilter $stateFilter, 
                Inx_Api_TriggerMailing_TriggerMailingAttribute $orderAttribute = null, $iOrderType = null, $sFilter = null )
	{
                if(!empty($orderAttribute) && !$orderAttribute->isOrderAttribute())
                {
                    throw new Inx_Api_IllegalArgumentException( 'The given attribute may not be used for ordering' );
                }
            
		try
		{
			$mailingStateFilter = ( $stateFilter !== null && $stateFilter->getMailingStateFilter() !== null ) ? 
                            Inx_Api_TriggerMailing_TriggerMailingState::toBitPattern( $stateFilter->getMailingStateFilter() )
                            : -1;
			$triggerStateFilter = ( $stateFilter !== null && $stateFilter->getTriggerStateFilter() !== null ) ? 
                            $stateFilter->getTriggerStateFilter()->getId() : -1;

			$holder = null;
                        $resultSetData = null;
                        
                        $orderAttributeId = null !== $orderAttribute ? $orderAttribute->getId() : -1;
                        $orderTypeId = null !== $iOrderType ? $iOrderType : -1;
                        
                        if(null === $sFilter)
                        {    
                            $holder = $this->mService->select( $this->sc->createCxt(), $listContext->getId(), $mailingStateFilter, 
                                    $triggerStateFilter, $orderAttributeId, $orderTypeId );
                            $resultSetData = $holder;
                        }
                        else
                        {   
                            $holder = $this->mService->selectWithFilter( $this->sc->createCxt(), $listContext->getId(),
                                    $mailingStateFilter, $triggerStateFilter, Inx_Apiimpl_TConvert::TConvert( $sFilter ), 
                                    $orderAttributeId, $orderTypeId );
                            
                            if( !empty($holder->updExcDesc) )
				throw new Inx_Api_FilterStmtException( $holder->updExcDesc->msg, $holder->updExcDesc->type );
                            
                            $resultSetData = $holder->reultSet;
                        }
                        
			return new Inx_Apiimpl_TriggerMailing_TriggerMailingResultSet( $this->sc, $resultSetData );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->sc->notify( $x );
			return null;
		}
	}


	public function createTriggerMailing( Inx_Api_List_ListContext $listContext, 
                Inx_Api_TriggerMailing_Descriptor_TriggerDescriptor $descriptor )
	{
		// default featureId is MAILING_FEATURE_ID
		return new Inx_Apiimpl_TriggerMailing_TriggerMailingImpl($this->sc, null, $listContext->getId(), 
                    Inx_Api_Features::MAILING_FEATURE_ID, $descriptor);
	}


	public function createRenderer()
	{
		return new Inx_Apiimpl_TriggerMailing_TriggerMailingRendererImpl( $this->sc );
	}


	public function createRendererForTestrecipient()
	{
		return new Inx_Apiimpl_TriggerMailing_TriggerMailingRendererTestRecipientImpl( $this->sc );
	}


	public function cloneMailing( $iMailingId, Inx_Api_List_ListContext $lc )
	{
		try
		{
			$h = $this->mService->cloneMailing( $this->sc->createCxt(), $iMailingId, $lc->getId() );
			$desc = $h->mailingExcDesc;

			if( !empty($desc) )
			{
				throw new Inx_Api_DataException( $desc->msg );
			}

			return new Inx_Apiimpl_TriggerMailing_TriggerMailingImpl($this->sc, $h->value);
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->sc->notify( $x );
		}
                
		return null;
	}


	public function createMailingStateFilter( array $stateFilter = null )
	{
		return Inx_Apiimpl_TriggerMailing_StateFilterImpl::createMailingStateFilter($stateFilter);
	}


	public function createTriggerStateFilter( Inx_Api_TriggerMailing_TriggerState $stateFilter = null )
	{
		return Inx_Apiimpl_TriggerMailing_StateFilterImpl::createTriggerStateFilter($stateFilter);
	}


	public function createStateFilter( array $mailingStateFilter = null, 
                Inx_Api_TriggerMailing_TriggerState $triggerStateFilter = null )
	{
		return Inx_Apiimpl_TriggerMailing_StateFilterImpl::createStateFilter($mailingStateFilter, $triggerStateFilter);
	}


	public function createAllMatchingStateFilter()
	{
		return Inx_Apiimpl_TriggerMailing_StateFilterImpl::getAllMatchingStateFilter();
	}


	public function getTriggerDescriptorBuilderFactory()
	{
		return Inx_Apiimpl_TriggerMailing_Descriptor_TriggerDescriptorBuilderFactoryImpl::getInstance();
	}


	public function getTriggerIntervalBuilderFactory()
	{
		return Inx_Apiimpl_TriggerMailing_Descriptor_TriggerIntervalBuilderFactoryImpl::getInstance();
	}
}