<?php
/**
 * @package Inxmail
 */
/**
 * An <i>Inx_Api_IllegalArgumentException</i> is thrown when wrong arguments are supplied. 
 * A common reason for this exception are data type issues. 
 * <p>
 * Example: Calling <i>Mailing->sendSingleMail("sample@invalid.inv")</i> will raise this exception, because 
 * <i>sendSingleMail()</i> expects a recipient id of type integer, not an email address string. 
 * @version $Revision: 9348 $ $Date: 2007-12-10 09:33:56 +0200 (Pr, 10 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 */
class Inx_Api_IllegalArgumentException extends Exception 
{
	
}