<?php
class Inx_Apiimpl_Recipient_ContextAttribute_Time extends Inx_Apiimpl_Recipient_ContextAttribute
{
	public function __construct( Inx_Apiimpl_Recipient_RecipientContextImpl $oRecipientContext, $oAttribute )
	{
		parent::__construct( $oRecipientContext, $oAttribute );
	}
	 
	public function getDataType()
	{
		return Inx_Api_Recipient_Attribute::DATA_TYPE_TIME;
	}
	 
	public function getObject( $oRecipientData )
	{
		return $this->getTime( $oRecipientData );
	}

	public function getTime( $oRecipientData )
	{
		if(empty($oRecipientData->timeData[$this->_iTypeAttrIndex]))
			return null;		
		return $oRecipientData->timeData[ $this->_iTypeAttrIndex ]->value;
	}

	public function updateObject( $oRecipientData, &$aChangedAttrs, $value )
	{
		$this->updateTime( $oRecipientData, $aChangedAttrs, $value );
	}

	public function updateTime( $oRecipientData, &$aChangedAttrs, $value )
	{
		$oRecipientData->timeData[$this->_iTypeAttrIndex] = new stdClass();
		$oRecipientData->timeData[$this->_iTypeAttrIndex]->value = $value;
		$aChangedAttrs[$this->_iArrayIndex] = true;
	}
	 
	public function createAttrUpdate( $newValue )
	{
		$upd = new stdClass();
		$upd->id = $this->_iId;
		$upd->timeData = Inx_Apiimpl_TConvert::TConvert($newValue);
		return $upd;
	}
}
