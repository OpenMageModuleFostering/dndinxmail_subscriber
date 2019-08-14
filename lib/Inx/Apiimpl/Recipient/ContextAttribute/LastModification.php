<?php
class Inx_Apiimpl_Recipient_ContextAttribute_LastModification extends Inx_Apiimpl_Recipient_ContextAttribute_Datetime
{
	public function __construct( Inx_Apiimpl_Recipient_RecipientContextImpl $oRecipientContext, $oAttribute )
	{
		parent::__construct( $oRecipientContext, $oAttribute );
	}
	 
	public function updateObject( $oRecipientData, &$aChangedAttrs, $value )
	{
		throw new Inx_Api_IllegalStateException( "last modification attribute isn't updateable" );
	}

	public function updateDatetime( $oRecipientData, &$aChangedAttrs, $value )
	{
		throw new Inx_Api_IllegalStateException( "last modification attribute isn't updateable" );
	}
	 
	public function createAttrUpdate( $newValue )
	{
		throw new Inx_Api_IllegalStateException( "last modification attribute isn't updateable" );
	}
}
