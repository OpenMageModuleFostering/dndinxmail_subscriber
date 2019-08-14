<?php
/**
 * @package Inxmail
 * @subpackage List
 */
/**
 * The <i>Inx_Api_List_AdminListContext</i> does not represent a usual mailing list. 
 * Mail server and user credentials, along with other administrative properties, can be defined in the administration list.
 * <p>
 * <b>At the moment the <i>Inx_Api_List_AdminListContext</i> has no functionality.</b>
 * 
 * @since API 1.0
 * @version $Revision: 9553 $ $Date: 2008-01-04 11:28:41 +0200 (Pn, 04 Sau 2008) $ $Author: vladas $
 * @package Inxmail
 * @subpackage List
 */
interface Inx_Api_List_AdminListContext extends Inx_Api_List_ListContext
{

    /**
	 * The predefined, immutable name of the administration list.
	 */
	const NAME = "administration";
	
}
