<?php
/**
 * @package Inxmail
 * @subpackage Mailing
 */
/**
 * The <i>Inx_Api_Mailing_XsltPlainTextContentHandler</i> is a content handler used by templates to structure (XML content) and
 * format (Style) mailings with plain text content. 
 * This content handler can only handle plain text content. 
 * If you wish to use both, plain and HTML text content, use the <i>Inx_Api_Mailing_XsltMultiPartContentHandler</i> instead.
 * 
 * @since API 1.0.1
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 * @subpackage Mailing
 */
interface Inx_Api_Mailing_XsltPlainTextContentHandler extends Inx_Api_Mailing_XsltContentHandler
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
     * @param string $sPlainTextXslt the new plain text style XML content.
     */
    public function updatePlainTextXslt( $sPlainTextXslt );

}