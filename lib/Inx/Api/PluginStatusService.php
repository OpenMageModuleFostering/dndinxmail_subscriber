<?php
/**
 * @package Inxmail
 */


abstract class Inx_Api_PluginStatusService
{
	protected $oService;

	protected static $_aProperties = array();
	protected $_sApplicationUrl = null;

	public static function create( $applicationUrl )
	{
		try
		{
			return new Inx_Apiimpl_AxisPluginStatusService($applicationUrl);
		}
		catch( Exception $x )
		{
			throw new Inx_Api_APIException( "Unknown error in PluginStatusService", $x );
		}
	}


	public function isPluginInstalled( $sPluginSecretId )
	{
		try
		{
			return $this->oService->isPluginInstalled( $sPluginSecretId );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->rebuildException( $x );
			return null;
		}
	}


	public function isPluginActive( $pluginSecretId, $listContextId )
	{
		try
		{
			return $this->oService->isPluginActive( $pluginSecretId, $listContextId );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->rebuildException( $x );
			return null;
		}
	}


	public function getListContextIdsWherePluginActive( $pluginSecretId )
	{

		try
		{
			return $this->oService->getListContextIdsWherePluginActive( $pluginSecretId );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->rebuildException( $x );
			return null;
		}
	}


	protected abstract function rebuildException( Inx_Api_RemoteException $e );
	
	

	/**
	 * Sets property value
	 *
	 * @param string $sKey Property name. Possible values are: <i>http.proxyHost</i>, <i>http.proxyPort</i>, <i>http.proxyUser</i>, <i>http.proxyPassword</i>, <i>soap.connectionTimeout</i> 
	 * @param string|int $sValue
	 */
	public static function setProperty($sKey, $mxValue)
	{
		if (empty($sKey)) {
			throw new Inx_Api_IllegalArgumentException("Key can't be empty.");
		}
		
		if (! (is_string($mxValue) || is_int($mxValue))) {
			throw new Inx_Api_IllegalArgumentException("Value must be string or int.");
		}
		
		self::$_aProperties[$sKey] = $mxValue;
	}
	
	/**
	 * Returns property value
	 *
	 * @param string $sKey
	 * @return string|int
	 */
	public static function getProperty($sKey)
	{
		if (empty($sKey)) {
			throw new Inx_Api_IllegalArgumentException("Key can't be empty.");
		}
		if (isset(self::$_aProperties[$sKey])) {
			return self::$_aProperties[$sKey];
		}
		
		return null;
	}
}
