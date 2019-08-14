<?php
/**
 * @package Inxmail
 * @subpackage Recipient
 */
/**
 * Using the <i>Inx_Api_Recipient_AttributeManager</i>, attributes (columns) can be manipulated. 
 * The following operations can be performed using the <i>AttributeManager</i>:
 * <p>
 * <ul>
 * <li>Creating attributes: <i>create(String, int, int)</i>
 * <li>Removing user attributes: <i>remove(Attribute)</i>
 * <li>Renaming user attributes: <i>rename(Attribute, String)</i>
 * <li>Checking list visibility: <i>isAttributeVisibleInList(Attribute, int)</i> and
 * <i>areAttributesVisibleInList(List, int)</i>
 * <li>Setting list visibility: <i>setAttributeListVisibility(Attribute, int, boolean)</i> and
 * <i>setAttributeListVisibilities(List, int, boolean)</i>
 * <li>Setting global visibility: <i>setGlobalAttributeVisibility(Attribute, boolean)</i> and
 * <i>setGlobalAttributeVisibilities(List, boolean)</i>
 * </ul>
 * Note: Changing the data type of an attribute is not supported by the <i>AttributeManager</i>. 
 * This is a possibly dangerous operation that should - if at all - be performed using the client which can 
 * provide guidance and assistance in converting attributes from on type into another.
 * <p>
 * The <i>AttributeManager</i> can not be used to change attribute values for recipients. 
 * This is performed using the <i>Inx_Api_Recipient_RecipientContext</i>. 
 * See the <i>RecipientContext</i> documentation for more information on this topic.
 * <p>
 * Following example illustrates how to create a new text attribute with a length of 50 characters:
 * 
 * <pre>
 * $oSession->getAttributeManager()->create( "Firstname", Inx_Api_Recipient_Attribute::DATA_TYPE_STRING, 50 );
 * </pre>
 * <p>
 * For more information on <i>Attribute</i>s in general, see the <i>Inx_Api_Recipient_Attribute</i> documentation.
 * 
 * @see Inx_Api_Recipient_Attribute
 * @see Inx_Api_Recipient_RecipientContext
 * @since   API 1.0
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 * @subpackage Recipient
 */
interface Inx_Api_Recipient_AttributeManager
{

	/**
	 * Create a new user attribute. 
	 * 
	 * @param attributeName	the unique name of the attribute
	 * @param dataType	the data type of the attribute
	 * @param maxStringLenth	the length of the string attribute (length from 1 to 255),
	 * only for <i>Inx_Api_Recipient_Attribute::DATA_TYPE_STRING</i>
	 * @return	the attribute id of the new attribute
	 * @throws Inx_Api_NameException if the attribute name is illegal or already exist
	 * @see Inx_Api_Recipient_Attribute
	 */
	public function create( $sAttributeName, $iDataType, $iMaxStringLenth );
	

	/**
	 * Rename a user attribute.
	 * 
	 * @param Inx_Api_Recipient_Attribute $oAttribute	the attribute to rename
	 * @param string $sAttributeName	the new attribute name
	 * @return boolean	true, if the attribute is renamed, otherwise false 
	 * @throws Inx_Api_NameException if the attribute name is illegal or already exist
	 */
	public function rename( Inx_Api_Recipient_Attribute $oAttribute, $sAttributeName );

	
	/**
	 * Remove a user attribute.
	 * 
	 * @param Inx_Api_Recipient_Attribute $oAttribute the attribute to remove
	 * @return boolean true, if the attribute is removed, otherwise false
	 */
	public function remove( Inx_Api_Recipient_Attribute $oAttribute = null );

	
	/**
	* Checks whether the given attribute is visible in the specified list.
	*
	* @param Inx_Api_Recipient_Attribute $oAttribute the attribute to check.
	* @param int $iListId the id of the list to check.
	* @return bool <i>true</i> if the attribute is visible in the list, <i>false</i> otherwise.
	* @since API 1.10.0
	*/
	public function isAttributeVisibleInList( Inx_Api_Recipient_Attribute $oAttribute, $iListId );
	
	
	/**
	 * Checks whether the given attributes are visible in the specified list. 
	 * The result is an associative array where the attribute id is the key and the value is a <i>bool</i> indicating 
	 * the visibility of the attribute.
	 *
	 * @param array $aAttributes a list of <i>Inx_Api_Recipient_Attribute</i>s to check.
	 * @param int $iListId the id of the list to check.
	 * @return array an associative array containing int/bool pairs.
	 * @since API 1.10.0
	 */
	public function areAttributesVisibleInList( $aAttributes, $iListId );
	
	
	/**
	 * Sets the visibility of an attribute (column) in a specific list. 
	 * Some attributes, like the email attribute, may not be shown or hidden and will therefore trigger an 
	 * <i>Inx_Api_APIException</i>.
	 *
	 * @param Inx_Api_Recipient_Attribute $oAttribute the attribute to show or hide.
	 * @param int $iListId the id of the list in which the attribute shall be shown or hidden.
	 * @param bool $blVisible <i>true</i> if the attribute shall be shown, <i>false</i> if it shall be hidden.
	 * @throws Inx_Api_APIException if the attribute can not be shown / hidden.
	 * @since API 1.9.0
	 */
	public function setAttributeListVisibility( Inx_Api_Recipient_Attribute $oAttribute, $iListId, $blVisible );
	
	
	/**
	 * Sets the visibility of a list of attributes (columns) in a specific list. 
	 * Some attributes, like the email attribute, may not be shown or hidden and will therefore trigger an 
	 * <i>Inx_Api_APIException</i>. 
	 * If the list contains such an attribute, none of the attributes will be modified.
	 *
	 * @param array $aAttributes a list of <i>Inx_Api_Recipient_Attribute</i>s to show or hide.
	 * @param int $iListId the id of the list in which the attributes shall be shown or hidden.
	 * @param bool $blVisible <i>true</i> if the attributes shall be shown, <i>false</codei> if they shall be hidden.
	 * @throws Inx_Api_APIException if at least one attribute can not be shown / hidden.
	 * @since API 1.9.0
	 */
	public function setAttributeListVisibilities( $aAttributes, $iListId, $blVisible );
	
	
	/**
	 * Sets the visibility of an attribute (column) in all lists. 
	 * Some attributes, like the email attribute, may not be shown or hidden and will therefore trigger an 
	 * <i>Inx_Api_APIException</i>.
	 *
	 * @param Inx_Api_Recipient_Attribute $oAttribute the attribute to show or hide.
	 * @param bool $blVisible <i>true</i> if the attribute shall be shown, <i>false</i> if it shall be hidden.
	 * @throws Inx_Api_APIException if the attribute can not be shown / hidden.
	 * @since API 1.9.0
	 */
	public function setGlobalAttributeVisibility( Inx_Api_Recipient_Attribute $oAttribute, $blVisible );
	
	
	/**
	 * Sets the visibility of a list of attributes (columns) in all lists. 
	 * Some attributes, like the email attribute, may not be shown or hidden and will therefore trigger an 
	 * <i>Inx_Api_APIException</i>. 
	 * If the list contains such an attribute, none of the attributes will be modified.
	 *
	 * @param array $aAttributes a list of <i>Inx_Api_Recipient_Attribute</i>s to show or hide.
	 * @param bool $blVisible <i>true</i> if the attributes shall be shown, <i>false</i> if they shall be hidden.
	 * @throws Inx_Api_APIException if at least one attribute can not be shown / hidden.
	 * @since API 1.9.0
	 */
	public function setGlobalAttributeVisibilities( $aAttributes, $blVisible );
}
