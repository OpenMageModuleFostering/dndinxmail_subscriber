<?php
/**
 * @package Inxmail
 * @subpackage Subscription
 */

/**
 * An <i>Inx_Api_Subscription_SubscriptionLogEntryRowSet</i> can be used to determine whether recipients have  been 
 * unsubscribed from or subscribed to a list.
 * It can also contain information about the recipient, if she/he exists.
 * <P/>
 * The following information can be retrieved using the <i>SubscriptionLogEntryRowSet</i>:
 * <ul>
 * <li><i>The log entry type</i>: Describes the message of the entry. May be one of:
 * <ul>
 * <li><i>BLACKLISTED</i>: The recipient could not be subscribed because of a blacklist entry.</li>
 * <li><i>DUPLICATE_SUBSCRIPTION</i>: The recipient could not be subscribed because she/he is already subscribed.</li>
 * <li><i>INVALID_ADRESS_ERROR</i>: The recipient could not be subscribed because the email address </li>
 * is not conform to the RFC standard.
 * <li><i>LIST_UNSUBSCRIBE_HEADER_UNSUBSCRIPTION</i>: The recipient was unsubscribed using header unsubscription.</li>
 * <li><i>MANUAL_SUBSCRIPTION</i>: The recipient was subscribed by an Inxmail user.</li>
 * <li><i>MANUAL_UNSUBSCRIPTION</i>: The recipient was unsubscribed by an Inxmail user.</li>
 * <li><i>NOT_IN_LIST_UNSUBSCRIPTION</i>: The recipient could not be unsubscribed because she/he is not subscribed.</li>
 * <li><i>PENDING_SUBSCRIPTION</i>: The subscription of the recipient is in progress (Double Opt In).</li>
 * <li><i>PENDING_UNSUBSCRIPTION</i>: The unsubscription of the recipient is in progress (Double Opt Out).</li>
 * <li><i>SUBSCRIPTION_EMAIL_MISSMATCH</i>: The recipient could not be subscribed because of an 
 * email address mismatch.</li>
 * <li><i>SUBSCRIPTION_ID_NOT_VALID</i>: An invalid subscription verification was received (Double Opt In).</li>
 * <li><i>SUBSCRIPTION_INTERNAL_ERROR</i>: The recipient could not be subscribed due to an internal error.</li>
 * <li><i>SUBSCRIPTION_TIMED_OUT</i>: The subscription of the recipient timed out (Double Opt In).</li>
 * <li><i>SUBSCRIPTION_VERIFICATION_BOUNCED</i>: A subscription verification mail bounced.</li>
 * <li><i>UNSUBSCRIPTION_EMAIL_MISSATCH</i>: The recipient could not be unsubscribed because of an email address</li>
 * <li><i>UNSUBSCRIPTION_ID_NOT_VALID</i>: An invalid unsubscription verification was received (Double Opt Out).</li>
 * <li><i>UNSUBSCRIPTION_INTERNAL_ERROR</i>: The recipient could not be unsubscribed due to an internal error.</li>
 * <li><i>UNSUBSCRIPTION_TIMED_OUT</i>: The subscription of the recipient timed out (Double Opt Out).</li>
 * <li><i>UNSUBSCRIPTION_VERIFICATION_BOUNCED</i>: An unsubscription verification mail bounced.</li>
 * <li><i>VERIFIED_SUBSCRIPTION</i>: A recipient subscription has been verified.</li>
 * <li><i>VERIFIED_UNSUBSCRIPTION</i>: A recipient unsubscription has been verified.</li>
 * <li><i>UNKNOWN_SUBSCRIPTIONTYPE</i>: The log entry type is unknown.</li>
 * </ul>
 * </li>
 * <li><i>The log message</i>: The message associated with the log entry.</li>
 * <li><i>The datetime of the entry</i>: When was the log entry created?</li>
 * <li><i>The email address</i>: The email address of the recipient involved in the log entry.</li>
 * <li><i>The recipient id</i>: The id of the recipient involved in the log entry.</li>
 * <li><i>The recipient state</i>: The state of the recipient involved in the log entry. May be one of:
 * <ul>
 * <li><i>RECIPIENT_STATE_EXISTENT</i>: If the recipient exists.</li>
 * <li><i>RECIPIENT_STATE_UNKNOWN_OR_DELETED</i>: If the recipient was deleted or the state is unknown.</li>
 * </ul>
 * </li>
 * <li>Possibly some attributes queried in the <i>Inx_Api_Subscription_SubscriptionManager</i> which can be retrieved 
 * using the <i>getter</i> methods.</li>
 * </ul>
 * <P/>
 * A <i>SubscriptionLogEntryRowSet</i> object maintains a cursor pointing to its current row of data. 
 * Initially the cursor is positioned before the first row. 
 * The <i>next()</i> method moves the cursor to the next row (recipient), and because it returns <i>false</i> when 
 * there are no more rows in the <i>SubscriptionLogEntryRowSet</i> object, it can be used in a <i>while</i> loop to 
 * iterate through the result set.
 * <p/>
 * Be sure to call <i>next()</i> before the first retrieval statement on the row set. 
 * As stated above, initially the cursor is before the first row, thus no data can be retrieved from the row set 
 * before calling <i>next()</i>. 
 * Doing so will trigger an <i>Inx_Api_DataException</i>.
 * <P/>
 * The <i>SubscriptionLogEntryRowSet</i> interface provides <i>getter</i> methods (<i>getString</i>,
 * <i>getInteger</i>, and so on) for retrieving attribute values from the current row. 
 * Values can be retrieved using the attribute object if they were included in the query.
 * <p/>
 * The following snippet shows how to retrieve the email address of all (un)subscriptions in the row set, thus also
 * illustrating how to iterate over a <i>SubscriptionLogEntryRowSet</i>:
 * 
 * <pre>
 * $oRecipientContext = $oSession->createRecipientContext();
 * $oSubscriptionManager = $oSession->getSubscriptionManager();
 * $oSubscriptionLogEntryRowSet = $oSubscriptionManager->getAllLogEntries( $oRecipientContext, null );
 * 
 * while( $oSubscriptionLogEntryRowSet->next() )
 * {
 * 	echo $oSubscriptionLogEntryRowSet->getEmailAddress().&quot;&#60;br&#62;&quot;;
 * }
 * 
 * $oSubscriptionLogEntryRowSet->close();
 * </pre>
 * <p/>
 * <strong>Note:</strong> An <i>Inx_Api_Subscription_SubscriptionLogEntryRowSet</i> object <strong>must</strong> be closed 
 * once it is not needed anymore to prevent memory leaks and other potentially harmful side effects.
 * <p/>
 * For more information about the (un)subscription of recipients, see the <i>Inx_api_Subscritpion_SubscriptionManager</i> 
 * and Inx_Api_Recipient_RecipientContext</i> documentation.
 * 
 * @see Inx_api_Subscritpion_SubscriptionManager
 * @see Inx_Api_Recipient_RecipientContext
 * @since API 1.4.4
 * @version $Revision:$ $Date:$ $Author:$
 * @package Inxmail
 * @subpackage Subscription
 */
interface Inx_Api_Subscription_SubscriptionLogEntryRowSet
{
	/** 
	 * State for missing recipient information. 
	 * This state will be used when no attributes are specified in the query or in case of an unknown or deleted recipient. 
	 * 
	 * @var int
	 */
	const RECIPIENT_STATE_UNKNOWN_OR_DELETED = 0;

	/** 
	 * State for existent recipient.
	 * 
	 * @var int
	 */
	const RECIPIENT_STATE_EXISTENT = 1;

	/** 
	 * The SubscriptionInformation State for verified subscriptions.
	 * 
	 * @var int
	 */
	const VERIFIED_SUBSCRIPTION = 1;

	/** 
	 * The SubscriptionInformation State for verified unsubscriptions. 
	 * 
	 * @var int 
	 */
	const VERIFIED_UNSUBSCRIPTION = 2;

	/** The SubscriptionInformation State for pending subscriptions.
	 * 
	 * @var int  
	 */
	const PENDING_SUBSCRIPTION = 3;

	/** The SubscriptionInformation State for pending unsubscriptions.
	 * 
	 * @var int  
	 */
	const PENDING_UNSUBSCRIPTION = 4;

	/** The SubscriptionInformation State for an unknown subscription type.
	 * 
	 * @var int  
	 */
	const UNKNOWN_SUBSCRIPTIONTYPE = -1;
	
	/**
	* The SubscriptionInformation state for forced subscriptions.
	*
	* @var int
	* @since API 1.9.0
	*/
	const MANUAL_SUBSCRIPTION = 5;
	
	/**
	 * The SubscriptionInformation state for forced unsubscriptions.
	 *
	 * @var int
	 * @since API 1.9.0
	 */
	const MANUAL_UNSUBSCRIPTION = 6;
	
	/**
	 * The SubscriptionInformation state for duplicate subscriptions.
	 * 
	 * @var int
	 * @since API 1.9.0
	 */
	const DUPLICATE_SUBSCRIPTION = 7;
	
	/**
	 * The SubscriptionInformation state for unsubscription of unknown list members.
	 *
	 * @var int
	 * @since API 1.9.0
	 */
	const NOT_IN_LIST_UNSUBSCRIPTION = 8;
	
	/**
	 * The SubscriptionInformation state for a timed out subscription verification.
	 *
	 * @var int
	 * @since API 1.9.0
	 */
	const SUBSCRIPTION_TIMED_OUT = 9;
	
	/**
	 * The SubscriptionInformation state for an invalid subscription verification.
	 *
	 * @var int
	 * @since API 1.9.0
	 */
	const SUBSCRIPTION_ID_NOT_VALID = 10;
	
	/**
	 * The SubscriptionInformation state for subscriber email address != mail email address.
	 *
	 * @var int
	 * @since API 1.9.0
	 */
	const SUBSCRIPTION_EMAIL_MISSMATCH = 11;
	
	/**
	 * The SubscriptionInformation state for a timed out unsubscription verification.
	 *
	 * @var int
	 * @since API 1.9.0
	 */
	const UNSUBSCRIPTION_TIMED_OUT = 12;
	
	/**
	 * The SubscriptionInformation state for an invalid unsubscription verification.
	 *
	 * @var int
	 * @since API 1.9.0
	 */
	const UNSUBSCRIPTION_ID_NOT_VALID = 13;
	
	/**
	 * The SubscriptionInformation state for member email address != mail email address.
	 *
	 * @var int
	 * @since API 1.9.0
	 */
	const UNSUBSCRIPTION_EMAIL_MISSMATCH = 14;
	
	/**
	 * The SubscriptionInformation state for an error which occurred during the subscription.
	 *
	 * @var int
	 * @since API 1.9.0
	 */
	const SUBSCRIPTION_INTERNAL_ERROR = 15;
	
	/**
	 * The SubscriptionInformation state for an error which occurred during the unsubscription.
	 *
	 * @var int
	 * @since API 1.9.0
	 */
	const UNSUBSCRIPTION_INTERNAL_ERROR = 16;
	
	/**
	 * The SubscriptionInformation State for a subscription blocked by a blacklist agent.
	 *
	 * @var int
	 * @since API 1.9.0
	 */
	const BLACKLISTED = 17;
	
	/**
	 * The SubscriptionInformation state for an invalid mail address.
	 *
	 * @var int
	 * @since API 1.9.0
	 */
	const INVALID_ADRESS_ERROR = 18;
	
	/**
	 * The SubscriptionInformation state for a bounced subscription verification.
	 *
	 * @var int
	 * @since API 1.9.0
	 */
	const SUBSCRIPTION_VERIFICATION_BOUNCED = 19;
	
	/**
	 * The SubscriptionInformation state for a bounced unsubscription verification.
	 *
	 * @var int
	 * @since API 1.9.0
	 */
	const UNSUBSCRIPTION_VERIFICATION_BOUNCED = 20;
	
	/**
	 * The SubscriptionInformation state for an unsubscription received via an unsubscription header.
	 *
	 * @var int
	 * @since API 1.9.0
	 */
	const LIST_UNSUBSCRIBE_HEADER_UNSUBSCRIPTION = 21;



	/**
	 * Returns the whole log message as string.
	 * 
	 * @return string the log message as string.
	 * @throws Inx_Api_DataException if no row is selected (e.g. you forgot to call next()).
	 */
	function getLogMessage();


	/**
	 * Returns the id of the list associated with this entry.
	 * 
	 * @return int the id of the list associated with this entry.
	 * @throws Inx_Api_DataException if no row is selected (e.g. you forgot to call next()).
	 */
	function getListId() ;


	/**
	 * Returns the type of the entry. May be one of:
	 * <ul>
	 * <li><i>BLACKLISTED</i>: The recipient could not be subscribed because of a blacklist entry.
	 * <li><i>DUPLICATE_SUBSCRIPTION</i>: The recipient could not be subscribed because she/he is already subscribed.
	 * <li><i>INVALID_ADRESS_ERROR</i>: The recipient could not be subscribed because the email address is not conform
	 * to the RFC standard.
	 * <li><i>LIST_UNSUBSCRIBE_HEADER_UNSUBSCRIPTION</i>: The recipient was unsubscribed using header unsubscription.
	 * <li><i>MANUAL_SUBSCRIPTION</i>: The recipient was subscribed by an Inxmail user.
	 * <li><i>MANUAL_UNSUBSCRIPTION</i>: The recipient was unsubscribed by an Inxmail user.
	 * <li><i>NOT_IN_LIST_UNSUBSCRIPTION</i>: The recipient could not be unsubscribed because she/he is not
	 * subscribed.
	 * <li><i>PENDING_SUBSCRIPTION</i>: The subscription of the recipient is in progress (Double Opt In).
	 * <li><i>PENDING_UNSUBSCRIPTION</i>: The unsubscription of the recipient is in progress (Double Opt Out).
	 * <li><i>SUBSCRIPTION_EMAIL_MISSMATCH</i>: The recipient could not be subscribed because of an email address
	 * mismatch.
	 * <li><i>SUBSCRIPTION_ID_NOT_VALID</i>: An invalid subscription verification was received (Double Opt In).
	 * <li><i>SUBSCRIPTION_INTERNAL_ERROR</i>: The recipient could not be subscribed due to an internal error.
	 * <li><i>SUBSCRIPTION_TIMED_OUT</i>: The subscription of the recipient timed out (Double Opt In).
	 * <li><i>SUBSCRIPTION_VERIFICATION_BOUNCED</i>: A subscription verification mail bounced.
	 * <li><i>UNSUBSCRIPTION_EMAIL_MISSATCH</i>: The recipient could not be unsubscribed because of an email address
	 * <li><i>UNSUBSCRIPTION_ID_NOT_VALID</i>: An invalid unsubscription verification was received (Double Opt Out).
	 * <li><i>UNSUBSCRIPTION_INTERNAL_ERROR</i>: The recipient could not be unsubscribed due to an internal error.
	 * <li><i>UNSUBSCRIPTION_TIMED_OUT</i>: The subscription of the recipient timed out (Double Opt Out).
	 * <li><i>UNSUBSCRIPTION_VERIFICATION_BOUNCED</i>: An unsubscription verification mail bounced.
	 * <li><i>VERIFIED_SUBSCRIPTION</i>: A recipient subscription has been verified.
	 * <li><i>VERIFIED_UNSUBSCRIPTION</i>: A recipient unsubscription has been verified.
	 * <li><i>UNKNOWN_SUBSCRIPTIONTYPE</i>: The log entry type is unknown.
	 * </ul>
	 * 
	 * @return int the type of this entry.
	 * @throws Inx_Api_DataException if no row is selected (e.g. you forgot to call next()).
	 */
	function getType();


	/**
	 * Returns the datetime of the entry.
	 * 
	 * @return string the datetime. The datetime will be returned as ISO 8601 formatted datetime string.
	 * @throws Inx_Api_DataException if no row is selected (e.g. you forgot to call next()).
	 */
	function getEntryDatetime();


	/**
	 * Returns the email address associated with this entry.
	 * 
	 * @return the email address associated with this entry.
	 * @throws Inx_Api_DataException if no row is selected (e.g. you forgot to call next()).
	 */
	function getEmailAddress();


	/**
	 * Returns the id of the recipient associated with this entry, if the recipient exists.
	 * 
	 * @return the id of the recipient associated with this entry, if the recipient exists.
	 * @throws Inx_Api_DataException if the recipient does not exists or the recipient state is unknown. 
	 * 				May also occur if no row is selected (e.g. you forgot to call next()).
	 */
	function getRecipientId();


	/**
	 * Returns the state of the recipient associated with the current log entry. May be one of:
	 * <ul>
	 * <li><i>RECIPIENT_STATE_UNKNOWN_OR_DELETED</i> - if the recipient state is unknown or the recipient was deleted.
	 * <li><i>RECIPIENT_STATE_EXISTENT</i> - if the recipient exists.
	 * </ul>
	 * 
	 * @return the recipient state.
	 * @throws Inx_Api_DataException if the recipient state cannot be determined.
	 */
	function getRecipientState();


	/**
	 * Returns the integer value for the given recipient Attribute.
	 * 
	 * @param Inx_Api_Recipient_Attribute $attr the recipient attribute to be retrieved.
	 * @return int the integer value.
	 * @throws Inx_Api_IllegalArgumentException if the requested attribute was not fetched.
	 * @throws Inx_Api_IllegalStateException if the requested attribute is not of type <i>integer</i>.
	 * @throws Inx_Api_DataException if no row is selected (e.g. you forgot to call next()).
	 */
	function getInteger( Inx_Api_Recipient_Attribute $attr ) ;


	/**
	 * Returns the string value for the given recipient Attribute.
	 * 
	 * @param Inx_Api_Recipient_Attribute $attr the recipient attribute to be retrieved.
	 * @return string the string value.
	 * @throws Inx_Api_IllegalArgumentException if the requested attribute was not fetched.
	 * @throws Inx_Api_IllegalStateException if the requested attribute is not of type <i>string</i>.
	 * @throws Inx_Api_DataException if no row is selected (e.g. you forgot to call next()).
	 */
	function getString(Inx_Api_Recipient_Attribute $attr );


	/**
	 * Returns the datetime value for the given recipient Attribute.
	 * 
	 * @param Inx_Api_Recipient_Attribute $attr the recipient attribute to be retrieved.
	 * @return string the datetime value. The datetime will be returned as ISO 8601 formatted datetime string.
	 * @throws Inx_Api_IllegalArgumentException if the requested attribute was not fetched.
	 * @throws Inx_Api_IllegalStateException if the requested attribute is not of type <i>datetime</i>.
	 * @throws Inx_Api_DataException if no row is selected (e.g. you forgot to call next()).
	 */
	function getDatetime(Inx_Api_Recipient_Attribute $attr );


	/**
	 * Returns the date value for the given recipient Attribute.
	 * 
	 * @param Inx_Api_Recipient_Attribute $attr the recipient attribute to be retrieved.
	 * @return string the date value. The date will be returned as ISO 8601 formatted date string.
	 * @throws Inx_Api_IllegalArgumentException if the requested attribute was not fetched.
	 * @throws Inx_Api_IllegalStateException if the requested attribute is not of type <i>date</i>.
	 * @throws Inx_Api_DataException if no row is selected (e.g. you forgot to call next()).
	 */
	function getDate(Inx_Api_Recipient_Attribute $attr );


	/**
	 * Returns the time value for the given recipient Attribute.
	 * 
	 * @param Inx_Api_Recipient_Attribute $attr the recipient attribute to be retrieved.
	 * @return string the time value. The time will be returned as ISO 8601 formatted time string.
	 * @throws Inx_Api_IllegalArgumentException if the requested attribute was not fetched.
	 * @throws Inx_Api_IllegalStateException if the requested attribute is not of type <i>time</i>.
	 * @throws Inx_Api_DataException if no row is selected (e.g. you forgot to call next()).
	 */
	function getTime(Inx_Api_Recipient_Attribute $attr );


	/**
	 * Returns the float value for the given recipient Attribute.
	 * 
	 * @param Inx_Api_Recipient_Attribute $attr the recipient attribute to be retrieved.
	 * @return float the float value.
	 * @throws Inx_Api_IllegalArgumentException if the requested attribute was not fetched.
	 * @throws Inx_Api_IllegalStateException if the requested attribute is not of type <i>float</i>.
	 * @throws Inx_Api_DataException if no row is selected (e.g. you forgot to call next()).
	 */
	function getDouble( Inx_Api_Recipient_Attribute $attr );


	/**
	 * Returns the bool value for the given recipient Attribute.
	 * 
	 * @param Inx_Api_Recipient_Attribute $attr the recipient attribute to be retrieved.
	 * @return bool the bool value.
	 * @throws Inx_Api_IllegalArgumentException if the requested attribute was not fetched.
	 * @throws Inx_Api_IllegalStateException if the requested attribute is not of type <i>bool</i>.
	 * @throws Inx_Api_DataException if no row is selected (e.g. you forgot to call next()).
	 */
	function getBoolean(Inx_Api_Recipient_Attribute  $attr );


	/**
	 * Returns the value for the given recipient Attribute.<br>
	 * 
	 * @param Inx_Api_Recipient_Attribute $attr the recipient attribute to be retrieved.
	 * @return mixed the value.
	 * @throws Inx_Api_IllegalArgumentException if the requested attribute was not fetched.
	 * @throws Inx_Api_DataException if no row is selected (e.g. you forgot to call next()).
	 */
	function getObject(Inx_Api_Recipient_Attribute $attr );


	/**
	 * Moves the cursor to the front of this <i>Inx_Api_Subscription_SubscriptionLogEntryRowSet</i> object, 
	 * just before the first row. 
	 * This method has no effect if the result set contains no rows.
	 */
	function beforeFirstRow();


	/**
	 * Moves the cursor to the end of this <i>Inx_Api_Subscription_SubscriptionLogEntryRowSet</i> object, 
	 * just after the last row.
	 * This method has no effect if the result set contains no rows.
	 */
	function afterLastRow();


	/**
	 * Moves the cursor to the given row number in this <i>Inx_Api_Subscription_SubscriptionLogEntryRowSet</i> object. 
	 * The first row is row 0, the second is row 1, and so on.
	 * 
	 * @param int $row the number of the row to which the cursor should move.
	 */
	function setRow( $row );


	/**
	 * Retrieves the current row number. The first row is number 0, the second number 1, and so on.
	 * 
	 * @return int the current row number.
	 */
	function getRow();


	/**
	 * Moves the cursor down one row from its current position. 
	 * A <i>Inx_Api_Subscription_SubscriptionLogEntryRowSet</i> cursor is initially positioned before the first row; 
	 * the first call to the method <i>next()</i> makes the first row the current row; 
	 * the second call makes the second row the current row, and so on.
	 * 
	 * @return bool <i>true</i> if the new current row is valid, <i>false</i> if there are no more rows.
	 */
	function next();


	/**
	 * Moves the cursor to the previous row in this <i>Inx_Api_Subscription_SubscriptionLogEntryRowSet</i> object.
	 * 
	 * @return bool <i>true</i> if the cursor is on a valid row; <i>false</i> if it is off the result set.
	 */
	function previous();


	/**
	 * Returns the number of rows in this <i>Inx_Api_Subscription_SubscriptionLogEntryRowSet</i> object.
	 * 
	 * @return int the number of rows.
	 */
	function getRowCount();


	/**
	 * Releases the resources associated with this <i>Inx_Api_Subscription_SubscriptionLogEntryRowSet</i> object on 
	 * the server immediately.
     * <p>
     * An <i>Inx_Api_Subscription_SubscriptionLogEntryRowSet</i> object <strong>must</strong> be closed 
 	 * once it is not needed anymore to prevent memory leaks and other potentially harmful side effects.
	 */
	function close();

}

