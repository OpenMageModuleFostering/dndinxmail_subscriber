<?php
/**
 * @package Inxmail
 * @subpackage TriggerMailing_Descriptor
 */

/**
 * The <i>Inx_Api_TriggerMailing_Descriptor_WeeklyTriggerIntervalBuilder</i> is used to create a weekly trigger interval. 
 * The following settings are mandatory:
 * <p/>
 * <ul>
 * <li><b>The interval count</b>: Specifies how many times the trigger will be fired. The trigger will be fired every X
 * weeks where X is the interval count.</li>
 * <li><b>The dispatch intervals</b>: Specifies the days on which the trigger will be fired. The following options are
 * allowed:
 * <ul>
 * <li><i>MONDAY</i>: The trigger will be fired on Mondays.</li>
 * <li><i>TUESDAY</i>: The trigger will be fired on Tuesdays.</li>
 * <li><i>WEDNESDAY</i>: The trigger will be fired on Wednesday.</li>
 * <li><i>THURSDAY</i>: The trigger will be fired on Thursdays.</li>
 * <li><i>FRIDAY</i>: The trigger will be fired on Fridays.</li>
 * <li><i>SATURDAY</i>: The trigger will be fired on Saturdays.</li>
 * <li><i>SUNDAY</i>: The trigger will be fired on Sundays.</li>
 * </ul>
 * </li>
 * </ul>
 * There are no optional settings.
 * <p/>
 * The following snippet shows how to build a weekly trigger interval which will fire the trigger every two weeks on
 * Mondays and Fridays:
 * 
 * <pre>
 * $factory = $session->getTriggerMailingManager()->getTriggerIntervalBuilderFactory();
 * $interval = $factory->getWeeklyIntervalBuilder()->intervalCount( 2 )->dispatchIntervals(
 *      array( Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval::MONDAY(), 
 *          Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval::FRIDAY() ) )->build();
 * </pre>
 * 
 * @see Inx_Api_TriggerMailing_Descriptor_TriggerInterval
 * @since API 1.10.0
 * @author chge, 17.07.2012
 */
interface Inx_Api_TriggerMailing_Descriptor_WeeklyTriggerIntervalBuilder 
    extends Inx_Api_TriggerMailing_Descriptor_TriggerIntervalBuilder
{
	/**
	 * Sets the <i>set</i> (implemented as array) of <i>Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval</i>s 
         * which determines the dispatch intervals. This setting is mandatory. The following options are legal:
	 * <p/>
	 * <ul>
	 * <li><i>MONDAY</i>: The trigger will be fired on Mondays.
	 * <li><i>TUESDAY</i>: The trigger will be fired on Tuesdays.
	 * <li><i>WEDNESDAY</i>: The trigger will be fired on Wednesday.
	 * <li><i>THURSDAY</i>: The trigger will be fired on Thursdays.
	 * <li><i>FRIDAY</i>: The trigger will be fired on Fridays.
	 * <li><i>SATURDAY</i>: The trigger will be fired on Saturdays.
	 * <li><i>SUNDAY</i>: The trigger will be fired on Sundays.
	 * </ul>
	 * <p/>
	 * The dispatch interval set can be easily created using the array function.
	 * 
	 * @param array $dispatchIntervals the <i>set</i> of <i>Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval</i>s 
         * which determines the dispatch intervals.
	 * @return Inx_Api_TriggerMailing_Descriptor_WeeklyTriggerIntervalBuilder the builder.
	 * @throws Inx_Api_IllegalArgumentException if the dispatch intervals contain a value not listed above.
	 */
	public function dispatchIntervals( array $dispatchIntervals );
}