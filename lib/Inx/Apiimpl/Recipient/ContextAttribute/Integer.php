<?php

class Inx_Apiimpl_Recipient_ContextAttribute_Integer extends Inx_Apiimpl_Recipient_ContextAttribute
{
	public function __construct( Inx_Apiimpl_Recipient_RecipientContextImpl $oRecipientContext, $oAttribute )
	{
		parent::__construct( $oRecipientContext, $oAttribute );
	}

	public function getDataType()
	{
		return Inx_Api_Recipient_Attribute::DATA_TYPE_INTEGER;
	}
	 
	public function getObject( $oRecipientData )
	{
		return $this->getInteger( $oRecipientData );
	}

	public function getInteger( $oRecipientData )
	{
		if(empty($oRecipientData->integerData[$this->_iTypeAttrIndex]))
			return null;		
		return $oRecipientData->integerData[ $this->_iTypeAttrIndex ]->value;
	}

	public function updateObject( $oRecipientData, &$aChangedAttrs, $value )
	{
		$this->updateInteger( $oRecipientData, $aChangedAttrs, (int)$value );
	}

	public function updateInteger( $oRecipientData, &$aChangedAttrs, $value )
	{
		$oRecipientData->integerData[$this->_iTypeAttrIndex] = new stdClass();
		$oRecipientData->integerData[$this->_iTypeAttrIndex]->value = $value;
		$aChangedAttrs[$this->_iArrayIndex] = true;
	}
	 
	public function createAttrUpdate( $newValue )
	{
		$upd = new stdClass();
		$upd->id = $this->_iId;
		$upd->integerData = Inx_Apiimpl_TConvert::TConvert($newValue);
		return $upd;
	}
}