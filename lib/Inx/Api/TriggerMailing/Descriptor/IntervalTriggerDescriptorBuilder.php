<?php
/**
 * @package Inxmail
 * @subpackage TriggerMailing_Descriptor
 */

/**
 * The <i>Inx_Api_TriggerMailing_Descriptor_IntervalTriggerDescriptorBuilder</i> is used to easily create interval 
 * triggers. The following settings are mandatory:
 * <p>
 * <ul>
 * <li><b>The start date</b>: Defines the date at which the trigger will be fired for the first time.
 * <li><b>The sending time</b>: Defines the time at which the trigger will be fired during each dispatch cycle.
 * <li><b>The interval</b>: Defines the interval at which the trigger will be fired.
 * </ul>
 * <p>
 * Using only these settings the easiest possible interval trigger descriptor can be built using the following
 * statements:
 * 
 * <pre>
 * $intFactory = $session->getTriggerMailingManager()->getTriggerIntervalBuilderFactory();
 * $intBuilder = $intFactory->getDailyIntervalBuilder();
 * $intBuilder->intervalCount( 1 );
 * $interval = $intBuilder->build();
 * $sendingTime = date('c', mktime(12, 30));
 *
 * $factory = $session->getTriggerMailingManager()->getTriggerDescriptorBuilderFactory();
 * $builder = $factory->createIntervalTriggerDescriptorBuilder();
 * $builder->startDate( date('c') );
 * $builder->sendingTime( $sendingTime );
 * $builder->interval( $interval );
 * $descriptor = $builder->build();
 * </pre>
 * <p>
 * There are also some optional settings which can be set:
 * <p>
 * <ul>
 * <li><b>The end date</b>: Defines the date at which the trigger mailing will be dispatched for the last time.
 * <li><b>The attribute value setters</b>: Can be used to set recipient attribute values along with the dispatch of the
 * trigger mailing.
 * </ul>
 * <p>
 * Using all of these settings, the trigger descriptor could be built with the following statements:
 * 
 * <pre>
 * $intFactory = $session->getTriggerMailingManager()->getTriggerIntervalBuilderFactory();
 * $interval = $intFactory->getWeeklyIntervalBuilder()->intervalCount( 2 )->dispatchIntervals(
 *      array(Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval::MONDAY(),
 *          Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval::FRIDAY() ) )->build();
 *
 * $rmd = $session->createRecipientContext()->getMetaData();
 * $counterId = $rmd->getUserAttribute( "Counter" )->getId();
 * $endDate = date('c', strtotime('+1 year'));
 * $sendingTime = date('c', mktime(12, 30));
 *
 * $cmdFactory = $session->getActionManager()->getCommandFactory();
 * $cmd = $cmdFactory->createSetRelativeValueCmd( $counterId, "1" );
 * $commands = array( $cmd );
 *
 * $factory = $session->getTriggerMailingManager()->getTriggerDescriptorBuilderFactory();
 * $descriptor = $factory->createIntervalTriggerDescriptorBuilder()->startDate( date('c') )
 *      ->sendingTime( $sendingTime )->endDate( $endDate )->interval( $interval )
 *      ->attributeValueSetters( $commands )->build();
 * </pre>
 * 
 * The created trigger will fire every two weeks on Monday and Friday at 12:30 and will increase the Counter attribute.
 * The trigger will be active from now on till the next year.
 * 
 * @see Inx_Api_TriggerMailing_Descriptor_TriggerDescriptorBuilderFactory::createIntervalTriggerDescriptorBuilder()
 * @since API 1.10.0
 * @author chge, 17.07.2012
 */
interface Inx_Api_TriggerMailing_Descriptor_IntervalTriggerDescriptorBuilder 
        extends Inx_Api_TriggerMailing_Descriptor_TimeTriggerDescriptorBuilder
{
	/**
	 * Sets the <i>Inx_Api_TriggerMailing_Descriptor_TriggerInterval</i> used to define the dispatch intervals of 
         * an interval trigger mailing. This setting is mandatory.
	 * 
	 * @param Inx_Api_TriggerMailing_Descriptor_TriggerInterval interval the <i>TriggerInterval</i> used to define 
         *      the dispatch intervals of an interval trigger mailing.
	 * @return Inx_Api_TriggerMailing_Descriptor_IntervalTriggerDescriptorBuilder the builder.
	 * @throws Inx_Api_NullPointerException if the given interval is <i>null</i>.
	 */
	public function interval( Inx_Api_TriggerMailing_Descriptor_TriggerInterval $interval = null );
}