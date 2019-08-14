<?php
/**
 * @package Inxmail
 * @subpackage TriggerMailing
 */

/**
 * The <i>TriggerMailingManager</i> manages all trigger mailings. The <i>TriggerMailingManager</i> can be
 * used to perform the following tasks:
 * <ul>
 * <li>Retrieve mailings
 * <li>Create mailings
 * <li>Clone mailings
 * <li>Create a renderer to generate a preview of the mailing
 * </ul>
 * Be aware that this manager is not able to manage normal mailings. Normal mailings are managed by the
 * <i>Inx_Api_Mailing_MailingManager</i>.
 * <p>
 * <strong>Mailing retrieval</strong>
 * <p>
 * There are several ways to retrieve trigger mailings. The simplest way is to call <i>selectAll()</i> which will
 * retrieve all trigger mailings. To retrieve a single trigger mailing, use the <i>get(int)</i> method. To
 * retrieve all trigger mailings of a specific list use one of the <i>selectByState(...)</i> methods. Using this
 * type of method gives you the ability to define search filters, like the trigger mailing state. It is also possible to
 * order the result.
 * <p>
 * The following snippet shows how to retrieve all trigger mailings of a specific list, which are either in the
 * <code>DRAFT</code> or the <code>APPROVAL_REQUESTED</code> state and print out their names:
 * 
 * <pre>
 * $triggerMailingMgr = $session->getTriggerMailingManager();
 * $mailingStateFilter = array( Inx_Api_TriggerMailing_TriggerMailingState::DRAFT(),
 *      Inx_Api_TriggerMailing_TriggerMailingState::APPROVAL_REQUESTED() );
 * $stateFilter = $triggerMailingMgr->createMailingStateFilter( $mailingStateFilter );
 * $set = $triggerMailingMgr->selectByState( $listContext, $stateFilter );
 *
 * for( $i = 0; $i &lt; $set-&gt;size(); $i++ )
 * {
 *      $tm = $set->get( $i );
 *      echo $tm->getName() . '&lt;br&gt;';
 * }
 *
 * $set->close();
 * </pre>
 * 
 * To retrieve all mailings of a specific list, disregarding their state, use the all matching state filter which can be
 * created using the <i>createAllMatchingStateFilter()</i> method. This filter produces the same result as a state
 * filter with all states.
 * <p>
 * If needed, it is possible to create much more complex select statements than the one above. This can be accomplished
 * using filter expressions. The following snippet extends the previous select statement with a filter that restricts
 * the result to mailings which were modified during the last hour. The result is also ordered by the mailing name:
 * 
 * <pre>
 * $triggerMailingMgr = $session->getTriggerMailingManager();
 *
 * $filterDate = date('d.m.Y H:i:s', strtotime('-1 hour'));
 * $filter = 'Attribute(' . Inx_Api_TriggerMailing_TriggerMailingAttribute::MODIFICATION_DATETIME()->getId() 
 *      . ') > #' . $filterDate . '#';
 *               
 * $mailingStateFilter = array( Inx_Api_TriggerMailing_TriggerMailingState::DRAFT(),
 *      Inx_Api_TriggerMailing_TriggerMailingState::APPROVAL_REQUESTED() );
 * $stateFilter = $triggerMailingMgr->createMailingStateFilter( $mailingStateFilter );
 *
 * $set = $triggerMailingMgr->selectByState( $listContext, $stateFilter,
 *      Inx_Api_TriggerMailing_TriggerMailingAttribute::NAME(), Inx_Api_Order::ASC, $filter );
 *
 * for( $i = 0; $i &lt; $set-&gt;size(); $i++ )
 * {
 *      $tm = $set->get( $i );
 *      echo $tm->getName() . '&lt;br&gt;';
 * }
 *
 * $set->close();
 * </pre>
 * <p>
 * <strong>Mailing creation and editing</strong>
 * <p>
 * Creating a trigger mailing can be a bit tricky as there are many settings needed to set up a trigger descriptor.
 * There are several builders which will help you with creating a valid trigger descriptor. The following snippet
 * exemplary shows how to create an anniversary trigger mailing:
 * 
 * <pre>
 * $optInDate = $session->createRecipientContext()->getMetaData()->getSubscriptionAttribute( 
 *      $listContext )->getId();
 * $startDate = date('c');
 * $sendingTime = date('c', mktime(12, 30));
 *
 * $triggerMailingMgr = $session->getTriggerMailingManager();
 * $descriptor = $triggerMailingMgr->getTriggerDescriptorBuilderFactory()
 *      ->createAnniversaryTriggerDescriptorBuilder()->startDate( $startDate )->sendingTime( $sendingTime )
 *      ->attribute( $optInDate )->columnModificator(
 *              new Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffset( 
 *                      Inx_Api_TriggerMailing_Descriptor_TimeTriggerOffsetType::WAS_AGO(), 
 *                      Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit::YEAR(), 1 ) )->build();
 *
 * $mailing = $triggerMailingMgr->createTriggerMailing( $listContext, $descriptor );
 * $mailing->updateName( 'One year anniversary' );
 * $mailing->updateSubject( "Thank's for staying with us!" );
 * $mailing->commitUpdate();
 * </pre>
 * 
 * The created anniversary mailing will be sent to recipients that have been member of the specified list for one year.
 * The descriptor in this example is set up with minimal information. If you wish to, you can configure even more
 * aspects of the trigger. You could, for example, add commands to set recipient attributes along with sending the
 * mailing. The available options vary from builder to builder, documented for each builder interface, including
 * information on which settings are mandatory and which are optional.
 * <p>
 * <strong>Note:</strong> For existing trigger mailings, always call <i>lock()</i> before updating it, and
 * <i>unlock()</i> after committing changes!
 * <p>
 * The following snippet shows how to edit an existing trigger mailing:
 * 
 * <pre>
 * $triggerMailingMgr = $session->getTriggerMailingManager();
 * $mailing = $triggerMailingMgr->get( $iMailingId );
 *
 * try
 * {
 *      $mailing->lock();
 *      $mailing->updateSubject( 'New Subject' );
 *      $mailing->commitUpdate();
 *      $mailing->unlock();
 * }
 * catch( Inx_Api_LockException $x )
 * {
 *      // someone else has locked this mailing
 * }
 * </pre>
 * <p>
 * It is not necessary to repeatedly create almost identical mailings. This can be accomplished a lot easier using the
 * <i>clone()</i> method.
 * <p>
 * The following snippet shows how to clone a mailing and put the clone in the specified list:
 * 
 * <pre>
 * $triggerMailingMgr = $session->getTriggerMailingManager();
 * $triggerMailingMgr->cloneMailing( $iMailingId, $listContext );
 * </pre>
 * <p>
 * <strong>Preview generation</strong>
 * <p>
 * To create a preview of a trigger mailing, an <i>Inx_Api_TriggerMail_TriggerMailingRenderer</i> is needed. A renderer 
 * can be obtained using the <i>createRenderer()</i> method.
 * <p>
 * The following snippet shows how to create a <i>TriggerMailingRenderer</i> and generate a preview of the trigger
 * mailing:
 * 
 * <pre>
 * $triggerMailingMgr = $session->getTriggerMailingManager();
 * $renderer = $triggerMailingMgr->createRenderer();
 * $renderer->parse( $iMailingId, Inx_Api_TriggerMail_BuildMode::PREVIEW() );
 * $preview = $renderer->build( $iRecipientId );
 *
 * echo $preview->getHtmlText() . '<br>';
 * </pre>
 * <p>
 * For more information on <i>TriggerMailing</i>s, see the <i>Inx_Api_TriggerMailing_TriggerMailing</i> documentation.
 * <p>
 * Note: To use trigger mailings, the following API user right is required: <i>Inx_Api_UserRights::MAILING_FEATURE_USE</i>
 * 
 * @see Inx_Api_TriggerMailing_TriggerMailing
 * @since API 1.10.0
 * @author chge, 12.07.2012
 */
interface Inx_Api_TriggerMailing_TriggerMailingManager extends Inx_Api_BOManager
{
	/**
	 * Returns a <code>BOResultSet</code> containing all trigger mailings of the specified list, that pass the specified
	 * state filter and filter expression. The result will be ordered by the given attribute using the specified order
	 * type.
	 * <p>
	 * The stateFilter parameter can be created using one of the following methods:
	 * <ul>
	 * <li><i>createMailingStateFilter</i>: matches a set of mailing states.
	 * <li><i>createTriggerStateFilter</i>: matches a specific trigger state.
	 * <li><i>createStateFilter</i>: matches a set of mailing states and a specific trigger state. Both filters must 
         * be passed.
	 * <li><i>createAllMatchingStateFilter()</i>: matches any mailing and trigger state. Note: this is a singleton.
	 * </ul>
	 * <p>
	 * To retrieve all trigger mailings of a list, disregarding their state, use the all matching state filter.
	 * <p>
	 * The filter parameter is a boolean expression on a single trigger mailing attribute. The expression syntax is
	 * almost identical to the one used by <i>Inx_Api_Filter_Filter::updateStatement( $sStmt )</i> with two exceptions:
	 * <ol>
	 * <li>The filter is not matching recipient attributes, but trigger mailing attributes. To define the mailing
	 * attribute to match, use the following pattern: 
         * <i>'Attribute(' . Inx_Api_TriggerMailing_TriggerMailingAttribute::XYZ()->getId() . ')'</i>
	 * <li>The filter may only match one column. The operators AND and OR are not allowed.
	 * </ol>
	 * <p>
	 * The orderAttribute parameter is the attribute used to order the result. Allowed attributes are:
	 * <ul>
	 * <li><i>Inx_Api_TriggerMailing_TriggerMailingAttribute::SUBJECT()</i>: the subject of the trigger mailing - alphabetical order.
	 * <li><i>Inx_Api_TriggerMailing_TriggerMailingAttribute::NAME()</i>: the name of the trigger mailing - alphabetical order.
	 * <li><I>Inx_Api_TriggerMailing_TriggerMailingAttribute::MODIFICATION_DATETIME()</i>: the datetime of the last modification of 
         * the trigger mailing - chronological order.
	 * <li><i>Inx_Api_TriggerMailing_TriggerMailingAttribute::ACTIVATION_DATETIME()</i>: the datetime of the first activation of the 
         * trigger mailing - chronological order.
	 * <li><i>Inx_Api_TriggerMailing_TriggerMailingAttribute::SINGLE_SEND_COUNT()</i>: the number of recipients to which the trigger 
         * mailing was sent till now - numerical order.
	 * <li><i>Inx_Api_TriggerMailing_TriggerMailingAttribute::DEFAULT()</i>: the default order attribute - unspecified order.
	 * </ul>
	 * To check if an attribute can be used as order attribute, use the
	 * <i>Inx_Api_TriggerMailing_TriggerMailingAttribute::isOrderAttribute()</i> method.
	 *
	 * @param Inx_Api_List_ListContext $listContext the list which contains the trigger mailings to be retrieved.
	 * @param Inx_Api_TriggerMailing_StateFilter $stateFilter the state filter condition.
	 * @param Inx_Api_TriggerMailing_TriggerMailingAttribute $orderAttribute the attribute used to order the result. May be omitted.
	 * @param int $iOrderType the order direction; one of <i>Inx_Api_Order::ASC</i> and <I>Inx_Api_Order::DESC</i>. May be omitted.
         * @param string $sFilter the filter expression. May be omitted.
	 * @return Inx_Api_BOResultSet a <i>BOResultSet</i> containing all trigger mailings of the specified list, that pass the specified
	 *         state filter and filter expression.
	 * @throws Inx_Api_FilterStmtException if the given filter statement could not be parsed.
         * @throws Inx_Api_IllegalArgumentException if the given order attribute is invalid.
	 */
	public function selectByState( Inx_Api_List_ListContext $listContext, Inx_Api_TriggerMailing_StateFilter $stateFilter, 
			Inx_Api_TriggerMailing_TriggerMailingAttribute $orderAttribute = null, $iOrderType = null, $sFilter = null );


	/**
	 * Creates a new trigger mailing in the specified list using the given trigger descriptor. To create a trigger
	 * descriptor, use one of the builders provided by the <i>Inx_Api_TriggerMailing_Descriptor_TriggerDescriptorBuilderFactory</i>, 
         * which can be obtained using the <i>getTriggerDescriptorBuilderFactory()</i> method.
	 *
	 * @param Inx_Api_List_ListContext $listContext the list that will be containing the trigger mailing.
	 * @param Inx_Api_TriggerMailing_Descriptor_TriggerDescriptor $descriptor the descriptor for the trigger.
	 * @return Inx_Api_TriggerMailing_TriggerMailing a new <i>TriggerMailing</i>.
	 */
	public function createTriggerMailing( Inx_Api_List_ListContext $listContext, 
			Inx_Api_TriggerMailing_Descriptor_TriggerDescriptor $descriptor );


	/**
	 * Creates a new <i>Inx_Api_TriggerMail_TriggerMailingRenderer</i> which can be used to render a <i>TriggerMailing</i>.
	 *
	 * @return Inx_Api_TriggerMail_TriggerMailingRenderer a new <i>TriggerMailingRenderer</i>.
	 */
	public function createRenderer();


	/**
	 * Creates a new <i>Inx_Api_TriggerMail_TriggerMailingRenderer</i> which can be used to render a <i>TriggerMailing</i>
	 * personalized with a test recipient instead of an ordinary recipient.
	 *
	 * @return Inx_Api_TriggerMail_TriggerMailingRenderer a new <i>TriggerMailingRenderer</i> for test recipients.
	 */
	public function createRendererForTestrecipient();


	/**
	 * Copies a <i>TriggerMailing</i> to the specified list.
	 *
         * @param int $iMailingId the id of the trigger mailing to be cloned.
         * @param Inx_Api_List_ListContext $lc the list to which the trigger mailing should be cloned.
	 * @return Inx_Api_TriggerMailing_TriggerMailing the new <i>TriggerMailing</i> which is a clone of the specified 
         *      <i>TriggerMailing</i>.
	 * @throws Inx_Api_DataException if the trigger mailing does not exist or can not be copied. See the exception reason for
	 *             detailed information.
	 */
	public function cloneMailing( $iMailingId, Inx_Api_List_ListContext $lc );


	/**
	 * Creates a new <i>Inx_Api_TriggerMailing_StateFilter</i> which matches all of the given mailing states and any trigger 
         * state.
	 * <p>
	 * The easiest way to create the array is to use the <i>array()</i> method. The following example demonstrates how to 
         * create a <i>set</i> of two mailing states:
	 *
	 * <pre>
	 * $stateFilter = array( Inx_Api_TriggerMailing_TriggerMailingState::DRAFT(), 
         *      Inx_Api_TriggerMailing_TriggerMailingState::APPROVAL_REQUESTED() );
	 * </pre>
	 *
	 * @param array $stateFilter a set of mailing states the filter shall match.
	 * @return Inx_Api_TriggerMailing_StateFilter a new <i>StateFilter</i> matching the given mailing states.
	 */
	public function createMailingStateFilter( array $stateFilter = null );


	/**
	 * Creates a new <i>Inx_Api_TriggerMailing_StateFilter</i> which matches the given trigger state and any mailing state.
	 *
	 * @param Inx_Api_TriggerMailing_TriggerState $stateFilter the trigger state the filter shall match.
	 * @return Inx_Api_TriggerMailing_StateFilter a new <i>StateFilter</i> matching the given trigger state.
	 */
	public function createTriggerStateFilter( Inx_Api_TriggerMailing_TriggerState $stateFilter = null );


	/**
	 * Creates a new <i>Inx_Api_TriggerMailing_StateFilter</i> which matches all of the given mailing states AND the given 
         * trigger state. Both filters must be matched.
	 *
	 * @param array $mailingStateFilter a set of mailing states the filter shall match.
	 * @param Inx_Api_TriggerMailing_TriggerState $triggerStateFilter the trigger state the filter shall match.
	 * @return Inx_Api_TriggerMailing_StateFilter a new <i>StateFilter</i> matching the given mailing states and trigger state.
	 */
	public function createStateFilter( array $mailingStateFilter = null, 
                Inx_Api_TriggerMailing_TriggerState $triggerStateFilter = null );


	/**
	 * Returns a <i>Inx_Api_TriggerMailing_StateFilter</i> which matches any mailing and trigger state.
	 * <p>
	 * Note: This <i>StateFilter</i> is a singleton.
	 *
	 * @return Inx_Api_TriggerMailing_StateFilter a <i>StateFilter</i> which matches any mailing and trigger state.
	 */
	public function createAllMatchingStateFilter();


	/**
	 * Returns the <i>Inx_Api_TriggerMailing_Descriptor_TriggerDescriptorBuilderFactory</i> used to create builders for 
         * the various trigger types.
	 * <p>
	 * Note: The factory is a singleton.
	 *
	 * @return Inx_Api_TriggerMailing_Descriptor_TriggerDescriptorBuilderFactory the <i>TriggerDescriptorBuilderFactory</i> 
         * used to create builders for the various trigger types.
	 */
	public function getTriggerDescriptorBuilderFactory();


	/**
	 * Return the <i>Inx_Api_TriggerMailing_Descriptor_TriggerIntervalBuilderFactory</i> used to create the builders for 
         * the various interval types. The resulting <i>Inx_Api_TriggerMailing_Descriptor_TriggerInterval</i> is used for 
         * interval trigger mailings.
	 * <p>
	 * Note: the factory is a singleton.
	 *
	 * @return Inx_Api_TriggerMailing_Descriptor_TriggerIntervalBuilderFactory the <i>TriggerIntervalBuilderFactory</i> 
         * used to create the builders for the various interval types.
	 */
	public function getTriggerIntervalBuilderFactory();
}
