<?php
/**
 * @package Inxmail
 */
/**
 * An <i>Inx_Api_FeatureNotAvailableException</i> is thrown when a feature is not available or not enabled in a list.
 * <p>
 * Example: Calling <i>Inx_Api__List_ListContext->enableFeature(Features::SUBSCRIPTION_FEATURE_ID)</i> on a dynamic 
 * list will raise a <i>FeatureNotAvailableException</i>. The same is true wehn calling 
 * <i>Inx_Api_Subscription_SubscriptionManager->processSubscription()</i> for a list with disabled subscription feature.
 * 
 * @see Inx_Api_List_ListContext#enableFeature(int)
 * @see Inx_Api_List_ListContext#disableFeature(int)
 * @see Inx_Api_Subscription_SubscriptionManager#processSubscription(Inx_Api_List_StandardListContext, String)
 * @see Inx_Api_Subscription_SubscriptionManager#processUnsubscription(Inx_Api_List_StandardListContext, String)
 * @version $Revision: 9482 $ $Date: 2007-12-18 16:42:11 +0200 (An, 18 Grd 2007) $ $Author: vladas $
 * @package Inxmail
 */
class Inx_Api_FeatureNotAvailableException extends Inx_Api_APIException
{
    
}
