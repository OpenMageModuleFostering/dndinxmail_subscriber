<?php
/**
 * @package Inxmail
 */
/**
 * An <i>Inx_Api_LoginException</i> is thrown by login methods if the login process failed.
 * 
 * @see	    Inx_Api_Session#createLocalSession(String, String)
 * @see	    Inx_Api_Session#createRemoteSession(String, String, String)
 * @since   API 1.0
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 */
class Inx_Api_LoginException extends Exception
{
	/** 
	 * System exception: The server isn't running, too many sessions are opened, no valid license can be found or the
	 * api is incompatible to the server version.
	 */
	const SYSTEM_EXCEPTION = 1000;

	/** An illegal username or password was specfied. */
	const ILLEGAL_USERNAME_OR_PASSWORD = 1001;

	/**
	 * The specified user is inactive, the login right for the specified user is missing or access is denied from the ip
	 * filter.
	 */
	const USER_EXCEPTION = 1002;

	/**
	 * The password expiration is elapsed.
	 * @since 1.4.2
	 */	
	const PWD_VALIDITY_EXPIRATION = 1003;
	
	/**
	 * The user is forced to change his password by the administrator.
	 * @since 1.4.2
	 */	
	const PWD_FORCED_CHANGE = 1004;
	
	/**
	* The specified user has insufficient permissions.
	*
	* @since 1.9.0
	*/
	const MISSING_PERMISSIONS = 1010;
	
	/**
	 * The specified Plugin (secret) could not be found.
	 *
	 * @since 1.9.0
	 */
	const MISSING_PLUGIN = 1011;
}
