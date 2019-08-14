<?php
/**
 * Created on 2007.11.19
 *
 * @copyright (C) UAB "Net frequency" 2007
 *
 * This Software is the property of UAB "Net frequency" 
 * and is protected by copyright law - it is NOT Freeware.
 *
 * Any use of this software without a permission from
 * UAB "Net frequency" will be prosecuted by
 * civil and criminal law.
 *
 * Contact UAB "Net frequency":
 * E-mail: info@nfq.lt
 * Phone: +370 37 333053
 * http://www.nfq.lt
 */
 
 class Inx_Apiimpl_SoapSession extends Inx_Apiimpl_AbstractSession 
 {
 	const API_ID = "v1.10.0|php5";
 	
 	public function __construct($sApplicationUrl, $sUsername,
			$sPassword, $blPwdEncrypted=false, $sLoginToken = null, $pluginSecretId = null) {

		$this->_sApplicationUrl = rtrim($sApplicationUrl, '/') . '/api/';
		if(empty($sLoginToken))
 			$this->_login($sUsername, $sPassword, $blPwdEncrypted, self::API_ID);
 		else if(empty($pluginSecretId))
 			$this->_login2($sLoginToken, self::API_ID);
 		else
 			$this->_login3($pluginSecretId, $sUsername, $sPassword, $blPwdEncrypted, self::API_ID);
 	}
	
 	public function getService($sServiceName) 
	{
		if ( ! isset($this->_aServiceMap[$sServiceName]) 
			 || ! $this->_aServiceMap[$sServiceName] instanceof Inx_Apiimpl_SoapClient) {
			 	
			$sApiServletUrl = $this->_sApplicationUrl . $sServiceName;
			if(defined('TEST_WSDL_LOCATION'))
				$sWsdlLocation = TEST_WSDL_LOCATION.DIRECTORY_SEPARATOR . $sServiceName . '.wsdl';
			else
				$sWsdlLocation = dirname(__FILE__).DIRECTORY_SEPARATOR.'wsdl'.DIRECTORY_SEPARATOR . $sServiceName . '.wsdl';
			
			// Magento compilation FIX
			if (defined('COMPILER_INCLUDE_PATH')) {
				$sWsdlLocation = Mage::getBaseDir('lib').DIRECTORY_SEPARATOR.'Inx'.DIRECTORY_SEPARATOR.'Apiimpl'.DIRECTORY_SEPARATOR.'wsdl'.DIRECTORY_SEPARATOR . $sServiceName . '.wsdl';
			}
			// / Magento compilation FIX
			
			if (file_exists($sWsdlLocation)) {
				$aArgs = array();
				//$aArgs['trace'] = 1;//DEBUG
				$aArgs['location'] = $sApiServletUrl; 
				$aArgs['uri'] = self::$_aServiceDescriptors[$sServiceName];

				if ($proxy_host = self::getProperty('http.proxyHost')) {
					$aArgs['proxy_host'] = $proxy_host;
				}
				
				if ($proxy_port = self::getProperty('http.proxyPort')) {
					$aArgs['proxy_port'] = $proxy_port;
				}
				
				if ($proxy_login = self::getProperty('http.proxyUser')) {
					$aArgs['proxy_login'] = $proxy_login;
				}
				
				if ($proxy_password = self::getProperty('http.proxyPassword')) {
					$aArgs['proxy_password'] = $proxy_password;
				}
				
				if ($soap_connection_timeout = self::getProperty('soap.connectionTimeout')) {
				    $aArgs['connection_timeout'] = $soap_connection_timeout;
				}
				
				$this->_aServiceMap[$sServiceName] = 
				        new Inx_Apiimpl_SoapClient(
				                $sWsdlLocation, 
				                $aArgs
				        );	
				//print_r($this->_aServiceMap[$sServiceName]->__getFunctions());
			} else {
				throw new Inx_Api_APIException('Wsdl file does not exist: ' . $sWsdlLocation);
			}																									    
		}
		
		return $this->_aServiceMap[$sServiceName];
	}
	
	/**
	 * @param Exception $e Exception to rebuild
	 */
	public function rebuildException(Inx_Api_RemoteException $e) {
	    $axisMsg = "java.rmi.RemoteException: ";
	    $msg = $e->getMessage();
	    if (isset($msg) && strpos($msg, $axisMsg)===0) {
	        $msg = substr($msg, strlen($axisMsg));
	        if (strpos($msg, Inx_Apiimpl_Constants::SECURITY_EXCEPTION) === 0) {
	            throw new Inx_Api_SecurityException(
	                    substr(
	                        $msg, 
	                        strpos(
	                            $msg, 
	                            'java.lang.SecurityException: '
	                         ) +  strlen('java.lang.SecurityException: ')));
	        }
	        //fixes XAPI-53: replaced substr with strpos
	        elseif (strpos($msg, Inx_Apiimpl_Constants::MEMORY_EXCEPTION) === 0) {
	            throw new Inx_Api_APIException("Out of memory: server cannot allocate more objects");
	        }
	        //fixes XAPI-53: replaced substr with strpos
	        elseif (strpos($msg, Inx_Apiimpl_Constants::SERVER_INACTIVE_EXCEPTION) === 0) {
	            throw new Inx_Api_APIException("inxmail server is inactive");
	        }
	    }
	    throw new Inx_Api_APIException($msg);
	}
 }
 
 
?>
