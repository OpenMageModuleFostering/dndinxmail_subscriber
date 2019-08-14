<?php
class Inx_Apiimpl_DesignTemplate_StyleImpl implements Inx_Api_DesignTemplate_Style
{
	private $_sStyleName;
	private $_iTemplateID;
	
	public function __construct( $iTemplaetIDIN, $sStyleIN )
	{
		$this->_iTemplateID = $iTemplaetIDIN;
		$this->_sStyleName = $sStyleIN;
	}
	
	public function getStyleName()
	{
		return $this->_sStyleName;
	}

	public function getTemplateId()
	{
		return $this->_iTemplateID;
	}
	//TODO ensure that those functions are not needed in php
//	public function equals( $o )
//	{
//		if (!isset($o->styleName) || !isset($o->))
//		return b.styleName == this.styleName && b.templateID == this.templateID;
//	}
//	
//	public int hashCode()
//	{
//		return this.styleName.hashCode() + templateID;
//	}
}
