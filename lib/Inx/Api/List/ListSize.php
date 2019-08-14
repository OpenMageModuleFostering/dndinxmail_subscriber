<?php
/**
 * @package Inxmail
 * @subpackage List
 */
/**
 * The <i>Inx_Api_List_ListSize</i> object contains the list size and the computation date of the size.
 * 
 * @since API 1.4.3
 * @package Inxmail
 * @subpackage List
 */
interface Inx_Api_List_ListSize
{
	/**
	 * Returns the number of recipients that are subscribed to the list.
	 * 
	 * @return int the list size as integer.
	 */
	public function getSize();
	
	/**
	 * Returns the creation datetime when the list size was computed.
	 * 
	 * @return the creation datetime as ISO 8601 formatted datetime string.
	 */
	public function getCreationDate();
}
?>
