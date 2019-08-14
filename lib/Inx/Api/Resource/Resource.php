<?php

/**
 * @package Inxmail
 * @subpackage Resource
 */
/**
 * An <i>Inx_Api_Resource_Resource</i> is a business object representing an attachment or an embedded image stored on the server.
 * <i>Resource</i>s can be used in mailings, depending on their sharing type. 
 * The following sharing types are supported:
 * <p>
 * <ul>
 * <li><i>SHARING_TYPE_SYSTEM</i>: The resource can be used by all mailings in all lists
 * <li><i>SHARING_TYPE_MAILING</i>: The resource can only be used by one specific mailing
 * <li><i>SHARING_TYPE_LIST</i>: The resource can be used by all mailings of a specific list
 * </ul>
 * <p>
 * Besides of the sharing type a <i>Resource</i> contains meta information about the represented resource:
 * <p>
 * <ul>
 * <li><i>The name</i>: Each resource has a name. The name does not have to be unique.
 * <li><i>The content type</i>: Contains the MIME type of the resource.
 * <li><i>The creation datetime</i>: The datetime when the resource was uploaded.
 * <li><i>The size</i>: The size of the resource in bytes.
 * <li><i>The user id</i>: References the user who uploaded the resource.
 * </ul>
 * <p>
 * To download a resource, use the <i>Inx_Api_InputStream</i> provided by <i>getInputStream()</i>.
 * <p>
 * For an example on how to upload, retrieve and use resources, see the <i>Inx_Api_Resource_ResourceManager</i>
 * documentation.
 * 
 * @see com.inxmail.xpro.api.resource.ResourceManager
 * @since API 1.0
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 * @subpackage Resource
 */
interface Inx_Api_Resource_Resource extends Inx_Api_BusinessObject
{
    
    /**
     * Constant for the name attribute. 
     * Used by the <i>select()</i> and <i>selectAll()</i> methods to order the result.
     * 
     * @see Inx_Api_Resource_ResourceManager#select(Mailing, int orderAttribute, int)
     * @see Inx_Api_Resource_ResourceManager#selectAll(int orderAttribute, int)
     * @var int 
     */
    const ATTRIBUTE_NAME = 0;
    
    /**
     * Constant for the size attribute. 
     * Used by the <i>select()</i> and <i>selectAll()</i> methods to order the result.
     * 
     * @see Inx_Api_Resource_ResourceManager#select(Mailing, int orderAttribute, int)
     * @see Inx_Api_Resource_ResourceManager#selectAll(int orderAttribute, int)
     * @var int 
     */
    const ATTRIBUTE_SIZE = 1;
    
    /**
     * Constant for the creation date attribute. 
     * Used by the <i>select()</i> and <i>selectAll()</i> methods to order the result.
     * 
     * @see Inx_Api_Resource_ResourceManager#select(Mailing, int orderAttribute, int)
     * @see Inx_Api_Resource_ResourceManager#selectAll(int orderAttribute, int)
     * @var int 
     */
    const ATTRIBUTE_CREATION_DATETIME = 2;
    
    /**
     * Constant for the sharing type attribute. 
     * Used by the <i>select()</i> and <i>selectAll()</i> methods to order the result.
     * 
     * @see Inx_Api_Resource_ResourceManager#select(Mailing, int orderAttribute, int)
     * @see Inx_Api_Resource_ResourceManager#selectAll(int orderAttribute, int)
     * @var int 
     */
    const ATTRIBUTE_SHARING_TYPE = 4;
    
    /**
     * Constant for the user id attribute. 
     * Used by the <i>select()</i> and <i>selectAll()</i> methods to order the result.
	 * 
     * @see Inx_Api_Resource_ResourceManager#select(Mailing, int orderAttribute, int)
     * @see Inx_Api_Resource_ResourceManager#selectAll(int orderAttribute, int)
     * @var int 
     */
    const ATTRIBUTE_USER_ID = 5;
	
    
    /**
     * Sharing behaviour: Resource is not shared, but bound to the specified mailing - <i>getMailingId()</i>.
     * 
     * @see ::getSharingType()
     * @var int
     */
    const SHARING_TYPE_MAILING = 0; 
 
    /**
     * Sharing behaviour: Resource is list shared, thus bound to the the specified list - <i>getListContextId()</i>. 
     * 
     * @see ::getSharingType()
     * @var int
     */
    const SHARING_TYPE_LIST = 1; 

    /**
     * Sharing behaviour: Resource is system shared, thus not bound to a single mailing or list.
     * 
     * @see ::getSharingType()
     * @var int
     */
    const SHARING_TYPE_SYSTEM = 2; 

    
    /**
     * Returns the filename of the resource.
     * 
     * @return string the filename of the resource.
     */
    public function getName();
    
    
    /**
     * Returns the creation date of the resource.
     * 
     * @return	string the creation date of the resource.
     */
    public function getCreationDatetime();
    
    
    /**
     * Returns the size of the resource file in bytes.
     * 
     * @return int the size of the resource file in bytes.
     */
    public function getSize();
    
    
    /**
     * Returns the id of the user who uploaded the resource.
     * 
     * @return int the id of the user who uploaded the resource.
     */
    public function getUserId();
    
    
    /**
     * Returns the id of the list this resource is bound to. Only specified, if the sharing type is <i>SHARING_TYPE_LIST</i>.
     * 
     * @return int the id of the list this resource is bound to.
     */
    public function getListContextId();
    
    
    /**
     * Returns the id of the mailing this resource is bound to. Only specified, if the sharing type is <i>SHARING_TYPE_MAILING</i>.
     * 
     * @return int the id of the mailing this resource is bound to.
     */
    public function getMailingId();
    

    /**
     * Returns the sharing type. The following sharing type values are allowed:
     * <ul>
     * <li> <i>SHARING_TYPE_MAILING</i>: Resource is not shared, but bound to the specified mailing - <i>getMailingId</i>.
     * <li> <i>SHARING_TYPE_LIST</i>: Resource is list shared, thus bound to the the specified list - <i>getListContextId</i>.
     * <li> <i>SHARING_TYPE_SYSTEM</i>: Resource is system shared, thus not bound to a single mailing or list.
     * </ul>
     * 
     * @return int the sharing type.
     */
    public function getSharingType();
    
    
    /**
     * Returns the MIME type of the content.
     * 
     * @return string the MIME type of the content.
     */
    public function getContentType();
    
    
    /**
     * Returns an <i>Inx_Api_InputStream</i> which can be used to download the resource file.
     * 
     * @return Inx_Api_InputStream	an <i>InputStream</i> to download the resource file.
     * @throws Inx_Api_SecurityException if the session user doesn't have the following permission:
	 * <i>Inx_Api_UserRights::RESOURCE_FEATURE_USE</i>
     */
    public function getInputStream();
    
}
