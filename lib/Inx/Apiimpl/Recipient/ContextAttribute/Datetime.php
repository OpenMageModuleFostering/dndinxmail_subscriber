<?php
class Inx_Apiimpl_Recipient_ContextAttribute_Datetime extends Inx_Apiimpl_Recipient_ContextAttribute
{
	public function __construct( Inx_Apiimpl_Recipient_RecipientContextImpl $oRecipientContext, $oAttribute )
	{
		parent::__construct( $oRecipientContext, $oAttribute );
	}
	 
	public function getDataType()
	{
		return Inx_Api_Recipient_Attribute::DATA_TYPE_DATETIME;
	}
	 
	public function getObject( $oRecipientData )
	{
		return $this->getDatetime( $oRecipientData );
	}

	public function getDatetime( $oRecipientData )
	{
		if(empty($oRecipientData->datetimeData[$this->_iTypeAttrIndex]))
			return null;
		return  $oRecipientData->datetimeData[$this->_iTypeAttrIndex]->value;
	}

	public function updateObject( $oRecipientData, &$aChangedAttrs, $value )
	{
		$this->updateDatetime( $oRecipientData, $aChangedAttrs, $value );
	}

	public function updateDatetime( $oRecipientData, &$aChangedAttrs, $value )
	{
		$oRecipientData->datetimeData[$this->_iTypeAttrIndex] = new stdClass;
	    $oRecipientData->datetimeData[$this->_iTypeAttrIndex]->value = $value;
		$aChangedAttrs[$this->_iArrayIndex] = true;
	}
	 
	public function createAttrUpdate( $newValue )
	{
		$upd = new stdClass();
		$upd->id = $this->_iId;
		$upd->datetimeData = Inx_Apiimpl_TConvert::TConvert($newValue);
		return $upd;
	}
}