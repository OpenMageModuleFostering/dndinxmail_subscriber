<?php

/**
 * ControlImpl
 * 
 * @version $Revision: 5007 $ $Date: 2006-10-17 11:39:33 +0000 (Di, 17 Okt 2006) $ $Author: bgn $
 */
class Inx_Apiimpl_Reporting_ControlImpl implements Inx_Api_Reporting_Control
{

	protected $_sType;
	
	protected $_aProps = array();
	
	
	public function __construct( $oData )
	{
		$this->_sType = $oData->type;
		
		if( $oData->propKeys !== null )
		{
		    foreach ($oData->propKeys as $key => $val) {
		        $this->_aProps[$val] = $oData->propValues[$key];
		    }
		}
	}
	
	
	/**
	 * @see com.inxmail.xpro.api.reporting.Control#getType()
	 */
	public function getType()
	{
		return $this->_sType;
	}
	
	
	/**
	 * @see com.inxmail.xpro.api.reporting.Control#getProperty(java.lang.String)
	 */
	public function getProperty( $sKey )
	{
		if (isset($this->_aProps[$sKey])) {
		    return $this->_aProps[$sKey];
		}
	    return null;
	}
	
	
	/**
	 * @see com.inxmail.xpro.api.reporting.Control#getPropertyKeys()
	 */
	public function getPropertyKeys()
	{
		return array_keys($this->_aProps);
	}
}
