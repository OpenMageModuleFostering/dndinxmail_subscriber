<?php
/**
 * @package Inxmail
 * @subpackage Filter
 */
/**
 * Often, mailings are to be sent not to the whole recipient list but only to a certain subgroup of recipients. 
 * Examples for such target groups are 'All recipients who read HTML format', 'Women', 'Men', 'People interested in 
 * product X', 'Recipients born after 1970', and so on.
 * <p>
 * The <i>Inx_Api_Filter_FilterManager</i> can be used to create and retrieve <code>Filter</code>s (target groups). 
 * The following snippet creates a global <i>Inx_Api_Filter_Filter</i>:
 * 
 * <pre>
 * $oSystemListContext = $oSession->getListContextManager()->findByName( Inx_Api_List_SystemListContext::NAME );
 * $oFilterManager = $oSession->getFilterManager();
 * $oFilter = $oFilterManager->createFilter( $oSystemListContext );
 *    
 * $oFilter->updateName( "New Yorker" );
 * $oFilter->updateStatement( "city LIKE \"New York\"" );
 * $oFilter->commitUpdate();   
 * </pre>
 * <p>
 * An <i>Inx_Api_Filter_Filter</i> can be assigned to an individual <i>Inx_Api_Mailing_Mailing</i>, as demonstrated 
 * in the following snippet:
 * 
 * <pre>
 *    $oMailing = ...
 *    
 *    $oMailing->updateFilterId( $oFilter->getId() );
 *    $oMailing->commitUpdate();
 * </pre>
 * <p>
 * The retrieval of <i>Inx_Api_Filter_Filter</i>s can be accomplished using the <i>selectAll()</i> method to retrieve all
 * filters, or one of the methods that expect an <i>Inx_Api_List_ListContext</i> to retrieve only the filters assigned to a
 * specific list. 
 * The following snippet shows how to retrieve all filters belonging to the specified list, ordered by their creation date:
 * 
 * <pre>
 * $oListContext = $oSession->getListContextManager()->findByName( &quot;Desired list&quot; );
 * $oFilterManager = $oSession->getFilterManager();
 * 
 * $oBOResultSet = $oFilterManager->select( $oListContext, 
 * 	Inx_Api_Filter_Filter::ATTRIBUTE_CREATION_DATETIME, Inx_Api_Order::ASC );
 * 
 * for( $i = 0; $i &lt; $oBOResultSet->size(); $i++ )
 * {
 * 	$oFilter = $oBOResultSet->get( $i );
 * 	echo $oFilter->getName()."&#60;br&#62;";
 * }
 * 
 * $oBOResultSet->close();
 * </pre>
 * <p>
 * Note: The usage of <i>Inx_Api_Filter_Filter</i>s requires the api user right: <i>Inx_Api_UserRights::FILTER_FEATURE_USE</i>
 * <p>
 * For more information on filters and the filter statement syntax, see the <i>Inx_Api_Filter_Filter</i> documentation.
 * 
 * @see Inx_Api_Filter_Filter
 * @since API 1.1.0
 * @version $Revision: 9553 $ $Date: 2008-01-04 11:28:41 +0200 (Pn, 04 Sau 2008) $ $Author: vladas $
 * @package Inxmail
 * @subpackage Filter
 */
interface Inx_Api_Filter_FilterManager extends Inx_Api_BOManager
{

	/**
	 * Creates a new filter that belongs to the specified list. 
	 * To create a global filter, use the system list. 
	 * The following snippet shows how to retrieve the <i>Inx_Api_List_SystemListContext</i>:
	 * <pre>
	 * $oSystemListContext = $oSession->getListContextManager()->findByName( Inx_Api_List_SystemListContext::NAME );
	 * </pre>
	 * 
	 * @param Inx_Api_List_ListContext $oListContext the owning list of the filter.
	 * @return Inx_Api_Filter_Filter a new filter.
	 */
	public function createFilter( Inx_Api_List_ListContext $oListContext );
	
    /**
     * Returns an <i>Inx_Api_BOResultSet</i> containing all filters which belong to the specified list ordered
	 * by the specified order attribute and type. To retrieve the global filters, use the system list.
     * 
     * @param Inx_Api_List_ListContext $oListContext all filters belonging to this list will be retrieved.
	 * @param int $iOrderAttribute the order attribute (<i>Inx_Api_Filter_Filter::ATTRIBUTE_NAME</i> or
     * <i>Inx_Api_Filter_Filter::ATTRIBUTE_CREATION_DATETIME</i>). May be ommitted.
     * @param int $orderType the order type (<i>Inx_Api_Order::ASC</i>
     * or <i>Inx_Api_Order::DESC</i>). May be ommitted.
     * @return	an <i>Inx_Api_BOResultSet</i> that contains the data produced by the given query.
     * @throws Inx_Api_SecurityException if the session user doesn't have the following permission:
	 * <i>Inx_Api_UserRights::FILTER_FEATURE_USE</i>
     */
	public function select( Inx_Api_List_ListContext $oListContext, $iOrderAttribute = null, $orderType = null);
	
}
