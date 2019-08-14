<?php

/**
 * @package Inxmail
 * @subpackage Util
 */
/**
 * The <i>Inx_Api_Util_TemporaryMailSender</i> may be used to send <i>Inx_Api_Util_TemporaryMail</i>s. 
 * A <i>TemporaryMail</i> is a mailing that may be sent to a single recipient that does not have to be a registered 
 * recipient in Inxmail. 
 * The mailing will not be personalized and will not be saved in Inxmail and therefore won't be trackable.
 * <p>
 * The following snippet shows how to send a temporary mail:
 * 
 * <pre>
 * $oListContextManager = $oSession->getListContextManager();
 * $oListContext = $oListContextManager->findByName( Inx_Api_List_SystemListContext::NAME );
 * 
 * $oTemporaryMailSender = $oSession->getTemporaryMailSender();
 * $oTemporaryMail = $oTemporaryMailSender->createTemporaryMail( $oListContext );
 * $oTemporaryMail->updateRecipientAddress( &quot;recipient@domain.invalid&quot; );
 * $oTemporaryMail->updateSenderAddress( &quot;sender@domains.invalid&quot; );
 * $oTemporaryMail->updateSubject( &quot;Temporary Mailing&quot; );
 * $oTemporaryMail->setContentHandler( 'Inx_Api_Mailing_HtmlTextContentHandler' );
 * 
 * $oHtmlTextContentHandler = $oTemporaryMail->getContentHandler();
 * $oHtmlTextContentHandler->updateContent( &quot;&lt;html&gt;&lt;head&gt;&lt;/head&gt;&lt;body&gt;Hi there,&lt;br&gt;this is a temporary mailing!&lt;/body&gt;&lt;/html&gt;&quot; );
 * 
 * $blSuccess = $oTemporaryMailSender->sendTemporaryMail( $oTemporaryMail );
 * 
 * if( $blSuccess )
 * {
 * 	echo &quot;Mailing sended.&lt;br&gt;&quot;;
 * }
 * else
 * {
 * 	echo &quot;Mailing not sended.&lt;br&gt;&quot;;
 * }
 * </pre>
 * 
 * The approach shown above will send a mail to the specified recipient address without any personalization. 
 * To personalize a mailing for a specific recipient, use the <i>sendTemporaryMail($oTemporaryMail, $iRecipientId)</i> 
 * method instead. 
 * You can mix using this method and explicitly specifying a recipient address to send a mailing to a recipient
 * (possibly unknown to Inxmail) which was personalized for a different recipient.
 * <p>
 * <strong>Note:</strong> Be aware that the <i>bool</i> returned by the send method does not state if the mail has really been sent. 
 * The method may return <i>true</i> even though no recipient address was specified, thus the mail was not sent to any recipient. 
 * The only requirement is that the sender address has been set and the content is not <i>null</i> or empty. 
 * The sender address may also be determined by the list provided on the creation of the mail, as long as the address is configured.
 * <p>
 * For more information on temporary mails in general, see the <i>Inx_Api_Util_TemporaryMail</i> documentation.
 * 
 * @see Inx_Api_Util_TemporaryMail
 * @version $Revision: 9545 $ $Date: 2007-12-21 18:49:01 +0200 (Pn, 21 Grd 2007) $ $Author: vladas $
 * @package Inxmail
 * @subpackage Util
 */
interface Inx_Api_Util_TemporaryMailSender
{

	/**
	 * Creates a <i>TemporaryMail</i> using the sender address of the specified list by default.
	 * 
	 * @param Inx_Api_List_ListContext $oListContext the list context.
	 * @return Inx_Api_Util_TemporaryMail a new <i>TemporaryMail</i>.
	 */
    public function createTemporaryMail( Inx_Api_List_ListContext $oListContext );
    
    
    /**
     * Sends the specified <i>TemporaryMail</i> to the given recipient, if any was passed. 
     * The mail will be personalized for this recipient. 
     * It is possible to override the recipient address using <i>Inx_Api_Util_TemporaryMail::updateRecipientAddress($sRecipientAddress)</i>. 
     * Using this approach you can send a mail to a recipient which is personalized for a different recipient.
     * <p>
     * <strong>Note:</strong> If the recipient id is ommitted, you are required to specify a recipient address. 
	 * <p>
	 * <strong>Note:</strong> This method may return <i>true</i> even if the recipient address was explicitly set to <i>null</i>.
	 * 
	 * @param Inx_Api_Util_TemporaryMail $oMail the mail to be sent.
	 * @param int $iRecipientId the recipient for whom the mail shall be personalized and probably send to. May be ommitted.
	 * @return bool <i>true</i> if the mailing could (possibly) be sent, <i>false</i> otherwise.
     */
    public function sendTemporaryMail( $oMail, $iRecipientId = -2 );
    
}
