<?php
/**
 * @package Inxmail
 */
/**
 * An <i>Inx_Api_NameException</i> is thrown when a specified name (e.g. attribute name) is invalid or already used.
 * 
 * @see	Inx_Api_Recipient_AttributeManager#create(string, int, int)
 * @since   API 1.0
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 */
class Inx_Api_NameException extends Exception
{
	/** Type indicating that the specified name is already used. */
	const DUPLICATE_NAME = 100;
	
	/** Type indicating that the specified name is invalid. */
	const ILLEGAL_NAME = 101;
}
