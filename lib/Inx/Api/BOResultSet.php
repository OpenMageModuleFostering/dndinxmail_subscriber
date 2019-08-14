<?php
/**
 * @package Inxmail
 */
/**
 * An <i>Inx_Api_BOResultSet</i> is a list of <i>Inx_Api_BusinessObject</i>s. 
 * The result set can be used to browse through this list, and to remove elements of the list.
 * <p>
 * <strong>Note:</strong> An <i>Inx_Api_BOResultSet</i> object <strong>must</strong> be closed once it is not needed
 * anymore to prevent memory leaks and other potentially harmful side effects.
 *
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 */
interface Inx_Api_BOResultSet
{

	/**
	 * Returns the <i>Inx_Api_BusinessObject</i> with the specified index.
	 * 
	 * @param int $iIndex	the index of the <i>Inx_Api_BusinessObject</i> to retrieve in this result set.
	 * @return	Inx_Api_BusinessObject	the <i>Inx_Api_BusinessObject</i> with the specified index.
	 * @throws Inx_Api_DataException if no <i>Inx_Api_BusinessObject</i> could be found (e.g. the object was deleted).
	 */
	public function get( $iIndex );

	
    /**
     * Returns the number of business objects in this result set.
     * 
     * @return int	the number of business objects.
     */
    public function size();

    
    /**
     * Removes all business objects that are selected. The method returns true if and only if all selected elements 
     * have been removed. In some case it is possible that some elements cannot be removed (e.g. 
     * Inx_Api_List_SystemListContext, Properties, ... ). 
     * 
     * @param Inx_Api_IndexSelection $oSelection the selection of business objects to be removed.
     *
     * @return boolean true, if and only if the removing succeeded; false otherwise.
     * 
     */
    public function remove( Inx_Api_IndexSelection $oSelection );

    
    /**
     * Closes this result set and releases any resources associated with the result set. 
     * An <i>Inx_Api_BOResultSet</i> object <strong>must</strong> be closed once it is not needed anymore to prevent 
     * memory leaks and other potentially harmful side effects.
     */
    public function close();

}
