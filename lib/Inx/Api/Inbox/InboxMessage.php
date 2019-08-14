<?php

/**
* An <i>Inx_Api_Inbox_InboxMessage</i> object contains information related to a message received through the inbox. 
* With this object you can access data of a received reply, auto responder message, flame message or spam message. 
* For example you can retrieve the id of the recipient or the content of the received message.
* <p>
* For an example on how to retrieve <i>InboxMessage</i>s, see the <i>Inx_Api_Inbox_InboxManager</i> documentation.
*
* @see Inx_Api_Inbox_InboxManager
* @since API 1.9.0
* @version $Revision:$ $Date:$ $Author:$
* @package Inxmail
* @subpackage Inbox
*/
interface Inx_Api_Inbox_InboxMessage extends Inx_Api_BusinessObject
{
	/** 
	 * This category represents an auto responder message. 
	 *
	 * @var int
	 */
	const CATEGORY_AUTO_RESPONDER = 0;

	/**
	 * This category represents a flame message. A flame message is a message with aggressive content and/or strong
	 * language.
	 * 
	 * @var int
	 */
	const CATEGORY_FLAME = 1;

	/** 
	 * This category represents a mail categorized as undesirable by spam/virus checking software 
	 * 
	 * @var int 
	 */
	const CATEGORY_SPAM = 2;

	/**
	 * This category represents an ordinary mail which does not match a specific category.
	 *
	 * @var int
	 */
	const CATEGORY_UNCATEGORIZED = 3;
	
	/** 
	 * This category represents a mail of unknown type.
	 * 
	 * @var int
	 */
	const CATEGORY_UNKNOWN = 4;

	/**
	 * State for missing recipient information. This state will be used when no <i>RecipientContext</i> and/or no
	 * attributes are specified in the query or in case of an unknown recipient.
	 * 
	 * @var int
	 */
	const RECIPIENT_STATE_UNKNOWN = 0;

	/** 
	 * State for existent recipient. 
	 * 
	 * @var int
	 */
	const RECIPIENT_STATE_EXISTENT = 1;

	/** 
	 * State for non existing (deleted) recipient.
	 * 
	 * @var int
	 */
	const RECIPIENT_STATE_DELETED = 2;


	/**
	 * Returns the category of this inbox message. May be one of:
	 * <ul>
	 * <li><i>CATEGORY_AUTO_RESPONDER</i>
	 * <li><i>CATEGORY_FLAME</i>
	 * <li><i>CATEGORY_SPAM</i>
	 * <li><i>CATEGORY_UNCATEGORIZED</i>
	 * <li><i>CATEGORY_UNKNOWN</i>
	 * </ul>
	 *
	 * @return int the category of this inbox message.
	 */
	public function getCategory();


	/**
	 * Returns the date when the message was received. 
	 * The date will be returned as ISO 8601 formatted datetime string.
	 *
	 * @return string the date of the message reception.
	 */
	public function getReceptionDate();


	/**
	 * Returns the sender address.
	 *
	 * @return string the sender address as string.
	 */
	public function getSender();


	/**
	 * Returns the subject of the received message.
	 *
	 * @return string the subject of the received message as string.
	 */
	public function getSubject();


	/**
	 * Returns the message content as text.
	 *
	 * @return string the message as string.
	 */
	public function getTextContent();


	/**
	 * Returns the id of the recipient who sent the message.
	 *
	 * @return int the recipient id.
	 */
	public function getRecipientId();


	/**
	 * Returns the header of the message as string.
	 *
	 * @return string the header of the message as string.
	 */
	public function getHeaders();


	/**
	 * Returns the complete message as mime message stream.
	 *
	 * @return Inx_Api_InputStream the mime message as input stream.
	 */
	public function getMIMEMessageAsStream();


	/**
	 * Returns the matched e-mail address (i.e. the e-mail address of the recipient).
	 *
	 * @return string the e-mail address.
	 */
	public function getMatchedEmailAddress();


	/**
	 * Returns the state of the recipient for the message.<br>
	 * RecipientState values:
	 * <ul>
	 * <li><i>RECIPIENT_STATE_UNKNOWN</i>  - no attributes are queried or recipient is unknown.
	 * <li><i>RECIPIENT_STATE_EXISTENT</i> - recipient exists.
	 * <li><i>RECIPIENT_STATE_DELETED</i>  - recipient is deleted.
	 * </ul>
	 *
	 * @return int the recipient state.
	 */
	public function getRecipientState();


	/**
	 * Returns the integer value for the given recipient Attribute.<br>
	 *
	 * @param Inx_Api_Recipient_Attribute $oAttribute the recipient attribute to be retrieved.
	 * @return int the integer value.
	 * @throws Inx_Api_IllegalArgumentException if the requested attribute was not fetched.
	 * @throws Inx_Api_IllegalStateException if the requested attribute is not of type <i>int</i>.
	 * @throws Inx_Api_UnknownRecipientException if the recipient state is unknown.
	 */
	public function getInteger( Inx_Api_Recipient_Attribute $oAttribute );


	/**
	 * Returns the string value for the given recipient Attribute.<br>
	 *
	 * @param Inx_Api_Recipient_Attribute $oAttribute the recipient attribute to be retrieved.
	 * @return string the string value.
	 * @throws Inx_Api_IllegalArgumentException if the requested attribute was not fetched.
	 * @throws Inx_Api_IllegalStateException if the requested attribute is not of type <i>string</i>.
	 * @throws Inx_Api_UnknownRecipientException if the recipient state is unknown.
	 */
	public function getString( Inx_Api_Recipient_Attribute $oAttribute );


	/**
	 * Returns the datetime value for the given recipient Attribute.
	 * The datetime will be returned as ISO 8601 formatted datetime string.
	 *
	 * @param Inx_Api_Recipient_Attribute $oAttribute the recipient attribute to be retrieved.
	 * @return string the datetime value.
	 * @throws Inx_Api_IllegalArgumentException if the requested attribute was not fetched.
	 * @throws Inx_Api_IllegalStateException if the requested attribute is not of type <i>datetime</i>.
	 * @throws Inx_Api_UnknownRecipientException if the recipient state is unknown.
	 */
	public function getDatetime( Inx_Api_Recipient_Attribute $oAttribute );


	/**
	 * Returns the date value for the given recipient Attribute.
	 * The date will be returned as ISO 8601 formatted date string.
	 *
	 * @param Inx_Api_Recipient_Attribute $oAttribute the recipient attribute to be retrieved.
	 * @return string the date value.
	 * @throws Inx_Api_IllegalArgumentException if the requested attribute was not fetched.
	 * @throws Inx_Api_IllegalStateException if the requested attribute is not of type <i>date</i>.
	 * @throws Inx_Api_UnknownRecipientException if the recipient state is unknown.
	 */
	public function getDate( Inx_Api_Recipient_Attribute $oAttribute );


	/**
	 * Returns the time value for the given recipient Attribute.
	 * The time will be returned as ISO 8601 formatted time string
	 *
	 * @param Inx_Api_Recipient_Attribute $oAttribute the recipient attribute to be retrieved.
	 * @return string the time value.
	 * @throws Inx_Api_IllegalArgumentException if the requested attribute was not fetched.
	 * @throws Inx_Api_IllegalStateException if the requested attribute is not of type <i>time</i>.
	 * @throws Inx_Api_UnknownRecipientException if the recipient state is unknown.
	 */
	public function getTime( Inx_Api_Recipient_Attribute $oAttribute );


	/**
	 * Returns the float value for the given recipient Attribute.<br>
	 *
	 * @param Inx_Api_Recipient_Attribute $oAttribute the recipient attribute to be retrieved.
	 * @return float the float value.
	 * @throws Inx_Api_IllegalArgumentException if the requested attribute was not fetched.
	 * @throws Inx_Api_IllegalStateException if the requested attribute is not of type <i>float</i>.
	 * @throws Inx_Api_UnknownRecipientException if the recipient state is unknown.
	 */
	public function getDouble( Inx_Api_Recipient_Attribute $oAttribute );


	/**
	 * Returns the bool value for the given recipient Attribute.<br>
	 *
	 * @param Inx_Api_Recipient_Attribute $oAttribute the recipient attribute to be retrieved.
	 * @return bool the bool value.
	 * @throws Inx_Api_IllegalArgumentException if the requested attribute was not fetched.
	 * @throws Inx_Api_IllegalStateException if the requested attribute is not of type <i>bool</i>.
	 * @throws Inx_Api_UnknownRecipientException if the recipient state is unknown.
	 */
	public function getBoolean( Inx_Api_Recipient_Attribute $oAttribute );


	/**
	 * Returns the value for the given recipient Attribute.<br>
	 *
	 * @param Inx_Api_Recipient_Attribute $oAttribute the recipient attribute to be retrieved.
	 * @return mixed the value.
	 * @throws Inx_Api_IllegalArgumentException if the requested attribute was not fetched.
	 * @throws Inx_Api_UnknownRecipientException if the recipient state is unknown.
	 */
	public function getObject( Inx_Api_Recipient_Attribute $oAttribute );

}