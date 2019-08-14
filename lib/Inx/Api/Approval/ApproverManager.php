<?php
/**
 * @package Inxmail
 * @subpackage Approval
 */
/**
 * The <i>Inx_Api_Approval_ApproverManager</i> is used for the retrieval and creation of approvers. 
 * The following code snippet creates a new approver responsible for the list with the id 12:
 * 
 * <pre>
 * $approverMgr = $session->getApproverManager();
 * $approver = approverMgr->createApprover();
 * $approver->updateName( &quot;Max Mustermann&quot; );
 * $approver->updateComment( &quot;Approver for List 12&quot; );
 * $approver->updateLists( array( 12 ) );
 * $approver->commitUpdate();
 * </pre>
 * Note: The usage of <i>Inx_Api_Approval_Approver</i>s requires the api user right: <i>Inx_Api_UserRights::PROPERTY_SYSTEM_USE</i>
 * <p>
 * For more information on approvers, see the <i>Inx_Api_Approval_Approver</i> documentation.
 * 
 * @since API 1.6.0
 * @version $Revision: 10520 $ $Date: 2008-09-12 14:40:48 +0200 (Fr, 12 Sep 2008) $ $Author: sbn $
 * @package Inxmail
 * @subpackage Approval
 */
interface Inx_Api_Approval_ApproverManager extends Inx_Api_BOManager
{

	/**
	 * Selects all approvers assigned to the given list and all system wide approvers.
	 * 
	 * @param Inx_Api_List_ListContext $olistContext all approvers assigned to this list will be retrieved.
	 * @return Inx_Api_BOResultSet a result set containing the approvers.
	 */
	public function select( $olistContext );


	/**
	 * Creates a new approver.
	 * 
	 * @return Inx_Api_Aprroval_Approver the new approver.
	 */
	public function createApprover();

}
