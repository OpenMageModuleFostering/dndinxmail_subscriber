<?php
/**
 * @package Inxmail
 * @subpackage Mailing
 */
/**
 * The <i>Inx_Api_Mailing_ContentHandler</i> interface identifies content handlers. 
 * Content handlers are used to store and update the content of a mailing in a specific format. 
 * Some content handlers (like <i>Inx_Api_Mailing_XsltContentHandler</i>) provide special functionality like applying 
 * styles to a mailing (used by templates).
 * <p>
 * There are no requirements common for all content handlers, thus content handlers are free to provide only the 
 * methods needed for the current content type.
 * 
 * @see Inx_Api_Mailing_Mailing::getContentHandler()
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 * @subpackage Mailing
 */
interface Inx_Api_Mailing_ContentHandler
{
    
}
