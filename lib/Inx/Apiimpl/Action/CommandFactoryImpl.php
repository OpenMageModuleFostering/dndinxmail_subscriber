<?php

/**
 * <code>CommandFactoryImpl</code>
 * 
 * @since API 1.2.0
 * @version $Revision: 9739 $ $Date: 2008-01-23 14:44:04 +0200 (Tr, 23 Sau 2008) $ $Author: aurimas $
 */
class Inx_Apiimpl_Action_CommandFactoryImpl implements Inx_Api_Action_CommandFactory
{

	/**
	 * @see com.inxmail.xpro.api.action.CommandFactory#createDeleteRecipientCmd()
	 */
	public function createDeleteRecipientCmd()
	{
		return new Inx_Apiimpl_Action_CommandImpl_RemoveRecipientCmd();
	}
	
	/**
	 * @see com.inxmail.xpro.api.action.CommandFactory#createSetValueCmd(int, java.lang.String)
	 */
	public function createSetValueCmd( $iAttributeId, $sExpression )
	{
	    if (!is_int($iAttributeId)) {
	        throw new Inx_Api_IllegalArgumentException('Integer $iAttributeId argument expected');
	    }
	    return new Inx_Apiimpl_Action_CommandImpl_SetValueCmd( $iAttributeId,
				Inx_Apiimpl_Action_CommandImpl_SetValueCmd::CMD_TYPE_FREE_EXPRESSION, $sExpression );
	}
	
	/**
	 * @see com.inxmail.xpro.api.action.CommandFactory#createSetAbsoluteValueCmd(int, java.lang.String)
	 */
	public function createSetAbsoluteValueCmd( $iAttributeId, $sAbsoluteValue )
	{
	    if (!is_int($iAttributeId)) {
	        throw new Inx_Api_IllegalArgumentException('Integer $iAttributeId argument expected');
	    }
		return new Inx_Apiimpl_Action_CommandImpl_SetValueCmd( $iAttributeId,
				Inx_Apiimpl_Action_CommandImpl_SetValueCmd::CMD_TYPE_ABSOLUTE, $sAbsoluteValue );
	}
	
	/**
	 * @see com.inxmail.xpro.api.action.CommandFactory#createSetRelativeValueCmd(int, java.lang.String)
	 */
	public function createSetRelativeValueCmd( $iAttributeId, $sRelativeValue )
	{
	    if (!is_int($iAttributeId)) {
	        throw new Inx_Api_IllegalArgumentException('Integer $iAttributeId argument expected');
	    }
	    return new Inx_Apiimpl_Action_CommandImpl_SetValueCmd( $iAttributeId,
				Inx_Apiimpl_Action_CommandImpl_SetValueCmd::CMD_TYPE_RELATIVE, $sRelativeValue );
	}

	/**
	 * @see com.inxmail.xpro.api.action.CommandFactory#createSubscriptionCmd(int, boolean)
	 */
	public function createSubscriptionCmd( $iListContextId,	$blSubscriptionProcessingEnabled )
	{
	    if (!is_int($iListContextId)) {
	        throw new Inx_Api_IllegalArgumentException('Integer $iListContextId argument expected');
	    }
		return new Inx_Apiimpl_Action_CommandImpl_SubUnsubscriptionCmd( $iListContextId,
				Inx_Apiimpl_Action_CommandImpl_SubUnsubscriptionCmd::CMD_TYPE_SUBSCRIBE, $blSubscriptionProcessingEnabled );
	}

	/**
	 * @see com.inxmail.xpro.api.action.CommandFactory#createUnsubscriptionCmd(int, boolean)
	 */
	public function createUnsubscriptionCmd( $iListContextId, $blUnsubscriptionProcessingEnabled )
	{
		if (!is_int($iListContextId)) {
	        throw new Inx_Api_IllegalArgumentException('Integer $iListContextId argument expected');
	    }
		return new Inx_Apiimpl_Action_CommandImpl_SubUnsubscriptionCmd( $iListContextId,
				Inx_Apiimpl_Action_CommandImpl_SubUnsubscriptionCmd::CMD_TYPE_UNSUBSCRIBE, $blUnsubscriptionProcessingEnabled );
	}
	
	/**
	 * @see com.inxmail.xpro.api.action.CommandFactory#createUnsubscribeAllCmd()
	 */
	public function createUnsubscribeAllCmd()
	{
		return new Inx_Apiimpl_Action_CommandImpl_SubUnsubscriptionCmd( 
		        Inx_Apiimpl_Constants::SYSTEM_LIST_CONTEXT_ID,
				Inx_Apiimpl_Action_CommandImpl_SubUnsubscriptionCmd::CMD_TYPE_UNSUBSCRIBE_ALL, false );
	}

	
	
	
	/**
	 * @see com.inxmail.xpro.api.action.CommandFactory#createSubscriptionCmd2(int, boolean)
	 */
	public function createSubscriptionCmd2( $iListContextId,	$blSubscriptionProcessingEnabled )
	{
	    if (!is_int($iListContextId)) {
	        throw new Inx_Api_IllegalArgumentException('Integer $iListContextId argument expected');
	    }
		return new Inx_Apiimpl_Action_CommandImpl_SubscriptionCmd( $iListContextId,
				Inx_Apiimpl_Action_CommandImpl_SubscriptionCmd::CMD_TYPE_SUBSCRIBE, $blSubscriptionProcessingEnabled );
	}

	/**
	 * @see com.inxmail.xpro.api.action.CommandFactory#createUnsubscriptionCmd2(int, boolean)
	 */
	public function createUnsubscriptionCmd2( $iListContextId, $blUnsubscriptionProcessingEnabled )
	{
		if (!is_int($iListContextId)) {
	        throw new Inx_Api_IllegalArgumentException('Integer $iListContextId argument expected');
	    }
		return new Inx_Apiimpl_Action_CommandImpl_UnsubscriptionCmd( $iListContextId,
				Inx_Apiimpl_Action_CommandImpl_UnsubscriptionCmd::CMD_TYPE_UNSUBSCRIBE, $blUnsubscriptionProcessingEnabled );
	}
	
	/**
	 * @see com.inxmail.xpro.api.action.CommandFactory#createUnsubscribeAllCmd2()
	 */
	public function createUnsubscribeAllCmd2()
	{
		return new Inx_Apiimpl_Action_CommandImpl_UnsubscriptionCmd( 
		        Inx_Apiimpl_Constants::SYSTEM_LIST_CONTEXT_ID,
				Inx_Apiimpl_Action_CommandImpl_UnsubscriptionCmd::CMD_TYPE_UNSUBSCRIBE_ALL, false );
	}	
	
	
	
	/**
	 * @see com.inxmail.xpro.api.action.CommandFactory#createSendLastNewsletterCmd(int)
	 */
	public function createSendLastNewsletterCmd( $iListContextId )
	{
		if (!is_int($iListContextId)) {
	        throw new Inx_Api_IllegalArgumentException('Integer $iListContextId argument expected');
	    }
	    return new Inx_Apiimpl_Action_CommandImpl_SendMailCmd( $iListContextId );
	}
	
	/**
	 * @see com.inxmail.xpro.api.action.CommandFactory#createSendMailCmd(int, int)
	 */
	public function createSendMailCmd( $iListContextId, $iMailingId )
	{
		if (!is_int($iListContextId)) {
	        throw new Inx_Api_IllegalArgumentException('Integer $iListContextId argument expected');
	    }
	    return new Inx_Apiimpl_Action_CommandImpl_SendMailCmd( $iListContextId, $iMailingId );
	}
        
        /**
	 * @see Inx_Api_Action_CommandFactory::createSendActionMailCmd
	 */
	public function createSendActionMailCmd( $iListContextId, $iActionMailingId )
	{
            return new Inx_Apiimpl_Action_CommandImpl_SendActionMailCmd($iListContextId, $iActionMailingId);
	}
}
