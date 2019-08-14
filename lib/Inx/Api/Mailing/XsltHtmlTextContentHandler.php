<?php

/**
 * @package Inxmail
 * @subpackage Mailing
 */
/**
 * The <i>Inx_Api_Mailing_XsltHtmlTextContentHandler</i> is a content handler used by templates to structure (XML content) and
 * format (Style) mailings with HTML text content. 
 * This content handler can only handle HTML content. 
 * If you wish to use both, plain and HTML text content, use the <i>Inx_Api_Mailing_XsltMultiPartContentHandler</i> instead.
 * 
 * @since API 1.0.1
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 * @subpackage Mailing
 */
interface Inx_Api_Mailing_XsltHtmlTextContentHandler extends Inx_Api_Mailing_XsltContentHandler
{

	/**
	 * Returns the HTML style XML content stored by this content handler.
	 * 
	 * @return string the HTML style XML content.
	 */
    public function getHtmlTextXslt();
    
    /**
     * Updates the HTML style XML content stored by this content handler.
     * 
     * @param string $sHtmlTextXslt the HTML style XML content.
     */ 
    public function updateHtmlTextXslt( $sHtmlTextXslt );
    
}