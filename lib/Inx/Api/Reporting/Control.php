<?php

/**
 * @package Inxmail
 * @subpackage Reporting
 */
/**
 * An <i>Inx_Api_Reporting_Control</i> describes a configuration element like the list or mailing chooser. 
 * You can determine which element a <i>Control</i> describes using the <i>getType()</i> method. 
 * For a list of all available types, see below. 
 * A <i>Control</i> also provides some localized labels and the names of the value bindings, used to set
 * the value of a property.
 * <p>
 * The following snippet shows how to use <i>getProperty($sKey)</i> to acquire the parameter bindings:
 * 
 * <pre>
 * $domainParam = $domainControl->getProperty( "bind" ); // $domainControl is of type stringControl
 * $intervalParam = $timeIntervalChooser->getProperty( "intervalBind" );
 * $countParam = $timeIntervalChooser->getProperty( "countBind" );
 *
 * $oReportRequest = new Inx_Api_Reporting_ReportRequest( "IncomingMailDetailsForDomain",
 *		Inx_Api_Reporting_ReportRequest::OUTPUT_FORMAT_HTML, "de_DE", "Europe/Berlin" );
 * $oReportRequest->putParameter( $domainParam, "org" );
 * $oReportRequest->putParameter( $intervalParam, "day" );
 * $oReportRequest->putParameter( $countParam, "14" );
 * </pre>
 * <p>
 * <b><u>Supported control types since Inxmail 3.5:</u></b>
 * <p>
 * <b>stringControl</b><br>
 * This control has following properties:<br>
 * title - the localized title of the control<br>
 * bind - the unique parameter key (like "domain"); the value as string (like "com")<br>
 * <p>
 * <b>timeIntervalChooser</b><br>
 * title - the localized title of this control<br>
 * beginBind - the unique parameter key; the begin date of the interval as number of milliseconds since January 1, 1970,
 * 00:00:00 GMT<br>
 * endBind - the unique parameter key; the end date of the interval as number of milliseconds since January 1, 1970,
 * 00:00:00 GMT<br>
 * intervalBind - the unique parameter key; the interval type - hour, day, week and month<br>
 * countBind - the unique parameter key; the count of intervals<br>
 * <p>
 * <b>simpleTimeIntervalControl</b><br>
 * title - the localized title of this control<br>
 * clause - the localized title of this control<br>
 * intervalBind - the unique parameter key; the interval type - hour, day, week and month<br>
 * countBind - the unique parameter key; the count of intervals<br>
 * <p>
 * <b>dateSpanControl</b><br>
 * title - the localized title of this control<br>
 * beginBind - the unique parameter key; the begin date of the interval as number of milliseconds since January 1, 1970,
 * 00:00:00 GMT<br>
 * endBind - the unique parameter key; the end date of the interval as number of milliseconds since January 1, 1970,
 * 00:00:00 GMT<br>
 * countBind - the unique parameter key; the count of intervals<br>
 * <p>
 * <b>limitControl</b><br>
 * title - the localized title of this control<br>
 * bind - the unique parameter key (like "limit"); the integer value as string (like "25")<br>
 * <p>
 * <b>attributeChooser</b><br>
 * title - the localized title of this control<br>
 * bind - the unique parameter key (like "attrid"); the parameter value is the attribute id<br>
 * <p>
 * <b>listChooser</b><br>
 * title - the localized title of this control<br>
 * bind - the unique parameter key (like "listid"); the parameter value is the list id<br>
 * <p>
 * <b>mailingChooser</b><br>
 * listTitle - the localized title of this control<br>
 * mailingTitle - the localized title of this control<br>
 * listBind - the unique parameter key (like "attrid"); the parameter value is the attribute id<br>
 * mailingBind - the unique parameter key (like "listid"); the parameter value is the list id<br>
 * <p>
 * <b>checkboxControl</b><br>
 * title - the localized title of this control<br>
 * bind - the unique parameter key (like "enabled1"); the valid values are "true" and "false"<br>
 * <p>
 * For more information on the report configuration in general, see the <i>Inx_Api_Reporting_ConfigDescriptor</i> documentation.
 * 
 * @see Inx_Api_Reporting_ControlUnit
 * @see Inx_Api_Reporting_ConfigDescriptor 
 * @since   API 1.3
 * @version $Revision: 9553 $ $Date: 2008-01-04 11:28:41 +0200 (Pn, 04 Sau 2008) $ $Author: vladas $
 * @package Inxmail
 * @subpackage Reporting
 */
interface Inx_Api_Reporting_Control
{
	
	/**
	 * Returns the type of this control.
	 * <p>
	 * The supported types are:
	 * <ul>
	 * <li>stringControl,
	 * <li>timeIntervalChooser,
	 * <li>simpleTimeIntervalControl,
	 * <li>dateSpanControl,
	 * <li>limitControl,
	 * <li>attributeChooser,
	 * <li>listChooser,
	 * <li>mailingChooser and
	 * <li>checkboxControl
	 * </ul>
	 * 
	 * @return string the type of this control.
	 */
	public function getType();
	
	
	/**
	 * Returns the value to which this control maps the specified key. 
	 * The control contains localized titles and parameter bindings.
	 * 
	 * @param string $sKey the key whose associated value shall be returned.
	 * @return string the value to which this control maps the specified key.
	 */
	public function getProperty( $sKey );

	
	/**
	 * Returns an array of the keys contained in this control.
	 * 
	 * @return array an array of the keys.
	 */
	public function getPropertyKeys();
}
