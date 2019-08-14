<?php

class Inx_Apiimpl_Action_CommandImpl_RemoveRecipientCmd 
                                extends Inx_Apiimpl_Action_CommandImpl 
                                implements Inx_Api_Action_DeleteRecipientCommand 
{
	public function __construct( $oCommandData = null )
	{
		
		if (isset($oCommandData)) {
		    return parent::__construct($oCommandData);
		}
		parent::__construct( Inx_Apiimpl_Action_CommandImpl::createCommandData());
		$this->_oCommandData = new stdClass;
		$this->_oCommandData->type = self::DELETE_MEMBER_CMD_TYPE;
	}
	
	
	public function toString()
	{
		return "RemoveCommand";
	}
	
	public function __toString() 
	{
	    return $this->toString();
	}
}