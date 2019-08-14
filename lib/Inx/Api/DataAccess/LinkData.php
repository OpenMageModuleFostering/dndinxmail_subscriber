<?php
/**
 * @package Inxmail
 * @subpackage DataAccess
 */
/**
 * An <i>Inx_Api_DataAccess_LinkData</i> object can be used to retrieve information about a specific link 
 * accessible through an <i>Inx_Api_DataAccess_LinkDataRowSet</i>. A row set can be obtained using various filters:
 * <ul>
 * <li>Link id: <i>selectByLink(int)</i>
 * <li>Link name: <i>selectByLinkName(String)</i>
 * <li>Mailing id: <i>selectByMailing(int)</i>
 * <li>Recipient id: <i>selectByRecipient(int)</i>
 * </ul>
 * <p>
 * The following example returns a result set containing link data for the specified mailing:
 * <pre>
 * $oDataAccess = $oSession->getDataAccess();
 * $oLinkData = $oDataAccess->getLinkDataWithNewLinkType();
 * ...
 * $oLinkDataRowSet = $oLinkData->selectByMailing( $iMailingId );
 * </pre>
 * For more information on the data available for links, see the <i>Inx_Api_DataAccess_LinkDataRowSet</i> documentation.
 * 
 * @see Inx_Api_DataAccess_DataAccess
 * @see Inx_Api_DataAccess_LinkDataRowSet
 * @since API 1.4.0
 * @version $Revision: 9553 $ $Date: 2008-01-04 11:28:41 +0200 (Pn, 04 Sau 2008) $ $Author: vladas $
 * @package Inxmail
 * @subpackage DataAccess
 */
interface Inx_Api_DataAccess_LinkData
{	

    /**
     * This method returns a row set containing information about all links in the specified mailing. If there is no
	 * link data, an empty row set will be returned.
	 * 
	 * @param $iMailingId the id of the mailing.
	 * @return Inx_Api_DataAccess_LinkDataRowSet an <i>Inx_Api_DataAccess_LinkDataRowSet</i> object that contains the 
	 * data produced by the given query. 
	 */
	public function selectByMailing( $iMailingId );
	
	
	/**
	 * This method returns a row set containing information about the specified link. If there is no link data, an empty
	 * row set will be returned.
	 * 
	 * @param in $iLinkId the id of the link.
	 * @return Inx_Api_DataAccess_LinkDataRowSet an <i>Inx_Api_DataAccess_LinkDataRowSet</i> object that contains the 
	 * data produced by the given query.
	 */
	public function selectByLink( $iLinkId );
	
	
	/**
	 * This method returns a row set containing information about all links that were clicked by the given recipient. If
	 * there is no link data, an empty row set will be returned.
	 * 
	 * @param int $iRecipient the id of the recipient.
	 * @return Inx_Api_DataAccess_LinkDataRowSet an <i>Inx_Api_DataAccess_LinkDataRowSet</i> object that contains the 
	 * data produced by the given query.
	 */	
	public function selectByRecipient( $iRecipient );
	
	
	/**
	 * This method returns a row set containing information about all links with the given name. If there is no link
	 * data, an empty row set will be returned.
	 * 
	 * @param string $linkName the name of the link.
	 * @return Inx_Api_DataAccess_LinkDataRowSet an <i>Inx_Api_DataAccess_LinkDataRowSet</i> object that contains the 
	 * data produced by the given query.
	 */	
	public function selectByLinkName( $linkName );
	
}
