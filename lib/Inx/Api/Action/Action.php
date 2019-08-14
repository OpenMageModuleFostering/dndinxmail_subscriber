<?php
/**
 * @package Inxmail
 * @subpackage Action
 */
/**
 * An <i>Inx_Api_Action_Action</i> is a powerful tool which can manipulate or send a mail to a recipient for which 
 * an event has occurred. To do so, an <i>Inx_Api_Action_Action</i> has a list of commands that will be executed 
 * when the event occurs. Using this pattern, complex actions may be created. An <i>Inx_Api_Action_Action</i> could, 
 * for example, be configured to respond automatically to flame mails.
 * <p>
 * <i>Inx_Api_Action_Action</i>s can be accessed using the <i>Inx_Api_Action_ActionManager</i>.
 * <p>
 * The different types of commands are:
 * <ul>
 * <li><i>Inx_Api_Action_DeleteRecipientCommand</i> - Permanently remove the recipient.
 * <li><i>Inx_Api_Action_SendMailCommand</i> - Send a mailing to the recipient.
 * <li><i>Inx_Api_Action_SendActionMailCommand</i> - Send an action mailing to the recipient.
 * <li><i>Inx_Api_Action_SetValueCommand</i> - Set an attribute value of the recipient.
 * <li><i>Inx_Api_Action_SubscriptionCommand</i> - Subscribe the recipient.
 * <li><i>Inx_Api_Action_UnsubscriptionCommand</i> - Unsubscribe the recipient.
 * </ul>
 * These commands are created by the <i>Inx_Api_Action_CommandFactory</i> which can be obtained from the 
 * <i>Inx_Api_Action_ActionManager</i>.
 * <p>
 * There are different event types which are triggered by inxmail.
 * <p>
 * System-wide events (the owner is the SystemListContext):
 * <ul>
 * <li>EVENT_TYPE_CLICK - A link in an email is clicked.
 * <li>EVENT_TYPE_HARD_BOUNCE - A hard bounce mail is received.
 * <li>EVENT_TYPE_SOFT_BOUNCE - A soft bounce mail is received.
 * <li>EVENT_TYPE_UNKNOWN_BOUNCE - An unknown mail is detected through the bounce mailbox.
 * <li>EVENT_TYPE_AUTO_RESPONDER_BOUNCE - An auto-responder mail is received through the bounce mailbox.
 * <li>EVENT_TYPE_AUTO_RESPONDER_REPLY - An auto-responder mail is received through the normal mailbox.
 * <li>EVENT_TYPE_FLAME_REPLY - A flame mail is received through the normal mailbox.
 * <li>EVENT_TYPE_UNKNOWN_REPLY - An unknown mail is detected through the normal mailbox.
 * </ul>
 * <p>
 * ListContext-specific events (the owner is a StandardListContext or a FilterListContext):
 * <ul>
 * <li>EVENT_TYPE_NEWSLETTER_SENT - A newsletter was sent.
 * <li>EVENT_TYPE_SINGLE_MAIL_SENT - A single mail was sent.
 * <li>EVENT_TYPE_SUBSCRIBE - A recipient was successfully subscribed.
 * <li>EVENT_TYPE_UNSUBSCRIBE - A recipient was successfully unsubscribed.
 * </ul>
 * <p>
 * Note: The usage of <i>Inx_Api_Action_Action</i>s requires the api user right: <i>Inx_Api_UserRights::ACTION_FEATURE_USE</i>
 * <p>
 * For an example on how to use actions, see the <i>Inx_Api_Action_ActionManager</i> documentation.
 * 
 * @see Inx_Api_Action_Command
 * @see Inx_Api_Action_ActionManager
 * @since API 1.2.0
 * @version $Revision: 9553 $ $Date: 2008-01-04 11:28:41 +0200 (Pn, 04 Sau 2008) $ $Author: vladas $
 * @package Inxmail
 * @subpackage Action
 */
interface Inx_Api_Action_Action extends Inx_Api_BusinessObject
{
    /**
     * Constant for the name attribute. 
     * Used by the <code>UpdateException</code> to indicate the error source.
	 */
    const ATTRIBUTE_NAME = 0;

    /**
     * Constant for the event type attribute. 
     * Used by the <code>UpdateException</code> to indicate the error source.
     */
    const ATTRIBUTE_EVENT_TYPE = 1;
    
    /**
     * Constant for the list context attribute. 
     * Used by the <code>UpdateException</code> to indicate the error source.
	 */
    const ATTRIBUTE_LIST_CONTEXT_ID = 2;
    
    /**
     * Constant for the commands attribute. 
     * Used by the <code>UpdateException</code> to indicate the error source.
	 */
    const ATTRIBUTE_COMMANDS = 3;
 
    
	/** Constant for event type: CLICK - A link in an email is clicked. */
	const EVENT_TYPE_CLICK = 1;

	/** Constant for event type: NEWSLETTER_SENT - A newsletter was sent. */
	const EVENT_TYPE_NEWSLETTER_SENT = 10;
	
	/** Constant for event type: SINGLE_MAIL_SENT - A single mail was sent. */
	const EVENT_TYPE_SINGLE_MAIL_SENT = 11;

	/** Constant for event type: HARD_BOUNCE - A hard bounce mail is received. */
	const EVENT_TYPE_HARD_BOUNCE = 20;
	
	/** Constant for event type: SOFT_BOUNCE - A soft bounce mail is received. */
	const EVENT_TYPE_SOFT_BOUNCE = 21;
	
	/** Constant for event type: UNKNOWN_BOUNCE - An unknown mail is detected through the bounce mailbox. */
	const EVENT_TYPE_UNKNOWN_BOUNCE = 22;
	
	/** Constant for event type: AUTO_RESPONDER_BOUNCE - An auto-responder mail is received through the bounce mailbox. */
	const EVENT_TYPE_AUTO_RESPONDER_BOUNCE = 23;

	/** Constant for event type: AUTO_RESPONDER_REPLY - An auto-responder mail is received through the normal mailbox. */
	const EVENT_TYPE_AUTO_RESPONDER_REPLY = 30;
	
	/** Constant for event type: FLAME_REPLY - A flame mail is received through the normal mailbox. */
	const EVENT_TYPE_FLAME_REPLY = 31;
	
	/** Constant for event type: UNKNOWN_REPLY - An unknown mail is detected through the normal mailbox. */
	const EVENT_TYPE_UNKNOWN_REPLY = 32;

	/** Constant for event type: SUBSCRIBE - A recipient was successfully subscribed. */
	const EVENT_TYPE_SUBSCRIBE = 40;
	
	/** Constant for event type: UNSUBSCRIBE - A recipient was successfully unsubscribed. */
	const EVENT_TYPE_UNSUBSCRIBE = 41;
    
    
    /**
     * Returns the unique name of this action.
     * 
     * @return	string the unique name of this action.
     */
    public function getName();
    
    
    /**
	 * Sets the name of this action.
	 * 
	 * @param string $sName	the unique name of this action.
	 */
	public function updateName( $sName );
	
    
	/**
	 * Returns the id of the list context which this action belongs to.
	 * 
	 * @return	int the id of the list context which this action belongs to.
	 */
	public function getListContextId();
    
	
    /**
     *  Returns the event type of this action. 
     *  Can be one of the event type constants defined in the <code>Action</code> interface.
     * 
     * @return	int the event type.
     */
    public function getEventType();
    
    
    /**
     * Sets the event type of this action. 
     * Can be one of the event type constants defined in the <code>Action</code> interface.
     * 
     * @param int $iEventType	the event type.
     */
    public function updateEventType( $iEventType );
    
    
    /**
     * Returns the commands this action will execute on the specified event.
     * 
     * @return	array the commands.
     */
    public function getCommands();

    
    /**
     * Sets the commands this action will execute on the specified event.
     * 
     * @param array $aCmds the commands.
     */
    public function updateCommands( $aCmds );

}
