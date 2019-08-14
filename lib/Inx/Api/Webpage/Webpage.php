<?php

/**
* An <i>Inx_Api_Webpage_Webpage</i> object can be used to access information about a web page. 
* A web page can be a JSP or a FORM or of unknown type and is bound to a server URL. 
* A <i>Webpage</i> object also has a sub type which defines the usage of the web page. 
* A possible sub type is, for example, subscription.
* <p>
* The following code snippet prints out the names of all available webpages:
*
* <PRE>
* $oWebpageManager = $oSession->getWebpageManager();
* $oBOResultSet = $oWebpageManager->selectAll();
*
* for( $i = 0; $i &lt; $oBOResultSet->size(); $i++ )
* {
* 	$oWebpage = $oBOResultSet->get( $i );
* 	echo 'Page name: ' . $oWebpage->getName() . '&lt;br&gt;';
* }
* 
* $oBOResultSet->close();
* </PRE>
*
* @see Inx_Api_Webpage_WebpageManager
* @author chge, 06.03.2012
* @since API 1.9.0
* @package Inxmail
* @subpackage Webpage
*/
interface Inx_Api_Webpage_Webpage extends Inx_Api_BusinessObject
{
	/** 
	 * Type for JSP webpages. 
	 * 
	 * @var int
	 */
	const TYPE_JSP = 0;

	/** 
	 * Type for form (HTML) webpages. 
	 * 
	 * @var int
	 */
	const TYPE_FORM = 1;

	/** 
	 * Type for webpages of unknown type. 
	 * 
	 * @var int
	 */
	const TYPE_UNKNOWN = 2;


	/**
	 * Returns the name of this web page.
	 *
	 * @return string the name.
	 */
	public function getName();


	/**
	 * Returns the server URL this web page is published at.
	 *
	 * @return string the server URL.
	 */
	public function getServerUrl();


	/**
	 * Returns the type of this web page. The possible types are:
	 * <ul>
	 * <li><i>TYPE_FORM</i>: A form (HTML) web page
	 * <li><i>TYPE_JSP</i>: A JSP web page
	 * <li><I>TYPE_UNKNOWN</i>: A web page of unknown type
	 * </ul>
	 *
	 * @return int the type.
	 */
	public function getType();


	/**
	 * Returns the sub type of this web page. A possible value would be subscription.
	 *
	 * @return string the sub type.
	 */
	public function getSubType();


	/**
	 * Returns the creation date of this web page.
	 * The date will be returned as ISO 8601 formatted datetime string.
	 *
	 * @return string the creation date.
	 */
	public function getCreationDate();
}