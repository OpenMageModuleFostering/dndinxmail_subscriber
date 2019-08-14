<?php


class Inx_Apiimpl_Mailing_MailingContentHandler_HtmlTextImpl extends Inx_Apiimpl_Mailing_MailingContentHandler
implements Inx_Api_Mailing_HtmlTextContentHandler
{
	public function __construct( Inx_Apiimpl_Mailing_MailingImpl $oMailing )
	{
		parent::__construct( $oMailing );
	}
	 
	/**
	 * Enter description here...
	 *
	 * @return String
	 */
	public function getContent()
	{
		$this->check();
		return Inx_Apiimpl_TConvert::convert( $this->_oMailing->oData->lazyData->htmlText );
	}

	public function updateContent( $sContent )
	{
		$this->check();
		$this->_oMailing->oData->lazyData->htmlText = Inx_Apiimpl_TConvert::TConvert( $sContent );
		$this->_oMailing->_aChangedAttrs[ Inx_Api_Mailing_Mailing::ATTRIBUTE_HTML_TEXT ] = true;
	}
	
	/**
	 * Enter description here...
	 *
	 * @return int
	 */
	public function getMailingContentType()
	{
		return Inx_Api_Mailing_MailingConstants::MAIL_CONTENT_TYPE_HTML_TEXT;
	}
}
