<?php
class Inx_Apiimpl_TriggerMailing_Descriptor_TimeTriggerDescriptorBuilderImpl implements Inx_Api_TriggerMailing_Descriptor_TimeTriggerDescriptorBuilder
{
        protected $type;

	protected $startDate;
        
        protected $sendingTime;

	protected $endDate;

	protected $commands;


	function __construct( Inx_Api_TriggerMailing_Descriptor_TriggerType $type )
	{
		if( !$type->isTimeTriggerType() )
		{
			throw new Inx_Api_IllegalArgumentException( "Only time trigger types are allowed" );
		}

		$this->type = $type;
	}


	public function build()
	{
		$this->validate();

		return new Inx_Apiimpl_TriggerMailing_Descriptor_TriggerDescriptorImpl( $this->type, 
                        $this->startDate, $this->sendingTime, $this->endDate, null, $this->commands, null, null, null );
	}


	public function validate()
	{
		if( null === $this->startDate )
		{
			throw new Inx_Api_IllegalStateException( "The start date must be specified" );
		}
                
                if( null === $this->sendingTime )
		{
			throw new Inx_Api_IllegalStateException( "The sending time must be specified" );
		}

		if( null === $this->endDate )
		{
			// if end date is null, no invariants can be violated
			return;
		}

                $start = strtotime($this->startDate);
                $end = strtotime($this->endDate);
                
		if( $start !== $end && $start > $end )
		{
			throw new Inx_Api_IllegalStateException( "The end date must be after the start date" );
		}
	}


	public function startDate( $sStartDate )
	{
		if( null ===$sStartDate )
		{
			throw new Inx_Api_NullPointerException( "The start date may not be null" );
		}

		$this->startDate = $sStartDate;

		return $this;
	}


        public function sendingTime( $sSendingTime )
	{
                if(null === $sSendingTime)
                {
                    throw new Inx_Api_NullPointerException( "The sending time may not be null" );
                }

		$this->sendingTime = $sSendingTime;

		return $this;
	}
        
        
	public function endDate( $sEndDate )
	{
		$this->endDate = $sEndDate;
		return $this;
	}


	public function attributeValueSetters( array $commands = null )
	{
		$this->commands = $commands;

		return $this;
	}
}