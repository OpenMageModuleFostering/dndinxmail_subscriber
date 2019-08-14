<?php
/**
 * ConfigDescriptorImpl
 * 
 * @version $Revision: 4396 $ $Date: 2006-08-14 12:38:05 +0000 (Mo, 14 Aug 2006) $ $Author: bgn $
 */
class Inx_Apiimpl_Reporting_ConfigDescriptorImpl implements Inx_Api_Reporting_ConfigDescriptor
{

	protected $_sTitle;
	
	protected $_aControlUnits = null;
	
	
	public function __construct( $oData )
	{
		$this->_sTitle = $oData->displayName;
		if( $oData->controlUnits !== null )
		{
			$this->_aControlUnits = array();
			foreach($oData->controlUnits as $key => $val) {
			    $this->_aControlUnits[$key] = new Inx_Apiimpl_Reporting_ControlUnitImpl($val);
			}
		}
	}
	

	public function getTitle()
	{
		return $this->_sTitle;
	}
	

	public function getControlUnit( $iIndex )
	{
	    if (!is_int($iIndex)) {
		    throw new Inx_Api_IllegalArgumentException('Wrong parameter $iIndex type, integer expected');
		}
	    return $this->_aControlUnits[ $iIndex ];
	}
	
	
	public function getControlUnitCount()
	{
		if( $this->_aControlUnits === null )
			return 0;
		
		return count($this->_aControlUnits);
	}
}
