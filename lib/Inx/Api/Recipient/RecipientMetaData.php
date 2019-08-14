<?php

/**
 * @package Inxmail
 * @subpackage Recipient
 */
/**
 * An <i>Inx_Api_Recipient_RecipientMetaData</i> object contains meta data about the recipients represented by an
 * <i>Inx_Api_Recipient_RecipientContext</i> object. 
 * The meta data includes information about the available attributes, though can not be used to retrieve the 
 * actual attribute values.
 * 
 * @see Inx_Api_Recipient_RecipientContext
 * @since   API 1.0
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 * @subpackage Recipient
 */
interface Inx_Api_Recipient_RecipientMetaData
{

	/**
	 * Returns the id attribute.
	 *
	 * @return Inx_Api_Recipient_Attribute the id attribute.
	 */
	public function getIdAttribute();

	/**
	 * Returns the key attribute.
	 *
	 * @return Inx_Api_Recipient_Attribute the key attribute.
	 */
	public function getKeyAttribute();

	/**
	 * Returns the email attribute.
	 *
	 * @return Inx_Api_Recipient_Attribute the email attribute.
	 */
	public function getEmailAttribute();

	
	/**
	 * Returns the last modification attribute.
	 * 
	 * @return Inx_Api_Recipient_Attribute the last modification attribute.
	 */
	public function getLastModificationAttribute();
	
	
		
	/**
	 * Returns the hardbounce attribute.
	 * 
	 * @return Inx_Api_Recipient_Attribute the hardbounce attribute.
	 */
	public function getHardbounceAttribute();
	
	
	/**
	 * Returns the attribute specified by the given name.
	 *
	 * @param string $sAttributeName the name of the attribute to retrieve, ignoring case considerations.
	 *
	 * @return Inx_Api_Recipient_Attribute the attribute object.
	 * @throws Inx_Api_Recipient_AttributeNotFoundException	if the attribute could not be found.
	 */
	public function getUserAttribute( $sAttributeName );

	/**
	 * Returns the subscription attribute for the specified list. 
	 * A recipient has a subscription attribute for each standard list.
	 *
	 * @param Inx_Api_List_ListContext $oList the list context.
	 *
	 * @return Inx_Api_Recipient_Attribute the attribute object.
	 * @throws Inx_Api_Recipient_AttributeNotFoundException	if the list is not a standard list.
	 */
	public function getSubscriptionAttribute( Inx_Api_List_ListContext $oList );

	/**
	 * Returns the attribute specified by the given id.
	 *
	 * @param int $iAttributeId the id of the attribute to retrieve.
	 *
	 * @return Inx_Api_Recipient_Attribute the attribute object.
	 * @throws Inx_Api_Recipient_AttributeNotFoundException	if the attribute could not be found.
	 */
	public function getAttribute( $iAttributeId );

	/**
	 * Returns the number of attributes.
	 *
	 * @return int the number of attributes.
	 */
	public function getAttributeCount();

	/**
	 * Returns an <i>Inx_Apiimpl_Recipient_RecipientContextImpl_AttributeIterator</i> over the attributes in this meta data.
	 * <p>
	 * The following snippet shows how to iterate over the recipient attributes:
	 * 
	 * <pre>
	 * $oRecipientMetaData = $oSession->createRecipientContext()->getMetaData();
	 * $oAttributeIterator = $oRecipientMetaData->getAttributeIterator();
	 * 
	 * while( $oAttributeIterator->hasNext() )
	 * {
	 *  $oAttribute = $oAttributeIterator->current();
	 * 	echo $oAttribute->getName().&quot;&#60;br&#62;&quot;;
	 *  $oAttributeIterator->next();
	 * }
	 * </pre> 
	 *
	 * @return Inx_Apiimpl_Recipient_RecipientContextImpl_AttributeIterator an iterator over the attributes.
	 */
	public function getAttributeIterator();

}
