<?php

/**
 * @package Inxmail
 * @subpackage Textmodule
 */
/**
 * The <i>Inx_Api_TextModule_TextModuleManager</i> can be used to retrieve and create text modules. 
 * Text modules are reusable text snippets that can be used inside mailings in the same list (or all lists if the 
 * text module is defined in the system list). 
 * A common text module is a custom, personalized salutation.
 * <p>
 * The following snippet shows how to create a new text module and update its name:
 * 
 * <pre>
 * $oTextmoduleManager = $oSession->getTextmoduleManager();
 * $oListContext = $oSession->getListContextManager()->findByName( &quot;Desired List&quot; );
 * $oTextModule = $oTextmoduleManager->createTextmodule( $oListContext, Inx_Api_TextModule_TextModule::MIME_TYPE_HTML_TEXT );
 * 
 * $oTextModule->updateName( &quot;Desired name&quot; );
 * $oTextModule->commitUpdate();
 * </pre>
 * 
 * </p>
 * To retrieve existing text modules, use one of the two <i>select</i> methods provided by this manager. 
 * The following snippet shows how to retrieve all global text modules, ordered by their name, and prints out some
 * information regarding these text modules:
 * 
 * <pre>
 * $oTextmoduleManager = $oSession->getTextmoduleManager();
 * $oListContext = $oSession->getListContextManager()->findByName( Inx_Api_List_SystemListContext::NAME );
 * $oBOResultSet = $oTextmoduleManager->select( $oListContext, Inx_Api_TextModule_TextModule::ATTRIBUTE_NAME, Inx_Api_Order::DESC );
 * 
 * for( $i = 0; $i &lt; $oBOResultSet->size(); $i++ )
 * {
 * 	$oTextModule = $oBOResultSet->get( $i );
 * 	echo &quot;Textmodule &quot;.$oTextModule->getName().&quot; has the content type &quot;.$oTextModule->getMimeType().&quot;&#60;br&#62;&quot;;
 * }
 * 
 * $oBOResultSet->close();
 * </pre>
 * <p>
 * For more information on text modules, see the <i>Inx_Api_TextModule_TextModule</i> documentation.
 * 
 * @see Inx_Api_TextModule_TextModule
 * @since API 1.4.0
 * @version $Revision: 9553 $ $Date: 2008-01-04 11:28:41 +0200 (Pn, 04 Sau 2008) $ $Author: vladas $
 * @package Inxmail
 * @subpackage Textmodule
 */
interface Inx_Api_TextModule_TextModuleManager extends Inx_Api_BOManager
{

	/**
	 * Creates a new text module in the specified list. 
	 * To create a globally available text module, use the <i>SystemListContext</i>. 
	 * The <i>SystemListContext</i> can be retrieved using the following snippet:
	 * 
	 * <pre>
	 * $oListContext = $oSession->getListContextManager()->findByName( Inx_Api_List_SystemListContext::NAME );
	 * </pre>
	 * 
	 * @param Inx_Api_List_ListContext $oListContext the list the text module shall be created for.
	 * @param int $iMimeType the MIME type of this text module. May be one of:
	 *            <ul>
	 *            <li><i>Inx_Api_TextModule_TextModule::MIME_TYPE_HTML_TEXT</i>,
	 *            <li><i>Inx_Api_TextModule_TextModule::MIME_TYPE_PLAIN_TEXT</i> or
	 *            <li><i>Inx_Api_TextModule_TextModule::MIME_TYPE_MULTIPART</i>
	 *            </ul>
	 * @return a new text module.
	 */
	public function createTextmodule( Inx_Api_List_ListContext $oListContext, $iMimeType );

	/**
	 * Returns an <i>Inx_Api_BOResultSet</i> containing all text modules in the specified list, ordered by the given
	 * attribute.
	 * 
	 * @param Inx_Api_List_ListContext $oListContext all text modules of this list will be selected.
	 * @param int $iOrderAttribute the order attribute (only <i>Inx_Api_TextModule_TextModule::ATTRIBUTE_NAME</i>). 
	 * 				May be ommitted.
	 * @param int $iOrderType the order type (<i>Inx_Api_Order::ASC</i> or <i>Inx_Api_Order::DES</i>).
	 * 				May be ommitted.
	 * @return Inx_Api_BOResultSet an <i>Inx_Api_BOResultSet</i> containing all text modules in the specified list.
	 * @throws Inx_Api_SecurityException if the session user doesn't have the following permission:
	 *             	<i>Inx_Api_UserRights::TEXTMODULE_FEATURE_USE</i>
	 */
	public function select( Inx_Api_List_ListContext $oListContext, $iOrderAttribute=null, $iOrderType=null );

}
