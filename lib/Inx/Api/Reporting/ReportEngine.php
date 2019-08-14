<?php
/**
 * @package Inxmail
 * @subpackage Reporting
 */
/**
 * The <i>Inx_Api_Reporting_ReportEngine</i> is used to generate reports. 
 * To generate a report, you first need to create an <i>Inx_Api_Reporting_ReportRequest</i> which contains the relevant 
 * information needed to generate the report:
 * <p>
 * <ul>
 * <li>The report name
 * <li>The output format (e.g. OUTPUT_FORMAT_HTML, OUTPUT_FORMAT_PDF_A4)
 * <li>The output locale (e.g. "de_DE", "en_GB")
 * <li>The output time zone (e.g. "Europe/Berlin", "America/New_York")
 * <li>Probably some report specific properties (e.g. "listid")
 * </ul>
 * The report request is sent to the server where the actual report generation takes place. 
 * The <i>ReportEngine</i> returns an <i>Inx_Api_Reporting_ReportTicket</i> which can be used to retrieve the result as
 * <i>Inx_Api_Reporting_DownloadableResult</i>. 
 * However, be aware that the report generation is processed asynchronous. 
 * Therefore, the <i>DownloadableResult</i> must be polled until it is available. 
 * Once it is available an <i>Inx_Api_InputStream</i> may be retrieved which can be used to download the report in the 
 * desired output format.
 * <p>
 * The following snippet shows how to download the report 'SystemDomainDistribution' as PDF report in the 
 * German locale and time zone with a limit of 20 entries and save it to the file 'SystemDomainDistribution.pdf':
 * 
 * <pre>
 * $oReportRequest = new Inx_Api_Reporting_ReportRequest( &quot;SystemDomainDistribution&quot;,
 * 		Inx_Api_Reporting_ReportRequest::OUTPUT_FORMAT_PDF_A4, &quot;de_DE&quot;, &quot;Europe/Berlin&quot; );
 * $oReportRequest->putParameter( &quot;limit&quot;, &quot;20&quot; );
 *  
 * $oReportEngine = $oSession->getReportEngine();
 * $oReportTicket = $oReportEngine->generate( $oReportRequest, false );
 *  
 * $oResult = $oReportTicket->fetchDownloadableResult();
 * while( $oResult == null )
 * {
 * 	sleep( 3 );
 * 	$oResult = $oReportTicket->fetchDownloadableResult();
 * }
 *  
 * $sOutputFile = &quot;SystemDomainDistribution.pdf&quot;;
 * download( $oResult->getInputStream(), $sOutputFile );
 * 
 * if( $oReportTicket != null )
 * {
 * 	$oReportTicket->close();
 * }
 * </pre>
 * <p>
 * The <i>download()</i> method - which is not part of the API - may be used to save the report to a file on disk.
 * The following snippet shows the definition of the <i>download()</i> method:
 * <p>
 * 
 * <pre>
 * function download($inputStream, $sFileName)
 * {
 *  $handle = fopen($sFileName, 'w+b');
 *  while (($ch = $inputStream->read()) != -1) 
 *  {
 *   fwrite($handle, $ch);
 *  }
 * 
 *  $inputStream->close();
 *  fclose($handle);
 * }
 * </pre>
 * <p>
 * For a complete list of the available reports and the properties associated with them, see Appendix A of the API
 * developer guide.
 * 
 * @see Inx_Api_Reporting_ReportRequest
 * @see Inx_Api_Reporting_ReportTicket
 * @since API 1.3 
 * @version $Revision: 9553 $ $Date: 2008-01-04 11:28:41 +0200 (Pn, 04 Sau 2008) $ $Author: vladas $
 * @package Inxmail
 * @subpackage Reporting
 */
interface Inx_Api_Reporting_ReportEngine
{
	
	/**
	 * This method is used to initiate the generation of the report specified by the given <i>Inx_Api_Reporting_ReportRequest</i>.
	 * The returned <i>Inx_Api_Reporting_ReportTicket</i> may be used to poll for the <i>Inx_Api_Reporting_DownloadableResult</i> 
	 * used to download the generated report. 
	 * For an example on how to do this, see the documentation of this class.
	 * 
	 * @param Inx_Api_Reporting_ReportRequest $oRequest the description of the report to generate.
	 * @param boolean $blIgnoreCache <i>true</i> if the cache shall be ignored, <i>false</i> otherwise. 
	 * 			This will force the report to be generated instead of using a previously generated report.
	 * @return Inx_Api_Reporting_ReportTicket a report ticket which can be used to poll for the <i>DownloadableResult</i>.
	 */
	public function generate( Inx_Api_Reporting_ReportRequest $oRequest, $blIgnoreCache );
	

	/**
	 * Returns all names of the default and custom report types.
	 * 
	 * @return array all names of the default and custom report types.
	 */
	public function getReportNames();

	
	/**
	 * Returns the localized <i>Inx_Api_Reporting_ConfigDescriptor</i> of the specified report. 
	 * The <i>ConfigDescriptor</i> describes the structure and elements of the report configuration area. 
	 * A <i>ConfigDescriptor</i> contains a set of <i>Inx_Api_Reporting_ControlUnit</i>s which in turn contain a set 
	 * of <i>Inx_Api_Reporting_Control</i>s. 
	 * A <i>Control</i> describes a configuration element like the list or mailing chooser.
	 * 
	 * @param string $sReportName the name of the report whose configuration descriptor shall be returned.
	 * @param string $sLocale the locale in which the <code>ConfigDescriptor</code> shall be returned. Use the name of the
	 *            locale, with the language (defined by ISO-639) or the language and country (defined by ISO-3166)
	 *            separated by an underscore. For example: "de_DE", "de_CH", "de", "en", "en_GB", "it_IT", "fr_FR"
	 * @return Inx_Api_Reporting_ConfigDescriptor the localized descriptor of the specified report, or null if the report 
	 * 			name is unknown.
	 */
	public function getDescriptor( $sReportName, $sLocale );

	
	/**
	 * Returns all supported time zones.
	 * 
	 * @return array all supported time zones as string array.
	 */
	public function getSupportedTimeZones();
}
