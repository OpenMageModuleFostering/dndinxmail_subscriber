<?php
/**
 * @package Inxmail
 * @subpackage Action
 */
/**
 * The <i>Inx_Api_Action_ActionManager</i> manages all actions. 
 * The following snippet creates a new <i>Action</i> that sets the lastClick recipient attribute 
 * (last time the recipient clicked a link) to the current date and increments the clickCount 
 * recipient attribute (the number of clicks by the recipient):
 * 
 * <PRE>
 * $oListContextManager = $oSession->getListContextManager();
 * $oListContext = $oListContextManager->findByName( Inx_Api_List_SystemListContext::NAME );
 * 
 * $oRecipientMetaData = $session->createRecipientContext()->getMetaData();
 * $iLastClick = $oRecipientMetaData->getUserAttribute( &quot;lastClick&quot; )->getId();
 * $iClickCount = $oRecipientMetaData->getUserAttribute( &quot;clickCount&quot; )->getId();
 * 
 * $oActionMgr = $oSession->getActionManager();
 *
 * $oAction = $oActionMgr->createAction( $oListContext );
 * $oAction->updateEventType( Inx_Api_Action_Action::EVENT_TYPE_CLICK );
 * $oAction->updateName( "Click-Registry" );
 * 
 * $oCommandFactory = $oActionMgr->getCommandFactory();
 * 
 * $aCmds = array();
 * $aCmds[] = $oCommandFactory->createSetValueCmd( $iLastClick, "=Date()" );
 * $aCmds[] = $oCommandFactory->createSetRelativeValueCmd( $iClickCount, 1 );
 *
 * $oAction->updateCommands( $aCmds );
 * $oAction->commitUpdate();
 * </PRE>
 * 
 * <p>
 * Note: The recipient attributes referenced in the snippet are not standard attributes and must be created using the
 * <i>Inx_Api_Recipient_AttributeManager</i> before they may be used in the shown way.
 * <p>
 * Note: The usage of <i>Inx_Api_Action_Action</i>s requires the api user right: <i>Inx_Api_UserRights::ACTION_FEATURE_USE</i>
 * <p>
 * For more information on actions (including event types), see the <i>Inx_Api_Action_Action</i> documentation.
 * 
 * @see Inx_Api_Action_Action
 * @since API 1.2.0
 * @version $Revision: 9482 $ $Date: 2007-12-18 16:42:11 +0200 (An, 18 Grd 2007) $ $Author: vladas $
 * @package Inxmail
 * @subpackage Action
 */
interface Inx_Api_Action_ActionManager extends Inx_Api_BOManager
{

	/**
	 * Creates a new, empty action with the specified owning list. If the action is not list specific, the
	 * system list context must be used. The following snippet retrieves the system list context:
	 * 
	 * <PRE>
	 * $oListContextManager = $oSession->getListContextManager();
 	 * $oListContext = $oListContextManager->findByName( Inx_Api_List_SystemListContext::NAME );
	 * </PRE>
	 * 
	 * 
	 * @param Inx_Api_List_ListContext $oListContext the list owning the action.
	 * @return Inx_Api_Action_Action a new action.
	 * 
	 */
	public function createAction( Inx_Api_List_ListContext $oListContext );
	
	
    /**
     * Selects all actions owned by the specified list context. To retrieve actions which are not list
	 * specific, use the system list context. The following snippet retrieves the system list context:
	 * 
	 * <PRE>
	 * $oListContextManager = $oSession->getListContextManager();
 	 * $oListContext = $oListContextManager->findByName( Inx_Api_List_SystemListContext::NAME );
	 * </PRE>
	 * 
	 * 
	 * @paramInx_Api_List_ListContext|int $mListContext the list context (or list id) which owns the actions to retrieve.
	 * @return Inx_Api_BOResultSet an <i>Inx_Api_BOResultSet</i> object that contains the actions owned by the specified list.
	 * @throws Inx_Api_SecurityException if the session user doesn't have the following permission:
	 *             <i>Inx_Api_UserRights::ACTION_FEATURE_USE</i>
     */
	public function select( $mListContext );

	
	/**
	 * Returns the factory used to create new commands. 
	 * <i>Inx_Api_Action_Command</i>s are executed by an <i>Inx_Api_Action</i> if the event associated with that 
	 * action is triggered.
	 * 
	 * @return Inx_Api_Action_CommandFactory the command factory.
	 */
	public function getCommandFactory();
	
}
