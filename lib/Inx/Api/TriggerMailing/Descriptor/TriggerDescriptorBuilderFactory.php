<?php
/**
 * @package Inxmail
 * @subpackage TriggerMailing_Descriptor
 */

/**
 * The <i>Inx_Api_TriggerMailing_Descriptor_TriggerDescriptorBuilderFactory</i> is used to create the builders for the 
 * various trigger types. The trigger types differ in their mandatory and optional settings, including the allowed state 
 * space. The builders are designed to guide you through the process of creating trigger descriptors as easy as possible.
 * 
 * @see Inx_Api_TriggerMailing_Descriptor_TriggerDescriptorBuilder
 * @see Inx_Api_TriggerMailing_Descriptor_TriggerDescriptor
 * @since API 1.10.0
 * @author chge, 17.07.2012
 */
interface Inx_Api_TriggerMailing_Descriptor_TriggerDescriptorBuilderFactory
{
	/**
	 * Creates a builder which can be used to create action trigger descriptors.
	 * 
	 * @return Inx_Api_TriggerMailing_Descriptor_ActionTriggerDescriptorBuilder a builder which can be used to create 
         * action trigger descriptors.
	 */
	public function createActionTriggerDescriptorBuilder();


	/**
	 * Creates a builder which can be used to create interval trigger descriptors.
	 * 
	 * @return Inx_Api_TriggerMailing_Descriptor_IntervalTriggerDescriptorBuilder a builder which can be used to create 
         * interval trigger descriptors.
	 */
	public function createIntervalTriggerDescriptorBuilder();


	/**
	 * Creates a builder which can be used to create birthday trigger descriptors.
	 * 
	 * @return Inx_Api_TriggerMailing_Descriptor_AttributeTriggerDescriptorBuilder a builder which can be used to create 
         * birthday trigger descriptors.
	 */
	public function createBirthdayTriggerDescriptorBuilder();


	/**
	 * Creates a builder which can be used to create anniversary trigger descriptors.
	 * 
	 * @return Inx_Api_TriggerMailing_Descriptor_AnniversaryTriggerDescriptorBuilder a builder which can be used to create 
         * anniversary trigger descriptors.
	 */
	public function createAnniversaryTriggerDescriptorBuilder();


	/**
	 * Creates a builder which can be used to create reminder trigger descriptors.
	 * 
	 * @return Inx_Api_TriggerMailing_Descriptor_AttributeTriggerDescriptorBuilder a builder which can be used to create 
         * reminder trigger descriptors.
	 */
	public function createReminderTriggerDescriptorBuilder();


	/**
	 * Creates a builder which can be used to create follow-up trigger descriptors.
	 * 
	 * @return Inx_Api_TriggerMailing_Descriptor_AttributeTriggerDescriptorBuilder a builder which can be used to create 
         * follow-up trigger descriptors.
	 */
	public function createFollowUpTriggerDescriptorBuilder();
}