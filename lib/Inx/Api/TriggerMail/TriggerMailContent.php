<?php
/**
 * @package Inxmail
 * @subpackage TriggerMail
 */

/**
 * The <code>TriggerMailContent</code> contains the personalized content of a trigger mailing for a specific recipient.
 * The information that can be retrieved from the <code>TriggerMailContent</code> includes:
 * <ul>
 * <li><i>The content type</i>: {@link #getContentType()}
 * <li><i>Plain/HTML text</i>: {@link #getPlainText()} and {@link #getHtmlText()}
 * <li><i>The subject</i>: {@link #getSubject()}
 * <li><i>The recipient address</i>: {@link #getRecipientAddress()}
 * <li><i>Attachments</i>: {@link #getAttachments()}
 * <li><i>Embedded images</i>: {@link #getEmbeddedImages()}
 * <li><i>The sender address</i>: {@link #getSenderAddress()}
 * <li><i>The bounce and reply addresses</i>: {@link #getBounceAddress()} and {@link #getReplyToAddress()}
 * <li><i>The mail headers</i>: {@link #getHeader()} or {@link #getMultipleHeaders()}
 * </ul>
 * A <code>TriggerMailContent</code> object is created by a {@link TriggerMailingRenderer} using its <code>build</code>
 * methods.
 * 
 * @see com.inxmail.xpro.api.triggermail.TriggerMailingRenderer#build(int)
 * @see com.inxmail.xpro.api.triggermail.TriggerMailingRenderer#build(int, int)
 * @since API 1.10.0
 * @author chge, 09.07.2012
 */
interface Inx_Api_TriggerMail_TriggerMailContent
{
	/**
	 * Returns the content type of this trigger mail.
	 * 
	 * @return the content type of this trigger mail.
	 */
	public function getContentType();


	/**
	 * Returns the HTML text part of the mail, or <code>null</code> if the mail type is
	 * {@link TriggerMailingContentType#PLAIN_TEXT}.
	 * 
	 * @return the HTML text part of the mail, if any.
	 */
	public function getHtmlText();


	/**
	 * Returns the plain text part of the mail, or <code>null</code> if the mail type is
	 * {@link TriggerMailingContentType#HTML_TEXT}.
	 * 
	 * @return the plain text part of the email, if any.
	 */
	public function getPlainText();


	/**
	 * Returns the subject of the trigger mail.
	 * 
	 * @return the subject of the trigger mail.
	 */
	public function getSubject();


	/**
	 * Returns the recipient address of the trigger mail.
	 * 
	 * @return the recipient address of the trigger mail.
	 */
	public function getRecipientAddress();


	/**
	 * Returns the sender address of the trigger mail.
	 * 
	 * @return the sender address of the trigger mail.
	 */
	public function getSenderAddress();


	/**
	 * Returns the reply address of the trigger mail. This address will be used for replies.
	 * 
	 * @return the reply address of the trigger mail.
	 */
	public function getReplyToAddress();


	/**
	 * Returns the bounce address of the trigger mail. This address will be used for bounce messages.
	 * 
	 * @return the bounce address of the trigger mail.
	 */
	public function getBounceAddress();


	/**
	 * Returns all regular attachments (files) of the trigger mail.
	 * 
	 * @return all regular attachments of the trigger mail.
	 */
	public function getAttachments();


	/**
	 * Returns all embedded images of the trigger mail.
	 * 
	 * @return all embedded images of the trigger mail.
	 */
	public function getEmbeddedImages();


	/**
	 * Returns the header informations of the trigger mail. The map contains the key/value-pair of the headers.
	 * <p>
	 * Note: This method allows header fields only to be defined once. If a header field is defined multiple times, the
	 * last value will be used. If you wish to define header fields multiple times, use the
	 * {@link #getMultipleHeaders()} method instead. Nonetheless, you should be aware that defining the same header
	 * field multiple times is discouraged by RFC 5322 as this is an obsolete behavior only permitted by legacy
	 * implementations.
	 * 
	 * @return the header information of the trigger mail.
	 */
	public function getHeader();


	/**
	 * Returns the header information of the trigger mail. The list contains <code>HeaderField</code> objects
	 * encapsulating the key/value-pairs of the headers. This method allows for multiple defined header fields.
	 * <p>
	 * Note: You should be aware that defining the same header field multiple times is discouraged by RFC 5322 as this
	 * is an obsolete behavior only permitted by legacy implementations.
	 * 
	 * @return the header information of the trigger mail.
	 * @since API 1.9.0
	 */
	public function getMultipleHeaders();
}