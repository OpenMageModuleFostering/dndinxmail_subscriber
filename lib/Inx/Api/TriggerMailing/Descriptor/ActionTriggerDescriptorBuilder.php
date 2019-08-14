<?php
/**
 * @package Inxmail
 * @subpackage TriggerMailing_Descriptor
 */

/**
 * The <i>Inx_Api_TriggerMailing_Descriptor_ActionTriggerDescriptorBuilder</i> is used to easily create action triggers. 
 * The following example shows how to create an action trigger descriptor:
 * 
 * <pre>
 * $factory = $session->getTriggerMailingManager()->getTriggerDescriptorBuilderFactory();
 * $descriptor = $factory->createActionTriggerDescriptorBuilder()->build();
 * </pre>
 * 
 * @see Inx_Api_TriggerMailing_Descriptor_TriggerDescriptorBuilderFactory::createActionTriggerDescriptorBuilder()
 * @since API 1.10.0
 * @author chge, 16.07.2012
 */
interface Inx_Api_TriggerMailing_Descriptor_ActionTriggerDescriptorBuilder extends Inx_Api_TriggerMailing_Descriptor_TriggerDescriptorBuilder
{

}