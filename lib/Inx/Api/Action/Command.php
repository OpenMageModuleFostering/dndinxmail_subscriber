<?php
/**
 * @package Inxmail
 * @subpackage Action
 */
/**
 * The <i>Inx_Api_Action_Command</i> interface identifies commands which are executed by an <i>Inx_Api_Action_Action</i> 
 * when the event associated with the action is triggered. 
 * <i>Inx_Api_Action_Command</i>s can be used to manipulate a recipient or to send a single mailing to that recipient.
 * <p>
 * The different types of commands are:
 * <ul>
 * <li><i>Inx_Api_Action_DeleteRecipientCommand</i> - Permanently remove the recipient.
 * <li><i>Inx_Api_Action_SendMailCommand</i> - Send a mailing to the recipient.
 * <li><i>Inx_Api_Action_SetValueCommand</i> - Set an attribute value of the recipient.
 * <li><i>Inx_Api_Action_SubscriptionCommand</i> - Subscribe the recipient.
 * <li><i>Inx_Api_Action_UnsubscriptionCommand</i> - Unsubscribe the recipient.
 * </ul>
 * <p>
 * For an example on how to use commands and actions, see the <i>Inx_Api_Action_ActionManager</i> documentation.
 * 
 * @see Inx_Api_Action_Action
 * @see Inx_Api_Action_ActionManager
 * @since API 1.2.0
 * @version $Revision: 9553 $ $Date: 2008-01-04 11:28:41 +0200 (Pn, 04 Sau 2008) $ $Author: vladas $
 * @package Inxmail
 * @subpackage Action
 */
interface Inx_Api_Action_Command
{

}
