<?php
/**
 * @package Inxmail
 * @subpackage TriggerMailing_Descriptor
 */

/**
 * The <i>Inx_Api_TriggerMailing_Descriptor_MonthlyTriggerIntervalBuilder</i> is used to create a monthly trigger interval. 
 * The following settings are mandatory:
 * <p/>
 * <ul>
 * <li><b>The interval count</b>: Specifies how many times the trigger will be fired. The trigger will be fired every X
 * months where X is the interval count. Do not confuse this setting with the day setting.</li>
 * <li><b>The day</b>: Specifies the day, at which the trigger will be fired.</li>
 * <li><b>The dispatch interval</b>: Specifies the basis for the day attribute. The following options are allowed:
 * <ul>
 * <li><i>LAST_DAY_OF_MONTH</i>: The trigger will be fired on the last day of the month. In this case, the day setting
 * must be omitted or set to zero.</li>
 * <li><i>SPECIFIC_DAY_OF_MONTH</i>: The trigger will be fired on the day of month specified by the day setting.</li>
 * <li><i>SPECIFIC_DAY_BEFORE_END_OF_MONTH</i>: The trigger will be fired on the specified day before the end of the
 * month. For example, using the value 2 for the day setting will cause the trigger to be fired to days before the end
 * of the current month.</li>
 * </ul>
 * </li>
 * </ul>
 * The day setting is only optional when using the dispatch interval LAST_DAY_OF_MONTH. There are no other optional
 * settings.
 * <p/>
 * The following snippet shows how to build a monthly trigger interval which will fire the trigger every two months,
 * three days before the end of the month:
 * 
 * <pre>
 * $factory = $session->getTriggerMailingManager()->getTriggerIntervalBuilderFactory();
 * $interval = $factory->getMonthlyIntervalBuilder()->intervalCount( 2 )->day( 3 )->dispatchInterval(
 *      Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval::SPECIFIC_DAY_BEFORE_END_OF_MONTH())
 *      ->build();
 * </pre>
 * 
 * @see Inx_Api_TriggerMailing_Descriptor_TriggerInterval
 * @since API 1.10.0
 * @author chge, 17.07.2012
 */
interface Inx_Api_TriggerMailing_Descriptor_MonthlyTriggerIntervalBuilder 
        extends Inx_Api_TriggerMailing_Descriptor_TriggerIntervalBuilder
{
	/**
	 * Sets the <i>Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval</i> which determines the dispatch interval. 
         * This setting is mandatory. The following options are legal:
	 * <p/>
	 * <ul>
	 * <li><i>LAST_DAY_OF_MONTH</i>: The trigger will be fired on the last day of the month. In this case, the day
	 * setting must be omitted or set to zero.
	 * <li><i>SPECIFIC_DAY_OF_MONTH</i>: The trigger will be fired on the day of month specified by the day setting.
	 * <li><i>SPECIFIC_DAY_BEFORE_END_OF_MONTH</i>: The trigger will be fired on the specified day before the end of the
	 * month. For example, using the value 2 for the day setting will cause the trigger to be fired to days before the
	 * end of the current month.
	 * </ul>
	 * 
	 * @param Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval $dispatchInterval the 
         * <i>TimeTriggerDispatchInterval</i>s which determines the dispatch interval.
	 * @return Inx_Api_TriggerMailing_Descriptor_MonthlyTriggerIntervalBuilder the builder.
	 * @throws Inx_Api_IllegalArgumentException if the dispatch interval is not one of the values listed above.
	 */
	public function dispatchInterval( Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval $dispatchInterval );


	/**
	 * Returns the day of the dispatch interval. This setting is only optional if the dispatch interval is
	 * LAST_DAY_OF_MONTH. In this case, the day setting must be omitted or set to zero. Do not confuse this setting with
	 * the interval count setting as they are used for different purposes. For example, to fire the trigger every two
	 * months on the first day of the month, you need the following settings:
	 * <p/>
	 * <ul>
	 * <li><b>Interval count</b>: 2
	 * <li><b>Dispatch interval</b>: SPECIFIC_DAY_OF_MONTH
	 * <li><b>Day</b>: 1
	 * </ul>
	 * <p/>
	 * Only values between 1 and 28 inclusively are legal.
	 * 
	 * @param int $iDay the day of the dispatch interval.
	 * @return Inx_Api_TriggerMailing_Descriptor_MonthlyTriggerIntervalBuilder the builder.
	 * @throws Inx_Api_IllegalArgumentException if the value is smaller than 1 or bigger than 28.
	 */
	public function day( $iDay );
}