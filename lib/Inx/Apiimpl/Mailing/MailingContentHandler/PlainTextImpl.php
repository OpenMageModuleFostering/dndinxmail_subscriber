<?php
class Inx_Apiimpl_Mailing_MailingContentHandler_PlainTextImpl extends Inx_Apiimpl_Mailing_MailingContentHandler implements Inx_Api_Mailing_PlainTextContentHandler
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
		return Inx_Apiimpl_TConvert::convert( $this->_oMailing->oData->lazyData->plainText );
	}

	/**
	 * Enter description here...
	 *
	 * @param String $sContent
	 */
	public function updateContent( $sContent )
	{
		$this->check();
		$this->_oMailing->oData->lazyData->plainText = Inx_Apiimpl_TConvert::TConvert( $sContent );
		$this->_oMailing->_aChangedAttrs[ Inx_Api_Mailing_Mailing::ATTRIBUTE_PLAIN_TEXT ] = true;
	}

	public function getMailingContentType()
	{
		return Inx_Api_Mailing_MailingConstants::MAIL_CONTENT_TYPE_PLAIN_TEXT;
	}
}