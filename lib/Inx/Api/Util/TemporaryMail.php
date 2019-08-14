<?php

/**
 * @package Inxmail
 * @subpackage Util
 */
/**
 * A <i>Inx_Api_Util_TemporaryMail</i> is a mailing that may be sent to a single recipient that does not have to be a
 * registered recipient in Inxmail. 
 * A temporary mailing behaves mostly like a simple version of a normal <i>Inx_Api_Mailing_Mailing</i>. 
 * However, the mailing will not be personalized and will not be saved in Inxmail and therefore won't be trackable. 
 * <i>TemporaryMail</i>s may be sent using the <i>Inx_Api_Util_TemporaryMailSender</i>.
 * <p>
 * Because a <i>TemporaryMail</i> does not belong to a specific list, you have to specify some information not
 * needed when using a normal <i>Mailing</i>. The most important is the recipient address. 
 * Normally, the recipient address is determined by the list, but as a temporary mail does not belong to any list, 
 * there is no predefined recipient address. 
 * The same is true for the reply address, though this address is not technically required to send the mail. 
 * The sender address, on the other hand, does not have to be specified as long as it is configured in the list 
 * that was passed on the creation of the temporary mailing.
 * <p>
 * <strong>Note:</strong> While it is discouraged to explicitly set the recipient address of a standard
 * <i>Inx_Api_Mailing_Mailing</i>, this is a technical requirement for the <i>TemporaryMail</i>. 
 * You won't be able to send a temporary mail to a recipient not registered in Inxmail without specifying the sender 
 * address, though the send method will return <i>true</i>. 
 * You may, however, send the mailing to a recipient known by Inxmail, without explicitly specifying the sender address. 
 * To do so, use the <i>Inx_Api_Util_TemporaryMailSender::sendTemporaryMail($oTemporaryMail, $iRecipientId)</i> method. 
 * This method will also personalize the mailing for the given recipient.
 * <p>
 * For an example on how to send a temporary mail, see the <i>Inx_Api_Util_TemporaryMailSender</i> documentation.
 * 
 * @see Inx_Api_Util_TemporaryMailSender
 * @see Inx_Api_Mailing_Mailing
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 * @subpackage Util
 */
interface Inx_Api_Util_TemporaryMail
{
   /**
	* Returns the sender address of this temporary mailing.
	*
	* @return string the sender address of this temporary mailing.
	*/
	public function getSenderAddress();
	
	/**
	* Sets the sender address of this temporary mailing.
	*
	* @param string $sSenderAddress the sender address of this temporary mailing.
	*/
	public function updateSenderAddress( $sSenderAddress );

	
	/**
	* Returns the recipient address header value of this temporary mailing. 
	* This is the address to which the mailing will be sent.
	*
	* @return string the recipient address header value of this temporary mailing.
	*/
	public function getRecipientAddress();
	
	/**
	* Sets the recipient address header value of this temporary mailing. 
	* This is the address to which the mailing will be sent.
	*
	* @param string $sRecipientAddress the recipient address header value of this temporary mailing.
	*/
	public function updateRecipientAddress( $sRecipientAddress );
	

	/**
	* Returns the reply address of this temporary mailing.
	*
	* @return string the reply address of this temporary mailing.
	*/
	public function getReplyToAddress();
	
	/**
	* Sets the reply address of this temporary mailing. 
	* Replies to this mailing will be sent to the given address.
	*
	* @param string $sReplyToAddress the reply address of this mailing.
	*/
	public function updateReplyToAddress( $sReplyToAddress );

	
	/**
	* Returns the subject of this temporary mailing.
	*
	* @return string the subject of this temporary mailing.
	*/
	public function getSubject();
	
	/**
	* Sets the subject of this temporary mailing.
	*
	* @param string $sSubject the subject of this temporary mailing.
	*/
	public function updateSubject( $sSubject );


	/**
	* Returns the content handler, which contains the format-specific mail content.
	*
	* @return Inx_Api_Mailing_ContentHandler the content handler.
	*/
	public function getContentHandler();
	
	/**
	 * Creates a new content handler. Allowed classes are:
	 * <ul>
	 * <li><i>PlainTextContentHandler</i>
	 * <li><i>HtmlTextContentHandler</i>
	 * <li><i>MultiPartContentHandler</i>
	 * <li><i>XsltMultiPartContentHandler</i>
	 * <li><i>XsltHtmlTextContentHandler</i>
	 * <li><i>XsltPlainTextContentHandler</i>
	 * </ul>
	 *  
	 * @param string $oContentHandlerClazz	the <i>Class</i> of the content handler
	 */
	public function setContentHandler( $oContentHandlerClazz );

}
