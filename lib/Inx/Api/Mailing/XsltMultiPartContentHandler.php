<?php
/**
 * @package Inxmail
 * @subpackage Mailing
 */
/**
 * The <i>Inx_Api_Mailing_XsltMultiPartContentHandler</i> is a content handler used by templates to structure (XML content) and
 * format (Style) mailings with both, plain and HTML text content. Both content parts can be used separately.
 * 
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 * @subpackage Mailing
 */
interface Inx_Api_Mailing_XsltMultiPartContentHandler extends Inx_Api_Mailing_XsltContentHandler
{
	/**
	 * Returns the plain text style XML content stored by this content handler.
	 * 
	 * @return string the plain text style XML content.
	 */
    public function getPlainTextXslt();
    
     
    /**
     * Updates the plain text style XML content stored by this content handler.
     * 
     * @param String $sPlainTextXslt the new plain text style XML content.
     */
    public function updatePlainTextXslt( $sPlainTextXslt );
    
	/**
	 * Returns the HTML style XML content stored by this content handler.
	 * 
	 * @return string the HTML style XML content.
	 */
    public function getHtmlTextXslt();
    
    /**
     * Updates the HTML style XML content stored by this content handler.
     * 
     * @param String $sHtmlTextXslt the new HTML style XML content.
     */
    public function updateHtmlTextXslt( $sHtmlTextXslt );
    
}
