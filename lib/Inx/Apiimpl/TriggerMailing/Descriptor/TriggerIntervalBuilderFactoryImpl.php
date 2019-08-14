<?php
class Inx_Apiimpl_TriggerMailing_Descriptor_TriggerIntervalBuilderFactoryImpl 
        implements Inx_Api_TriggerMailing_Descriptor_TriggerIntervalBuilderFactory
{
	private static $instance = null;


	private function __construct()
	{

	}


	public function getDailyIntervalBuilder()
	{
                return new Inx_Apiimpl_TriggerMailing_Descriptor_DailyTriggerIntervalBuilderImpl();
	}


	public function getWeeklyIntervalBuilder()
	{
		return new Inx_Apiimpl_TriggerMailing_Descriptor_WeeklyTriggerIntervalBuilderImpl();
	}


	public function getMonthlyIntervalBuilder()
	{
		return new Inx_Apiimpl_TriggerMailing_Descriptor_MonthlyTriggerIntervalBuilderImpl();
	}


	public function getHourlyIntervalBuilder()
	{
		return new Inx_Apiimpl_TriggerMailing_Descriptor_HourlyTriggerIntervalBuilderImpl();
	}


	public static function getInstance()
	{
                if( null === self::$instance )
                    self::$instance = new Inx_Apiimpl_TriggerMailing_Descriptor_TriggerIntervalBuilderFactoryImpl();
            
		return self::$instance;
	}
}