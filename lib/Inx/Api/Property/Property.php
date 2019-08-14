<?php
/**
 * @package Inxmail
 * @subpackage Property
 */
/**
 * Mailing lists have properties, which control the list behaviour. 
 * An <i>Inx_Api_Property_Property</i> may control, for example, the default mail encoding, the maximal sending 
 * performance, or settings used by features, such as the hard bounce threshold. 
 * The properties can be accessed through the <i>Inx_Api_List_ListContext::findProperty($sPropertyName)</i> and
 * <i>Inx_Api_List_ListContext::selectProperties()</i> methods.
 * <p>
 * The following snippet shows how to retrieve a specific property, namely the mail encoding property:
 * 
 * <pre>
 * $oListContext = ...
 * $oProperty = $oListContext->findProperty( Inx_Api_Property_PropertyNames::MAIL_ENCODING );
 * echo $oProperty->getInternalValue();
 * </pre>
 * 
 * Note: Not all properties are available for all lists. 
 * The <i>Inx_Api_Property_PropertyNames</i> interface documentation states, which properties are available for which lists.
 * <p>
 * The following snippet shows how to retrieve all properties of a list:
 * 
 * <pre>
 * $oBOResultSet = $oListContext->selectProperties();
 * 
 * for( $i = 0; $i &lt; $oBOResultSet->size(); $i++ )
 * {
 * 	$oProperty = $oBOResultSet->get( $i );
 * 	echo $oProperty->getName()."&#60;br&#62;";
 * }
 * 
 * $oBOResultSet->close();
 * </pre>
 * <p>
 * The following snippet shows how to change the locale of a specific list to English:
 * 
 * <pre>
 * $oListContext = $oSession->getListContextManager()->findByName( &quot;Desired list&quot; );
 * 
 * $oProperty = $oListContext->findProperty( Inx_Api_Property_PropertyNames::FORMAT_LOCALE );
 * $oProperty->updateInternalValue( &quot;en&quot; );
 * $oProperty->commitUpdate();
 * </pre>
 * <p>
 * Most of the properties can be set easily as the values are simple numbers or strings (see above). 
 * However, there are two special properties which require a bit more effort to be set correctly:
 * <ol>
 * <li><i>Inx_Api_Property_PropertyNames::APPROVAL_ACTIVE</i>: Defines the approval method and the approvers.
 * <li><i>Inx_Api_Property_PropertyNames::MAIL_FORMAT_CHOICE</i>: Defines the default mailing format.
 * </ol>
 * These two properties have a special internal value syntax. 
 * To ease the setting of these two properties, there are two formatters used to parse and create the internal values:
 * <ol>
 * <li><i>Inx_Api_Property_PropertyFormatter</i> for the approval property.
 * <li><i>Inx_Api_Property_FormatChoicePropertyFormatter</i> for the mail format property.
 * </ol>
 * An <i>Inx_Api_Property_PropertyFormatter</i> instance can be obtained using the <i>getFormatter()</i> method. 
 * The <i>Inx_Api_Property_FormatChoicePropertyFormatter</i> offers static methods for conversion instead. 
 * For examples on how to use the formatters, see their respective documentation.
 * <p>
 * Note: Several api user rights are required to use properties, depending on which properties shall be
 * retrieved/manipulated. 
 * See the PROPERTY_* constants in the <i>Inx_Api_UserRights</i> documentation.
 * 
 * @see Inx_Api_List_ListContext::findProperty($sPropertyName)
 * @see Inx_Api_List_ListContext::selectProperties()
 * @see Inx_Api_Property_PropertyNames
 * @see Inx_Api_Property_PropertyFormatter
 * @see Inx_Api_Property_FormatChoicePropertyFormatter
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 * @subpackage Property
 */
interface Inx_Api_Property_Property extends Inx_Api_BusinessObject
{
    /**
	 * Constant for the property value attribute. Used by the <i>UpdateException</i> to indicate the error source.
	 * 
	 * @see Inx_Api_UpdateException#getErrorSource()
	 */
	const ATTRIBUTE_VALUE = 1;

	
	/**
	 * Returns the name of the property.
	 * 
	 * @see Inx_Api_Property_PropertyNames
	 * @return string the name of the property.
	 */
	public function getName();

	
	/**
	 * Returns the value of the property.
	 * 
	 * @return string the value of the property.
	 */
	public function getInternalValue();

	
	/**
	 * Updates the value of the property.
	 * <p>
	 * For the <i>Inx_Api_Property_PropertyNames::APPROVAL_ACTIVE</i> property use the 
	 * <i>Inx_Api_Property_PropertyFormatter</i> provided by <i>getFormatter()<i>. 
	 * For the <i>Inx_Api_Property_PropertyNames::MAIL_FORMAT_CHOICE<i> property use the 
	 * <i>Inx_Api_Property_FormatChoicePropertyFormatter</i>.
	 * 
	 * @param string $sValue	the value of the property.
	 */
	public function updateInternalValue( $sValue );
	
	
	/**
	 * Returns the <i>Inx_Api_Property_PropertyFormatter</i> instance used to format the 
	 * <i>Inx_Api_Property_PropertyNames::APPROVAL_ACTIVE</i> property.
	 * 
	 * @return Inx_Api_Property_PropertyFormatter the <i>PropertyFormatter</i> used to format the approval property.
	 * @since API 1.6.0
	 */
	public function getFormatter();

}
