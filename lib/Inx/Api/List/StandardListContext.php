<?php
/**
 * @package Inxmail
 * @subpackage List
 */
/**
 * An <i>Inx_Api_List_StandardListContext</i> represents a normal mailing list. 
 * Recipients can subscribe or unsubscribe from the list using landing pages and links. 
 * Manual subscription and unsubscription of recipients can be accomplished using the 
 * <i>Inx_Api_Subscription_SubscriptionManager</i>.
 * 
 * @since API 1.0
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 * @subpackage List
 */
interface Inx_Api_List_StandardListContext extends Inx_Api_List_ListContext
{

	/**
	 * Changes the list name. The list will not be updated on the server until <i>commitUpdate()</i> has been called.
	 * 
	 * @param string $sName	the new list name.
	 */
    public function updateName( $sName );

}
