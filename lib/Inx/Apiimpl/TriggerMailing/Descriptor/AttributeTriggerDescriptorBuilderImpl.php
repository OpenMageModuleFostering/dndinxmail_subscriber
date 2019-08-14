<?php
class Inx_Apiimpl_TriggerMailing_Descriptor_AttributeTriggerDescriptorBuilderImpl 
        extends Inx_Apiimpl_TriggerMailing_Descriptor_TimeTriggerDescriptorBuilderImpl 
        implements Inx_Api_TriggerMailing_Descriptor_AttributeTriggerDescriptorBuilder
{
	protected $attributeId;

	protected $offset;


	function __construct( Inx_Api_TriggerMailing_Descriptor_TriggerType $type )
	{
                parent::__construct($type);

		if( !$type->isAttributeTriggerType() )
		{
			throw new Inx_Api_IllegalArgumentException( "Only attribute trigger types are allowed" );
		}
	}


	public function build()
	{
		$this->validate();

		return new Inx_Apiimpl_TriggerMailing_Descriptor_TriggerDescriptorImpl( $this->type, 
                        $this->startDate, $this->sendingTime, $this->endDate, $this->attributeId, $this->commands, 
                        $this->offset, null, null );
	}


	public function validate()
	{
		parent::validate();

		if( null === $this->attributeId )
		{
			throw new Inx_Api_IllegalStateException( "attribute must be specified" );
		}
	}


	public function attribute( $iAttributeId )
	{
                if( null === $iAttributeId )
                {
                    throw new Inx_Api_NullPointerException( "attribute must not be null" );
                }
            
		$this->attributeId = $iAttributeId;

		return $this;
	}


	public function offset( Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffset $offset = null )
	{
                if( $offset === null )
		{
			return $this;
		}

		switch( $this->type )
		{
			case Inx_Api_TriggerMailing_Descriptor_TriggerType::TIME_TRIGGER_ANNIVERSARY_MAILING():
				if( $offset->getValue() !== 0 && $offset->getUnit() !== 
                                        Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::DAY() )
				{
					throw new Inx_Api_IllegalArgumentException( 'Illegal offset unit: ' . 
                                                print_r($offset->getType(), true) . '; only DAY allowed in anniversary mailings' );
				}
				break;

			case Inx_Api_TriggerMailing_Descriptor_TriggerType::TIME_TRIGGER_BIRTHDAY_MAILING():
				if( $offset->getValue() !== 0 && $offset->getUnit() !== 
                                        Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::DAY() )
				{
					throw new Inx_Api_IllegalArgumentException( 'Illegal offset unit: ' . 
                                                print_r($offset->getUnit(), true) . '; only DAY allowed in birthday mailings' );
				}
				break;

			case Inx_Api_TriggerMailing_Descriptor_TriggerType::TIME_TRIGGER_FOLLOW_UP_MAILING():
				if( $offset->getValue() !== 0 && $offset->getType() !== 
                                        Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffsetType::WAS_AGO() )
				{
					throw new Inx_Api_IllegalArgumentException( 'Illegal offset type: ' . 
                                                print_r($offset->getType(), true) . '; only WAS_AGO allowed in follow-up mailings' );
				}
				else if( $offset->getValue() !== 0 && $offset->getUnit() !== 
                                        Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::DAY() )
				{
					throw new Inx_Api_IllegalArgumentException( 'Illegal offset unit: ' . 
                                                print_r($offset->getUnit(), true) . '; only DAY allowed in follow-up mailings' );
				}
				break;

			case Inx_Api_TriggerMailing_Descriptor_TriggerType::TIME_TRIGGER_REMINDER_MAILING():
				if( $offset->getValue() !== 0 && $offset->getType() !== 
                                        Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffsetType::IS_IN() )
				{
					throw new Inx_Api_IllegalArgumentException( 'Illegal offset type: ' . 
                                                print_r($offset->getType(), true) . '; only IS_IN allowed in reminder mailings' );
				}
				else if( $offset->getValue() !== 0 && $offset->getUnit() !== 
                                        Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::DAY() )
				{
					throw new Inx_Api_IllegalArgumentException( 'Illegal offset unit: ' . 
                                                print_r($offset->getUnit(), true) . '; only DAY allowed in reminder mailings' );
				}
				break;
		}
            
		$this->offset = $offset;
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