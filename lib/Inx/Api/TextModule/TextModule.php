<?php
/**
 * @package Inxmail
 * @subpackage Textmodule
 */
/**
 * This class defines a text module.
 * Text modules are reusable text snippets that can be used inside mailings in the same list (or all lists if the text 
 * module is defined in the system list). 
 * A common text module is a custom, personalized salutation which will be shown later.
 * <p>
 * You can update both of the content types (plain Text and html) but via the client only the one(s) defined by the 
 * MIME type will be used. 
 * Also, the text module name may be updated, though NOT the MIME type. 
 * If you wish to alter the MIME type, you have to delete the text module and create a new one with the values of 
 * the old text module and the new MIME type.
 * <p>
 * The following snippet shows how to create a global custom salutation text module using the user defined 
 * recipient attributes 'Surname', 'First name' and 'Gender':
 * 
 * <pre>
 * $oTextModuleManager = $oSession->getTextmoduleManager();
 * $oListContext = $oSession->getListContextManager()->findByName( Inx_Api_List_SystemListContext::NAME );
 * $oTextModule = $oTextModuleManager->createTextmodule( $oListContext, Inx_Api_TextModule_TextModule::MIME_TYPE_PLAIN_TEXT );
 * 
 * $sContent = &quot;[%if Surname IS_EMPTY]Dear Sir or Madam,\n&quot;;
 * $sContent .= &quot;[%elseif Column(\&quot;Gender\&quot;) = \&quot;m\&quot;]Dear Mr &quot;;
 * $sContent .= &quot;[First name,postfix( )][Surname], \n&quot;;
 * $sContent .= &quot;[%elseif Column(\&quot;Gender\&quot;) = \&quot;f\&quot;]Dear Ms &quot;;
 * $sContent .= &quot;[First name, postfix( )][Surname], \n &quot;;
 * $sContent .= &quot;[%else]Dear Sir or Madam,[%endif] \n &quot;;
 * 
 * $oTextModule->updateName( &quot;salutation&quot; );
 * $oTextModule->updatePlainTextContent( $sContent );
 * $oTextModule->commitUpdate();
 * </pre>
 * <p>
 * For more information on the possible contents of text modules, see the corresponding section of the Inxmail client manual.
 * <p>
 * For an example on how to retrieve existing text modules, see the <i>In_Api_TextModule_TextModuleManager</i> documentation.
 * 
 * @see In_Api_TextModule_TextModuleManager
 * @since API 1.4.0
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 * @subpackage Textmodule
 */
interface Inx_Api_TextModule_TextModule extends Inx_Api_BusinessObject
{

	/**
	 * MIME type constant for HTML text modules. This text module has only a HTML text part.
	 */
	const MIME_TYPE_HTML_TEXT = 0;

	/**
	 * MIME type constant for plain text modules. This text module has only a plain text part.
	 */
	const MIME_TYPE_PLAIN_TEXT = 1;

	/**
	 * MIME type constant for multipart text modules. This text module has a HTML and a plain text part.
	 */
	const MIME_TYPE_MULTIPART = 2;

	/**
	 * Constant for the name attribute. Used for ordering by the <i>Inx_Api_TextModule_TextModuleManager</i>.
	 * 
	 * @see Inx_Api_TextModule_TextModuleManager::select($oListContext, $iOrderAttribute, $iOrderType)
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
	 * Returns the name of this text module.
	 * 
	 * @return string the name of this text module.
	 */
	public function getName();

	/**
	 * Updates the name of the text module. 
	 * The text module will not be updated on the server until <i>commitUpdate()</i> has been called.
	 * 
	 * @param string $sName the new text module name.
	 */
	public function updateName( $sName );

	/**
	 * Returns the id of the list which this text module belongs to.
	 * 
	 * @return int the id of the list which this text module belongs to.
	 */
	public function getListContextId();

	/**
	 * Returns the MIME type of this text module. May be one of:
	 * <ul>
	 * <li><i>MIME_TYPE_HTML_TEXT</i>: Only HTML text
	 * <li><i>MIME_TYPE_PLAIN_TEXT</i>: Only plain text
	 * <li><i>MIME_TYPE_MULTIPART</i>: Both, HTML and plain text
	 * </ul>
	 * 
	 * @return int the MIME type of this text module.
	 */
	public function getMimeType();

	/**
	 * Returns the HTML text part of this text module, or <i>null</i> if the MIME type is <i>MIME_TYPE_PLAIN_TEXT</i>.
	 * 
	 * @return string the HTML text part of this text module, if any.
	 */
	public function getHtmlTextContent();

	/**
	 * Updates the HTML text part of this text module. 
	 * The text module will not be updated on the server until <i>commitUpdate()</i> has been called.
	 * 
	 * @param string $sHtmlTextContent the new HTML text part.
	 */
	public function updateHtmlTextContent( $sHtmlTextContent );

	/**
	 * Returns the plain text part of this text module, or <i>null</i> if the MIME type is <i>MIME_TYPE_HTML_TEXT</i>.
	 * 
	 * @return string the plain text part of this text module, if any.
	 */
	public function getPlainTextContent();

	/**
	 * Updates the plain text part of the text module. 
	 * The text module will not be updated on the server until <i>commitUpdate()</i> has been called.
	 * 
	 * @param string $sPlainTextContent the new plain text part.
	 */
	public function updatePlainTextContent( $sPlainTextContent );
}
