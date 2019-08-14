<?php
/**
 * @author nds
 * 
 */
class Inx_Apiimpl_DesignTemplate_TemplateImpl implements Inx_Api_DesignTemplate_Template
{
	private $_oData;

	/**
	 * 
	 */
	public function __construct( stdClass $oData )
	{
		$this->_oData = $oData;
	}

	/**
	 * @see com.inxmail.xpro.api.designtemplate.Template#getHTMLStyleNames()
	 */
	public function getHTMLStyles()
	{
		$aNames = $this->_oData->html_styles;
		$s = array();
		foreach ($aNames as $key => $sName) {
		    $s[$key] = new Inx_Apiimpl_DesignTemplate_StyleImpl($this->getId(), $sName); 
		}
		
		return $s;
	}

	/**
	 * @see com.inxmail.xpro.api.designtemplate.Template#getName()
	 */
	public function getName()
	{
		return $this->_oData->name;
	}

	/**
	 * @see com.inxmail.xpro.api.designtemplate.Template#getTextStyleNames()
	 */
	public function getTextStyles()
	{
		$aNames = $this->_oData->text_styles;
		$s = array();
		foreach($aNames as $key => $sName) {
		    $s[$key] = new Inx_Apiimpl_DesignTemplate_StyleImpl($this->getId(), $sName);
		}
		return $s;
	}

	/**
	 * @see com.inxmail.xpro.api.BusinessObject#getId()
	 */
	public function getId()
	{
		return $this->_oData->id;
	}

	public static function convert( $oData )
	{
		return new Inx_Apiimpl_DesignTemplate_TemplateImpl( $oData );
	}

}
