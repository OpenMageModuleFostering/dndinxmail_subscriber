<?php

class Inx_Apiimpl_Mailing_MailingContentHandler_XsltHtmlTextImpl extends Inx_Apiimpl_Mailing_MailingContentHandler_XsltImpl
implements Inx_Api_Mailing_XsltHtmlTextContentHandler
{
	public function __construct( Inx_Apiimpl_Mailing_MailingImpl $oMailing )
	{
		parent::__construct( $oMailing );
	}
	
	/**
	 * Enter description here...
	 *
	 * @return int
	 */
	public function getMailingContentType()
	{
		return Inx_Api_Mailing_MailingConstants::MAIL_CONTENT_TYPE_XML_XSLT_HTML_TEXT;
	}
}