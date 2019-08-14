<?php
class Inx_Apiimpl_TriggerMailing_Descriptor_TriggerDescriptorBuilderFactoryImpl 
        implements Inx_Api_TriggerMailing_Descriptor_TriggerDescriptorBuilderFactory
{
	private static $instance = null;


	private function __construct()
	{

	}


	public function createActionTriggerDescriptorBuilder()
	{
		return new Inx_Apiimpl_TriggerMailing_Descriptor_ActionTriggerDescriptorBuilderImpl();
	}


	public function createIntervalTriggerDescriptorBuilder()
	{
		return new Inx_Apiimpl_TriggerMailing_Descriptor_IntervalTriggerDescriptorBuilderImpl();
	}


	public function createBirthdayTriggerDescriptorBuilder()
	{
                return new Inx_Apiimpl_TriggerMailing_Descriptor_AttributeTriggerDescriptorBuilderImpl(
                        Inx_Api_TriggerMailing_Descriptor_TriggerType::TIME_TRIGGER_BIRTHDAY_MAILING() );
	}


	public function createAnniversaryTriggerDescriptorBuilder()
	{
		return new Inx_Apiimpl_TriggerMailing_Descriptor_AnniversaryTriggerDescriptorBuilderImpl();
	}


	public function createReminderTriggerDescriptorBuilder()
	{
                return new Inx_Apiimpl_TriggerMailing_Descriptor_AttributeTriggerDescriptorBuilderImpl(
                        Inx_Api_TriggerMailing_Descriptor_TriggerType::TIME_TRIGGER_REMINDER_MAILING() );
	}


	public function createFollowUpTriggerDescriptorBuilder()
	{
		return new Inx_Apiimpl_TriggerMailing_Descriptor_AttributeTriggerDescriptorBuilderImpl(
                        Inx_Api_TriggerMailing_Descriptor_TriggerType::TIME_TRIGGER_FOLLOW_UP_MAILING() );
	}


	public static function getInstance()
	{
                if( null === self::$instance )
                    self::$instance = new Inx_Apiimpl_TriggerMailing_Descriptor_TriggerDescriptorBuilderFactoryImpl();
            
		return self::$instance;
	}
}