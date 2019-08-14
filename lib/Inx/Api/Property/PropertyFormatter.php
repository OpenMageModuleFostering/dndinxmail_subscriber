<?php
/**
 * @package Inxmail
 * @subpackage Property
 */
/**
 * The <i>Inx_Api_Property_PropertyFormatter</i> is used for converting property values. 
 * At the moment it is only used for converting the approval property to and from the internal string representation. 
 * An <i>Inx_Api_Property_PropertyFormatter</i> can be obtained by calling <i>Inx_Api_Property_Property::getFormatter()</i>.
 * <p>
 * The following snippet shows how to retrieve and parse the approval property of the specified list:
 * 
 * <pre>
 * $oListContext = $oSession->getListContextManager()->findByName( &quot;Desired list&quot; );
 * $oProperty = $oListContext->findProperty( Inx_Api_Property_PropertyNames::APPROVAL_ACTIVE );
 * 
 * $oPropertyFormatter = $oProperty->getFormatter();
 * $oApprovalPropertyValue = $oPropertyFormatter->parseApprovalPropertyValue( $oProperty );
 * echo "Approval type:      ".$oApprovalPropertyValue->getApprovalType()."&#60;br&#62;";
 * echo "Primary approver:   ".$oApprovalPropertyValue->getPrimaryApproverId()."&#60;br&#62;";
 * echo "Secondary approver: ".$oApprovalPropertyValue->getSecondaryApproverId()."&#60;br&#62;";
 * </pre>
 * 
 * It is also possible to convert an <i>Inx_Api_Property_ApprovalPropertyValue</i> into the internal string representation. 
 * The following snippet shows how to update the approval process policy of the specified list:
 * 
 * <pre>
 * $iPrimaryApproverId = ...
 * $iSecondaryApproverId = ...
 * 
 * $oListContext = $oSession->getListContextManager()->findByName(&quot;Desired list&quot;);
 * $oProperty = $oListContext->findProperty(Inx_Api_Property_PropertyNames::APPROVAL_ACTIVE);
 * 
 * $oPropertyFormatter = $oProperty->getFormatter();
 * $oApprovalPropertyValue = new Inx_Api_Property_ApprovalPropertyValue(
 * 	Inx_Api_Property_ApprovalPropertyValue::APPROVAL_TYPE_ESCALATION, $iPrimaryApproverId, $iSecondaryApproverId);
 * $oProperty->updateInternalValue($oPropertyFormatter->createApprovalPropertyValue($oApprovalPropertyValue));
 * $oProperty->commitUpdate();
 * </pre>
 * <p>
 * For more information on the approval property and the possible approval types, see the 
 * <i>Inx_Api_Propterty_ApprovalPropertyValue</i> documentation.
 * <p>
 * For more information on properties in general, see the <i>Inx_Api_Property_Property</i> documentation.
 * 
 * @see Inx_Api_Property_ApprovalPropertyValue
 * @see Inx_Api_Property_Property
 * @since API 1.6.0
 * @version $Revision: 10520 $ $Date: 2008-09-12 14:40:48 +0200 (Fr, 12 Sep 2008) $ $Author: sbn $
 * @package Inxmail
 * @subpackage Property
 */
interface Inx_Api_Property_PropertyFormatter
{
	/**
	 * Creates the internal value string for the given <i>Inx_Api_Property_ApprovalPropertyValue</i> which is 
	 * used for <i>Inx_Api_Property_Property::updateInternalValue($sValue)</i>.
	 * 
	 * @param string $value the <i>Inx_Api_Property_ApprovalPropertyValue</i> which contains the new approval 
	 * process policy.
	 * @return string the internal value string.
	 */
	public function createApprovalPropertyValue( $value );


	/**
	 * Parses a property and creates an <i>Inx_Api_Property_ApprovalPropertyValue</i> object containing the 
	 * approval process policy. 
	 * This object can be used to easily retrieve the specifics of the approval process policy.
	 * 
	 * @param Inx_Api_Property_Property $property the property containing the approval value.
	 * @return Inx_Api_Property_ApprovalPropertyValue an <i>Inx_Api_Property_ApprovalPropertyValue</i> containing 
	 * the approval process policy.
	 */
	public function parseApprovalPropertyValue( $property );

}
