<?php
/**
 * An <i>Inx_Api_TriggerMailing_Descriptor_TriggerDescriptor</i> describes the trigger of an 
 * <i>Inx_Api_TriggerMailing_TriggerMailing</i>. The trigger defines when a <i>TriggerMailing</i> will be sent and 
 * which recipients will receive it. It therefore is the most important part of a <i>TriggerMailing</i>, controlling 
 * the whole dispatch process.
 * <p>
 * A <i>TriggerDescriptor</i> consists of a number of settings - some of which are optional depending on the
 * <i>Inx_Api_TriggerMailing_Descriptor_TriggerType</i>. The following settings are supported:
 * <ul>
 * <li><b>The <i>TriggerType</i>:</b> Defines what kind of trigger will be used (strictly mandatory).
 * <li><b>The start date</b>: Defines the date at which the trigger mailing will be dispatched first (only optional for
 * action triggers).
 * <li><b>The end date</b>: Defines the date at which the trigger mailing will be dispatched last (generally optional).
 * <li><b>The sending time</b>: Defines at which time the trigger mailing will be sent during each dispatch cycle (only
 * optional for action triggers).
 * <li><b>The attribute ID</b>: Defines the attribute used to determine the relevant recipients (mandatory for all
 * attribute driven triggers).
 * <li><b>The offset</b>: Defines the offset of the attribute. For example, how many days after a specific date the
 * trigger mailing shall be dispatched to a recipient (generally optional).
 * <li><b>The column modificator</b>: Defines how long after or before a specific date the trigger shall be fired (only
 * mandatory for anniversary triggers).
 * <li><b>An array of <i>SetValueCommand</i></b>s: Can be used to set recipient attribute values along with the
 * dispatch of the trigger mailing (generally optional).
 * <li><b>The <i>TriggerInterval</i></b>: Defines when the trigger mailing will be dispatched (only relevant for
 * interval triggers).
 * </ul>
 * <p>
 * It's rarely advisable to create a <i>TriggerDescriptor</i> directly as the state space is complex and can be
 * confusing. Generally, it's reasonable to use an <i>Inx_Api_TriggerMailing_Descriptor_TriggerDescriptorBuilder</i> for 
 * this task which will guide you through the process of creating a <i>TriggerDescriptor</i> and complain about any missing 
 * settings and broken invariants.
 * <p>
 * For an example on how to create a <i>TriggerDescriptor</i> using a builder, see the
 * <i>Inx_Api_TriggerMailing_TriggerMailingManager</i> documentation.
 * 
 * @see Inx_Api_TriggerMailing_TriggerMailing::getTriggerDescriptor()
 * @see Inx_Api_TriggerMailing_Descriptor_TriggerDescriptorBuilder
 * @see Inx_Api_TriggerMailing_TriggerMailingManager
 * @since API 1.10.0
 * @author chge, 16.07.2012
 */
interface Inx_Api_TriggerMailing_Descriptor_TriggerDescriptor
{
	/**
	 * Returns the type of the trigger described by this <i>TriggerDescriptor</i>. This setting is strictly
	 * mandatory.
	 *
	 * @return Inx_Api_TriggerMailing_Descriptor_TriggerType the type of the trigger.
	 */
	public function getType();


	/**
	 * Returns the date when the trigger described by this <i>TriggerDescriptor</i> will be fired for the first
	 * time. This setting is mandatory for all time triggers. That is, it's mandatory for all but action triggers.
	 *
	 * @return string the date when the trigger will be fired for the first time. The date is formatted as 
         * ISO-8601 datetime string.
	 */
	public function getStartDate();

        
        /**
	 * Returns the time when the trigger described by this <i>TriggerDescriptor</i> will be fired during each
	 * dispatch cycle. This setting is mandatory for all time triggers. That is, it's mandatory for all but action
	 * triggers.
	 * 
	 * @return string the time when the trigger will be fired during each dispatch cylce. The time is formatted as 
         * ISO-8601 datetime string.
	 */
	public function getSendingTime();

        
	/**
	 * Returns the date when the trigger described by this <i>TriggerDescriptor</i> will be fired for the last
	 * time. This setting is generally optional and only relevant for time trigger mailings.
	 *
	 * @return string the date when the trigger will be fired for the last time. The date is formatted as 
         * ISO-8601 datetime string.
	 */
	public function getEndDate();


	/**
	 * Returns an array of <i>Inx_Api_Action_SetValueCommand</i>s which will be executed when dispatching the trigger
	 * mailings. Using this feature, it is possible to set the values of recipient attributes along with the dispatching
	 * of a trigger mailing to that same recipient. This setting is generally optional and only relevant for time
	 * trigger mailings.
	 *
	 * @return array an array of <i>Inx_Api_Action_SetValueCommand</i>s used to set recipient attributes during dispatch.
	 */
	public function getAttributeValueSetters();


	/**
	 * Returns the ID of the recipient attribute used as basis of the trigger described by this <i>TriggerDescriptor</i>. 
         * This setting is only mandatory and relevant for all attribute driven triggers.
	 *
	 * @return int the ID of the recipient attribute used as basis of the trigger.
	 */
	public function getAttributeId();


	/**
	 * Returns the <i>Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffset</i> used to alter the dispatch date specified 
         * by the attribute. For example: Normally, birthday trigger mailings are sent on the birthday of the recipient. 
         * Using a <i>TimeTriggerOffset</i> you can send your congratulations before or after that date. This setting is
	 * generally optional and only relevant for time trigger mailings.
	 *
	 * @return Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffset the <i>TimeTriggerOffset</i> used to alter the 
         * dispatch date specified by the attribute.
	 */
	public function getOffset();


	/**
	 * Returns the <i>Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffset</i> used to define the time span between the 
         * dispatch date and the date specified by the attribute. For example: An anniversary trigger mailing can be sent 
         * out ten years after the date specified by the attribute. This setting is only mandatory and relevant for 
         * anniversary triggers.
	 *
	 * @return Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffset the <i>TimeTriggerOffset</i> used to define the time 
         * span between the dispatch date and the date specified by the attribute.
	 */
	public function getColumnModificator();


	/**
	 * Returns the <i>Inx_Api_TriggerMailing_Descriptor_TriggerInterval</i> used to define the dispatch intervals of an 
         * interval trigger mailing. This setting is only mandatory and relevant for interval triggers.
	 *
	 * @return Inx_Api_TriggerMailing_Descriptor_TriggerInterval the <i>TriggerInterval</i> used to define the dispatch 
         * intervals of an interval trigger mailing.
	 */
	public function getInterval();
}
