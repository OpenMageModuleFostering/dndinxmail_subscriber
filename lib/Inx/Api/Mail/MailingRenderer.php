<?php
/**
 * @package Inxmail
 * @subpackage Mail
 */

/**
 * The <i>Inx_Api_Mail_MailingRenderer</i> is used to generate mail content using the API. 
 * The main use of the class will be to generate personalized previews of mailings. 
 * The class can also be used to generate and send single mails using a different mail sender. 
 * Be aware that in this case the mail sending rate would decrease enormously.
 * <p>
 * To preview a mailing, acquire an <i>Inx_Api_Mail_MailingRenderer</i> from the <i>Inx_Api_Mailing_MailingManager</i>. 
 * Each mailing needs to be parsed before building it. 
 * The following snippet shows how to build a mail for a given recipient:
 * <pre>
 * $oMailingRenderer = $oSession->getMailingManager()->createRenderer();
 * $oMailingRenderer->parse( $oMailing->getId(), Inx_Api_Mail_MailingRenderer::BUILD_MODE_ALTERNATIVEVIEW_ACTIVE );
 * $oMailContent = $oMailingRenderer->build( $iRecipientId );
 * </pre>
 * <p>
 * <i>Inx_Api_Mail_MailingRenderer</i> can handle the following different build modes:
 * <ol>
 * <li><i>BUILD_MODE_PREVIEW</i> - Trackable links will not trigger any events, unsubscription links will redirect but
 * not unsubscribe anybody. Embedded images are replaced with http references to image resources on the Inxmail server.
 * <li><i>BUILD_MODE_VIEW</i> - deprecated, should not longer be used.
 * <li><i>BUILD_MODE_ALTERNATIVEVIEW_ACTIVE</i> - All links are fully functional. Embedded images are replaced 
 * with http references to image resources on the Inxmail server.
 * <li><i>BUILD_MODE_ALTERNATIVEVIEW_INACTIVE</i> - All links are not functional. Embedded images are replaced 
 * with http references to image resources on the Inxmail server.
 * <li><i>BUILD_MODE_NORMAL</i> - The mail is rendered, ready to be sent.
 * <li><i>BUILD_MODE_ARCHIVE</i> - Trackable links will not trigger any events, unsubscription links will redirect but
 * not unsubscribe anybody. Embedded images are replaced with http references to image resources on the Inxmail server.
 * <li><i>BUILD_MODE_ALTERNATIVEVIEW_ACTIVE_SIMPLE_LINKS</i> - All links are fully functional but converted to 
 * simple links. Embedded images are replaced with http references to image resources on the Inxmail server.
 * <li><i>BUILD_MODE_NEWSLETTER_SIMPLE_LINKS</i> - The same as above, but the function InInboxView returns true.
 * </ol>
 * <p>
 * <strong>Note:</strong> An <i>Inx_Api_Mail_MailingRenderer</i> object <strong>must</strong> be closed once it is not needed
 * anymore to prevent memory leaks and other potentially harmful side effects.
 * 
 * @see Inx_Api_Mail_MailContent
 * @since API 1.0
 * @version $Revision: 9553 $ $Date: 2008-01-04 11:28:41 +0200 (Pn, 04 Sau 2008) $ $Author: vladas $
 * @package Inxmail
 * @subpackage Mail
 */
interface Inx_Api_Mail_MailingRenderer
{

	/** The mode to generate a normal mail, ready to be sent. */
	const BUILD_MODE_NORMAL = 100;

	/**
	 * @deprecated use <i>BUILD_MODE_ALTERNATIVEVIEW_ACTIVE</i> instead.
	 */
	const BUILD_MODE_VIEW = 101;
	
	/**
	 * The mode for mail view: All links are fully functional. 
	 * Embedded images are replaced with http references to image resources on the Inxmail server.
	 */
	const BUILD_MODE_ALTERNATIVEVIEW_ACTIVE = 101;
	
	
	/**
	 * The mode for mail view: All links are not functional. 
	 * Embedded images are replaced with http references to image resources on the Inxmail server.
	 */
	const BUILD_MODE_ALTERNATIVEVIEW_INACTIVE = 104;

	/**
	 * The mode for mail preview: Trackable links will not trigger any events, unsubscription links will redirect but 
	 * not unsubscribe anybody. 
	 * Embedded images are replaced with http references to image resources on the Inxmail server.
	 */
	const BUILD_MODE_PREVIEW = 102;

	/**
	 * The mode for mail archive view: Trackable links will not trigger any events, unsubscription links will redirect 
	 * but not unsubscribe anybody. 
	 * Embedded images are replaced with http references to image resources on the Inxmail server.
	 */
	const BUILD_MODE_ARCHIVE = 103;
	
	
	/**
	 * Prepares the mailing for a preview. 
	 * It checks the mail quality (syntax errors, references to orphaned elements, ... ).<br>
	 * Errors will be listed in the <i>Inx_Api_Mail_ParseException</i>.<br>
	 * The mailingId is supposed to be valid (existing mailing).<br>
	 * 
	 * @param int $iMailingId the id of the mailing to be parsed.
	 * @param int $iBuildMode the mode of the build. May be one of the constants defined in this class:
	 *            <ul>
	 *            <li><i>BUILD_MODE_NORMAL</i>
	 *            <li><i>BUILD_MODE_ALTERNATIVEVIEW_ACTIVE</i>
	 *            <li><i>BUILD_MODE_ALTERNATIVEVIEW_INACTIVE</i>
	 *            <li><i>BUILD_MODE_PREVIEW</i>
	 *            <li><i>BUILD_MODE_ARCHIVE</i>
	 *            <li><i>BUILD_MODE_ALTERNATIVEVIEW_ACTIVE_SIMPLE_LINKS</i>
	 *            <li><i>BUILD_MODE_NEWSLETTER_SIMPLE_LINKS</i>
	 *            </ul>
	 * @throws Inx_Api_Mail_ParseException if any syntax error is present in the mail.
	 * @throws Inx_Api_APIException if the mailing id is no longer valid.
	 */
	public function parse( $iMailingId, $iBuildMode );

	/**
	 * Generates the personalized mail content (recipient address, subject, HTML and/or plain text, ...) for the
	 * specified recipient with a specified mail type restriction.
	 * 
	 * @param int $iRecipientId the id of the recipient for which the mail shall be personalized.
	 * @param int $iPreferredMailType the mail type. May be one of:
	 *            <ul>
	 *            <li><i>Inx_Api_Mail_MailContent::MAIL_TYPE_HTML_TEXT</i>
	 *            <li><i>Inx_Api_Mail_MailContent::MAIL_TYPE_PLAIN_TEXT</i>
	 *            <li><i>Inx_Api_Mail_MailContent::MAIL_TYPE_MULTIPART</i>
	 *            </ul>
	 *            May be ommitted (defaults to the standard mail type).
	 * @return Inx_Api_Mail_MailContent the personalized content of the mail.
	 * @throws Inx_Api_Mail_BuildException if the recipient could not be found, or the building failed.
	 */
	public function build( $iRecipientId, $iPreferredMailType=null );


	/**
     * Closes this <i>Inx_Api_Mail_MailingRenderer</i> and releases any server resources associated with this object.
     * An <i>Inx_Api_Mail_MailingRenderer</i> object <strong>must</strong> be closed once it is not needed
	 * anymore to prevent memory leaks and other potentially harmful side effects.
     */
	public function close();

}