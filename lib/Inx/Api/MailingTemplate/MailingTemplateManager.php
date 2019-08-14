<?php
/**
 * @package Inxmail
 * @subpackage MailingTemplate
 */
/**
 * The <i>Inx_Api_MailingTemplate_MailingTemplateManager</i> can be used to manage mailing templates. 
 * This includes the retrieval and creation of <i>Inx_Api_MailingTemplate_MailingTemplate</i>s.
 * <p>
 * To retrieve or create a globally available mailing template, use the system list. The following snippet shows how to
 * retrieve all global mailing templates ordered by name:
 * 
 * <pre>
 * $oMailingTemplateManager = $oSession->getMailingTemplateManager();
 * $oSystemListContext = $oSession->getListContextManager()->findByName( Inx_Api_List_SystemListContext::NAME );
 * 
 * $oBOResultSet = $oMailingTemplateManager->select( $oSystemListContext, 
 * 	Inx_Api_MailingTemplate_MailingTemplate::ATTRIBUTE_NAME, Inx_Api_Order::ASC );
 * 
 * for( $i = 0; $i &lt; $oBOResultSet->size(); $i++ )
 * {
 * 	$oMailingTemplate = $oBOResultSet->get( $i );
 * 	echo $oMailingTemplate->getName()."&#60;br&#62;";
 * }
 * 
 * $oBOResultSet->close();
 * </pre>
 * 
 * To retrieve all mailing templates, disregarding their list membership, use the inherited <i>selectAll()</i> method.
 * <p>
 * Be aware that mailing template names are not nullable and are unique in each list. 
 * However, it is possible to have two mailing templates with the same name in different lists. 
 * The following snippet shows how to create an <i>Inx_Api_MailingTemplate_MailingTemplate</i> and update its name:
 * 
 * <pre>
 * $oMailingTemplateManager = $oSession->getMailingTemplateManager();
 * $oListContext = $oSession->getListContextManager()->findByName( &quot;Name of the desired List&quot; );
 * $oMailingTemplate = $oMailingTemplateManager->createTemplate( $oListContext, 
 * 	Inx_Api_MailingTemplate_MailingTemplate::MIME_TYPE_HTML_TEXT );
 * 
 * $oMailingTemplate->updateName( &quot;Desired name&quot; );
 * $oMailingTemplate->commitUpdate();
 * </pre>
 * <p>
 * The usage of mailing templates requires the api user right: <i>Inx_Api_UserRights::TEMPLATE_FEATURE_USE</i>
 * <p>
 * For more information on mailing templates, see the <i>Inx_Api_MailingTemplate_MailingTemplate</i> documentation.
 * 
 * @see Inx_Api_MailingTemplate_MailingTemplate
 * @since API 1.4.0
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 * @subpackage MailingTemplate
 */
interface Inx_Api_MailingTemplate_MailingTemplateManager extends Inx_Api_BOManager
{

	/**
	 * Creates a mailing template in the specified list with the specified MIME type.
	 * 
	 * @param Inx_Api_List_ListContext $oListContext the list this template belongs to.
	 * @param int $iMimeType the MIME type of this template. May be one of:
	 *            <ul>
	 *            <li><i>Inx_Api_MailingTemplate_MailingTemplate::MIME_TYPE_HTML_TEXT</i>,
	 *            <li><i>Inx_Api_MailingTemplate_MailingTemplate::MIME_TYPE_PLAIN_TEXT</i> or
	 *            <li><i>Inx_Api_MailingTemplate_MailingTemplate::MIME_TYPE_MULTIPART</i>
	 *            </ul>
	 * @return Inx_Api_MailingTemplate_MailingTempalte a new mailing template.
	 */
	public function createTemplate( Inx_Api_List_ListContext $oListContext, $iMimeType );

	/**
	 * Returns an <i>Inx_Api_BOResultSet</i> containing all mailing templates assigned to the given list, ordered by the
	 * given attribute and order type. 
	 * To retrieve the globally available mailing templates, use the system list.
	 * <p>
	 * The following snippet shows how to retrieve the system list context:
	 * 
	 * <pre>
	 * $oSystemListContext = $oSession->getListContextManager()->findByName( 
	 * 	Inx_Api_List_SystemListContext::NAME );
	 * </pre>
	 * 
	 * @param Inx_Api_List_ListContext $oListContext all mailing templates assigned to this list will be fetched. 
	 * 			This parameter may <strong>not</strong> be <i>null</i>. 
	 * 			If you wish to retrieve all mailing templates, use <i>selectAll()</i> instead.
	 * @param int $iOrderAttribute the id of the attribute used to order the result (only
	 *            <i>Inx_Api_MailingTemplate_MailingTemplate::ATTRIBUTE_NAME</i>). 
	 *            Be aware that any other attribute as well as ommitting this parameter will default to the name attribute.
	 * @param int $iOrderType the order type (<i>Inx_Api_Order::ASC</i> or <i>Inx_Api_Order::DESC</i>). 
	 * 				May be ommitted if $iOrderAttribute is ommitted as well.
	 * @return Inx_Api_BOResultSet an <i>Inx_Api_BOResultSet</i> containing all mailing templates assigned to the given list.
	 */
	public function select( Inx_Api_List_ListContext $oListContext, $iOrderAttribute = -1, $iOrderType = -1 );

}
