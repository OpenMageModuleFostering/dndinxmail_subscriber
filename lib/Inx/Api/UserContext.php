<?php
/**
 * @package Inxmail
 */

/**
 * The <i>Inx_Api_UserContext</i> allows to check the rights of the currently logged in user and gives access to the 
 * <i>Inx_Api_user</i> object.
 * 
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 */
interface Inx_Api_UserContext
{
    
    /**
     * Checks if the currently logged in user has the specified user right. 
     * 
     * @param	string	$sUserRight the user right (Inx_Api_UserRights) to be checked.
     * @return	boolean	true, if the user has the right; false, otherwise.
     * @see Inx_Api_UserRights
     */
    public function hasUserRight( $sUserRight );

    
    /**
     * Refreshes this <i>Inx_Api_UserContext</i>. 
     * Reloads the newest user rights from the server.
     */
    public function refresh();


    /**
     * Returns the timestamp from the last refresh.
     * 
     * @return int the timestamp from the last refresh.
     */
    public function getLastRefresh();
    
    /**
	 * Returns the currently logged in <i>Inx_Api_User</i>.
	 * 
	 * @return Inx_Api_User the currently logged in <i>Inx_Api_User</i>.
	 * @since API 1.7.0
	 */
	public function whoAmI();

}
