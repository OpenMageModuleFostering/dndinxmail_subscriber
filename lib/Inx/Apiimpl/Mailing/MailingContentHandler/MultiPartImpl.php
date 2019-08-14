<?php


class Inx_Apiimpl_Mailing_MailingContentHandler_MultiPartImpl extends Inx_Apiimpl_Mailing_MailingContentHandler
implements Inx_Api_Mailing_MultiPartContentHandler
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
	public function getPlainTextContent()
	{
		$this->check();
		return Inx_Apiimpl_TConvert::convert( $this->_oMailing->oData->lazyData->plainText);
	}

	/**
	 * Enter description here...
	 *
	 * @param String $sPlainTextContent
	 */
	public function updatePlainTextContent( $sPlainTextContent )
	{
		$this->check();
		$this->_oMailing->oData->lazyData->plainText = Inx_Apiimpl_TConvert::TConvert( $sPlainTextContent );
		$this->_oMailing->_aChangedAttrs[ Inx_Api_Mailing_Mailing::ATTRIBUTE_PLAIN_TEXT ] = true;
	}

	/**
	 * Enter description here...
	 *
	 * @return String
	 */
	public function getHtmlTextContent()
	{
		$this->check();
		return Inx_Apiimpl_TConvert::convert( $this->_oMailing->oData->lazyData->htmlText );
	}

	/**
	 * Enter description here...
	 *
	 * @param String $sHtmlTextContent
	 */
	public function updateHtmlTextContent( $sHtmlTextContent )
	{
		$this->check();
		$this->_oMailing->oData->lazyData->htmlText = Inx_Apiimpl_TConvert::TConvert( $sHtmlTextContent ) ;
		$this->_oMailing->_aChangedAttrs[ Inx_Api_Mailing_Mailing::ATTRIBUTE_HTML_TEXT ] = true;
	}
	
	/**
	 * Enter description here...
	 *
	 * @return int
	 */
	public function getMailingContentType()
	{
		return Inx_Api_Mailing_MailingConstants::MAIL_CONTENT_TYPE_MULTI_PART;
	}
}
