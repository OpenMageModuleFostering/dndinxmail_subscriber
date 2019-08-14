<?php
/**
 * @package Inxmail
 * @subpackage TriggerMailing_Descriptor
 */

/**
 * The <i>Inx_Api_TriggerMailing_Descriptor_DailyTriggerIntervalBuilder</i> is used to create a daily trigger interval. 
 * The only mandatory setting is the interval count. There are no optional settings.
 * <p>
 * The following snippet shows how to build a daily trigger interval which will fire the trigger every two days:
 * 
 * <pre>
 * $factory = $session->getTriggerMailingManager()->getTriggerIntervalBuilderFactory();
 * $interval = $factory->getDailyIntervalBuilder()->intervalCount( 2 )->build();
 * </pre>
 * 
 * @see Inx_Api_TriggerMailing_Descriptor_TriggerInterval
 * @since API 1.10.0
 * @author chge, 17.07.2012
 */
interface Inx_Api_TriggerMailing_Descriptor_DailyTriggerIntervalBuilder 
        extends Inx_Api_TriggerMailing_Descriptor_TriggerIntervalBuilder
{

}