<?php
/**
 * @package Inxmail
 */
/**
 * An <i>Inx_Api_IndexOutOfBoundsException</i> is thrown when trying to access an invalid index of an 
 * indexed object. This applies mainly to the various RowSets and ResultSets used in the API.
 * <p>
 * Example: 
 * <pre>
 * $rset = Inx_Api_Mailing_MailingManager->selectAll();
 * 
 * for($i = -1; $i <= rest->size(); $i++)
 * {
 * 	   echo $rset->get($i)->getName();
 * }
 * </pre>
 * This code snippet contains two errors: The first index retrieved is -1 and the last index retrieved is 
 * rset->size(). -1 is no valid index as the first element of a ResultSet has the index 0. As the first 
 * valid index is 0, the last valid index is rset->size() - 1. Therefore, these errors will raise an 
 * <i>Inx_Api_IndexOutOfBoundsException</i>.
 * @package Inxmail
 */
class Inx_Api_IndexOutOfBoundsException extends Exception
{
	
}

?>