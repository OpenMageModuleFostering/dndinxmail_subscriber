<?php
/**
 * @package Inxmail
 * @subpackage Action
 */
/**
 * Use the <i>Inx_Api_Action_SendMailCommand</i> to send a mailing to a recipient. 
 * This command can be configured to either send a specific mailing or to send the last mailing 
 * (newsletter) in the recipients list.
 * 
 * @see Inx_Api_Action_CommandFactory
 * @since API 1.2.0
 * @version $Revision: 9482 $ $Date: 2007-12-18 16:42:11 +0200 (An, 18 Grd 2007) $ $Author: vladas $
 * @package Inxmail
 * @subpackage Action
 */
interface Inx_Api_Action_SendMailCommand extends Inx_Api_Action_Command
{
	
	/**
	 * Command type: Send a specific mailing.
	 */
	const CMD_TYPE_SPECIFIC_MAILING = 0;

	/**
	 * Command type: Send the last newsletter.
	 */
	const CMD_TYPE_LAST_MAILING = 1;


	/**
	 * Returns the command type: Inx_Api_Action_SendMailCommand::CMD_TYPE_SPECIFIC_MAILING or 
	 * Inx_Api_Action_SendMailCommand::CMD_TYPE_LAST_MAILING.
	 * 
	 * @return int the command type.
	 */
	public function getCmdType();

	
	/**
	 * Returns the id of the standard or filter list context associated with this command.
	 * 
	 * @return int the id of the list context
	 */
	public function getListContextId();
	

	/**
	 * Returns the id of the mailing associated with this command. Only specified if the command type is
	 * Inx_Api_Action_SendMailCommand::CMD_TYPE_SPECIFIC_MAILING.
	 * 
	 * @return int the id of the mailing.
	 */
	public function getMailingId();
	
}
