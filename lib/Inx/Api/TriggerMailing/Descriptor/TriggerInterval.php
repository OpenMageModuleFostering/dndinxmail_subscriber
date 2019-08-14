<?php
/**
 * @package Inxmail
 * @subpackage TriggerMailing_Descriptor
 */

/**
 * The <i>Inx_Api_TriggerMailing_Descriptor_TriggerInterval</i> is the integral part of the interval trigger. It 
 * describes when the trigger will be fired using a combination of the following settings:
 * <ul>
 * <li><b>The interval unit</b>: Defines the unit of the interval (e.g. day, week, month,...).
 * <li><b>The interval count</b>: Defines the how many times the trigger shall be fired (e.g. every X months).
 * <li><b>The dispatch intervals</b>: Defines the dispatch intervals (e.g. daily, hourly, day in month,...).
 * <li><b>The day</b>: Defines the day on which the trigger shall be fired. Only used in combination with monthly
 * dispatch intervals.
 * </ul>
 * <p>
 * It's rarely advisable to create a <i>TriggerInterval</i> directly as the state space is complex and can be
 * confusing. Generally, it's reasonable to use an <i>Inx_Api_TriggerMailing_Descriptor_TriggerIntervalBuilder</i> 
 * for this task which will guide you through the process of creating a <i>TriggerInterval</i> and complain about 
 * any missing settings and broken invariants.
 * <p>
 * For an example on how to create a <i>TriggerInterval</i> using a builder, see the
 * <i>Inx_Api_TriggerMailing_Descriptor_TriggerIntervalBuilder</i> documentation.
 * 
 * @see Inx_Api_TriggerMailing_Descriptor_TriggerDescriptor::getInterval()
 * @see Inx_Api_TriggerMailing_Descriptor_TriggerIntervalBuilder
 * @since API 1.10.0
 * @author chge, 16.07.2012
 */
interface Inx_Api_TriggerMailing_Descriptor_TriggerInterval
{
	/**
	 * Returns the interval unit.
	 * 
	 * @return Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit the interval unit.
	 */
	public function getIntervalUnit();


	/**
	 * Returns the interval count. Do not confuse this setting with the day setting as they are used for different
	 * purposes. For example, to fire the trigger every two months on the first day of the month, you need the following
	 * settings:
	 * <ul>
	 * <li><b>Unit</b>: Month
	 * <li><b>Count</b>: 2
	 * <li><b>Dispatch intervals</b>: [SPECIFIC_DAY_OF_MONTH]
	 * <li><b>Day</b>: 1
	 * </ul>
	 * 
	 * @return int the interval count.
	 */
	public function getIntervalCount();


	/**
	 * Returns the <i>set</i> (implemented as array) of <i>Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval</i>s 
         * which determines the dispatch intervals. Which dispatch intervals are legal depends on the type of trigger interval you 
         * use. The builders clearly point out which combinations are legal.
	 * 
	 * @return array the <i>set</i> of <i>Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval</i>s which determines 
         * the dispatch intervals.
	 */
	public function getDispatchIntervals();


	/**
	 * Returns the day of the dispatch interval. Do not confuse this setting with the interval count setting as they are
	 * used for different purposes. For example, to fire the trigger every two months on the first day of the month, you
	 * need the following settings:
	 * <ul>
	 * <li><b>Unit</b>: Month
	 * <li><b>Count</b>: 2
	 * <li><b>Dispatch intervals</b>: [SPECIFIC_DAY_OF_MONTH]
	 * <li><b>Day</b>: 1
	 * </ul>
	 * 
	 * @return int the day of the dispatch interval.
	 */
	public function getDayInterval();
}

