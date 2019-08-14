<?php
/**
 * @package Inxmail
 * @subpackage Mail
 */

/**
 * The <i>Inx_Api_Mail_MailContent</i> contains the personalized content of a mailing for a specific recipient. 
 * The information that can be retrieved from the <i>Inx_Api_Mail_MailContent</i> includes:
 * <ul>
 * <li>The mail type: <i>getMailType()</i>
 * <li>Plain/HTML text: <i>getPlainText()</i> and <i>getHtmlText()</i>
 * <li>The subject: <i>getSubject()</i>
 * <li>The recipient address: <i>getRecipientAddress()</i>
 * <li>Attachments: <i>getAttachments()</i>
 * <li>Embedded images: <i>getEmbeddedImages()</i>
 * <li>The sender address: <i>getSenderAddress()</i>
 * <li>The bounce and reply addresses: <i>getBounceAddress()</i> and <i>getReplyToAddress()</i>
 * <li>The mail headers: <i>getHeader()</i> or <i>getMultipleHeaders()</i>
 * </ul>
 * An <i>Inx_Api_Mail_MailContent</i> object is created by an <i>Inx_Api_Mail_MailingRenderer</i> using its <i>build</i> methods.
 * 
 * @see Inx_Api_Mail_MailingRenderer::build($iRecipientId, $iPreferredMailType=null)
 * @since API 1.0
 * @version $Revision: 9482 $ $Date: 2007-12-18 16:42:11 +0200 (An, 18 Grd 2007) $ $Author: vladas $
 * @package Inxmail
 * @subpackage Mail
 */
interface Inx_Api_Mail_MailContent
{
    
    /**
     * Mail type indicating a HTML text mail. This mail has only a HTML text part.
     */
    const MAIL_TYPE_HTML_TEXT = 0;

    /**
     * Mail type indicating a plain text mail. This mail has only a plain text part.
     */
    const MAIL_TYPE_PLAIN_TEXT = 1;

    /**
     * Mail type indicating a multipart mail. This mail has a HTML and a plain text part.
     */
    const MAIL_TYPE_MULTIPART = 2;

    
    /**
     * Returns the mail type of this mail - either:
     * <ul> 
     * <li><i>Inx_Api_Mail_MailContent::MAIL_TYPE_HTML_TEXT</i>,
     * <li><i>Inx_Api_Mail_MailContent::MAIL_TYPE_PLAIN_TEXT</i> or 
     * <li><i>Inx_Api_Mail_MailContent::MAIL_TYPE_MULTIPART</i>
     * </ul>
     * 
     * @return int the mail type of this mail.
     */
    public function getMailType();
        
    
    /**
     * Returns the HTML text part of the mail, or <i>null</i> if the mail type is 
     * <i>Inx_Api_Mail_MailContent::MAIL_TYPE_PLAIN_TEXT</i>
     * 
     * @return string the html text part of the mail, if any.
     */
    public function getHtmlText();
    
    
    /**
     * Returns the plain text part of the mail, or <i>null</i> if the mail type is 
     * <i>Inx_Api_Mail_MailContent::MAIL_TYPE_HTML_TEXT</i>
     * 
     * @return string the plain text part of the mail, if any.
     */
    public function getPlainText();

    
    /**
     * Returns the subject of the mail.
     * 
     * @return string the subject of the mail.
     */
    public function getSubject();
    
    
    /**
     * Returns the recipient address of the mail.
     * 
     * @return string the recipient address of the mail.
     */
    public function getRecipientAddress();

    
    /**
     * Returns the sender address of the mail.
     * 
     * @return string the sender address of the mail.
     */
    public function getSenderAddress();

    
    /**
     * Returns the reply address of the mail. This address will be used for replies.
     * 
     * @return string the reply address of the mail.
     */
    public function getReplyToAddress();

    
    /**
     * Returns the bounce address of the mail. This address will be used for bounce messages.
     * 
     * @return string the bounce address of the mail.
     */
    public function getBounceAddress();

    
    /**
     * Returns all regular attachments (files) of the mail.
     * 
     * @return array all regular attachments of the mail.
     */
    public function getAttachments();

    
    /**
     * Returns all embedded images of the mail.
     * 
     * @return array all embedded images of the mail.
     */
    public function getEmbeddedImages();

    
    /**
     * Returns the header information of the mail. 
     * The associative array contains the key/value-pair of the headers. 
     * <p>
	 * Note: This method allows header fields only to be defined once. 
	 * If a header field is defined multiple times, the last value will be used. 
	 * If you wish to define header fields multiple times, use the <i>getMultipleHeaders()<i> method instead. 
	 * Nonetheless, you should be aware that defining the same header field multiple times is discouraged by RFC 5322 
	 * as this is an obsolete behavior only permitted by legacy implementations.
     * 
     * @return array  the header information of the mail.
     */
    public function getHeader();
    
    /**
    * Returns the header information of the mail. 
    * The array contains <i>Inx_Api_Mail_HeaderField</i> objects encapsulating the key/value-pairs of the headers. 
    * This method allows for multiple defined header fields.
    * <p>
    * Note: You should be aware that defining the same header field multiple times is discouraged by RFC 5322 as this
    * is an obsolete behavior only permitted by legacy implementations.
    *
    * @return array the header information of the mail.
    * @since API 1.9.0
    */
    public function getMultipleHeaders();
}
