<?php
/**
 * @package Inxmail
 * @subpackage Action
 */
/**
 * The <i>Inx_Api_Action_CommandFactory</i> is a factory for creating <i>Inx_Api_Action_Command</i>s.
 * <p>
 * For an example on how to use commands and actions, see the <i>Inx_Api_Action_ActionManager</i> 
 * documentation.
 * 
 * @see Inx_Api_Action_Command
 * @see Inx_Api_Action_ActionManager
 * @since API 1.2.0
 * @version $Revision: 9553 $ $Date: 2008-01-04 11:28:41 +0200 (Pn, 04 Sau 2008) $ $Author: vladas $
 * @package Inxmail
 * @subpackage Action
 */
interface Inx_Api_Action_CommandFactory
{

	/**
	 * Creates a new <i>Inx_Api_Action_DeleteRecipientCommand</i> that will delete the recipient permanently 
	 * from the system.
	 * 
	 * @return Inx_Api_Action_DeleteRecipientCommand a new <i>Inx_Api_Action_DeleteRecipientCommand</i>.
	 */
	public function createDeleteRecipientCmd();
	
	
	/**
	 * Creates an <i>Inx_Api_Action_SetValueCommand</i> which sets a value based on an expression. 
	 * The expression must begin with an equal sign. The data type of the expression must be the same as the 
	 * data type of the specified attribute.
	 * <p>
	 * See the Inxmail client documentation for a detailed description.
	 * 
	 * <PRE>
	 * $oFactory->createSetValueCmd( $oDatetimeAttr->getId(), "=Date()" );
	 * </PRE>
	 * 
	 * @param int $iAttributeId the id of the user attribute.
	 * @param string $sExpression an expression that sets the value of the attribute.
	 * @return Inx_Api_Action_SetValueCommand a new <i>Inx_Api_Action_SetValueCommand</i>.
	 * @see Inx_Api_Recipient_Attribute
	 */
	public function createSetValueCmd( $iAttributeId, $sExpression );

	
	/**
	 * Creates an <i>Inx_Api_Action_SetValueCommand</i> which sets an absolute value. 
	 * Some examples for allowed values, dependent on the data type: <br>
	 * <ul>
	 * <li>DataType.TEXT     - "Text", null
	 * <li>DataType.INTEGER  - "12", "-3", null
	 * <li>DataType.DOUBLE   - "3.4", "-1.25", null
	 * <li>DataType.BOOLEAN  - "TRUE", "FALSE"
	 * <li>DataType.DATETIME - "31.12.2006 23:45:00"; (dd.MM.yyyy HH:mm:ss or dd.MM.yyyy HH:mm), null
	 * <li>DataType.DATE     - "31.12.2006"; (dd.MM.yyyy), null
	 * <li>DataType.TIME     - "23:45:00"; (HH:mm:ss or HH:mm), null
	 * </ul>
	 * 
	 * @param int $iAttributeId the id of the user attribute.
	 * @param string $sAbsoluteValue an absolute value for the attribute.
	 * @return Inx_Api_Action_SetValue_Command a new <i>Inx_Api_Action_SetValueCommand</i>.
	 * @see Inx_Api_Recipient_Attribute
	 */
	public function createSetAbsoluteValueCmd( $iAttributeId, $sAbsoluteValue );

	
	/**
	 * Creates an <i>Inx_Api_Action_SetValueCommand</i> which sets a relative value. 
	 * Examples for allowed values, dependent on the data type: <br>
	 * <ul>
	 * <li>DataType.TEXT    - "3", "-10"
	 * <li>DataType.INTEGER - "12", "-3"
	 * <li>DataType.DOUBLE  - "3.4", "-1.25"
	 * </ul>
	 * <p>
	 * You might wonder why text attributes can be incremented/decremented. This is a convenience for attributes that
	 * are numbers by nature but have the type text. DO NOT use this method for changing real text attributes, as this
	 * will overwrite the value.
	 * 
	 * @param int $iAttributeId the id of the user attribute.
	 * @param string $sRelativeValue a relative value for the attribute that can be positive (increment) or negative 
	 * 			(decrement).
	 * @return Inx_Api_Action_SetValueCommand a new <i>Inx_Api_Action_SetValueCommand</i>.
	 * @see Inx_Api_Recipient_Attribute
	 */
	public function createSetRelativeValueCmd( $iAttributeId, $sRelativeValue );
	

	/**
	 * Creates an <i>Inx_Api_Action_SubUnsubscriptionCommand</i> which subscribes the recipient to the specified 
	 * standard list.
	 * 
	 * @param int $iListContextId the id of the standard list context to which to subscribe to.
	 * @param bool $blSubscriptionProcessingEnabled true if subscription processing is enabled, false if direct (forced)
	 *            subscription is used. If processing and double opt in (DOI) are enabled, this will send a verification 
	 *            email to the recipient.
	 * @return Inx_Api_Action_SubUnsubscriptionCommand a new <i>Inx_Api_Action_SubUnsubscriptionCommand</i>.
	 * @deprecated use createSubscriptionCmd2(int, bool) instead.
	 */
	public function createSubscriptionCmd( $iListContextId,	$blSubscriptionProcessingEnabled );

	
	/**
	 * Creates an <i>Inx_Api_Action_SubUnsubscriptionCommand</i> which unsubscribes the recipient from the 
	 * specified standard list.
	 * 
	 * @param int $iListContextId the id of the standard list context from which to unsubscribe from.
	 * @param bool $blSnsubscriptionProcessingEnabled true if unsubscription processing is enabled, false if direct 
	 * 			(forced) unsubscription is used. If processing and double opt out (DOO) are enabled, this will send 
	 * 			a verification email to the recipient.
	 * @return Inx_Api_Action_SubUnsubscriptionCommand a new <i>Inx_Api_Action_SubUnsubscriptionCommand</i>.
	 * @deprecated use createUnsubscriptionCmd2(int, bool) instead.
	 */
	public function createUnsubscriptionCmd( $iListContextId, $blSnsubscriptionProcessingEnabled );
	
	
	/**
	 * Creates an <i>Inx_Api_Action_SubUnsubscriptionCommand</i> which unsubscribes the recipient from all standard 
	 * lists.
	 * 
	 * @return Inx_Api_Action_SubUnsubscriptionCommand a new <i>Inx_Api_Action_SubUnsubscriptionCommand</i>.
	 * @deprecated use createUnsubscribeAllCmd2() instead.
	 */
	public function createUnsubscribeAllCmd();

	
	/**
	 * Creates an <i>Inx_Api_Action_SubscriptionCommand</i> which subscribes the recipient to the specified 
	 * standard list.
	 * 
	 * @param int $iListContextId the id of the standard list context to which to subscribe to.
	 * @param bool $blSubscriptionProcessingEnabled true if subscription processing is enabled, false if direct 
	 * 			(forced) subscription is used. If processing and double opt in (DOI) are enabled, this will send 
	 * 			a verification email to the recipient.
	 * @return Inx_Api_Action_SubscriptionCommand a new <i>Inx_Api_Action_SubscriptionCommand</i>.
	 * @since API 1.6.0
	 */
	public function createSubscriptionCmd2( $iListContextId,
			$blSubscriptionProcessingEnabled );

	
	/**
	 * Creates an <i>Inx_Api_Action_UnsubscriptionCommand</i> which unsubscribes the recipient from the 
	 * specified standard list.
	 * 
	 * @param int $iListContextId the id of the standard list context from which to unsubscribe from.
	 * @param bool $blSnsubscriptionProcessingEnabled true if unsubscription processing is enabled, false if 
	 * 			direct (forced) unsubscription is used. If processing and double opt out (DOO) are enabled, 
	 * 			this will send a verification email to the recipient.
	 * @return Inx_Api_Action_UnsubscriptionCommand a new <i>Inx_Api_Action_UnsubscriptionCommand</i>.
	 * @since API 1.6.0
	 */
	public function createUnsubscriptionCmd2( $iListContextId,
			$blSnsubscriptionProcessingEnabled );
	
	
	/**
	 * Creates an <i>Inx_Api_Action_UnsubscriptionCommand</i> which unsubscribes the recipient from all 
	 * standard lists.
	 * 
	 * @return Inx_Api_Action_UnsubscriptionCommand a new <i>Inx_Api_Action_UnsubscriptionCommand</i>.
	 * @since API 1.6.0
	 */
	public function createUnsubscribeAllCmd2();
		
	
	
	/**
	 * Creates an <i>Inx_Api_Action_SendMailCommand</i> which sends the last newsletter from the 
	 * specified list context to the recipient.
	 * 
	 * @param int $iListContextId the id of the standard or filter list context.
	 * @return Inx_Api_Action_SendMailCommand	a new <i>Inx_Api_Action_SendMailCommand</i>.
	 */
	public function createSendLastNewsletterCmd( $iListContextId );
	
	
	/**
	 * Creates an <i>Inx_Api_Action_SendMailCommand</i> which sends the specified mailing from the 
	 * corresponding list context to the recipient.
	 * 
	 * @param int $iListContextId the id of the standard or filter list context containing the mailing.
	 * @param int $iMailingId the id of the mailing to send.
	 * @return Inx_Api_Action_SendMailCommand	a new <i>Inx_Api_Action_SendMailCommand</i>.
	 */
	public function createSendMailCmd( $iListContextId, $iMailingId );

        /**
	 * Creates an <i>Inx_Api_Action_SendActionMailCommand</i> which sends the specified action mailing 
         * from the corresponding list context to the recipient.
	 * 
	 * @param int $iListContextId id of the standard or filter list context containing the action mailing.
	 * @param int $iActionMailingId the id of the action mailing to send.
	 * @return Inx_Api_Action_SendActionMailCommand a new <i>Inx_Api_Action_SendActionMailCommand</i>.
	 * @since API 1.10.0
	 */
	public function createSendActionMailCmd( $iListContextId, $iActionMailingId );
}
