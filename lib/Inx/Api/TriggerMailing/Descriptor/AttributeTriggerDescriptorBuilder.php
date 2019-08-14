<?php
/**
 * @package Inxmail
 * @subpackage TriggerMailing_Descriptor
 */

/**
 * The <i>Inx_Api_TriggerMailing_Descriptor_AttributeTriggerDescriptorBuilder</i> is used to easily create attribute 
 * driven time triggers. The following settings are mandatory:
 * <p>
 * <ul>
 * <li><b>The start date</b>: Defines the date at which the trigger will be fired for the first time.
 * <li><b>The sending time</b>: Defines the time at shich the trigger will be fired during each dispatch cycle.
 * <li><b>The attribute ID</b>: Defines the attribute used to determine the relevant recipients.
 * </ul>
 * <p>
 * Using only these settings the easiest possible attribute trigger descriptor can be built using the following
 * statements:
 * 
 * <pre>
 * $rmd = $session->createRecipientContext()->getMetaData();
 * $birthdayId = $rmd->getUserAttribute( "Birthday" )->getId();
 * $sendingTime = date('c', mktime(12, 30));
 *
 * $factory = $session->getTriggerMailingManager()->getTriggerDescriptorBuilderFactory();
 * $builder = $factory->createBirthdayTriggerDescriptorBuilder();
 * $builder->startDate( date('c') );
 * $builder->sendingTime( $sendingTime );
 * $builder->attribute( $birthdayId );
 * $descriptor = $builder->build();
 * </pre>
 * <p>
 * There are also some optional settings which can be set:
 * <p>
 * <ul>
 * <li><b>The end date</b>: Defines the date at which the trigger mailing will be dispatched for the last time.
 * <li><b>The offset</b>: Defines the offset of the attribute. For example, how many days after a specific date the
 * trigger mailing shall be dispatched to a recipient.
 * <li><b>The attribute value setters</b>: Can be used to set recipient attribute values along with the dispatch of the
 * trigger mailing.
 * </ul>
 * <p>
 * Using all of these settings, the trigger descriptor could be built with the following statements:
 * 
 * <pre>
 * $rmd = $session->createRecipientContext()->getMetaData();
 * $birthdayId = $rmd->getUserAttribute( "Geburtstag" )->getId();
 * $counterId = $rmd->getUserAttribute( "Counter" )->getId();
 *
 * $endDate = date('c', strtotime('+1 year'));
 * $sendingTime = date('c', mktime(12, 30));
 *
 * $offset = new Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffset( 
 *      Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffsetType::IS_IN(), 
 *      Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::DAY(), 1 );
 *
 * $cmdFactory = $session->getActionManager()->getCommandFactory();
 * $cmd = $cmdFactory->createSetRelativeValueCmd( $counterId, "1" );
 * $commands = array( $cmd );
 *
 * $factory = $session->getTriggerMailingManager()->getTriggerDescriptorBuilderFactory();
 * $descriptor = $factory->createBirthdayTriggerDescriptorBuilder()->startDate( date('c') )
 *      ->sendingTime( $sendingTime )->endDate( $endDate )->attribute( $birthdayId )->offset( $offset )
 *      ->attributeValueSetters( $commands )->build();
 * </pre>
 * 
 * The created trigger will fire one day before a recipients birthday at 12:30 and will increase the Counter attribute.
 * The trigger will be active from now on till the next year.
 * 
 * @see Inx_Api_TriggerMailing_Descriptor_TriggerDescriptorBuilderFactory::createBirthdayTriggerDescriptorBuilder()
 * @see Inx_Api_TriggerMailing_Descriptor_TriggerDescriptorBuilderFactory::createFollowUpTriggerDescriptorBuilder()
 * @see Inx_Api_TriggerMailing_Descriptor_TriggerDescriptorBuilderFactory::createReminderTriggerDescriptorBuilder()
 * @since API 1.10.0
 * @author chge, 16.07.2012
 */
interface Inx_Api_TriggerMailing_Descriptor_AttributeTriggerDescriptorBuilder 
        extends Inx_Api_TriggerMailing_Descriptor_TimeTriggerDescriptorBuilder
{
	/**
	 * Sets the ID of the recipient attribute used as basis of the trigger. This setting is mandatory.
	 * 
	 * @param int $iAttributeId the ID of the recipient attribute used as basis of the trigger.
	 * @return Inx_Api_TriggerMailing_Descriptor_AttributeTriggerDescriptorBuilder the builder.
	 */
	public function attribute( $iAttributeId );


	/**
	 * Sets the <i>Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffset</i> used to alter the dispatch date specified 
         * by the attribute. For example: Normally, birthday trigger mailings are sent on the birthday of the recipient. 
         * Using a <i>TimeTriggerOffset</i> you can send your congratulations before or after that date. This setting is
	 * optional.
	 * <p>
	 * There are some restrictions regarding the permitted offset types and units:
	 * <ul>
	 * <li><b>Birthday trigger mailing</b>: Only the DAY unit is permitted.
	 * <li><b>Reminder trigger mailing</b>: Only the DAY unit and the IS_IN type are permitted.
	 * <li><b>Follow-up trigger mailing</b>: Only the DAY unit and the WAS_AGO type are permitted.
	 * <li><b>Anniversary trigger mailing</b>: Only the DAY unit is permitted.
	 * </ul>
	 * 
	 * @param Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffset $offset the <i>TimeTriggerOffset</i> used to alter 
         * the dispatch date specified by the attribute.
	 * @return Inx_Api_TriggerMailing_Descriptor_AttributeTriggerDescriptorBuilder the builder.
	 * @throws Inx_Api_IllegalArgumentException if the offset type or unit is illegal in combination with the trigger 
         *      type at hand.
	 */
	public function offset( Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffset $offset = null );
}