<?php
class Inx_Apiimpl_Recipient_ContextAttribute_Date extends Inx_Apiimpl_Recipient_ContextAttribute
{
	public function __construct( Inx_Apiimpl_Recipient_RecipientContextImpl $oRecipientContext, $oAttribute )
	{
		parent::__construct( $oRecipientContext, $oAttribute );
	}
	 
	public function getDataType()
	{
		return Inx_Api_Recipient_Attribute::DATA_TYPE_DATE;
	}
	 
	public function getObject( $oRecipientData )
	{
		return $this->getDate( $oRecipientData );
	}

	public function getDate( $oRecipientData )
	{
		if(empty($oRecipientData->dateData[$this->_iTypeAttrIndex]))
			return null;
		return $oRecipientData->dateData[$this->_iTypeAttrIndex]->value;
	}

	public function updateObject( $oRecipientData, &$aChangedAttrs, $value )
	{
		$this->updateDate( $oRecipientData, $aChangedAttrs, $value );
	}

	public function updateDate( $oRecipientData, &$aChangedAttrs, $value )
	{
		$oRecipientData->dateData[$this->_iTypeAttrIndex] = new stdClass();
		$oRecipientData->dateData[$this->_iTypeAttrIndex]->value = $value;
		$aChangedAttrs[$this->_iArrayIndex] = true;
	}
	 
	public function createAttrUpdate( $newValue )
	{
		$upd = new stdClass();
		$upd->id = $this->_iId;
		$upd->dateData = Inx_Apiimpl_TConvert::TConvert($newValue);
		return $upd;
	}
}
