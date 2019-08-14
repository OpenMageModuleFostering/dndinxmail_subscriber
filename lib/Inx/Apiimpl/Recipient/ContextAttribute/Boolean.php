<?php
class Inx_Apiimpl_Recipient_ContextAttribute_Boolean extends Inx_Apiimpl_Recipient_ContextAttribute
{
	public function __construct( Inx_Apiimpl_Recipient_RecipientContextImpl $oRecipientContext, $oAttribute )
	{
		parent::__construct( $oRecipientContext, $oAttribute );
	}
	 
	public function getDataType()
	{
		return Inx_Api_Recipient_Attribute::DATA_TYPE_BOOLEAN;
	}
	 
	public function getObject( $oRecipientData )
	{
		return $this->getBoolean( $oRecipientData );
	}

	public function getBoolean( $oRecipientData )
	{
		if (!empty($oRecipientData->booleanData[$this->_iTypeAttrIndex]->value))
			return ($oRecipientData->booleanData[$this->_iTypeAttrIndex]->value)? true:false;
		return false;
	}

	public function updateObject( $oRecipientData, &$aChangedAttrs, $value )
	{
		$this->updateBoolean( $oRecipientData, $aChangedAttrs, $value );
	}

	public function updateBoolean( $oRecipientData, &$aChangedAttrs, $blValue )
	{
		$oRecipientData->booleanData[$this->_iTypeAttrIndex] = new stdClass();
		$oRecipientData->booleanData[$this->_iTypeAttrIndex]->value = $blValue;
		$aChangedAttrs[$this->_iArrayIndex] = true;
	}
	 
	public function createAttrUpdate( $blNewValue )
	{
		$upd = new stdClass();
		$upd->id = $this->_iId;
		$upd->booleanData = Inx_Apiimpl_TConvert::TConvert($blNewValue);
		return $upd;
	}
}


