<?php

/**
 * @package Inxmail
 * @subpackage Mailing
 */
/**
 * The <i>Inx_Api_Mailing_SinglePartContentHandler</i> interface defines the basic requirements of a content 
 * handler that handles only one content type (for example text or HTML).
 * 
 * @since API 1.2.0
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 * @subpackage Mailing
 */
interface Inx_Api_Mailing_SinglePartContentHandler extends Inx_Api_Mailing_ContentHandler
{

	/**
	 * Returns the content stored by this content handler.
	 * 
	 * @return string the content.
	 */
	public function getContent();
    
	/**
	 * Updates the content stored by this content handler.
	 * 
	 * @param string $sContent the new content.
	 */
    public function updateContent( $sContent );

}
