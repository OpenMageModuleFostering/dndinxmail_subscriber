<?php
/**
 * @package Inxmail
 */
/**
 * @package Inxmail
 */
class Inx_Api_RemoteException extends Exception
{
	protected $_oOrigExc = null;
	
	/**
	 * Enter description here...
	 *
	 * @param string $sMsg
	 * @param int $iCode
	 * @param Exception $oOrigExc original exception object
	 */
	public function __construct($sMsg, $iCode=null, $oOrigExc=null)
	{
		$this->_oOrigExc = $oOrigExc;
		parent::__construct($sMsg, $iCode);
	}
	/**
	 * @return Exception object
	 */
	public function getOrigException()
	{
		return $this->_oOrigExc; 
	}
}