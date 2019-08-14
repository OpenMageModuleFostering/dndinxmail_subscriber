<?php
class Inx_Apiimpl_Recipient_ContextAttribute_Hardbounce extends Inx_Apiimpl_Recipient_ContextAttribute_Integer
{
	public function __construct( Inx_Apiimpl_Recipient_RecipientContextImpl $oRecipientContext, $oAttribute )
	{
		parent::__construct( $oRecipientContext, $oAttribute );
	}
}
