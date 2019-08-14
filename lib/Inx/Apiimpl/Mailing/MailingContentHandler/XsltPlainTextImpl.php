<?php

class Inx_Apiimpl_Mailing_MailingContentHandler_XsltPlainTextImpl extends Inx_Apiimpl_Mailing_MailingContentHandler_XsltImpl
implements Inx_Api_Mailing_XsltPlainTextContentHandler
{
	public function __construct( Inx_Apiimpl_Mailing_MailingImpl $oMailing )
	{
		parent::__construct( $oMailing );
	}
	
	
	public function getMailingContentType()
	{
		return Inx_Api_Mailing_MailingConstants::MAIL_CONTENT_TYPE_XML_XSLT_PLAIN_TEXT;
	}
}