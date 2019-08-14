<?php
/**
 * @package Inxmail
 * @subpackage MailingTemplate
 */
/**
 * An <i>Inx_Api_MailingTemplate_MailingTemplate</i> represents reusable mailing content that can be used as a basis 
 * for new mailings.
 * These templates are far less powerful than the templates provided by design collections, but can still save time in
 * the creation of complex mailings with a common structure.
 * <p>
 * For an example on how to retrieve and create <i>MailingTemplate</i>s, see the 
 * <i>Inx_Api_MailingTemplate_MailingTemplateManager</i> documentation.
 * 
 * @see Inx_Api_MailingTemplate_MailingTemplateManager
 * @since API 1.4.0
 * @version $Revision: 9553 $ $Date: 2008-01-04 11:28:41 +0200 (Pn, 04 Sau 2008) $ $Author: vladas $*
 * @package Inxmail
 * @subpackage MailingTemplate
 */
interface Inx_Api_MailingTemplate_MailingTemplate extends Inx_Api_BusinessObject
{
	/**
	 * MIME type constant for HTML text templates. This template has only a HTML text part.
	 */
	const MIME_TYPE_HTML_TEXT = 0;

	/**
	 * MIME type constant for plain text templates. This template has only a plain text part.
	 */
	const MIME_TYPE_PLAIN_TEXT = 1;

	/**
	 * MIME type constant for multipart templates. This template has a HTML and a plain text part.
	 */
	const MIME_TYPE_MULTIPART = 2;

	/**
	 * Constant for the name attribute. Used for ordering by the <i>Inx_Api_MailingTemplate_MailingTemplateManager</i>.
	 * 
	 * @see Inx_Api_MailingTemplate_MailingTemplateManager::select($oListContext, $iOrderAttribute, $iOrderType)
	 */
	const ATTRIBUTE_NAME = 0;

	/**
	 * Constant for the plain text attribute.
	 */
	const ATTRIBUTE_PLAIN_TEXT = 1;

	/**
	 * Constant for the HTML text attribute.
	 */
	const ATTRIBUTE_HTML_TEXT = 2;

	/**
	 * Constant for the list context id attribute.
	 */
	const ATTRIBUTE_LIST_CONTEXT_ID = 3;

	/**
	 * Constant for the MIME type attribute.
	 */
	const ATTRIBUTE_MIME_TYPE = 4;

	/**
	 * Returns the name of the mailing template.
	 * 
	 * @return string the name of the mailing template.
	 */
	public function getName();

	/**
	 * Updates the name of the mailing template. 
	 * The mailing template will not be updated on the server until <i>commitUpdate()</i> has been called.
	 * 
	 * @param string $sName the new template name.
	 */
	public function updateName( $sName );

	/**
	 * Returns the id of the list which this mailing template belongs to.
	 * 
	 * @return int the id of the list which this mailing template belongs to.
	 */
	public function getListContextId();

	/**
	 * Returns the MIME type of this mailing template. May be one of:
	 * <ul>
	 * <li><i>MIME_TYPE_HTML_TEXT</i>: Only HTML text
	 * <li><i>MIME_TYPE_PLAIN_TEXT</i>: Only plain text
	 * <li><i>MIME_TYPE_MULTIPART</i>: Both, HTML and plain text
	 * </ul>
	 * 
	 * @return int the MIME type of this mailing template.
	 */
	public function getMimeType();

	/**
	 * Returns the HTML text part of this mailing template, or <i>null</i> if the MIME type is
	 * <i>MIME_TYPE_PLAIN_TEXT</i>.
	 * 
	 * @return string the HTML text part of this mailing template, if any.
	 */
	public function getHtmlTextContent();

	/**
	 * Updates the HTML text part of this mailing template. The mailing template will not be updated on the server until
	 * <i>commitUpdate()</i> has been called.
	 * 
	 * @param string $sHtmlTextContent the new HTML text part.
	 */
	public function updateHtmlTextContent( $sHtmlTextContent );

	/**
	 * Returns the plain text part of this mailing template, or <code>null</code> if the MIME type is
	 * <i>MIME_TYPE_HTML_TEXT</i>.
	 * 
	 * @return string the plain text part of this mailing template, if any.
	 */
	public function getPlainTextContent();

	/**
	 * Updates the plain text part of the mailing template. The mailing template will not be updated on the server until
	 * <i>commitUpdate()</i> has been called.
	 * 
	 * @param string $sPlainTextContent the new plain text part.
	 */
	public function updatePlainTextContent( $sPlainTextContent );
}
