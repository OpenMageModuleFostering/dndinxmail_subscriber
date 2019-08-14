<?php

/**
 * @package Inxmail
 * @subpackage Reporting
 */
/**
 * The <i>Inx_Api_Reporting_ControlUnit</i> describes the configuration area of a report. 
 * It holds the localized title and a list of <i>Inx_Api_Reporting_Control</i>s. 
 * <i>Inx_Api_Reporting_Control</i>s describe configuration elements like the list or mailing chooser.
 * <p>
 * For more information on controls, see the <i>Inx_Api_Reporting_Control</i> documentation.
 * <p>
 * For more information on the report configuration in general, see the <i>Inx_Api_Reporting_ConfigDescriptor</i> documentation.
 * 
 * @see Inx_Api_Reporting_ConfigDescriptor
 * @see Inx_Api_Reporting_Control
 * @since   API 1.3
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 * @subpackage Reporting
 */
interface Inx_Api_Reporting_ControlUnit
{
	
	/**
	 * Returns the localized title of this control unit.
	 * 
	 * @return string the localized title of this control unit.
	 */
	public function getTitle();

	
	/**
	 * Returns the control at the specified position.
	 * 
	 * @param int $iIndex the index of the control to return.
	 * @return Inx_Api_Reporting_Control the control at the specified position.
	 */
	public function getControl( $iIndex );
	
	
	/**
	 * Returns the number of controls.
	 * 
	 * @return int the number of controls.
	 */
	public function getControlCount();

}
