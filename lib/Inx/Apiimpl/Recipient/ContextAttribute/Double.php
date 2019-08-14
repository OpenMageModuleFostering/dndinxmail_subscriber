<?php
class Inx_Apiimpl_Recipient_ContextAttribute_Double extends Inx_Apiimpl_Recipient_ContextAttribute
{
	public function __construct( Inx_Apiimpl_Recipient_RecipientContextImpl $oRecipientContext, $oAttribute )
	{
		parent::__construct( $oRecipientContext, $oAttribute );
	}
	 
	public function getDataType()
	{
		return Inx_Api_Recipient_Attribute::DATA_TYPE_DOUBLE;
	}
	 
	public function getObject( $oRecipientData )
	{
		return $this->getDouble( $oRecipientData );
	}

	public function getDouble( $oRecipientData )
	{
		if(empty($oRecipientData->doubleData[$this->_iTypeAttrIndex]))
			return null;
		return $oRecipientData->doubleData[$this->_iTypeAttrIndex]->value;
	}

	public function updateObject( $oRecipientData, &$aChangedAttrs, $oValue )
	{
		$this->updateDouble( $oRecipientData, $aChangedAttrs, (double)$oValue );
	}

	public function updateDouble( $oRecipientData, &$aChangedAttrs, $iValue )
	{
		$oRecipientData->doubleData[$this->_iTypeAttrIndex] = new stdClass();
		$oRecipientData->doubleData[$this->_iTypeAttrIndex]->value = $iValue;
		$aChangedAttrs[$this->_iArrayIndex] = true;
	}
	 
	public function createAttrUpdate( $newValue )
	{
		$upd = new stdClass();
		$upd->id = $this->_iId;
		$upd->doubleData = Inx_Apiimpl_TConvert::TConvert($newValue);
		return $upd;
	}
}
