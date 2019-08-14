<?php
class Inx_Apiimpl_TriggerMailing_Descriptor_AnniversaryTriggerDescriptorBuilderImpl 
        extends Inx_Apiimpl_TriggerMailing_Descriptor_AttributeTriggerDescriptorBuilderImpl 
        implements Inx_Api_TriggerMailing_Descriptor_AnniversaryTriggerDescriptorBuilder
{
	protected $columnModificator;


	function __construct()
	{
		parent::__construct( Inx_Api_TriggerMailing_Descriptor_TriggerType::TIME_TRIGGER_ANNIVERSARY_MAILING() );
	}


	public function build()
	{
		$this->validate();

		return new Inx_Apiimpl_TriggerMailing_Descriptor_TriggerDescriptorImpl( $this->type, 
                        $this->startDate, $this->sendingTime, $this->endDate, $this->attributeId, $this->commands, 
                        $this->offset, $this->columnModificator, null );
	}


	public function validate()
	{
		parent::validate();

		if( null === $this->columnModificator )
		{
			throw new Inx_Api_IllegalStateException( "column modificator must be specified" );
		}
	}


	public function columnModificator( Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffset $columnModificator )
	{
		if( null === $columnModificator )
		{
			throw new Inx_Api_NullPointerException( "columnModificator must not be null" );
		}
                
                if( $columnModificator->getValue() !== 0 && $columnModificator->getType() 
                        !== Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffsetType::WAS_AGO() )
		{
			throw new Inx_Api_IllegalArgumentException( 'Illegal column modificator type: ' . 
                                print_r($columnModificator->getType(), true) . '; only WAS_AGO allowed in anniversary mailings' );
		}

		$this->columnModificator = $columnModificator;

		return $this;
	}


	public function attribute( $iAttributeId )
	{
		parent::attribute($iAttributeId);
		return $this;
	}


	public function offset( Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffset $offset = null )
	{
		parent::offset($offset);
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