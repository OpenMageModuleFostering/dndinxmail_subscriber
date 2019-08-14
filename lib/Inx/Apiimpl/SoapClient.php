<?php

class Inx_Apiimpl_SoapClient extends SoapClient 
{
	function __call($function_name, $arguments)
	{
		try {
			$oResult = parent::__call($function_name, $arguments);
		} catch (Exception $e) {
			throw new Inx_Api_RemoteException($e->getMessage(), $e->getCode(), $e);
		}
		return $oResult;
	}
} 