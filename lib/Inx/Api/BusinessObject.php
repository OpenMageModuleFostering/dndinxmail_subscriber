<?php
/**
 * @package Inxmail
 */
/**
 * The API gives access to objects of Inxmail, which are called "BusinessObjects".
 * For example, a mailing lists in Inxmail is such a Business Object.
 *
 * Values <i>of Inx_Api_BusinessObject</i>s can be changed with the "update" methods
 * (like <i>updateName()</i>). By calling <i>commitUpdate()</i> on such an object, 
 * changes will be passed to the server. Rollback is done by the <i>reload()</i> 
 * method, which reloads the object and discards all uncomitted changes. 
 * 
 * @version $Revision: 9482 $ $Date: 2007-12-18 16:42:11 +0200 (An, 18 Grd 2007) $ $Author: vladas $
 * @package Inxmail
 */
interface Inx_Api_BusinessObject
{

	/**
	 * Returns the unique identifier of this <i>Inx_Api_BusinessObject</i>.
	 * 
	 * @return int the unique identifier.
	 */
	public function getId();

    
	/**
	 * Passes all changes made since the last commit to the server.
	 * 
	 * @throws Inx_Api_UpdateException if the update failed (e.g. one of the attributes is illegal).
	 * @throws Inx_Api_DataException	if this business object could not be found on the server (e.g. the object was deleted).
	 */
	public function commitUpdate();

	
	/**
	 * Reloads this business object from the server. All changes uncomitted changes are lost.
	 * 
	 * @throws Inx_Api_DataException	if this business object could not be found on the server (e.g. the object was deleted).
	 */
	public function reload();

}
