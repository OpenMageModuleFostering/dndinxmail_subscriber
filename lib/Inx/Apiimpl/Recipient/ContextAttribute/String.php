<?php
class Inx_Apiimpl_Recipient_ContextAttribute_String extends Inx_Apiimpl_Recipient_ContextAttribute
{
	public function __construct( Inx_Apiimpl_Recipient_RecipientContextImpl $oRecipientContext, $oAttribute )
	{
		parent::__construct( $oRecipientContext, $oAttribute );
	}

	public function getDataType()
	{
		return Inx_Api_Recipient_Attribute::DATA_TYPE_STRING;
	}

	public function getObject( $oRecipientData )
	{
		return $this->getString( $oRecipientData );
	}

	public function getString( $oRecipientData )
	{
		if(empty($oRecipientData->stringData[$this->_iTypeAttrIndex]))
			return null;
		return $oRecipientData->stringData[$this->_iTypeAttrIndex]->value;
	}

	public function updateString( $oRecipientData, &$aChangedAttrs, $sValue )
	{
		$oRecipientData->stringData[$this->_iTypeAttrIndex] = new stdClass;
	    $oRecipientData->stringData[$this->_iTypeAttrIndex]->value = (string)$sValue;
		$aChangedAttrs[$this->_iArrayIndex] = true;
	}
	
	public function updateObject( $oRecipientData, &$aChangedAttrs, $value )
	{
		$this->updateString( $oRecipientData, $aChangedAttrs, $value );
	}
	public function createAttrUpdate( $newValue )
	{
		$upd = new stdClass();
		$upd->id = $this->_iId;
		$upd->stringData = Inx_Apiimpl_TConvert::TConvert($newValue);
		return $upd;
	}
}