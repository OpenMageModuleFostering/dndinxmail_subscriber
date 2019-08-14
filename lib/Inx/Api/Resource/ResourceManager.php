<?php

/**
 * @package Inxmail
 * @subpackage Resource
 */
/**
 * The <i>Inx_Api_Resource_ResourceManager</i> manages the file resources. 
 * An <i>Inx_Api_Resource_Resource</i> can be used as attachment or embedded image in a mailing.
 * <p>
 * Attachments and embedded images used in mailings are "resources". 
 * Using the <i>ResourceManager</i>, these resources can be upload to and download from the Inxmail server. 
 * Resources can be bound to mailing lists or mailings, which means they are not visible outside these bounds, 
 * and will be removed with their mailing list or mailing.
 * <p>
 * The following snippet shows how to upload a resource (logo.gif) which can be used by all mailings in all lists:
 * 
 * <PRE>
 * $oResourceManager = $oSession->getResourceManager();
 * $in = fopen("/images/logo.gif", 'rb');
 * $oResource = $oResourceManager->upload( null, "logo.gif", $in );
 * fclose($in);
 * </PRE>
 * 
 * Inxmail assigns an unique identifier to the uploaded resource. 
 * To attach a resource to a mailing, add the <i>attach</i> tag to the mail body. 
 * The following snippet shows how to attach the resource with the id 42 to a mailing:
 * 
 * <PRE>
 * $sb = "[%attach(".$oResource->getId(). "); ".$res->getName(). "]" ;
 * </PRE>
 * 
 * This results in a string like <i>[%attach(42); logo.gif]</i>. 
 * To embed an image instead of adding it as attachment, replace 'attach' with 'embedded-image': 
 * <i>[%embedded-image(42); logo.gif]</i>.
 * <p>
 * To locate existing resources, use one of the <i>select</i> methods of the <i>ResourceManager</i>. 
 * The following snippet shows how to retrieve all <i>Inx_Api_Resource_Resource</i>s available for a specific mailing 
 * and prints their IDs and names:
 * 
 * <pre>
 * $oMailing = $oSession->getMailingManager()->get( 4711 );
 * 
 * $oResourceManager = $oSession->getResourceManager();
 * $oBOResultSet = $oResourceManager->select( $oMailing, Inx_Api_Resource_Resource::ATTRIBUTE_NAME, Inx_Api_Order::ASC );
 * 
 * for( $i = 0; $i &lt; $oBOResultSet->size(); $i++ )
 * {
 * 	$oResource = $oBOResultSet->get( $i );
 * 	echo $oResource->getId().&quot;: &quot;.$oResource->getName().&quot;&#60;br&#62;&quot;;
 * }
 * </pre>
 * <p>
 * For more information on resources, see the <i>Inx_Api_Resource_Resource</i> documentation.
 * 
 * @see Inx_Api_Resource_Resource
 * @since API 1.0 
 * @version $Revision: 9553 $ $Date: 2008-01-04 11:28:41 +0200 (Pn, 04 Sau 2008) $ $Author: vladas $
 * @package Inxmail
 * @subpackage Resource
 */
interface Inx_Api_Resource_ResourceManager extends Inx_Api_BOManager
{

	/** @deprecated replaced by <i>Inx_Api_Order::ASC</i> */
	const ORDER_ASC = 0;
	
	/** @deprecated replaced by <i>Inx_Api_Order::DESC</i> */
	const ORDER_DESC = 1;

	
    /**
     * Uploads a file resource to Inxmail.
     * The sharing type depends on the type of the $mOwner parameter:
     * <ol>
     * <li>If you pass a <code>null</code> value, the resource will be shared with all other mailings in the system (i.e.
	 * sharingType is <i>Inx_Api_Resource_Resource::SHARING_TYPE_SYSTEM</i>).
	 * <li>If you pass an instance of <i>Inx_Api_Mailing_Mailing</i>, the resource will not be shared with other mailings 
	 * (i.e. sharingType is <i>Inx_Api_Resource_Resource::SHARING_TYPE_MAILING</i>).
	 * <li>If you pass an instance of <i>Inx_Api_List_ListContext</i>, The resource will be shared with other mailings in 
	 * the specified list (i.e. sharingType is <i>Inx_Api_Resource_Resource::SHARING_TYPE_LIST</i>).
	 * <li>Any other non <i>null</i> value will render no effect. The method will not perform the upload.
	 * </ol> 
	 * If a resource with the specified name already exists it will not be overwritten. 
	 * Instead a second resource with the same name and the new content will be created.
	 * 
	 * @param Inx_Api_List_ListContext|Inx_Api_Mailing_Mailing $mOwner the list or mailing this resource will be restricted to.
	 * 			May be <i>null</i> to share the resource with all mailings in all lists.
	 * @param string $sFilename the filename of the resource (e.g. logo.gif).
	 * @param resource $rsInputStream the input stream of the file content.
	 * @return Inx_Api_Resource_Resource the new resource, or <i>null</i> if the upload failed.
	 * @throws Inx_Api_SecurityException if the session user doesn't have the following permission:
	 *             <i>Inx_Api_UserRights::RESOURCE_UPLOAD_MAILING_SHARING</i>
     */
    public function upload( $mOwner, $sFilename, $rsInputStream );
    
    
    /**
     * Returns an <i>Inx_Api_BOResultSet</i> containing all resources available for the given <i>Inx_Api_Mailing_Mailing</i>. 
     * This includes all non shared resources available for this mailing, list shared resources and system shared resources.
	 * 
	 * @param Inx_Api_Mailing_Mailing $oMailing the mailing for which the available resources shall be retrieved.
	 * @param int $iOrderAttribute the order attribute. May be one of:
	 *            <ul>
	 *            <li><i>Inx_Api_Resource_Resource::ATTRIBUTE_NAME</i>
	 *            <li><i>Inx_Api_Resource_Resource::ATTRIBUTE_SHARING_TYPE</i>
	 *            <li><i>Inx_Api_Resource_Resource::ATTRIBUTE_SIZE</i>
	 *            <li><i>Inx_Api_Resource_Resource::ATTRIBUTE_CREATION_DATETIME</i>
	 *            <li><i>Inx_Api_Resource_Resource::ATTRIBUTE_USER_ID</i>
	 *            </ul>
	 * @param int $iOrderType the order type <i>Inx_Api_Order::ASC</i> or <i>Inx_Api_Order::DESC</i>).
	 * @return Inx_Api_BOResultSet an <i>BOResultSet</i> object that contains the data produced by the given query.
	 * @throws SecurityException if the session user doesn't have the following permission:
	 *             <i>Inx__Api_UserRights::RESOURCE_FEATURE_USE</i>
     */
    public function select( Inx_Api_Mailing_Mailing $oMailing, $iOrderAttribute, $iOrderType );

}
