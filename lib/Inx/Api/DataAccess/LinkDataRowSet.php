<?php
/**
 * @package Inxmail
 * @subpackage DataAccess
 */
/**
 * An <i>Inx_Api_DataAccess_LinkDataRowSet</i> is used to access rows of link data resulting from a query. 
 * Only tracked links - which can be used for opening analysis - will be fetched.
 * <p>
 * The following data can be retrieved:
 * <ul>
 * <li><i>Link id</i>: the unique identifier of the link.
 * <li><i>Link name</i>: the name of the link (alias).
 * <li><i>Link type</i>: the type of the link (see constants below).
 * <lI><i>Link URL</i>: the Uniform resource locator (URL) of the link.
 * <li><i>Action id</i>: the id of the action associated to this link, if any.
 * <li><i>Mailing id</i>: the id of the mailing which contains the link.
 * </ul>
 * The link type can be one of the following:
 * <ul>
 * <li>LINK_TYPE_REDIRECT - can be used to perform actions before redirecting to the target URL.
 * <li>LINK_TYPE_UNSUBSCRIBE - unsubscribes the current recipient without verification (deprecated).
 * <li>LINK_TYPE_COUNT - tracking link that counts each click.
 * <li>LINK_TYPE_UNIQUE_COUNT - tracking link that counts each click and the <i>first</i> click of every
 * recipient.
 * <li>LINK_TYPE_VERIFY_SUBSCRIPTION - verifies the subscription of the current recipient.
 * <li>LINK_TYPE_VERIFY_UNSUBSCRIPTION - verifies the unsubscription of the current recipient.
 * <li>LINK_TYPE_OPENING_COUNT - trackable image that counts each loading.
 * <li>LINK_TYPE_CONTENT - tracking link embedded in external content (unique count).
 * <li>LINK_TYPE_OPENING_CONTENT - trackable image embedded in external content (unique count).
 * <li>LINK_TYPE_UNSUBSCRIBE_LINK - unsubscribes the current recipient without verification.
 * <li>LINK_TYPE_HEADER_UNSUBSCRIBE - unsubscribes the current recipient using the header unsubscription.
 * Clients which support this feature (like Google mail) will show an unsubscription button at the head of the mailing.
 * <li>LINK_TYPE_JSP_UNSUBSCRIBE - unsubscribes the current recipient using a JSP landing page.
 * <li>LINK_TYPE_PAGE_UNSUBSCRIBE - unsubscribes the current recipient using a HTML landing page.
 * <li>LINK_TYPE_UNKNOWN - unknown link type used for legacy APIs (server version > API version).
 * </ul>
 * For information on how to navigate through an <i>Inx_Api_DataAccess_LinkDataRowSet</i>, see the 
 * <i>Inx_Api_DataAccess_DataRowSet</i> documentation.
 * <p>
 * For an example on how to query link data, see the <i>Inx_Api_DataAccess_LinkData</i> documentation.
 * <p>
 * 
 * @see Inx_Api_DataAccess_LinkData
 * @see Inx_Api_DataAccess_DataRowSet 
 * @since API 1.4.0
 * @version $Revision: 9553 $ $Date: 2008-01-04 11:28:41 +0200 (Pn, 04 Sau 2008) $ $Author: vladas $
 * @package Inxmail
 * @subpackage DataAccess
 */
interface Inx_Api_DataAccess_LinkDataRowSet extends Inx_Api_DataAccess_DataRowSet
{	

    /** The 'redirect' link type can be used to perform actions before redirecting to the target URL. */
    const LINK_TYPE_REDIRECT         		= 0;

    /**
	 * The deprecated 'unsubscribe' link type unsubscribes the current recipient without verification.
	 * 
	 * @deprecated the new unsubscription link types are:
	 *             <ul>
	 *             <li>LINK_TYPE_UNSUBSCRIBE_LINK
	 *             <li>LINK_TYPE_HEADER_UNSUBSCRIBE
	 *             <li>LINK_TYPE_JSP_UNSUBSCRIBE
	 *             <li>LINK_TYPE_PAGE_UNSUBSCRIBE
	 *             </ul>
	 */
    const LINK_TYPE_UNSUBSCRIBE      		= 1;

    /** The 'count' link type counts each click of a particular link. */
    const LINK_TYPE_COUNT            		= 2;

    /**
	 * The 'unique count' link type counts each click of a particular link and the <i>first</i> click of a recipient
	 * (tracks the number of recipients that clicked the link). Both values can be used for reporting and analysis.
	 */
    const LINK_TYPE_UNIQUE_COUNT     		= 3;

    /** The 'verify subscription' link type verifies the subscription of the current recipient. */
    const LINK_TYPE_VERIFY_SUBSCRIPTION   = 5;

    /** The 'verify unsubscription' link type verifies the unsubscription of the current recipient. */
    const LINK_TYPE_VERIFY_UNSUBSCRIPTION	= 6;
    
    /**
	 * The 'opening count' link type is used to count the <i>first</i> loading of a particular image by a recipient.
	 * 
	 * @see LINK_TYPE_UNIQUE_COUNT
	 */ 
 	const LINK_TYPE_OPENING_COUNT 		= 7; 
	
	/**
	 * The 'content' link type counts the number of recipients that click a link embedded in external content.
	 * 
	 * @see LINK_TYPE_UNIQUE_COUNT
	 * @since API 1.8.0
	 */
 	const LINK_TYPE_CONTENT				= 8; 
	
	
	/**
	 * The 'opening content' link type counts the number of recipients that load an image embedded in external content.
	 * 
	 * @see LINK_TYPE_UNIQUE_COUNT
	 * @since API 1.8.0
	 */
 	const LINK_TYPE_OPENING_CONTENT		= 9; 
	
	
	/**
	 * The 'unsubscribe link' link type unsubscribes the current recipient without verification.
	 * 
	 * @since API 1.8.0
	 */
 	const LINK_TYPE_UNSUBSCRIBE_LINK		= 10; 
	
	
	/**
	 * The 'header unsubscribe' link type unsubscribes the current recipient using the header unsubscription. Clients
	 * which support this feature (like Google mail) will show an unsubscription button at the head of the mailing.
	 * 
	 * @since API 1.8.0
	 */
 	const LINK_TYPE_HEADER_UNSUBSCRIBE	= 11; 
	
	
	/**
	 * The 'JSP unsubscribe' link type unsubscribes the current recipient using a JSP landing page.
	 * 
	 * @since API 1.8.0
	 */
 	const LINK_TYPE_JSP_UNSUBSCRIBE	= 12; 
	
	
	/**
	 * The 'page unsubscribe' link type unsubscribes the current recipient using a HTML landing page.
	 * 
	 * @since API 1.8.0
	 */
 	const LINK_TYPE_PAGE_UNSUBSCRIBE	= 13; 
	
	
	/**
	 * The 'unknown' link type is used for legacy APIs (server version > API version). This type will be used if the
	 * link type is not supported by the API.
	 * 
	 * @since API 1.8.0
	 */
 	const LINK_TYPE_UNKNOWN	= -1; 
	
    
    /**
	 * Returns the unique identifier of the current link.
	 * 
	 * @return int the id of the current link.
	 * @throws Inx_Api_DataException if no row is selected (e.g. you forgot to call next()).
	 */
	public function getLinkId();

    /**
	 * Returns the name of the current link.
	 * 
	 * @return string the name of the current link.
	 * @throws Inx_Api_DataException if no row is selected (e.g. you forgot to call next()).
	 */
	public function getLinkName();
	
	
    /**
	 * Returns the uniform resource locator (URL) of the current link.
	 * 
	 * @return string the URL of the current link.
	 * @throws Inx_Api_DataException if no row is selected (e.g. you forgot to call next()).
	 */
	public function getLinkUrl();
	
    /**
	 * Returns the type of the current link. The possible types are:<br>
	 * <ul>
	 * <li>LINK_TYPE_REDIRECT - can be used to perform actions before redirecting to the target URL.
	 * <li>LINK_TYPE_UNSUBSCRIBE - unsubscribes the current recipient without verification (deprecated).
	 * <li>LINK_TYPE_COUNT - tracking link that counts each click.
	 * <li>LINK_TYPE_UNIQUE_COUNT - tracking link that counts each click and the <i>first</i> click of every
	 * recipient.
	 * <li>LINK_TYPE_VERIFY_SUBSCRIPTION - verifies the subscription of the current recipient.
	 * <li>LINK_TYPE_VERIFY_UNSUBSCRIPTION - verifies the unsubscription of the current recipient.
	 * <li>LINK_TYPE_OPENING_COUNT - trackable image that counts each loading.
	 * <li>LINK_TYPE_CONTENT - tracking link embedded in external content (unique count).
	 * <li>LINK_TYPE_OPENING_CONTENT - trackable image embedded in external content (unique count).
	 * <li>LINK_TYPE_UNSUBSCRIBE_LINK - unsubscribes the current recipient without verification.
	 * <li>LINK_TYPE_HEADER_UNSUBSCRIBE - unsubscribes the current recipient using the header unsubscription.
	 * Clients which support this feature (like Google mail) will show an unsubscription button at the head of the
	 * mailing.
	 * <li>LINK_TYPE_JSP_UNSUBSCRIBE - unsubscribes the current recipient using a JSP landing page.
	 * <li>LINK_TYPE_PAGE_UNSUBSCRIBE - unsubscribes the current recipient using a HTML landing page.
	 * <li>LINK_TYPE_UNKNOWN - unknown link type used for legacy APIs (server version > API version).
	 * </ul>
	 * 
	 * @return int the type of the current link.
	 * @throws Inx_Api_DataException if no row is selected (e.g. you forgot to call next()).
	 */
	public function getLinkType();
	
    /**
	 * Returns the id of the action associated to this link, or 0 if no action is associated to this link.
	 * 
	 * @return int the id of the associated action, or 0.
	 * @throws Inx_Api_DataException if no row is selected (e.g. you forgot to call next()).
	 */
	public function getActionId();
	
    /**
	 * Returns the id of the mailing which contains the current link.
	 * 
	 * @return int the id of the mailing which contains the current link.
	 * @throws Inx_Api_DataException if no row is selected (e.g. you forgot to call next()).
	 */
	public function getMailingId();

}
