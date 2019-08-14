<?php
/**
 * @package Inxmail
 */
/**
 * The <i>Inx_Api_BOManager</i> interface defines the basic requirements of a business object manager, including retrieval
 * and removal of the managed objects.
 * @package Inxmail
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 */
interface Inx_Api_BOManager
{

	/**
	 * Returns the <i>Inx_Api_BusinessObject</i> with the specified id.
	 * 
	 * @param int $iId	the id of the <i>Inx_Api_BusinessObject</i> to retrieve.
	 * @return Inx_Api_BusinessObject the <i>Inx_Api_BusinessObject</i>.
	 * @throws Inx_Api_DataException if no <i>Inx_Api_BusinessObject</i> could be found (e.g. the object was deleted).
	 */
	public function get( $iId );

	
	/**
	 * Removes the <i>Inx_Api_BusinessObject</i> with the specified id.
	 * 
	 * @param int $iId	the id of the <i>Inx_Api_BusinessObject</i> to be removed.
	 * @return boolean	true, if and only if the removing succeeded; false otherwise (e.g. the object was already deleted).
	 */
	public function remove( $iId );

	
	/**
	 * Returns an <i>Inx_Api_BOResultSet</i> containing all managed <i>Inx_Api_BusinessObject</i>s.
	 * For Inx_Api_Blacklist_BlacklistManager and Inx_Api_Resource_ResourceManager two params can be specified:
	 * 1. int $iOrderAttribute  the order attribute id.
	 * 2. the order type (<i>Inx_Api_Order::ASC</i> or <i>Inx_Api_Order::DESC</i>).
	 * 
	 * @return Inx_Api_BOResultSet an <i>Inx_Api_BOResultSet</i> containing all managed <i>Inx_Api_BusinessObject</i>s.
	 */
	public function selectAll();
	
}
