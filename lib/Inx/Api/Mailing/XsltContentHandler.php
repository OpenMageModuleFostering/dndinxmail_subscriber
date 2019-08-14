<?php

/**
 * @package Inxmail
 * @subpackage Mailing
 */
/**
 * The <i>Inx_Api_Mailing_XsltContentHandler</i> defines the basic requirements for a content handler that handles XML based
 * content. This type of content handler is used by templates to structure (XML content) and format (Style) a mailing.
 * 
 * @since API 1.2.0
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 * @subpackage Mailing
 */
interface Inx_Api_Mailing_XsltContentHandler extends Inx_Api_Mailing_ContentHandler
{
	
	/**
	 * Returns the raw XML content stored by this content handler.
	 * 
	 * @return string the raw XML content.
	 */
	public function getXmlContent();
    
    /**
     * Updates the raw XML content stored by this content handler.
     *
     * @param string $sContent the new raw XML content.
     */
    public function updateXmlContent( $sContent );
    
    
	/**
	 * Returns the style, the mailing has been created with. 
	 * The style is used to format the mailing, very similar to a CSS file.
	 * 
	 * @return Inx_Api_DesignTemplate_Style the style used to format the mailing.
	 */
	public function getStyle();
	
	/**
	 * Updates the style used for the mailing. The style is used to format the mailing, very similar to a CSS file.
	 * 
	 * @param Inx_Api_DesignTemplate_Style style the new style (has to be from the same template as the old one).
	 */
	public function updateStyle( Inx_Api_DesignTemplate_Style $oStyle );
}
