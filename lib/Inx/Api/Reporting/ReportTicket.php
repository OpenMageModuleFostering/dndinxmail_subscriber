<?php
/**
 * @package Inxmail
 * @subpackage Reporting
 */
/**
 * The <i>Inx_Api_Reporting_ReportTicket</i> is a handle to access the report. 
 * Using the <i>Inx_Api_Reporting_ReportEngine</i> it is not possible to generate a report synchronous. 
 * The <i>Inx_Api_Reporting_ReportRequest</i> is sent to the server instead, where the actual generation takes place. 
 * This generation is processed asynchronous, thus the result must be polled. 
 * This polling is accomplished using the <i>ReportTicket</i> returned by 
 * <i>Inx_Api_Reporting_ReportEngine::generate($oRequest, $blIgnoreCache)</i>.
 * <p>
 * The following snippet briefly shows how to retrieve and use a <i>ReportTicket</i>:
 * 
 * <pre>
 * $oReportRequest = new Inx_Api_Reporting_ReportRequest( "SystemDomainDistribution",
 *		Inx_Api_Reporting_ReportRequest::OUTPUT_FORMAT_PDF_A4, "de_DE", "Europe/Berlin" );
 * $oReportRequest->putParameter( "limit", 20 );
 *
 * $oTicket = $oSession->getReportEngine()->generate( $oReportRequest, false );
 * try
 * {
 * 	$oDownloadableResult = $oTicket->fetchDownloadableResult();
 * 	while( $oDownloadableResult == null )
 * 	{
 * 		echo  "Waiting for the report to finish..." ;
 * 		sleep( 3 );
 * 		$oDownloadableResult = $oTicket->fetchDownloadableResult();
 * 	}
 * 
 * 	$oInputStream = $oDownloadableResult->getInputStream();
 * 	...
 * }
 * catch( ReportException x )
 * {
 * 	echo $x->getMessage();
 * }
 * 
 * if($oTicket != null)
 * {
 * 	$oTicket->close();
 * }
 * </pre>
 * <p>
 * The <i>Inx_Api_Reporting_DownloadableResult</i> fetched from the <i>ReportTicket</i> is used to download the generated report.
 * <i>fetchDownloadableResult()</i> will return <i>null</i> as long as the report generation is not finished. 
 * To download the report, just poll for the <i>DownloadableResult</i> to become something different from <i>null</i>
 * and use the provided <i>Inx_Api_InputStream</i> to download the report.
 * <p>
 * <strong>Note:</strong> An <i>Inx_Api_Reporting_ReportTicket</i> object <strong>must</strong> be closed once it is not needed
 * anymore to prevent memory leaks and other potentially harmful side effects.
 * <p>
 * For a more complete example on how to generate and retrieve reports, see the <i>Inx_Api_Reporting_ReportEngine</i> documentation.
 * 
 * @see Inx_Api_Reporting_ReportEngine
 * @since API 1.3 
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 * @subpackage Reporting
 */
interface Inx_Api_Reporting_ReportTicket
{
	
	/**
	 * The original description used to generate this report.
	 * 
	 * @return Inx_Api_Reporting_ReportRequest the report request
	 */
	public function getReportRequest();
	
	
	/**
	 * Returns the <i>Inx_Api_Reporting_DownloadableResult</i> object, if the report is completely generated. 
	 * Returns <i>null</i>, if the generation of the report has not yet finished.
	 * 
	 * @return the <i>DownloadableResult</i> or <i>null</i>.
	 * @throws Inx_Api_Reporting_ReportException if an error in the report engine has occurred.
	 */
	public function fetchDownloadableResult();


	/**
     * Closes this <i>Inx_Api_Reporting_ReportTicket</i> and releases any resources on
     * the server associated with this object.
     * An <i>Inx_Api_Reporting_ReportTicket</i> object <strong>must</strong> be closed once it is not needed
 	 * anymore to prevent memory leaks and other potentially harmful side effects.
     */
	public function close();
	
}