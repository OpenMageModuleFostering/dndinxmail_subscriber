<?php
/**
 * @package Inxmail
 * @subpackage List
 */
/**
 * An <i>Inx_Api_List_ListContext</i> corresponds to a list in Inxmail, like a mailing list or the system list. 
 * The <i>Inx_Api_List_ListContextManager</i> is used to access and manipulate these lists.
 * <p>
 * A list is, in simple terms, a set of recipients for which mailings can be created. 
 * A list may offer various features (corresponding to agents in inxmail) which can be used to perform tasks like 
 * subscription management, creating text modules, generating reports, etc.
 * <p>
 * The available features can be determined from the <i>Inx_Api_Features<i> interface. 
 * Using the constants defined in that interface, you can enable or disable features. 
 * The following snippet enables the subscription feature, if it is not already enabled:
 * 
 * <pre>
 * $oListContext = ...
 * 
 * if(!$oListContext->isFeatureEnabled(Inx_Api_Features::SUBSCRIPTION_FEATURE_ID))
 * {
 *    $oListContext->enableFeature(Inx_Api_Features::SUBSCRIPTION_FEATURE_ID);
 * }
 * </pre>
 * 
 * Be aware that not all features can be enabled for all lists. 
 * Which features can be enabled for which lists is also documented in the <i>Inx_Api_Features</i> interface.
 * <p>
 * An <i>Inx_Api_List_ListContext</i> can also be used to retrieve the list properties using the 
 * <i>findProperty($sPropertyName)</i> and <i>selectProperties()</i> methods. 
 * These properties define the behaviour of the list. 
 * For more information on properties, see the <i>Inx_Api_Property_Property</i> documentation.
 * <p>
 * For an example on how to create and retrieve lists, see the <i>Inx_Api_List_ListContextManager</i> documentation.
 * 
 * @see Inx_Api_List_ListContextManager
 * @see Inx_Api_Features
 * @see Inx_Api_Property_Property
 * @since API 1.0 
 * @version $Revision: 9482 $ $Date: 2007-12-18 16:42:11 +0200 (An, 18 Grd 2007) $ $Author: vladas $
 * @package Inxmail
 * @subpackage List
 */
interface Inx_Api_List_ListContext extends Inx_Api_BusinessObject
{

	/**
	 * Constant for the name attribute. Used by the <i>Inx_Api_UpdateException</i> to indicate the error source.
	 * 
	 * @see Inx_Api_UpdateException::getErrorSource()
	 */
	const ATTRIBUTE_NAME = 1;
	
	/**
	 * Constant for the description attribute. Used by the <i>Inx_Api_UpdateException</i> to indicate the error source.
	 * 
	 * @see Inx_Api_UpdateException::getErrorSource()
	 */
	const ATTRIBUTE_DESCRIPTION = 2;	

	
	/**
	 * Returns the list name. The list names are unique, while the characters are case insensitive. <br>
	 * The names of the system and administration lists are predefined and immutable.
	 * 
	 * @see Inx_Api_List_SystemListContext::NAME
	 * @see Inx_Api_List_AdminListContext::NAME
	 * @return	string	the list name
	 */
	public function getName();

	
	/**
	 * Returns the list description.
	 *
	 * @return	string	the list description
	 */
	public function getDescription();


	/**
	 * Returns the creation datetime.
	 * 
	 * @return	string the creation datetime. The creation datetime is returned as ISO 8601 formatted datetime string.
	 */
	public function getCreationDatetime();
		
	
	/**
	 * Changes the list description.
	 * 
	 * @param string $sDesc	the new list description.
	 */
	public function updateDescription( $sDesc );

	
	/**
	 * Returns the property identified by the specified name.
	 * 
	 * @param string $sPropertyName the name of the property to be retrieved.
	 * @return Inx_Api_Property_Property the property identified by the specified name.
	 * @throws Inx_Api_IllegalArgumentException if the property name is unknown.
	 * @see Inx_Api_Property_PropertyNames
	 */
	public function findProperty( $sPropertyName );
	
	
	/**
	 * Returns an <i>Inx_Api_BOResultSet</i> containing all properties of this list.
	 * 
	 * @return	Inx_Api_BOResultSet an <i>Inx_Api_BOResultSet</i> containing all properties of this list
	 * @see	Inx_Api_Property_Property
	 */
	public function selectProperties();

	
	/**
	 * Checks if the specified feature is enabled.
	 * 
	 * @param int	$iFeatureId the id of the feature to check.
	 * @return bool <i>true</i>, if the feature is enabled, <i>false</i> otherwise.
	 * @throws Inx_Api_FeatureNotAvailableException if the feature is not available for this list.
	 * @see Inx_Api_Features
	 */
	public function isFeatureEnabled( $iFeatureId );

	
	/**
	 * Enables the feature with the given id. Not every feature is accessible for every type of list. 
	 * For example, the "Subscription" feature is available in standard lists, only. 
	 * The "Mailing" feature can be used in standard and filter lists.
	 * 
	 * @param int $iFeatureId the id of the feature to enable.
	 * @return bool <i>true</i>, if the feature has been enabled, <i>false</i>, if the feature was already enabled.
	 * @throws Inx_Api_FeatureNotAvailableException if the feature is not available for this list.
	 * @see Inx_Api_Features
	 */
	public function enableFeature( $iFeatureId );

	
	/**
	 * Disables the feature with the given id.
	 * 
	 * @param int $iFeatureId the id of the feature to disable.
	 * @return bool <i>true</i>, if the feature has been disabled, <i>false</i>, if the feature was already disabled.
	 * @throws Inx_Api_FeatureNotAvailableException if the feature is not available for this list.
	 * @see Inx_Api_Features
	 */
	public function disableFeature( $iFeatureId );
	
	
	/**
	 * Returns the number of recipients that are subscribed to the list. This method can return the actual list size if
	 * the parameter is true. Note: Refreshing the list size can produce a high load on the Inxmail Server. USE THIS
	 * METHOD WITH CAUTION!
	 * 
	 * @param bool $computeNow <code>true</code> if the number of recipients shall be recomputed, <code>false</code>
	 *            otherwise. May be ommitted (defaults to <i>false</i>).
	 * @return Inx_Api_List_ListSize the list size object.
	 * @throws Inx_Api_DataException if the list is deleted.
	 */
	public function getListSize( $computeNow=false );

}

