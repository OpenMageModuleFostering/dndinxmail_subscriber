<?php
/**
 * @package Inxmail
 * @subpackage DataAccess
 */
/**
 * <i>Inx_Api_DataAccess_DataRowSet</i> provides a common interface for row set navigation. 
 * The most important methods of <i>Inx_Api_DataAccess_DataRowSet</i> are <i>next()</i> and <i>close()</i>. 
 * The <i>next()</i> method can be used to iterate over the rows of the row set. 
 * The following snippet shows how to iterate over an <i>Inx_Api_DataAccess_DataRowSet</i>:
 * 
 * <pre>
 * $oDataRowSet = ... //get an Inx_Api_DataAccess_DataRowSet implementation
 * 
 * while($oDataRowSet.next())
 * {
 *    //retrieve some information from the row set.
 * }
 * 
 * $oDataRowSet.close();
 * </pre>
 * 
 * Be sure to call <i>next()</i> before the first retrieval statement on the row set. Initially the cursor is
 * before the first row, thus no data can be retrieved from the row set before calling <i>next()</i>. Doing so
 * will trigger an Inx_Api_DataException.
 * <p>
 * <strong>Note:</strong> An <i>Inx_Api_DataAccess_DataRowSet</i> object <strong>must</strong> be closed once it is not 
 * needed anymore to prevent memory leaks and other potentially harmful side effects.
 * 
 * @version $Revision: 9482 $ $Date: 2007-12-18 16:42:11 +0200 (An, 18 Grd 2007) $ $Author: vladas $
 * @package Inxmail
 * @subpackage DataAccess
 */
interface Inx_Api_DataAccess_DataRowSet
{
	
    /**
     * Moves the cursor to the front of
     * this <i>Inx_Api_DataAccess_DataRowSet</i> object, just before the
     * first row. This method has no effect if the result set contains no rows.
     */
	public function beforeFirstRow();
	
    /**
     * Moves the cursor to the end of
     * this <i>Inx_Api_DataAccess_DataRowSet</i> object, just after the
     * last row. This method has no effect if the result set contains no rows.
     */
	public function afterLastRow();
	
    /**
     * Moves the cursor to the given row number in
     * this <i>Inx_Api_DataAccess_DataRowSet</i> object.
     * The first row is row 0, the second is row 1, and so on. 
     *
     * @param int $iRow the number of the row to which the cursor should move.
     */
	public function setRow( $iRow );

    /**
     * Retrieves the current row number. 
     * The first row is number 0, the second number 1, and so on.  
     *
     * @return int the current row number.
     */
    public function getRow();

    /**
     * Moves the cursor down one row from its current position.
     * An <i>Inx_Api_DataAccess_DataRowSet</i> cursor is initially positioned before the first row; 
     * the first call to the method <i>next()</i> makes the first row the current row; 
     * the second call makes the second row the current row, and so on. 
     *
     * @return bool <i>true</i> if the new current row is valid, <i>false</i> if there are no more rows. 
     */
    public function next();
    
    /**
     * Moves the cursor to the previous row in this <i>Inx_Api_DataAccess_DataRowSet</i> object.
     *
     * @return bool <i>true</i> if the new current row is valid, <i>false</i> if it is off the result set.
     */
    public function previous();
    
	/**
	 * Returns the number of rows in this <i>Inx_Api_DataAccess_DataRowSet</i> object.
	 *
	 * @return int the number of rows.
	 */
    public function getRowCount();  
    
    /**
     * Releases the resources associated with this <i>Inx_Api_DataAccess_DataRowSet</i> object on the server immediately.
     * <p>
     * An <i>Inx_Api_DataAccess_DataRowSet</i> object <strong>must</strong> be closed once it is not 
 	 * needed anymore to prevent memory leaks and other potentially harmful side effects.
     */	
    public function close();
    
}
