<?php
/**
 * @package Inxmail
 * @subpackage TriggerMailing_Descriptor
 */

/**
 * <i>Inx_Api_TriggerMailing_Descriptor_TriggerDescriptorBuilder</i>s are used to easily create 
 * <i>Inx_Api_TriggerMailing_Descriptor_TriggerDescriptor</i>s. They provide some guidance and will complain about 
 * any missing settings and broken invariants. The different builders are created using the 
 * <i>Inx_Api_TriggerMailing_Descriptor_TriggerDescriptorBuilderFactory</i>.
 * 
 * @see Inx_Api_TriggerMailing_Descriptor_TriggerDescriptorBuilderFactory
 * @since API 1.10.0
 * @author chge, 16.07.2012
 */
interface Inx_Api_TriggerMailing_Descriptor_TriggerDescriptorBuilder
{
	/**
	 * Creates the <i>Inx_Api_TriggerMailing_Descriptor_TriggerDescriptor</i> according to the settings. Before creating 
         * the descriptor, the <i>validate()</i> method will be called to check the settings for correctness.
	 * 
	 * @return Inx_Api_TriggerMailing_Descriptor_TriggerDescriptor the <i>TriggerDescriptor</i> as defined by the settings.
	 */
	public function build();


	/**
	 * Validates the settings for correctness. Any missing settings and broken invariants will trigger a certain kind of
	 * <i>Exception</i> like:
	 * <ul>
	 * <li><i>Inx_Api_NullPointerException</i>: A mandatory setting was configured with <i>null</i>.
	 * <li><i>Inx_Api_IllegalArgumentException</i>: A setting was configured with an illegal value.
	 * <li><i>Inx_Api_IllegalStateException</i>: An invariant was broken or a mandatory setting is missing.
	 * </ul>
	 * 
	 * @throws Exception if the settings are incorrect.
	 */
	public function validate();
}

