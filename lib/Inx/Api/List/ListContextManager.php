<?php
/**
 * @package Inxmail
 * @subpackage List
 */
/**
 * An <i>Inx_Api_List_ListContext</i> corresponds to a list in Inxmail, like a mailing list or the system list. 
 * The <i>Inx_Api_List_ListContextManager</i> is used to access and manipulate these lists.
 * <p>
 * There are four different types of lists:
 * <ul>
 * <li>Standard lists: <i>Inx_Api_List_StandardListContext</i>
 * <li>Filter lists: <i>Inx_Api_List_FilterListContext</i>
 * <li>The system list: <i>Inx_Api_List_SystemListContext</i>
 * <li>The administration list: <i>Inx_Api_List_AdminListContext</i>
 * </ul>
 * New mailing lists are created using <i>createStandardList()</i> or <i>createFilterList()</i>.
 * <p>
 * The following snippet creates a new standard mailing list:
 * 
 * <PRE>
 * $oListContextManager = $session->getListContextManager();
 * $oStandardListContext = $oListContextManager->createStandardList();
 * $oStandardListContext->updateName( "New List" );
 * $oStandardListContext->commitUpdate();
 * </PRE>
 * 
 * Special lists, like the system or administration list, can be retrieved using the <i>findByName($sName)</i> method. 
 * Both, <i>Inx_Api_List_SystemListContext</i> and <i>Inx_Api_List_AdminListContext</i> provide a constant with their predefined,
 * immutable name which can be used to retrieve the list context. 
 * The following snippet illustrates this:
 * 
 * <PRE>
 * $oListContextManager = $oSession->getListContextManager();
 * $systemListContext = $oListContextManager->findByName( Inx_Api_List_SystemListContext::NAME );
 * $adminListContext  = $oListContextManager->findByName( Inx_Api_List_AdminListContext::NAME );
 * </PRE>
 * <p>
 * For more information on lists, see the <i>Inx_Api_List_ListContext</i> documentation.
 * 
 * @see Inx_Api_List_ListContext
 * @since API 1.0  
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 * @subpackage List
 */
interface Inx_Api_List_ListContextManager extends Inx_Api_BOManager
{

	/**
	 * Returns the <i>Inx_Api_List_ListContext</i> with the specified list name.
	 * The list name is case insensitive.
	 * 
	 * @param string $sListName	the name of the list to find.
	 * @return	Inx_Api_List_ListContext the list context, or null if no list can be found.
	 */
	public function findByName( $sListName );

	
    /**
     * Creates an <i>Inx_Api_List_StandardListContext</i> object.
     * The list will not be created on the server until <i>commitUpdate()</i> has been called.
     * 
     * @return Inx_Api_List_StandardListContext an <i>Inx_Api_List_StandardListContext</i> object.
     */
    public function createStandardList();

    
    /**
     * Creates an <i>Inx_Api_List_FilterListContext</i> object.
     * The list will not be created on the server until <i>commitUpdate()</i> has been called.
     *
     * @return	Inx_Api_List_FilterListContext an <i>Inx_Api_List_FilterListContext</i> object.
     */
    public function createFilterList();
  
}
