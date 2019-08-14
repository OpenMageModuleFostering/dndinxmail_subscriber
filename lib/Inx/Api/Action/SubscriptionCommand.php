<?php
/**
 * @package Inxmail
 * @subpackage Action
 */
/**
 * Use the <i>Inx_Api_Action_SubscriptionCommand</i> to subscribe the recipient to the specified standard list.
 * 
 * @see Inx_Api_Action_CommandFactory
 * @since API 1.2.0
 * @version $Revision: 9482 $ $Date: 2007-12-18 16:42:11 +0200 (An, 18 Grd 2007) $ $Author: vladas $
 * @package Inxmail
 * @subpackage Action
 */
interface Inx_Api_Action_SubscriptionCommand extends Inx_Api_Action_Command
{
	/**
	 * Command type: Subscribe to a standard list.
	 */
	const CMD_TYPE_SUBSCRIBE = 5;


	
	/**
	 * Returns the id of the list context. Only specified if the command type is CMD_TYPE_SUBSCRIBE.
	 * 
	 * @return int the id of the list context.
	 */
	public function getListContextId();
	
	
	/**
	 * Returns the command type: 
	 * Inx_Api_Action_SubUnsubscriptionCommand::CMD_TYPE_SUBSCRIBE, 
	 * 
	 * @return int the command type.
	 */
	public function getCmdType();
	
	
	/**
	 * Specifies if the subscription processing is enabled or the recipient will be subscribed directly. If processing
	 * and double opt in (DOI) are enabled, this will send a verification email to the recipient.
	 * 
	 * @return bool true if the subscription processing is enabled, false otherwise.
	 */
	public function isProcessingEnabled();
	
}