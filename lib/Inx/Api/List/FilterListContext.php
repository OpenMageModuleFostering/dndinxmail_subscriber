<?php
/**
 * @package Inxmail
 * @subpackage List
 */
/**
 * An <i>Inx_Api_List_FilterListContext</i> represents a mailing list with no permanent recipients. 
 * The recipients of a filter list are computed based on a filter. 
 * All recipients that match that filter are recipients of the filter list. 
 * The recipients are computed each time a mailing is sent.
 * <p>
 * For a detailed description of the filter statement syntax, see the documentation of
 * <i>Inx_Api_Filter_Filter->updateStatement(String)</i>;
 * 
 * @see Inx_Api_Filter_Filter::updateStatement(String)
 * @since API 1.0
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 * @subpackage List
 */
interface Inx_Api_List_FilterListContext extends Inx_Api_List_ListContext
{
    /**
	 * Constant for the filter statement attribute. 
	 * Used by the <i>Inx_Api_UpdateException</i> to indicate the error source.
	 * 
	 * @see Inx_Api_UpdateException::getErrorSource()
	 */
	const ATTRIBUTE_FILTER_STMT = 4;

	
	/**
	 * Changes the list name. 
	 * The list will not be updated on the server until <i>commitUpdate()</i> has been called.
	 * 
	 * @param string $sName	the new list name.
	 */
	public function updateName( $sName );

	
	/**
	 * Returns the filter statement.
	 * 
	 * @return string the filter statement.
	 */
	public function getFilterStmt();
	
	
	/**
	 * Changes the filter statement. The list will not be updated on server until <i>commitUpdate()</i> has been called. 
	 * For a detailed description of the filter statement syntax, see the documentation of
	 * <i>Inx_Api_Filter_Filter->updateStatement(String)</i>
	 * 
	 * @param string $sFilterStmt	the new filter statement.
	 * @see Inx_Api_Filter_Filter::updateStatement(String)
	 */
	public function updateFilterStmt( $sFilterStmt );

}
