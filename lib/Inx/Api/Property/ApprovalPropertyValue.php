<?php
/**
 * @package Inxmail
 * @subpackage Property
 */
/**
 * The <i>Inx_Api_Property_ApprovalPropertyValue</i> is a wrapper class for the approval property values. 
 * This value determines if and how mailings shall be approved and by whom. 
 * An <i>Inx_Api_Property_ApprovalPropertyValue</i> therefore consists of three parts which define the approval strategy:
 * <ul>
 * <li><i>The approval type</i>: Defines if and how mailings shall be approved.
 * <li><i>The primary approver</i>: Approver that will be involved in all approval types immediately.
 * <li><i>The secondary approver</i>: Approver that will only get involved in certain conditions.
 * </ul>
 * If and how the approvers will get involved is determined from the approval type. 
 * The possible values for the approval type are:
 * <p>
 * <ul>
 * <li><i>APPROVAL_TYPE_OFF</i>: Approval is completely turned off. 
 * No approver will get involved, the editor is the only one responsible for the correctness of the mailing content.
 * <li><i>APPROVAL_TYPE_SYSTEM</i>: The approval type is inherited from the system list.
 * <li><i>APPROVAL_TYPE_IDENTICAL</i>: Both approvers will get involved immediately. 
 * Only one of them has to approve the mailing.
 * <li><i>APPROVAL_TYPE_ESCALATION</i>: At first, only the primary approver will be involved. 
 * If the escalation date expires without the primary approver having approved the mailing, the secondary 
 * approver will get involved.
 * </ul>
 * <p>
 * To convert an <i>Inx_Api_Property_ApprovalPropertyValue</i> into the internal representation needed for the 
 * approval property, use the 
 * <i>Inx_Api_Property_PropertyFormatter::createApprovalPropertyValue($oApprovalPropertyValue)</i> method. 
 * To convert the internal representation into an <i>Inx_Api_Property_ApprovalPropertyValue</i> object, use the
 * <i>Inx_Api_Property_PropertyFormatter::parseApprovalPropertyValue($oProperty)</i> method.
 * 
 * @see com.inxmail.xpro.api.property.PropertyFormatter
 * @see com.inxmail.xpro.api.property.PropertyNames#APPROVAL_ACTIVE
 * 
 * @since API 1.6.0
 * @version $Revision: 10520 $ $Date: 2008-09-12 14:40:48 +0200 (Fr, 12 Sep 2008) $ $Author: sbn $
 * @package Inxmail
 * @subpackage Property
 */
class Inx_Api_Property_ApprovalPropertyValue
{
	private $approvalType;

	private $primaryApproverId;

	private $secondaryApproverId;

	/**
	 * Approval type used for deactivating the approval process. 
	 * No approver will get involved, the editor is the only one responsible for the correctness of the mailing content.
	 */
	const APPROVAL_TYPE_OFF = 0;

	/**
	 * Approval type used to inherit the type from the system approval property. 
	 * If this type is used in the system list, the system approval property will be set to <i>APPROVAL_TYPE_OFF</i>.
	 */
	const APPROVAL_TYPE_SYSTEM = 1;

	/**
	 * Approval type used for the escalating approval process. 
	 * At first, only the primary approver will be involved. 
	 * If the escalation date expires without the primary approver having approved the mailing, the secondary approver 
	 * will get involved.
	 */
	const APPROVAL_TYPE_ESCALATION = 2;

	/**
	 * Approval type used for the identical approval process.
	 * Both approvers will get involved immediately. 
	 * Only one of them has to approve the mailing.
	 */
	const APPROVAL_TYPE_IDENTICAL = 3;


	/**
	* Creates an <i>Inx_Api_Property_ApprovalPropertyValue</i> instance with the given approval type, primary 
	* approver and secondary approver. 
	* If the approval type is <i>APPROVAL_TYPE_OFF</i> or <i>APPROVAL_TYPE_SYSTEM</i>, no approvers need to be defined. 
	* In that case use -1 as the id of both approvers.
	*
	* @param int $approvalType the approval type. May be one of:
	*            <ul>
	*            <li><i>APPROVAL_TYPE_OFF</i>
	*            <li><i>APPROVAL_TYPE_SYSTEM</i>
	*            <li><i>APPROVAL_TYPE_IDENTICAL</i>
	*            <li><i>APPROVAL_TYPE_ESCALATION</i>
	*            </ul>
	* @param int $primaryApproverId the id of the primary approver, or -1 if none is needed.
	* @param int $secondaryApproverId the id of the secondary approver, or -1 if none is needed.
	*/
	public function __construct( $approvalType, $primaryApproverId, $secondaryApproverId )
	{
		$this->approvalType = $approvalType;
		$this->primaryApproverId = $primaryApproverId;
		$this->secondaryApproverId = $secondaryApproverId;
	}


	/**
	 * Returns the type of the approval process, also indicates if the process is deactivated.
	 * 
	 * @return int the approval type. May be one of:
	 *         <ul>
	 *         <li><i>APPROVAL_TYPE_OFF</i>
	 *         <li><i>APPROVAL_TYPE_SYSTEM</i>
 	 *         <li><i>APPROVAL_TYPE_IDENTICAL</i>
	 *         <li><i>APPROVAL_TYPE_ESCALATION</i>
	 *         </ul>
	 */
	public function getApprovalType()
	{
		return $this->approvalType;
	}


	/**
	 * Returns the id of the primary approver.
	 * 
	 * @return int the id of the primary approver.
	 */
	public function getPrimaryApproverId()
	{
		return $this->primaryApproverId;
	}


	/**
	 * Returns the id of the secondary approver.
	 * 
	 * @return int the id of the secondary approver.
	 */
	public function getSecondaryApproverId()
	{
		return $this->secondaryApproverId;
	}

}
