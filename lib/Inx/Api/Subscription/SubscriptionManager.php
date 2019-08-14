<?php

/**
 * @package Inxmail
 * @subpackage Subscription
 */
/**
 * If the subscription feature is enabled for a standard list, the <i>Inx_Api_Subscription_SubscriptionManager</i> can 
 * be used to subscribe and unsubscribe recipients and to retrieve log entries concerning subscription.
 * <p>
 * The behaviour is the same as if a recipient subscribes to a list via a web frontend. 
 * For example, if double opt in is configured, calling <i>processSubscription()</i> will start the normal double opt 
 * in subscription process.
 * <p>
 * The subscription process requires some information:
 * <p>
 * <ul>
 * <li><i>The source identifier</i>: A string which describes the source of the subscription (e.g. the name of the
 * landing page)
 * <li><i>The remote address</i>: The IP address of the subscriber
 * <li><i>The list context</i>: The mailing list to which the recipient shall be subscribed
 * <li><i>The email address</i>: The email address of the subscriber
 * <li><i>An attribute map</i>: An associative array of key-value pairs used to specify certain recipient attribute values
 * </ul>
 * <p>
 * The following snippet shows how to subscribe the recipient with the email address <i>name@company.com</i>, the last
 * name <i>Smith</i>, the birthday <i>1994-10-25</i> and two children to the specified list, using the specified remote
 * address and <i>Hompage(german)</i> as source:
 * <p>
 * 
 * <PRE>
 * $aAttributes = array(
 * 	"Lastname" => "Smith",
 *  "Birthday" => "2004-05-06",
 *  "Children" => 2
 * );
 * 
 * $oSubscriptionManager = $oSession->getSubscriptionManager();
 * $iResult = $oSubscriptionManager->processSubscription( "Homepage(german)", $sRemoteAddr, $oListContext,
 * 		"name@company.com", $aAttributes );
 * </PRE>
 * <p>
 * The unsubscription of recipients works pretty much the same. 
 * There is only one additional parameter: the <i>mailing reference</i>. 
 * This string identifies the mailing which contains the link used to unsubscribe the recipient. 
 * However, the mailing reference is only known if the link used for the unsubscription is known. 
 * This is the case for unsubscription JSPs but not for common API usage. 
 * In most cases the unsubscription of a recipient is accomplished using the <i>Inx_Api_Recipient_RecipientRowSet</i> or 
 * the <i>Inx_Api_Recipient_BatchChannel</i>.
 * <p>
 * The following snippet shows how to unsubscribe the recipient with the email address <i>name@company.com</i> from 
 * the specified list, using the specified remote address and mailing reference and <i>Homepage(german)</i> as source:
 * 
 * <PRE>
 * $oSubscriptionManager = $oSession->getSubscriptionManager(); 
 * $iResult = $oSubscriptionManager->processUnsubscription( &quot;Homepage(german)&quot;, $sRemoteAddr, $oListContext, &quot;name@company.com&quot;, $sMailingRef, null );
 * </PRE>
 * <p>
 * The result is either <i>PROCESS_ACTIVATION_SUCCESSFULLY</i> if the subscription or unsubscription succeeded, or
 * <i>PROCESS_ACTIVATION_FAILED_ADDRESS_ILLEGAL</i> if the address is not conform to the RFC standard.
 * <p>
 * In most circumstances, you would add the recipient to the system list with all his profile data prior to calling the SubscriptionManager. 
 * For an example on how to add recipients to the system list, see the <i>Inx_Api_Recipient_RecipientContext</i> documentation.
 * <p>
 * The <i>Inx_Api_Subscription_SubscriptionManager</i> may also be used to retrieve log entries concerning subscription. 
 * For example you can retrieve all log entries associated with the subscription and unsubscription of a specific list in the last month. 
 * The following snippet shows how to do this and prints out some of the information:
 * 
 * <pre>
 * // create start date
 * $sOneMonthAgo = date('c', strtotime("-1 month"));
 * 
 * // create recipient context and attributes to query
 * $oRecipientContext = $oSession->createRecipientContext();
 * $oRecipientMetaData = $oRecipientContext->getMetaData();
 * $oAttribute_email = $oRecipientMetaData->getEmailAttribute();
 * $oAttribute_lastname = $oRecipientMetaData->getUserAttribute( &quot;Lastname&quot; );
 * $aAttributes = array( $oAttribute_email, $oAttribute_lastname );
 * 
 * $oSubscriptionManager = $oSession->getSubscriptionManager();
 * $oSubscriptionLogEntryRowSet = $oSubscriptionManager->getLogEntriesAfterAndList( $oListContext, $sOneMonthAgo, $oRecipientContext, $aAttributes );
 * 
 * while( $oSubscriptionLogEntryRowSet->next() )
 * {
 * 	echo &quot;Log message: &quot;.$oSubscriptionLogEntryRowSet->getLogMessage().&quot;&#60;br&#62;&quot;;
 * 	echo &quot;Log date: &quot;.$oSubscriptionLogEntryRowSet->getEntryDatetime().&quot;&#60;br&#62;&quot;;
 * 	echo &quot;Email address: &quot;.$oSubscriptionLogEntryRowSet->getString( $oAttribute_email ).&quot;&#60;br&#62;&quot;;
 * 	echo &quot;Lastname: &quot;.$oSubscriptionLogEntryRowSet->getString( $oAttribute_lastname ).&quot;&#60;br&#62;&#60;br&#62;&quot;;
 * }
 * </pre>
 * 
 * For more information on this topic, see the <i>Inx_Api_Subscruption_SubscriptionLogEntryRowSet</i> documentation.
 * 
 * @see Inx_Api_Subscruption_SubscriptionLogEntryRowSet
 * @see Inx_Api_Recipient_RecipientContext
 * @see Inx_Api_Recipient_RecipientRowSet
 * @see Inx_Api_Recipient_BatchChannel
 * @since API 1.0.0
 * @version $Revision: 9553 $ $Date: 2008-01-04 11:28:41 +0200 (Pn, 04 Sau 2008) $ $Author: vladas $
 * @package Inxmail
 * @subpackage Subscription
 */
interface Inx_Api_Subscription_SubscriptionManager
{
    /**
	 * Subscription or Unsubscription process has been successfully activated.
	 * 
	 * @var int
	 */
	const PROCESS_ACTIVATION_SUCCESSFULLY = 3000;

	/**
	 * Subscription or Unsubscription process activation has failed, the address is not conform to the RFC standard.
	 * 
	 * @var int
	 */
	const PROCESS_ACTIVATION_FAILED_ADDRESS_ILLEGAL = 3002;

	
	/**
	 * Activates the subscription process for the specified email address and sets the attribute values specified in the
	 * given associative array.
	 * 
	 * @param string $sSourceIdentifier the source identifier used for reports (e.g. the name of the landing page).
	 * @param string $sRemoteAddress the remote IP address of the subscriber.
	 * @param Inx_Api_List_StandardListContext $oListContext the list to which the recipient shall be subscribed.
	 * @param string $sEmailAddress the email address of the recipient.
	 * @param associative array $aAttrKeyValuePairs a map of attribute key/value-pairs which will be set for the recipient; 
	 * 			may be <i>null</i> or ommitted.
	 * @return int the state of the process activation. May be one of:
	 *         <ul>
	 *         <li><i>PROCESS_ACTIVATION_SUCCESSFULLY</i>: the process was successfully activated
	 *         <li><i>PROCESS_ACTIVATION_FAILED_ADDRESS_ILLEGAL</i>: the provided email address is not conform to the
	 *         RFC standard.
	 *         </ul>
	 * @throws Inx_Api_FeatureNotAvailableException if the subscription feature is not enabled.
	 * @throws Inx_Api_SecurityException if the session user doesn't have the following permission:
	 *             <i>Inx_Api_UserRights::SUBSCRIPTION_FEATURE_USE</i>
	 * @since API 1.0.2
	 */
	public function processSubscription( $sSourceIdentifier = null, $sRemoteAddress = null, 
				Inx_Api_List_StandardListContext $oListContext, $sEmailAddress, /*Map*/ $aAttrKeyValuePairs=array() );

	
	/**
	 * Activates the unsubscription process for the specified email address and mailing id. 
	 * The mailing id specifies the mailing, which contains the unsubscription link used to unsubscribe the recipient.
	 * 
	 * @param string $sSourceIdentifier the source identifier used for reports (e.g. the name of the landing page).
	 * @param string $sRemoteAddress the remote IP address of the unsubscriber.
	 * @param Inx_Api_List_StandardListContext $ListContext the list from which the recipient shall be unsubscribed.
	 * @param string $sEmailAddress the email address of the recipient.
	 * @param int $iMailingId the id of the mailing which contains the used unsubscription link.
	 * @return the state of the process activation. May be one of:
	 *         <ul>
	 *         <li><i>PROCESS_ACTIVATION_SUCCESSFULLY</i>: the process was successfully activated
	 *         <li><i>PROCESS_ACTIVATION_FAILED_ADDRESS_ILLEGAL</i>: the provided email address is not conform to the
	 *         RFC standard.
	 *         </ul>
	 * @throws FeatureNotAvailableException Inx_Api_FeatureNotAvailableException if the subscription feature is not enabled.
	 * @throws Inx_Api_SecurityException if the session user doesn't have the following permission:
	 *             <i>Inx_Api_UserRights::SUBSCRIPTION_FEATURE_USE</i>
	 * @since API 1.5.0
	 * @deprecated use <i>processUnsubscription3( $sSourceIdentifier, $sRemoteAddress, 
			Inx_Api_List_ListContext $oListContext,	$sEmailAddress, $sMailingRef, $aAttrKeyValuePairs = null )</i>
	 */
	public function processUnsubscription( $sSourceIdentifier = null, $sRemoteAddress = null,
			Inx_Api_List_StandardListContext $ListContext, $sEmailAddress, $iMailingId = 0 );
			
	
	   /**
		* Activates the unsubscription process for the specified email address and mailing id and sets the attribute values
		* specified in the given associative array. 
		* The mailing id specifies the mailing, which contains the unsubscription link used to unsubscribe the recipient.
		*
		* @param string $sSourceIdentifier the source identifier used for reports (e.g. the name of the landing page).
		* @param string $sRemoteAddress the remote IP address of the unsubscriber.
		* @param Inx_Api_List_StandardListContext $oListContext the list from which the recipient shall be unsubscribed.
		* @param string $sEmailAddress the email address of the recipient.
		* @param int $iMailingId the id of the mailing which contains the used unsubscription link.
		* @param array $aAttrKeyValuePairs an associative array of attribute key/value-pairs which will be set for the recipient; 
		* 			may be <i>null</i> or ommitted.
		* @return int the state of the process activation. May be one of:
		*         <ul>
		*         <li><i>PROCESS_ACTIVATION_SUCCESSFULLY</i>: the process was successfully activated
		*         <li><i>PROCESS_ACTIVATION_FAILED_ADDRESS_ILLEGAL</i>: the provided email address is not conform to the
		*         RFC standard.
		*         </ul>
		* @throws Inx_Api_FeatureNotAvailableException if the subscription feature is not enabled.
		* @throws Inx_Api_SecurityException if the session user doesn't have the following permission:
		*             <i>Inx_Api_UserRights::SUBSCRIPTION_FEATURE_USE</i>
		* @since API 1.9.0
		* @deprecated use <i>processUnsubscription3( $sSourceIdentifier, $sRemoteAddress, 
			Inx_Api_List_ListContext $oListContext,	$sEmailAddress, $sMailingRef, $aAttrKeyValuePairs = null )</i> instead.
		*/
		public function processUnsubscription3( $sSourceIdentifier, $sRemoteAddress, 
			Inx_Api_List_StandardListContext $oListContext, $sEmailAddress, $iMailingId, $aAttrKeyValuePairs = null );
		
		
		/**
		 * Activates the unsubscription process for the specified email address and mailing reference and sets the attribute
		 * values specified in the given associative array. 
		 * The mailing reference specifies the mailing, which contains the unsubscription link used to unsubscribe the recipient.
		 *
		 * @param string $sSourceIdentifier the source identifier used for reports (e.g. the name of the landing page).
		 * @param string $sRemoteAddress the remote IP address of the unsubscriber.
		 * @param Inx_Api_List_ListContext $oListContext the list from which the recipient shall be unsubscribed.
		 * @param string $sEmailAddress the email address of the recipient.
		 * @param string $sMailingRef the mailing reference of the mailing which contains the used unsubscription link.
		 * @param array $aAttrKeyValuePairs an associative array of attribute key/value-pairs which will be set for the recipient; 
		 * 			may be <i>null</i> or ommitted.
		 * @return the state of the process activation. May be one of:
		 *         <ul>
		 *         <li><i>PROCESS_ACTIVATION_SUCCESSFULLY</i>: the process was successfully activated
		 *         <li><i>PROCESS_ACTIVATION_FAILED_ADDRESS_ILLEGAL</i>: the provided email address is not conform to the
		 *         RFC standard.
		 *         </ul>
		 * @throws Inx_Api_FeatureNotAvailableException if the subscription feature is not enabled.
		 * @throws Inx_Api_SecurityException if the session user doesn't have the following permission:
		 *             <i>Inx_Api_UserRights::SUBSCRIPTION_FEATURE_USE</i>
		 * @since API 1.9.0
		 */
		public function processUnsubscription4( $sSourceIdentifier, $sRemoteAddress, 
			Inx_Api_List_StandardListContext $oListContext,	$sEmailAddress, $sMailingRef, $aAttrKeyValuePairs = null );


	/**
	 * Returns an <i>Inx_Api_Subsciption_SubscriptionLogEntryRowSet</i> containing all existing (un)subscription log entries.
	 * 
	 * @param Inx_Api_Recipient_RecipientContext $rc the <i>RecipientContext</i> used to fetch the attribute data.
	 * @param array $attrs an array of recipient attributes (Inx_Api_Recipient_Attribute) which are fetched for later retrieval; 
	 * 				may be <i>null</i>.
	 * @return Inx_Api_Subscription_SubscriptionLogEntryRowSet a <i>SubscriptionLogEntryRowSet</i> containing all existing 
	 * 				(un)subscription log entries.
	 */
	public function getAllLogEntries($rc, $attrs );


	/**
	 * Returns an <i>Inx_Api_Subsciption_SubscriptionLogEntryRowSet</i> containing all existing (un)subscription log entries for 
	 * a given list.
	 * 
	 * @param Inx_Api_List_ListContext $lc the list for which the (un)subscription log entries shall be fetched.
	 * @param Inx_Api_Recipient_RecipientContext $rc the <i>RecipientContext</i> used to fetch the attribute data.
	 * @param array $attrs an array of recipient attributes (Inx_Api_Recipient_Attribute) which are fetched for later retrieval; 
	 * 				may be <i>null</i>.
	 * @return Inx_Api_Subscription_SubscriptionLogEntryRowSet a <i>SubscriptionLogEntryRowSet</i> containing all existing 
	 * 				(un)subscription log entries.
	 */
	public function getLogEntriesForList( $lc, $rc, $attrs );


	/**
	 * Returns a <i>Inx_Api_Subsciption_SubscriptionLogEntryRowSet</i> containing all existing (un)subscription log entries for a
	 * given list and before a given date.
	 * 
	 * @param Inx_Api_List_ListContext $lc the list for which the (un)subscription log entries shall be fetched.
	 * @param string $before all log entries before this date will be fetched. 
	 * 				The date has to be passed as ISO8601 formatted datetime string.
	 * @param Inx_Api_Recipient_RecipientContext $rc the <i>RecipientContext</i> used to fetch the attribute data.
	 * @param array $attrs an array of recipient attributes (Inx_Api_Recipient_Attribute) which are fetched for later retrieval; 
	 * 				may be <i>null</i>.
	 * @return Inx_Api_Subscription_SubscriptionLogEntryRowSet a <i>SubscriptionLogEntryRowSet</i> containing all existing 
	 * 				(un)subscription log entries for a given list and before a given date.
	 */
	public function getLogEntriesBeforeAndList( $lc, $before, $rc, $attrs );


	/**
	 * Returns a <i>Inx_Api_Subsciption_SubscriptionLogEntryRowSet</i> containing all existing (un)subscription log entries for a
	 * given list and after a given date.
	 * 
	 * @param Inx_Api_List_ListContext $lc the list for which the (un)subscription log entries shall be fetched.
	 * @param string $after all log entries after this date will be fetched.
	 * 				The date has to be passed as ISO8601 formatted datetime string. 
	 * @param Inx_Api_Recipient_RecipientContext $rc the <i>RecipientContext</i> used to fetch the attribute data.
	 * @param array $attrs an array of recipient attributes (Inx_Api_Recipient_Attribute) which are fetched for later retrieval; 
	 * 				may be <i>null</i>.
	 * @return Inx_Api_Subscription_SubscriptionLogEntryRowSet a <i>SubscriptionLogEntryRowSet</i> containing all existing 
	 * 				(un)subscription log entries for a given list and after a given date.
	 */
	public function getLogEntriesAfterAndList( $lc, $after, $rc, $attrs );


	/**
	 * Returns a <i>Inx_Api_Subsciption_SubscriptionLogEntryRowSet</i> containing all existing (un)subscription log entries for a
	 * given list and between the given dates.
	 * 
	 * @param Inx_Api_List_ListContext $lc the list for which the (un)subscription log entries shall be fetched.
	 * @param string $start the start date for the search.
	 * 				The date has to be passed as ISO8601 formatted datetime string. 
	 * @param string $end the end date for the search.
	 * 				The date has to be passed as ISO8601 formatted datetime string. 
	 * @param Inx_Api_Recipient_RecipientContext $rc the <i>RecipientContext</i> used to fetch the attribute data.
	 * @param array $attrs an array of recipient attributes (Inx_Api_Recipient_Attribute) which are fetched for later retrieval; 
	 * 				may be <i>null</i>.
	 * @return Inx_Api_Subscription_SubscriptionLogEntryRowSet a <i>SubscriptionLogEntryRowSet</i> containing all existing 
	 * 				(un)subscription log entries for a given list and between the given dates.
	 */
	public function getLogEntriesBetweenAndList( $lc, $start, $end, $rc, $attrs );


	/**
	 * Returns a <i>Inx_Api_Subsciption_SubscriptionLogEntryRowSet</i> containing all existing (un)subscription log entries 
	 * before a given date.
	 * 
	 * @param string $before all log entries before this date will be fetched. 
	 * 				The date has to be passed as ISO8601 formatted datetime string.
	 * @param Inx_Api_Recipient_RecipientContext $rc the <i>RecipientContext</i> used to fetch the attribute data.
	 * @param array $attrs an array of recipient attributes (Inx_Api_Recipient_Attribute) which are fetched for later retrieval; 
	 * 				may be <i>null</i>.
	 * @return Inx_Api_Subscription_SubscriptionLogEntryRowSet a <i>SubscriptionLogEntryRowSet</i> containing all existing 
	 * 				un/subscription log entries before a given date.
	 */
	public function getLogEntriesBefore( $before, $rc, $attrs );


	/**
	 * Returns a <i>Inx_Api_Subsciption_SubscriptionLogEntryRowSet</i> containing all existing (un)subscription log entries 
	 * after a given date.
	 * 
	 * @param string $after all log entries after this date will be fetched.
	 * 				The date has to be passed as ISO8601 formatted datetime string. 
	 * @param Inx_Api_Recipient_RecipientContext $rc the <i>RecipientContext</i> used to fetch the attribute data.
	 * @param array $attrs an array of recipient attributes (Inx_Api_Recipient_Attribute) which are fetched for later retrieval; 
	 * 				may be <i>null</i>.
	 * @return Inx_Api_Subscription_SubscriptionLogEntryRowSet a <i>SubscriptionLogEntryRowSet</i> containing all existing 
	 * 				un/subscription log entries after a given date.
	 */
	public function getLogEntriesAfter( $after, $rc, $attrs );


	/**
	 * Returns a <i>Inx_Api_Subsciption_SubscriptionLogEntryRowSet</i> containing all existing (un)subscription log entries 
	 * between given dates.
	 * 
	 * @param string $start the start date for the search.
	 * 				The date has to be passed as ISO8601 formatted datetime string. 
	 * @param string $end the end date for the search.
	 * 				The date has to be passed as ISO8601 formatted datetime string. 
	 * @param Inx_Api_Recipient_RecipientContext $rc the <i>RecipientContext</i> used to fetch the attribute data.
	 * @param array $attrs an array of recipient attributes (Inx_Api_Recipient_Attribute) which are fetched for later retrieval; 
	 * 				may be <i>null</i>.
	 * @return Inx_Api_Subscription_SubscriptionLogEntryRowSet a <i>SubscriptionLogEntryRowSet</i> containing all existing 
	 * 				(un)subscription log entries between given dates.
	 */
	public function getLogEntriesBetween( $start, $end, $rc, $attrs );

}
