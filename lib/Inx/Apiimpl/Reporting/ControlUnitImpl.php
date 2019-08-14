<?php
/**
 * ControlUnitImpl
 * 
 * @version $Revision: 4396 $ $Date: 2006-08-14 12:38:05 +0000 (Mo, 14 Aug 2006) $ $Author: bgn $
 */
class Inx_Apiimpl_Reporting_ControlUnitImpl implements Inx_Api_Reporting_ControlUnit
{

	protected $_sTitle;
	
	protected $_aControls = null;
	
	
	public function __construct( $oData )
	{
		$this->_sTitle = $oData->title;
		if( $oData->controls !== null )
		{
			$this->_aControls = array();
			foreach($oData->controls as $key => $val) {
			    $this->_aControls[$key] = new Inx_Apiimpl_Reporting_ControlImpl( $val );
			}
		}
	}
	
	
	/**
	 * @see com.inxmail.xpro.api.reporting.ControlUnit#getTitle()
	 */
	public function getTitle()
	{
		return $this->_sTitle;
	}
	

	/**
	 * @see com.inxmail.xpro.api.reporting.ControlUnit#getControl(int)
	 */
	public function getControl( $iIndex )
	{
	    if (!is_int($iIndex)) {
		    throw new Inx_Api_IllegalArgumentException('Wrong parameter $iIndex type, integer expected');
		}
	    return $this->_aControls[ $iIndex ];
	}
	
	
	/**
	 * @see com.inxmail.xpro.api.reporting.ControlUnit#getControlCount()
	 */
	public function getControlCount()
	{
		if( $this->_aControls === null )
			return 0;
		
		return count($this->_aControls);
	}
}
