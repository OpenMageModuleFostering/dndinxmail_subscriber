<?php
class Inx_Apiimpl_TriggerMailing_Descriptor_IntervalTriggerDescriptorBuilderImpl 
        extends Inx_Apiimpl_TriggerMailing_Descriptor_TimeTriggerDescriptorBuilderImpl 
        implements Inx_Api_TriggerMailing_Descriptor_IntervalTriggerDescriptorBuilder
{
	private $interval;


	function __construct()
	{
                parent::__construct(Inx_Api_TriggerMailing_Descriptor_TriggerType::TIME_TRIGGER_INTERVAL_MAILING());
	}


	public function build()
	{
		$this->validate();

		return new Inx_Apiimpl_TriggerMailing_Descriptor_TriggerDescriptorImpl( 
                        Inx_Api_TriggerMailing_Descriptor_TriggerType::TIME_TRIGGER_INTERVAL_MAILING(), 
                        $this->startDate, $this->sendingTime, $this->endDate, null, $this->commands, null, 
                        null, $this->interval );
	}


	public function validate()
	{
		parent::validate();

		if( null === $this->interval )
		{
			throw new Inx_Api_IllegalStateException( "interval must be specified" );
		}
	}


	public function interval( Inx_Api_TriggerMailing_Descriptor_TriggerInterval $interval = null )
	{
		if( null === $interval )
		{
			throw new Inx_Api_NullPointerException( "interval may not be null" );
		}

		$this->interval = $interval;

		return $this;
	}
        
        
	public function startDate( $sStartDate )
	{
                parent::startDate($sStartDate);
		return $this;
	}

        
        public function sendingTime($sSendingTime) 
        {
            parent::sendingTime($sSendingTime);
            return $this;
        }
        

	public function endDate( $sEndDate )
	{
                parent::endDate($sEndDate);
		return $this;
	}


	public function attributeValueSetters( array $commands = null )
	{
                parent::attributeValueSetters($commands);
		return $this;
	}
}