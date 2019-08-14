<?php
/**
 * @package Inxmail
 * @subpackage TriggerMailing_Descriptor
 */

/**
 * The <i>Inx_Api_TriggerMailing_Descriptor_AnniversaryTriggerDescriptorBuilder</i> is used to easily create anniversary 
 * triggers. The following settings are mandatory:
 * <p>
 * <ul>
 * <li><b>The start date</b>: Defines the date at which the trigger will be fired for the first time.
 * <li><b>The sending time</b>: Defines the time at which the trigger will be fired during each dispatch cycle.
 * <li><b>The attribute ID</b>: Defines the attribute used to determine the relevant recipients.
 * <li><b>The column modificator</b>: Defines how long after or before a specific date the trigger shall be fired.
 * </ul>
 * <p>
 * Using only these settings the easiest possible anniversary trigger descriptor can be built using the following
 * statements:
 * 
 * <pre>
 * $rmd = $session->createRecipientContext()->getMetaData();
 * $birthdayId = $rmd->getUserAttribute( "Birthday" )->getId();
 * $sendingTime = date('c', mktime(12, 30));
 *
 * $modificator = new Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffset(
 *      Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffsetType::WAS_AGO(), 
 *      Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::YEAR(), 50);
 *
 * $factory = $session->getTriggerMailingManager()->getTriggerDescriptorBuilderFactory();
 * $builder = $factory->createAnniversaryTriggerDescriptorBuilder();
 * $builder->startDate( date('c') );
 * $builder->sendingTime( $sendingTime );
 * $builder->attribute( $birthdayId );
 * $builder->columnModificator( $modificator );
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
 * $birthdayId = $rmd->getUserAttribute( "Birthday" )->getId();
 * $counterId = $rmd->getUserAttribute( "Counter" )->getId();
 * $endDate = date('c', strtotime('+1 year'));
 * $sendingTime = date('c', mktime(12, 30));
 *
 * $modificator = new Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffset(
 *      Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffsetType::WAS_AGO(), 
 *      Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::YEAR(), 50);
 *               
 * $offset = new Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffset(
 *      Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffsetType::IS_IN(),
 *      Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::DAY(), 1);
 *
 * $cmdFactory = $session->getActionManager()->getCommandFactory();
 * $cmd = $cmdFactory->createSetRelativeValueCmd( $counterId, "1" );
 * $commands = array( $cmd );
 * 
 * $factory = $session->getTriggerMailingManager()->getTriggerDescriptorBuilderFactory();
 * $descriptor = $factory->createAnniversaryTriggerDescriptorBuilder()->startDate( date('c') )
 *      ->sendingTime( $sendingTime )->endDate( $endDate )->attribute( $birthdayId )
 *      ->columnModificator( $modificator )->offset( $offset )->attributeValueSetters( $commands )
 *      ->build();
 * </pre>
 * 
 * The created trigger will fire one day before a recipients 50th birthday at 12:30 and will increase the Counter
 * attribute. The trigger will be active from now on till the next year.
 * 
 * @see Inx_Api_TriggerMailing_Descriptor_TriggerDescriptorBuilderFactory::createAnniversaryTriggerDescriptorBuilder()
 * @since API 1.10.0
 * @author chge, 16.07.2012
 */
interface Inx_Api_TriggerMailing_Descriptor_AnniversaryTriggerDescriptorBuilder 
        extends Inx_Api_TriggerMailing_Descriptor_AttributeTriggerDescriptorBuilder
{
	/**
	 * Sets the <i>Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffset</i> used to define the time span between the 
         * dispatch date and the date specified by the attribute. Be aware that the only legal offset type is WAS_AGO. 
         * For example: An anniversary trigger mailing can be sent out ten years after the date specified by the attribute. 
         * This setting is mandatory.
	 * 
	 * @param Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffset $columnModificator the <i>TimeTriggerOffset</i> used 
         *      to define the time span between the dispatch date and the date specified by the attribute.
	 * @return Inx_Api_TriggerMailing_Descriptor_AnniversaryTriggerDescriptorBuilder the builder.
	 * @throws Inx_Api_NullPointerException if the given offset is <i>null</i>.
	 * @throws Inx_Api_IllegalArgumentException if the offset type is not WAS_AGO.
	 */
	public function columnModificator( Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffset $columnModificator );
}