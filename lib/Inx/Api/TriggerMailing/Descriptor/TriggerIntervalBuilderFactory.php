<?php
/**
 * @package Inxmail
 * @subpackage TriggerMailing_Descriptor
 */

/**
 * The <i>Inx_Api_TriggerMailing_Descriptor_TriggerIntervalBuilderFactory</i> is used to create the builders for the 
 * various interval types. The interval types differ in their mandatory settings, including the allowed state space. 
 * The builders are designed to guide you through the process of creating trigger intervals as easy as possible.
 * 
 * @see Inx_Api_TriggerMailing_Descriptor_TriggerIntervalBuilder
 * @see Inx_Api_TriggerMailing_Descriptor_TriggerInterval
 * @since API 1.10.0
 * @author chge, 17.07.2012
 */
interface Inx_Api_TriggerMailing_Descriptor_TriggerIntervalBuilderFactory
{
	/**
	 * Creates a builder which can be used to create daily trigger intervals.
	 * 
	 * @return Inx_Api_TriggerMailing_Descriptor_DailyTriggerIntervalBuilder a builder which can be used to create 
         * daily trigger intervals.
	 */
	public function getDailyIntervalBuilder();


	/**
	 * Creates a builder which can be used to create weekly trigger intervals.
	 * 
	 * @return Inx_Api_TriggerMailing_Descriptor_WeeklyTriggerIntervalBuilder a builder which can be used to create 
         * weekly trigger intervals.
	 */
	public function getWeeklyIntervalBuilder();


	/**
	 * Creates a builder which can be used to create monthly trigger intervals.
	 * 
	 * @return Inx_Api_TriggerMailing_Descriptor_MonthlyTriggerIntervalBuilder a builder which can be used to create 
         * monthly trigger intervals.
	 */
	public function getMonthlyIntervalBuilder();


	/**
	 * Creates a builder which can be used to create hourly trigger intervals.
	 * 
	 * @return Inx_Api_TriggerMailing_Descriptor_HourlyTriggerIntervalBuilder a builder which can be used to 
         * create hourly trigger intervals.
	 */
	public function getHourlyIntervalBuilder();
}