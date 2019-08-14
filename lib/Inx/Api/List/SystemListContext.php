<?php
/**
 * @package Inxmail
 * @subpackage List
 */
/**
 * The <i>Inx_Api_List_SystemListContext</i> does not represent a usual mailing list. 
 * Recipients cannot subscribe to this list and it is not possible to write emails to the recipients of the system list. 
 * The system list stores all recipient data regardless of any mailing list association.
 * <p>
 * The property settings defined in the system list are global in that they apply to all mailing list. 
 * A lot of property settings can only be defined here.
 * 
 * @since API 1.0
 * @version $Revision: 9553 $ $Date: 2008-01-04 11:28:41 +0200 (Pn, 04 Sau 2008) $ $Author: vladas $
 * @package Inxmail
 * @subpackage List
 */
interface Inx_Api_List_SystemListContext extends Inx_Api_List_ListContext
{

	/**
	 * The predefined, immutable name of the system list.
	 */
	const NAME = "system";

}
