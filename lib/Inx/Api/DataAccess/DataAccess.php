<?php
/**
 * @package Inxmail
 * @subpackage DataAccess
 */
/**
 * An <i>Inx_Api_DataAccess_DataAccess</i> object can be used to retrieve data regarding links and clicks. 
 * Link data can be retrieved using an <i>Inx_Api_DataAccess_LinkData</i> object, click data by using an 
 * <i>Inx_Api_DataAccess_ClickData</i> object. Both can be obtained via this class.
 * <p>
 * An <i>Inx_Api_DataAccess_LinkData</i> object can retrieve link data with the following filters:
 * <ul>
 * <li><i>Link id</i>: fetches a link by its unique identifier.
 * <li><i>Link name</i>: fetches a link by its name.
 * <li><i>Mailing id</i>: fetches all links used in the specified mailing.
 * <li><i>Recipient id</i>: fetches all links the specified user has clicked.
 * </ul>
 * <p>
 * An <i>Inx_Api_DataAccess_ClickData</i> object can retrieve click data with the following filters:
 * <ul>
 * <li><i>Mailing id</i>: fetches all clicks of links of the specified mailing.
 * <li><i>Recipient id</i>: fetches all clicks performed by the specified recipient.
 * <li><i>Mailing + Recipient id</i>: combination of the two above filters.
 * <li><i>Link id</i>: fetches all clicks of the specified link.
 * </ul>
 * All of the click data filters can be combined with a date filter: before, after or between.
 * <p>
 * <i>Inx_Api_DataAccess_LinkData</i> and <i>Inx_Api_DataAccess_ClickData</i> retrieve the information as result set: 
 * <i>Inx_Api_DataAccess_LinkDataRowSet</i> for link data and <i>Inx_Api_DataAccess_ClickDataRowSet</i> for click data. 
 * Using these result sets it is easy to navigate through the data retrieved by the various methods.
 * <p>
 * The following snippet returns an <i>Inx_Api_DataAccess_LinkDataRowSet</i> containing all link data for the given 
 * recipient id:
 * <pre>
 * DataAccess da = s.getDataAccess();
 * LinkData ld = da.getLinkDataWithNewLinkType();
 * ...
 * LinkDataRowSet rowSet = ld.selectByRecipient( id );
 * </pre>
 * <p>
 * The following snippet returns an <i>Inx_Api_DataAccess_ClickDataRowSet</i> containing all click data for the given 
 * recipient id:
 * <pre>
 * DataAccess da = s.getDataAccess();
 * ClickData cd = da.getClickData();
 * RecipientContext rc = s.createRecipientContext();
 * Attribute email = rc.getMetaData().getEmailAttribute();
 * ...
 * ClickDataRowSet rowSet = cd.selectByRecipient( id, rc, new Attribute[]{email} );
 * </pre>
 * <p>
 * Note: All data provided by <i>Inx_Api_DataAccess_DataAccess</i> is read only!
 * <p>
 * For more information about link and click data, see the <i>Inx_Api_DataAccess_LinkData</i> and 
 * <i>Inx_Api_DataAccess_ClickData</i> documentation.
 * 
 * @see Inx_Api_DataAccess_LinkData
 * @see Inx_Api_DataAccess_ClickData
 * @since API 1.4.0
 * @version $Revision: 9553 $ $Date: 2008-01-04 11:28:41 +0200 (Pn, 04 Sau 2008) $ $Author: vladas $
 * @package Inxmail
 * @subpackage DataAccess
 */
interface Inx_Api_DataAccess_DataAccess
{
	/**
	 * Returns the link data object which can used to access the link data.
	 * 
	 * @deprecated old behavior is, that uniquely counted image links are counted as unique links. The new method
	 *             <i>getLinkDataWithNewLinkType()</i> returns them separated in unique-count and opening-count links.
	 * @return Inx_Api_DataAccess_LinkData the link data object.
	 */
	public function getLinkData();


	/**
	 * Returns the link data object which can used to access the link data.<br>
	 * In this method unique counted image links are not counted as unique links. These links have the new type
	 * opening-count.
	 * 
	 * @return Inx_Api_DataAccess_LinkData the link data object.
	 */
	public function getLinkDataWithNewLinkType();


	/**
	 * Returns the click data object which can be used to access the click data.<br>
	 * 
	 * @return Inx_Api_DataAccess_ClickData the click data object.
	 */
	public function getClickData();

}