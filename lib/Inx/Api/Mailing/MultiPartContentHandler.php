<?php

/**
 * @package Inxmail
 * @subpackage Mailing
 */
/**
 * The <i>Inx_Api_Mailing_MultiPartContentHandler</i> is a simple content handler used to store and update mailing content in
 * both, plain and HTML text format. Both content parts can be used separately.
 * 
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 * @subpackage Mailing
 */
interface Inx_Api_Mailing_MultiPartContentHandler extends Inx_Api_Mailing_ContentHandler
{
    
	/**
	 * Returns the plain text content stored by this content handler.
	 * 
	 * @return string the plain text content.
	 */
    public function getPlainTextContent();
    
    /**
     * Updates the plain text content stored by this content handler.
     *
     * @param string $sPlainTextContent the new plain text content.
     */
    public function updatePlainTextContent( $sPlainTextContent );
    
    
    /**
     * Returns the HTML text content stored by this content handler.
     *
     * @return string the HTML text content.
     */
    public function getHtmlTextContent();
    
    /**
     * Updates the HTML text content stored by this content handler.
     *
     * @param string $sHtmlTextContent the new HTML text content.
     */
    public function updateHtmlTextContent( $sHtmlTextContent );

}