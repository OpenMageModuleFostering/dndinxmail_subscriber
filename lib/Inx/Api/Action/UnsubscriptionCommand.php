<?php
/**
 * @package Inxmail
 * @subpackage Action
 */
/**
 * Use the <i>Inx_Api_Action_UnsubscriptionCommand</i> to unsubscribe the recipient from the specified standard list or
 * unsubscribe the recipient from all standard lists.
 * 
 * @see Inx_Api_Action_CommandFactory
 * @since API 1.2.0
 * @version $Revision: 9482 $ $Date: 2007-12-18 16:42:11 +0200 (An, 18 Grd 2007) $ $Author: vladas $
 * @package Inxmail
 * @subpackage Action
 */
interface Inx_Api_Action_UnsubscriptionCommand extends Inx_Api_Action_Command
{

	/**
	 * Command type: Unsubscribe from a standard list.
	 */
	const CMD_TYPE_UNSUBSCRIBE = 6;

	/**
	 * Command type: Unsubscribe from all standard lists.
	 */
	const CMD_TYPE_UNSUBSCRIBE_ALL = 2;

	
	/**
	 * Returns the id of the list context. Only specified if the command type
	 * is CMD_TYPE_UNSUBSCRIBE.
	 * 
	 * @return int the id of the list context.
	 */
	public function getListContextId();
	
	
	/**
	 * Returns the command type: 
	 * Inx_Api_Action_SubUnsubscriptionCommand::CMD_TYPE_UNSUBSCRIBE or
	 * Inx_Api_Action_SubUnsubscriptionCommand::CMD_TYPE_UNSUBSCRIBE_ALL
	 * 
	 * @return int the command type.
	 */
	public function getCmdType();
	
	
	/**
	 * Specifies if the unsubscription processing is enabled or the recipient will be unsubscribed directly. If
	 * processing and double opt out (DOO) are enabled, this will send a verification email to the recipient.
	 * 
	 * @return bool true if the unsubscription processing is enabled, false otherwise.
	 */
	public function isProcessingEnabled();
	
}