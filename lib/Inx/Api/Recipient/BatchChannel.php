<?php

/**
 * @package Inxmail
 * @subpackage Recipient
 */
/**
 * An <i>Inx_Api_Recipient_BatchChannel</i> can (and should) be used for manipulation of large amounts of data. 
 * The <i>createRecipient()</i> and <i>selectRecipient()</i> methods are used to create and/or select a recipient. 
 * After creating or selecting a recipient, the following batch commands operate on this until another recipient is selected.
 * <p>
 * An <i>Inx_Api_Recipient_BatchChannel</i> may be used to perform the following operations:
 * <p>
 * <ul>
 * <li>Select recipients: <i>selectRecipient($sKeyValue)</i>
 * <li>Create recipients: <i>createRecipient($sKeyValue, $blSelectIfExistant)</i>
 * <li>Remove recipients: <i>removeRecipient($sKeyValue)</i>
 * <li>Manipulate recipient attributes <i>write($oAttribute, $oValue)</i> and <i>writeIfNull($oAttribute, $sValue)</i>
 * <li>Subscribe recipients: <i>subscribeIfNotUnsubscribed($oListContext, $sSubscriptionDate)</i>
 * <li>Unsubscribe recipients: <i>unsubscribe($oListContext)</i>
 * </ul>
 * The selection, creation and removal of recipients requires a value corresponding to the recipient key. 
 * Usually, this key is the email address. 
 * It is possible to use a different attribute as recipient key for the <i>BatchChannel</i>. 
 * To do this, use the <i>Inx_Api_Recipient_RecipientContext::createBatchChannel($oAttribute)</i> method to create 
 * the <i>Inx_Api_Recipient_BatchChannel</i> object and pass the attribute used as key. 
 * However, be aware that the attribute used as key should be unique, although this is no hard technical requirement. 
 * Using a non unique attribute as key will return any of the matching recipients (undetermined). 
 * Also, the creation of recipients using a different key attribute is not possible.
 * <p>
 * Note: Resubscription is not supported by <code>BatchChannel</code>. 
 * If you wish to resubscribe a recipient, use <i>In_Api_Recipient_UnsubscriptionRecipientRowSet::resubscribe($sDate)</i> instead.
 * <p>
 * The following snippet shows how to add two new addresses and change their "Firstname" and "Lastname" attributes. 
 * If the addresses exist already, these attribute values will be overwritten.
 * 
 * <pre>
 * $oRecipientContext = $oSession->createRecipientContext();
 * $oBatchChannel = $oRecipientContext->createBatchChannel();
 * $oRecipientMetaData = $oRecipientContext->getMetaData();
 * 
 * $oBatchChannel->createRecipient( "mueller@yourcompany.com", true );
 * $oBatchChannel->write( $oRecipientMetaData->getUserAttribute( "Firstname" ), "George" );
 * $oBatchChannel->write( $oRecipientMetaData->getUserAttribute( "Lastname" ), "Müller" );
 *
 * $oBatchChannel->createRecipient( "clinton@yourcompany.com", true );
 * $oBatchChannel->write( $oRecipientMetaData->getUserAttribute( "Firstname" ), "Bill" );
 * $oBatchChannel->write( $oRecipientMetaData->getUserAttribute( "Lastname" ), "Clinton" );
 *
 * $retArr = $oBatchChannel->executeBatch();
 * </pre>
 * 
 * Note: The <i>boolean</i> parameter of <i>createRecipient</i> defines how to handle already existent recipients. 
 * If the parameter is set to <i>true</i> - as in the example - the recipient will only be created if it does not already exist. 
 * Existent recipients are selected instead. 
 * If the parameter is set to <i>false</i> the <i>BatchChannel</i> will attempt to create the recipient. 
 * If the recipient is not already existing it will be created and selected. 
 * However, if the recipient exists already, the result will be <i>RESULT_FAILURE_DUPLICATE_KEY</i> and the recipient will 
 * <strong>not</strong> be selected. 
 * Therefore, all succeeding operations on this recipient will not be committed (<i>RESULT_NOT_COMMITTED</i>).
 * <p>
 * The selection and removal of recipients works very much the same, except that <i>removeRecipient($sKeyValue)</i> will 
 * not select the deleted recipient of course. 
 * After deleting a recipient, a new recipient must be selected (or created) before any tasks may be invoked. 
 * This is because the <i>remove()</i> method resets the currently selected recipient.
 * <p>
 * The <i>writeIfNull($oAttribute, $sValue)</i> method allows you to set an attribute value only, if no value was
 * assigned previously (i.e. the attribute value is <i>null</i>). 
 * A similar technique is used by <i>subscribeIfNotUnsubscribed($oListContext, $sDate)</i>. 
 * This method subscribes the selected recipient to the given list, only when the recipient was not unsubscribed from that list before.
 * <p>
 * Each command to the BatchChannel results in a value in the returned integer array. 
 * By scanning the array, you can find out which of the commands have been executed, and which have not.
 * <p>
 * The values produced by <code>removeRecipient()</code>:
 * <ul>
 * <LI>The recipientId is returned if the recipient is removed
 * <LI><i>RESULT_FAILURE_KEY_NOT_FOUND</i> is returned if the recipient doesn't exists
 * </ul>
 * <P>
 * The values produced by <i>selectRecipient()</i>:
 * <ul>
 * <LI>The recipientId is returned if the recipient is selected
 * <LI><i>RESULT_FAILURE_DUPLICATE_KEY</i> is returned if the unique key already exists
 * <LI><i>RESULT_FAILURE_BLOCKED_BY_BLACKLIST</i> is returned if the email address is blocked
 * <LI><i>RESULT_FAILURE_KEY_NOT_FOUND</i> is returned if the recipient doesn't exist
 * </ul>
 * <P>
 * The values produced by <i>createRecipient()</i>:
 * <ul>
 * <LI>The recipientId is returned if the recipient was successfully created or selected
 * <LI><i>RESULT_FAILURE_DUPLICATE_KEY</i> is returned if the unique key already exists
 * <LI><i>RESULT_FAILURE_BLOCKED_BY_BLACKLIST</i> is returned if the email address is blocked
 * <LI><i>RESULT_FAILURE_ILLEGAL_VALUE</i> is returned if the key value is illegal
 * </ul>
 * <P>
 * The values produced by <i>write()</i> and <i>writeIfNull()</i>
 * <ul>
 * <LI><i>RESULT_COMMITTED</i> is returned if the value is set and committed
 * <LI><i>RESULT_NOT_COMMITTED</i> is returned if the value is set, but could not be committed
 * <LI><i>RESULT_FAILURE_ILLEGAL_VALUE</i> is returned if the value of the attribute is illegal
 * </ul>
 * <P>
 * The values produced by <i>subscribeIfNotUnsubscribed()</i>
 * <ul>
 * <LI><i>RESULT_COMMITTED</i> is returned if the recipient was subscribed
 * <LI><i>RESULT_NOT_COMMITTED</i> is returned if the recipient was unsubscribed before
 * </ul>
 * <P>
 * The values produced by <i>unsubscribe()</i>
 * <ul>
 * <LI><i>RESULT_COMMITTED</i> is returned if the recipient was unsubscribed
 * <LI><i>RESULT_NOT_COMMITTED</i> is returned if the recipient was already unsubscribed before
 * </ul>
 * <p>
 * For more information on recipients, see the <i>Inx_Api_Recipient_RecipientContext</i> documentation.
 * 
 * @see Inx_Api_Recipient_RecipientContext 
 * @since   API 1.0
 * @version $Revision: 9553 $ $Date: 2008-01-04 11:28:41 +0200 (Pn, 04 Sau 2008) $ $Author: vladas $
 * @package Inxmail
 * @subpackage Recipient
 */
interface Inx_Api_Recipient_BatchChannel
{

	/** RESULT_COMMITTED is returned if the value is set and committed. */
	const RESULT_COMMITTED = -100;

	/** RESULT_NOT_COMMITTED is returned if the data was not committed. */
	const RESULT_NOT_COMMITTED = -101;

	/** RESULT_FAILURE_ILLEGAL_VALUE is returned if the key value is illegal. */
	const RESULT_FAILURE_ILLEGAL_VALUE = -102;

	/** RESULT_FAILURE_BLOCKED_BY_BLACKLIST is returned if the email address is blocked by a blacklist entry. */
	const RESULT_FAILURE_BLOCKED_BY_BLACKLIST = -103;

	/** RESULT_FAILURE_DUPLICATE_KEY is returned if the unique key already exists. */
	const RESULT_FAILURE_DUPLICATE_KEY = -104;

	/** RESULT_FAILURE_KEY_NOT_FOUND is returned if the recipient doesn't exist. */
	const RESULT_FAILURE_KEY_NOT_FOUND = -105;

	/** RESULT_PERMISSION_DENIED is returned if the permission is denied to create, update or remove a recipient. */
	const RESULT_PERMISSION_DENIED = -200;


	/**
	 * Removes the recipient identified by the given key value from the system.
	 * <p>
	 * A key different from the email address may be specified using
	 * <i>Inx_Api_Recipient_RecipientContext::createBatchChannel($oAttribute)</i>. 
	 * However, be careful with that method, as the selected recipient for non unique key attributes is not determined. 
	 * In such a case, any of the matching recipients may be removed.
	 * 
	 * @param string $sKeyValue	the key value of the desired recipient.
	 */
	public function removeRecipient( $sKeyValue );

	
	/**
	 * Selects an existing recipient identified by the given key value.
	 * <p>
	 * A key different from the email address may be specified using
	 * <i>Inx_Api_Recipient_RecipientContext::createBatchChannel($oAttribute)</i>. 
	 * However, be careful with that method, as the selected recipient for non unique key attributes is not determined. 
	 * In such a case, any of the matching recipients may be selected.
	 * 
	 * @param string $sKeyValue	the key value from the desired recipient.
	 */
	public function selectRecipient( $sKeyValue );


	/**
	 * Create and/or select a recipient identified by the given key value. 
	 * The behaviour of this method depends on the value of the <i>bool</i> parameter and the recipient state (existing or not existing). 
	 * The behaviour is defined as follows:
	 * <ul>
	 * <li>Recipient does not exist, parameter is <i>false</i>: The recipient will be created and selected.
	 * <li>Recipient already exists, parameter is <i>false</i>: The recipient will neither be created nor selected.
	 * <li>Recipient does not exist, parameter is <i>true</i>: The recipient will be created and selected.
	 * <li>Recipient already exists, parameter is <i>true</i>: The recipient will not be created but selected.
	 * </ul>
	 * <strong>Note:</strong> If a key different from the email address is used by this <i>Inx_Api_Recipient_BatchChannel</i> 
	 * this method will not create any recipient. 
	 * To use this method you must use the email address as recipient key.
	 * <p>
	 * 
	 * @param string $sKeyValue	the key value of the recipient to create/select.
	 * @param bool $blSelectIfExistant <i>true</i> if existent recipients shall be selected, <i>false</i> if existent 
	 * recipients shall neither be created nor selected.
	 */
	public function createRecipient( $sKeyValue, $blSelectIfExistant );

	
	/**
	 * Sets a new value to the specified attribute. 
	 * Requires a previously invoked select or create command. 
	 * If the attribute is changed several times during a batch command, the last will be the new value.
	 * 
	 * @param Inx_Api_Recipient_Attribute $oAttribute the attribute to be set.
	 * @param string $sValue the new value.
	 */
	public function write( Inx_Api_Recipient_Attribute $oAttribute, $sValue );
	
	
	/**
	 * Sets a new value to the specified attribute, only if the current value is <i>null</i>. 
	 * Requires a previously invoked select or create command. 
	 * If this method is invoked several times during a batch command, the first value will be set.
	 * 
	 * @param Inx_Api_Recipient_Attribute $oAttribute the attribute to be set.
	 * @param string $sValue the new value.
	 */
	public function writeIfNull( Inx_Api_Recipient_Attribute $oAttribute, $sValue );

	
	/**
	 * Unsubscribes the current recipient from the specified list. 
	 * Requires a previously invoked select or create command and the recipient must be a member of the list.
	 * 
	 * @param lc the list from which the recipient should be unsubscribed.
	 * @since API 1.6.0
	 */
	public function unsubscribe( Inx_Api_List_ListContext $lc );


	/**
	 * Subscribes a new recipient to the given list, if she/he was not unsubscribed from it before. 
	 * Use the <i>write()</i> method to overwrite the unsubscription of the recipient or use
	 * <i>Inx_Api_Recipient_UnsubscriptionRecipientRowSet::resubscribe($sDate)</i> instead.
	 * 
	 * @param lc the list to which the recipient should be subscribed.
	 * @param subscriptionDate the subscription date. May <strong>not</strong> be <i>null</i>.
	 * @since API 1.6.0
	 */
	public function subscribeIfNotUnsubscribed( Inx_Api_List_ListContext $lc, $subscriptionDate );
	
	
	
	/**
	 * Execute the batched commands.
	 * 
	 * @return array an array of <i>int</i>, with each element indicating the result of a the corresponding command. 
	 * 		   May be one of:
	 *         <ul>
	 *         <li><i>RESULT_COMMITTED</i>
	 *         <li><i>RESULT_NOT_COMMITTED</i>
	 *         <li><i>RESULT_FAILURE_BLOCKED_BY_BLACKLIST</i>
	 *         <li><i>RESULT_FAILURE_DUPLICATE_KEY</i>
	 *         <li><i>RESULT_FAILURE_ILLEGAL_VALUE</i>
	 *         <li><i>RESULT_FAILURE_KEY_NOT_FOUND</i>
	 *         <li><i>RESULT_PERMISSION_DENIED</i>
	 *         </ul>
	 */
	public function executeBatch();

	
	/**
	 * Retrieves the <i>Inx_Api_Recipient_RecipientContext</i> which created this <i>BatchChannel</i>.
	 * 
	 * @return Inx_Api_Recipient_RecipientContext the <i>RecipientContext</i> which created this <i>BatchChannel</i>.
	 */
	public function getContext();

}
