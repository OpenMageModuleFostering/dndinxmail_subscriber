<?php

class Inx_Apiimpl_SoapException extends Inx_Api_RemoteException
{
	public $oReturnObj;
    public function __construct($sMsg, $iType, $oReturnObj) 
	{
	    $this->oReturnObj  = $oReturnObj;
	    parent::__construct($sMsg, $iType);
	    
	}
}