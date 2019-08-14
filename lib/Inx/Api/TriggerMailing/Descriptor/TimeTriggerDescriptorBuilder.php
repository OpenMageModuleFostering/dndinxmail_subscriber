<?php
/**
 * @package Inxmail
 * @subpackage TriggerMailing_Descriptor
 */

/**
 * The <i>Inx_Api_TriggerMailing_Descriptor_TimeTriggerDescriptorBuilder</i> builder is used to easily create time triggers. 
 * There are only two mandatory settings: the start date and the sending time which identify the date and time at which the 
 * trigger will be fired for the first time.
 * <p>
 * The following settings are optional:
 * <p>
 * <ul>
 * <li><b>The end date</b>: Defines the date at which the trigger mailing will be dispatched for the last time.
 * <li><b>The attribute value setters</b>: Can be used to set recipient attribute values along with the dispatch of the
 * trigger mailing.
 * </ul>
 * 
 * @since API 1.10.0
 * @author chge, 16.07.2012
 */
interface Inx_Api_TriggerMailing_Descriptor_TimeTriggerDescriptorBuilder 
    extends Inx_Api_TriggerMailing_Descriptor_TriggerDescriptorBuilder
{
	/**
	 * Sets the date at which the trigger will be fired for the first time. This setting is mandatory. Be aware that the
	 * time component of the date will be disregarded. The sending time is specified separately by the <i>sendingTime</i> 
         * method. The time component of the specified date will be overwritten accordingly. Also, the seconds and milliseconds 
         * will be set to zero.
	 * <p>
	 * For example, consider the following two dates for start date and sending time:
	 * <ul>
	 * <li><b>Start date</b>: <i>2013-01-01T13:57:04+01:00</i>
	 * <li><b>Sending time</b>: <i>2012-07-05T12:30:42+01:00</i>
	 * </ul>
	 * The resulting start date for the trigger will be: <i>2013-01-01T12:30:00+01:00</i>
	 * 
	 * @param string $sStartDate the date at which the trigger will be fired for the first time. The date has to be specified 
         * as ISO-8601 formatted date or datetime string.
	 * @return Inx_Api_TriggerMailing_Descriptor_TimeTriggerDescriptorBuilder the builder.
	 * @throws Inx_Api_NullPointerException if the given start date is <i>null</i>.
	 */
	public function startDate( $sStartDate );

        
        /**
	 * Sets the time at which the sending will be started during each dispatch cycle. This setting is mandatory. Be
	 * aware that the date component of the given date object will be disregarded. Also, the seconds and milliseconds
	 * will be set to zero. This setting will overwrite the time component of the start and end dates when the
	 * <i>TriggerDescriptor</i> is built.
	 * 
	 * @param string $sSendingTime the time at which the sending will be started during each dispatch cycle. The date 
         * has to be specified as ISO-8601 formatted time or datetime string.
	 * @return Inx_Api_TriggerMailing_Descriptor_TimeTriggerDescriptorBuilder the builder.
	 * @throws Inx_Api_NullPointerException if the given sending time is <i>null</i>.
	 */
	public function sendingTime( $sSendingTime );
        

	/**
	 * Sets the date at which the trigger will be fired for the last time. This setting is optional. Be aware that the
	 * time component of the date will be disregarded. The sending time is specified separately by the <i>sendingTime</i> 
         * method. The time component of the specified date will be overwritten accordingly. Also, the seconds and milliseconds 
         * will be set to zero.
	 * <p>
	 * For example, consider the following two dates for end date and sending time:
	 * <ul>
	 * <li><b>End date</b>: <i>2015-01-01T13:57:04+01:00</i>
	 * <li><b>Sending time</b>: <i>2012-07-05T12:30:42+01:00</i>
	 * </ul>
	 * The resulting end date for the trigger will be: <i>2015-01-01T12:30:00+01:00</i>
	 * 
	 * @param string $sEndDate the date at which the trigger will be fired for the last time. The date has to be specified 
         * as ISO-8601 formatted date or datetime string.
	 * @return Inx_Api_TriggerMailing_Descriptor_TimeTriggerDescriptorBuilder the builder.
	 */
	public function endDate( $sEndDate );


	/**
	 * Sets an array of <i>Inx_Api_Action_SetValueCommand</i>s which will be executed when dispatching the trigger
	 * mailings. Using this feature, it is possible to set the values of recipient attributes along with the dispatching
	 * of a trigger mailing to that same recipient. This setting is optional.
	 * 
	 * @param array $commands an array of <i>Inx_Api_Action_SetValueCommand</i>s used to set recipient attributes during
	 *      dispatch.
	 * @return Inx_Api_TriggerMailing_Descriptor_TimeTriggerDescriptorBuilder the builder.
	 */
	public function attributeValueSetters( array $commands = null );
}

