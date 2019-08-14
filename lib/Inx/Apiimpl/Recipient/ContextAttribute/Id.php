<?php
class Inx_Apiimpl_Recipient_ContextAttribute_Id extends Inx_Apiimpl_Recipient_ContextAttribute
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
		return (int)$oRecipientData->id ;
	}

	public function getInteger( $oRecipientData )
	{
		return (int)$oRecipientData->id;
	}

	public function updateObject( $oRecipientData, &$aChangedAttrs, $sValue )
	{
		throw new Exception( "id attribute isn't updateable" );
	}

	public function updateInteger( $oRecipientData, &$aChangedAttrs, $sValue )
	{
		throw new Exception( "id attribute isn't updateable" );
	}
	 
	public function createAttrUpdate( $sNewValue )
	{
		throw new Exception( "id attribute isn't updateable" );
	}
}