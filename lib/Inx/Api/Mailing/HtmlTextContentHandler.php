<?php
/**
 * @package Inxmail
 * @subpackage Mailing
 */
/**
 * The <i>Inx_Api_Mailing_HtmlTextContentHandler</i> is a simple content handler used to store and update mailing 
 * content in HTML format. 
 * This content handler can only handle HTML content. 
 * If you wish to use both, plain and HTML text content, use the <i>Inx_Api_Mailing_MultiPartContentHandler</i> instead.
 * 
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 * @subpackage Mailing
 */
interface Inx_Api_Mailing_HtmlTextContentHandler extends Inx_Api_Mailing_SinglePartContentHandler
{
    
}
