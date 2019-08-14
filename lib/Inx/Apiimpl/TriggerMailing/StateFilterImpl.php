<?php
class Inx_Apiimpl_TriggerMailing_StateFilterImpl implements Inx_Api_TriggerMailing_StateFilter
{
	private static $allMatchingStateFilter = null;

	private $mailingStateFilter;

	private $triggerStateFilter;


	private function __construct( array $mailingStateFilter = null, 
                Inx_Api_TriggerMailing_TriggerState $triggerStateFilter = null )
	{
		$this->mailingStateFilter = $mailingStateFilter;
		$this->triggerStateFilter = $triggerStateFilter;
	}


	public function getMailingStateFilter()
	{
		return $this->mailingStateFilter;
	}


	public function getTriggerStateFilter()
	{
		return $this->triggerStateFilter;
	}


	public function matchesAllStates()
	{
		return $this->matchesAllMailingStates() && $this->matchesAllTriggerStates();
	}


	public function matchesAllMailingStates()
	{
		return null === $this->mailingStateFilter;
	}


	public function matchesAllTriggerStates()
	{
		return null === $this->triggerStateFilter;
	}


	public static function createMailingStateFilter( array $mailingStateFilter = null )
	{
                if(empty($mailingStateFilter))
                {
                    $mailingStateFilter = null;
                }
            
		if( $mailingStateFilter !== null )
		{
			if( in_array(Inx_Api_TriggerMailing_TriggerMailingState::UNKNOWN(), $mailingStateFilter) )
			{
				throw new Inx_Api_IllegalArgumentException( "mailingStateFilter may not contain the UNKNOWN state" );
			}
		}

		return new Inx_Apiimpl_TriggerMailing_StateFilterImpl( $mailingStateFilter, null );
	}


	public static function createTriggerStateFilter( Inx_Api_TriggerMailing_TriggerState $triggerStateFilter = null )
	{
		if( $triggerStateFilter != null && $triggerStateFilter == Inx_Api_TriggerMailing_TriggerState::UNKNOWN() )
		{
			throw new Inx_Api_IllegalArgumentException( "triggerStateFilter must not be UNKNOWN" );
		}

		return new Inx_Apiimpl_TriggerMailing_StateFilterImpl( null, $triggerStateFilter );
	}


	public static function createStateFilter( array $mailingStateFilter = null,
			Inx_Api_TriggerMailing_TriggerState $triggerStateFilter = null )
	{
                if(empty($mailingStateFilter))
                {
                    $mailingStateFilter = null;
                }
            
		if( $mailingStateFilter !== null )
		{
			if( in_array(Inx_Api_TriggerMailing_TriggerMailingState::UNKNOWN(), $mailingStateFilter) )
			{
				throw new Inx_Api_IllegalArgumentException( "mailingStateFilter may not contain the UNKNOWN state" );
			}
		}

		if( $triggerStateFilter !== null && $triggerStateFilter === Inx_Api_TriggerMailing_TriggerState::UNKNOWN() )
		{
			throw new Inx_Api_IllegalArgumentException( "triggerStateFilter must not be UNKNOWN" );
		}

		return new Inx_Apiimpl_TriggerMailing_StateFilterImpl( $mailingStateFilter, $triggerStateFilter );
	}


	public static function getAllMatchingStateFilter()
	{
                if(null === self::$allMatchingStateFilter)
                    self::$allMatchingStateFilter = new Inx_Apiimpl_TriggerMailing_StateFilterImpl(null, null);
                
		return self::$allMatchingStateFilter;
	}
}