<?php
/**
 * @package Inxmail
 * @subpackage Mailing
 */
/**
 * MailingConstants
 * 
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 * @subpackage Mailing
 */
interface Inx_Api_Mailing_MailingConstants
{

    const MAIL_CONTENT_TYPE_PLAIN_TEXT = 100; 
    
    const MAIL_CONTENT_TYPE_HTML_TEXT = 101;
    
    const MAIL_CONTENT_TYPE_MULTI_PART = 102; 
    
    const MAIL_CONTENT_TYPE_XML_XSLT_MULTI_PART = 103;
 
    const MAIL_CONTENT_TYPE_XML_XSLT_PLAIN_TEXT = 104;

    const MAIL_CONTENT_TYPE_XML_XSLT_HTML_TEXT = 105;

    
	/**
	 * the array index of list type of mailing bo
	 */
	const INTERNAL_MAILING_LIST_ID = 0;

	const INTERNAL_MAILING_CONTENT_MAIL_TYPE = 1;

	const INTERNAL_MAILING_FEATURE_ID = 2;

	
	const MAILING_EXCEPTION_TYPE_STATE = 1000;

	const MAILING_EXCEPTION_TYPE_RECIPIENT_NOT_FOUND = 1001;

	const MAILING_EXCEPTION_TYPE_MAILBUILD = 1002;

	const MAILING_EXCEPTION_TYPE_MAILING_FEATURE_DISABLED = 1003;

	
    const PARSE_SUCCESSFUL = 1;

    const PARSE_EXCEPTION = 2;

    const MAILING_NOT_FOUND = 3;
    
    
    const BUILD_SUCCESSFUL = 1;

    const BUILD_EXCEPTION = 2;

    
    const MAIL_TYPE_SYSTEM = -1;
    
    const MAILING_MAX_CHANGEDATTR_SIZE = 20;
    
}
