<?php

/**
 * @package Inxmail
 * @subpackage Reporting
 */
/**
 * Every report type has a configuration descriptor. 
 * The <i>Inx_Api_Reporting_ConfigDescriptor</i> describes the structure and elements of the report configuration area. 
 * A <i>ConfigDescriptor</i> contains a set of <i>Inx_Api_Reporting_ControlUnit</i>s (mostly zero or one) which in turn 
 * contain a set of <i>Inx_Api_Reporting_Control</i>s. 
 * An <i>Inx_Api_Reporting_Control</i> describes a configuration element like the list or mailing chooser.
 * <p>
 * The following snippet shows how to print out the content of the <i>ConfigurationDescriptor</i> for the
 * ClickReactionTimeResponse report:
 * 
 * <pre>
 * $oReportEngine = $oSession->getReportEngine();
 * $oConfigDescriptor = $oReportEngine->getDescriptor( &quot;ClickReactionTimeResponse&quot;, &quot;en_GB&quot; );
 * 
 * echo &quot;&#60;pre&#62;&quot;;
 * echo &quot;Localized Report Title: &quot;.$oConfigDescriptor->getTitle().&quot;&#60;br&#62;&#60;br&#62;&quot;;
 * 
 * for( $i = 0; $i &lt; $oConfigDescriptor->getControlUnitCount(); $i++ )
 * {
 * 	echo &quot;Control Unit #&quot;.$i.&quot;:&#60;br&#62;&quot;;
 * 	$oControlUnit = $oConfigDescriptor->getControlUnit( $i );
 * 
 * 	echo &quot;Localized control title: &quot;.$oControlUnit->getTitle().&quot;&#60;br&#62;&quot;;
 * 
 * 	for( $j = 0; $j &lt; $oControlUnit->getControlCount(); $j++ )
 * 	{
 * 		$oControl = $oControlUnit->getControl( $j );
 * 
 * 		echo &quot;	Control #&quot;.$j.&quot;:&#60;br&#62;&quot;;
 * 		echo &quot;	Control type: &quot;.$oControl->getType().&quot;&#60;br&#62;&quot;;
 * 
 * 		foreach( $oControl->getPropertyKeys() as $sKey )
 * 		{
 * 			echo &quot;		Key: &quot;.$sKey.&quot; - Value: &quot;.$oControl->getProperty( $sKey ).&quot;&#60;br&#62;&quot;;
 * 		}
 * 	}
 * }
 * 
 * echo &quot;&#60;/pre&#62;&quot;;
 * </pre>
 * 
 * This snippet will produce the following output:
 * 
 * <pre>
 * Localized Report Title: Clicks over time
 * 
 * Control Unit #0:
 * Localized control title: Settings
 * 	Control #0:
 * 	Control type: mailingChooser
 * 		Key: listTitle - Value: Mailing list:
 * 		Key: mailingTitle - Value: Mailing:
 * 		Key: listBind - Value: listid
 * 		Key: mailingBind - Value: mailingid
 * 	Control #1:
 * 	Control type: simpleTimeIntervalControl
 * 		Key: title - Value: Report time period:
 * 		Key: countBind - Value: count
 * 		Key: intervalBind - Value: interval
 * 		Key: clause - Value: until today
 * </pre>
 * <p>
 * For more information on controls, see the <i>Inx_Api_Reporting_Control</i> documentation.
 * 
 * @see Inx_Api_Reporting_ReportEngine
 * @see Inx_Api_Reporting_ControlUnit
 * @see Inx_Api_Reporting_Control
 * @since   API 1.3
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 * @subpackage Reporting
 */
interface Inx_Api_Reporting_ConfigDescriptor
{
	
	/**
	 * Returns the localized title of this report.
	 * 
	 * @return string the localized title of this report.
	 */
	public function getTitle();
	
	
	/**
	 * Returns the <i>Inx_Api_Reporting_ControlUnit</i> at the specified position.
	 * 
	 * @param int $iIndex the index of the control unit to return.
	 * @return Inx_Api_Reporting_ControlUnit the control unit at the specified position.
	 */
	public function getControlUnit( $iIndex );
	
	
	/**
	 * Returns the number of <i>Inx_Api_Reporting_ControlUnit</i>s.
	 * 
	 * @return int the number of control units.
	 */
	public function getControlUnitCount();
	
}
