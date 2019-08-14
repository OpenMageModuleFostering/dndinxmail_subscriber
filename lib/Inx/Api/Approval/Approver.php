<?php
/**
 * @package Inxmail
 * @subpackage Approval
 */
/**
 * An <i>Inx_Api_Approval_Approver</i> represents a person that has to approve a mailing before it can be sent.
 * <P>
 * Note: The system wide approvers are only assigned to the system list. Therefore, the system list id is the only id in
 * the array returned by <i>getLists()</i>.
 * <p>
 * Note: In order to commit changes, all attributes enlisted in this class must be assigned a non null value.
 * <p>
 * Note: The usage of <i>Inx_Api_Approval_Approver</i>s requires the api user right: <i>Inx_Api_UserRights::PROPERTY_SYSTEM_USE</i>
 * <p>
 * For an example on how to use approvers, see the Inx_Api_Approval_ApproverManager documentation.
 * 
 * @see Inx_Api_Approval_ApproverManager
 * @since API 1.6.0
 * @version $Revision: 10520 $ $Date: 2008-09-12 14:40:48 +0200 (Fr, 12 Sep 2008) $ $Author: sbn $
 * @package Inxmail
 * @subpackage Approval
 */
interface Inx_Api_Approval_Approver extends Inx_Api_BusinessObject
{

	/**
	 * Returns the name of the approver.
	 * 
	 * @return string the name of the approver.
	 */
	public function getName();


	/**
	 * Sets a new for the approver.
	 * 
	 * @param string $sName the new name of the approver.
	 */
	public function updateName( $sName );


	/**
	 * Returns the email address of the approver.
	 * 
	 * @return string the email address of the approver.
	 */
	public function getEmail();


	/**
	 * Sets a new email address for the approver.
	 * 
	 * @param string $sEmail the new email address of the approver.
	 */
	public function updateEmail( $sEmail );


	/**
	 * Returns the comment of the approver.
	 * 
	 * @return string the comment of the approver.
	 */
	public function getComment();


	/**
	 * Sets a new comment for the approver.
	 * 
	 * @param string $sComment the new comment of the approver.
	 */
	public function updateComment( $sComment );


	/**
	 * Returns an id list of all lists the approver is assigned to.
	 * <P>
	 * Note: System wide approvers return only the system list id.
	 * 
	 * @return array an id list of all lists the approver is assigned to, or the system list id if the approver is assigned to
	 *         all lists.
	 */
	public function getLists();


	/**
	 * Sets the lists this approver is assigned to.
	 * <P>
	 * Note: Use the id of the system list as the only id in the array if the approver should be assigned to all lists.
	 * The following snippet retrieves the system list id:
	 * <pre>
	 * $oListContextManager = $oSession->getListContextManager();
 	 * $oListContext = $oListContextManager->findByName( Inx_Api_List_SystemListContext::NAME );
 	 * </pre>
	 * 
	 * @param array $lists array of list ids.
	 */
	public function updateLists( $lists );

}
