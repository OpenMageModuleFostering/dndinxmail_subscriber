<?php
/**
 * @package Inxmail
 * @subpackage TriggerMailing_Descriptor
 */

/**
 * <i>Inx_Api_TriggerMailing_Descriptor_TriggerIntervalBuilder</i>s are used to easily create 
 * <i>Inx_Api_TriggerMailing_Descriptor_TriggerInterval</i>s. They provide some guidance and will complain about any missing 
 * settings and broken invariants. The different builders are created using the 
 * </i>Inx_Api_TriggerMailing_Descriptor_TriggerIntervalBuilderFactory</i>.
 * 
 * @see Inx_Api_TriggerMailing_Descriptor_TriggerIntervalBuilderFactory
 * @since API 1.10.0
 * @author chge, 17.07.2012
 */
interface Inx_Api_TriggerMailing_Descriptor_TriggerIntervalBuilder
{
	/**
	 * Creates the <i>Inx_Api_TriggerMailing_Descriptor_TriggerInterval</i> according to the settings. Any missing 
         * settings and broken invariants will trigger a certain kind of <i>Exception</i> like:
	 * <ul>
	 * <li><i>Inx_Api_NullPointerException</i>: A mandatory setting was configured with <i>null</i>.
	 * <li><i>Inx_Api_IllegalArgumentException</i>: A setting was configured with an illegal value.
	 * <li><i>Inx_Api_IllegalStateException</i>: An invariant was broken or a mandatory setting is missing.
	 * </ul>
	 * 
	 * @return Inx_Api_TriggerMailing_Descriptor_TriggerInterval the icode>TriggerInterval</i> as defined by 
         *      the settings.
	 * @throws Exception if the settings are incorrect.
	 */
	public function build();


	/**
	 * Sets the interval count. The interval count is used to specify how many times the trigger will be fired. For
	 * example, when using a daily interval, the trigger is fired every X days where X is the interval count. This
	 * setting is mandatory for all builders.
	 * <p>
	 * The legal values for the interval count vary between the different interval types. They are defined by
	 * <i>Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::getMinValue()</i> and 
         * <i>Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::getMaxValue()</i>.
	 * 
	 * @param int $iCount the interval count.
	 * @return Inx_Api_TriggerMailing_Descriptor_TriggerIntervalBuilder the builder.
	 * @throws Inx_Api_IllegalArgumentException if the interval count is out of legal bounds.
	 */
	public function intervalCount( $iCount );
}