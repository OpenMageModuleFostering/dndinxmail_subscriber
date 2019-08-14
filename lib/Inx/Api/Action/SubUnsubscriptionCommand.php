<?php
/**
 * @package Inxmail
 * @subpackage Action
 */
/**
 * Use the <i>Inx_Api_Action_SubUnsubscriptionCommand</i> to subscribe/unsubscribe a recipient to/from the specified standard
 * list (CMD_TYPE_SUBSCRIBE and CMD_TYPE_UNSUBSCRIBE) or unsubscribe a recipient from all standard lists (MD_TYPE_UNSUBSCRIBE_ALL).
 * 
 * @see Inx_Api_Action_CommandFactory
 * @since API 1.2.0
 * @version $Revision$ $Date$ $Author$
 * @deprecated Use <i>Inx_Api_Action_SubscriptionCommand</i> and <i>Inx_Api_Action_UnsubscriptionCommand</i> instead.
 */
interface Inx_Api_Action_SubUnsubscriptionCommand extends Inx_Api_Action_Command
{
	/**
	 * Command type: Subscribe to a standard list.
	 */
	const CMD_TYPE_SUBSCRIBE = 0;

	/**
	 * Command type: Unsubscribe from a standard list.
	 */
	const CMD_TYPE_UNSUBSCRIBE = 1;

	/**
	 * Command type: Unsubscribe from all standard lists.
	 */
	const CMD_TYPE_UNSUBSCRIBE_ALL = 2;

	
	/**
	 * Returns the id of the list context. Only specified if the command type
	 * is CMD_TYPE_SUBSCRIBE or CMD_TYPE_UNSUBSCRIBE.
	 * 
	 * @return int the id of the list context.
	 */
	public function getListContextId();
	
	
	/**
	 * Returns the command type: 
	 * Inx_Api_Action_SubUnsubscriptionCommand::CMD_TYPE_SUBSCRIBE, 
	 * Inx_Api_Action_SubUnsubscriptionCommand::CMD_TYPE_UNSUBSCRIBE or
	 * Inx_Api_Action_SubUnsubscriptionCommand::CMD_TYPE_UNSUBSCRIBE_ALL
	 * 
	 * @return int the command type.
	 */
	public function getCmdType();
	
	
	/**
	 * Specifies if the subscription/unsubscription processing is enabled or the recipient will be
	 * subscribed/unsubscribed directly. If processing and double opt in (DOI) / double opt out (DOO) are enabled, this
	 * will send a verification email to the recipient.
	 * 
	 * @return bool true if the subscription/unsubscription processing is enabled, false otherwise.
	 */
	public function isProcessingEnabled();
	
}