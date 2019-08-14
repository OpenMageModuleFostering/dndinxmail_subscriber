<?php


abstract class Inx_Apiimpl_Mailing_MailingContentHandler_XsltImpl extends Inx_Apiimpl_Mailing_MailingContentHandler
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
	public function getXmlContent()
	{
		$this->check();
		return Inx_Apiimpl_TConvert::convert( $this->_oMailing->oData->lazyData->xmlContent );
	}

	public function updateXmlContent( $sContent )
	{
		$this->check();
		$this->_oMailing->oData->lazyData->xmlContent = Inx_Apiimpl_TConvert::TConvert( $sContent );
		$this->_oMailing->_aChangedAttrs[ Inx_Api_Mailing_Mailing::ATTRIBUTE_XML_CONTENT ] = true;
	}

	/**
	 * @return String
	 */
	public function getPlainTextXslt()
	{
		$this->check();
		return Inx_Apiimpl_TConvert::convert( $this->_oMailing->oData->lazyData->plainTextXsl );
	}

	/**
	 * @param String $sPlainTextXslt
	 */
	public function updatePlainTextXslt( $sPlainTextXslt )
	{
		$this->check();
		$this->_oMailing->oData->lazyData->plainTextXsl = Inx_Apiimpl_TConvert::TConvert( $sPlainTextXslt );
		$this->_oMailing->_aChangedAttrs[ Inx_Api_Mailing_Mailing::ATTRIBUTE_PLAIN_TEXT_XSL ] = true;
	}
	
	/**
	 * Enter description here...
	 *
	 * @return string
	 */
	public function getHtmlTextXslt()
	{
		$this->check();
		return Inx_Apiimpl_TConvert::convert( $this->_oMailing->oData->lazyData->htmlTextXsl );
	}

	/**
	 * Enter description here...
	 *
	 * @param String $sHtmlTextXslt
	 */
	public function updateHtmlTextXslt( $sHtmlTextXslt )
	{
		$this->check();
		$this->_oMailing->oData->lazyData->htmlTextXsl = Inx_Apiimpl_TConvert::TConvert( $sHtmlTextXslt );
		$this->_oMailing->_aChangedAttrs[ Inx_Api_Mailing_Mailing::ATTRIBUTE_HTML_TEXT_XSL ] = true;
	}
	
	/**
	 * @return Inx_Api_DesignTemplate_Style
	 */
	public function getStyle()
	{
		$this->check();
		$tStyle = $this->_oMailing->oData->lazyData->templateStyle;
		if ($tStyle == null)
			return null;
		return new Inx_Apiimpl_DesignTemplate_StyleImpl($tStyle->templateId, $tStyle->style);
	}
	 
	public function updateStyle( Inx_Api_DesignTemplate_Style $style )
	{
		$this->check();
		/**
		 * @var TemplateStyle
		 */
		$newStyle = new stdClass();
		$newStyle->templateId = $style->getTemplateId();
		$newStyle->style = $style->getStyleName();
		$this->_oMailing->oData->lazyData->templateStyle = $newStyle;
		$this->_oMailing->_aChangedAttrs[ Inx_Api_Mailing_Mailing::ATTRIBUTE_STYLE ] = true;
	}
}