<?php
/**
* An <i>Inx_Api_Webpage_WebpageManager</i> object can be used to retrieve <i>Inx_Api_Webpage_Webpage</i> objects. 
* The web pages can be retrieved by their id, by their type (i.e. JSP, Form), by their sub type (e.g. "subscription") 
* or a combination of type and sub type.
* <p>
* The following code snippet prints out the names of all available web pages (JSPs and forms):
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
* <p>
* For more information on web pages, see the <i>Inx_Api_Webpage_Webpage</i> documentation.
*
* @see Inx_Api_Webpage_Webpage
* @author chge, 06.03.2012
* @since API 1.9.0
* @package Inxmail
* @subpackage Webpage
*/
interface Inx_Api_Webpage_WebpageManager
{
	/**
	 * Returns the web page with the given id.
	 *
	 * @param int $iId the id of the web page to be retrieved.
	 * @return Inx_Api_Webpage_Webpage The web page specified by the given id.
	 * @throws Inx_Api_DataException if the web page has been deleted.
	 */
	public function get( $iId );


	/**
	 * Returns a <i>BOResultSet</i> containing all webpages.
	 *
	 * @return Inx_Api_BOResultSet a result set containing all webpages.
	 */
	public function selectAll();


	/**
	 * Returns a <i>BOResultSet</i> containing all webpages with the given sub type.
	 *
	 * @param string $sSubType the sub type of the web pages to retrieve (e.g. 'subscription').
	 * @return Inx_Api_BOResultSet a result set containing all webpages with the given sub type.
	 */
	public function selectBySubType( $sSubType );


	/**
	 * Returns a <i>BOResultSet</i> containing all JSP webpages.
	 *
	 * @return Inx_Api_BOResultSet a result set containing all JSP webpages.
	 */
	public function selectAllJsps();


	/**
	 * Returns a <i>BOResultSet</i> containing all form (HTML) webpages.
	 *
	 * @return Inx_Api_BOResultSet a result set containing all form (HTML) webpages.
	 */
	public function selectAllForms();


	/**
	 * Returns a <i>BOResultSet</i> containing all JSP webpages with the given sub type.
	 *
	 * @param string $sSubType the sub type of the web pages to retrieve (e.g. 'subscription').
	 * @return Inx_Api_BOResultSet a result set containing all JSP webpages with the given sub type.
	 */
	public function selectJspsBySubType( $sSubType );


	/**
	 * Returns a <i>BOResultSet</i> containing all form (HTML) webpages with the given sub type.
	 *
	 * @param string $sSubType the sub type of the web pages to retrieve (e.g. 'subscription').
	 * @return Inx_Api_BOResultSet a result set containing all form (HTML) webpages with the given sub type.
	 */
	public function selectFormsBySubType( $sSubType );
}