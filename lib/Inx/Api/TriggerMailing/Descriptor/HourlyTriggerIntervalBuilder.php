<?php
/**
 * @package Inxmail
 * @subpackage TriggerMailing_Descriptor
 */

/**
 * The <i>Inx_Api_TriggerMailing_Descriptor_HourlyTriggerIntervalBuilder</i> is used to create a hourly trigger interval. 
 * The only mandatory setting is the interval count. There are no optional settings.
 * <p>
 * The following snippet shows how to build a hourly trigger interval which will fire the trigger every five hours:
 * 
 * <pre>
 * $factory = $session->getTriggerMailingManager()->getTriggerIntervalBuilderFactory();
 * $interval = $factory->getHourlyIntervalBuilder()->intervalCount( 5 )->build();
 * </pre>
 * 
 * @see Inx:_Api_TriggerMailing_Descriptor_TriggerInterval
 * @since API 1.10.0
 * @author chge, 17.07.2012
 */
interface Inx_Api_TriggerMailing_Descriptor_HourlyTriggerIntervalBuilder 
        extends Inx_Api_TriggerMailing_Descriptor_TriggerIntervalBuilder
{

}