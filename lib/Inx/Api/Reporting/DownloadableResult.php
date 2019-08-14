<?php

/**
 * @package Inxmail
 * @subpackage Reporting
 */
/**
 * Use the <i>Inx_Api_Reporting_DownloadableResult</i> to download a generated report. 
 * A <i>DownloadableResult</i> can be obtained using <i>Inx_Api_Reporting_ReportTicket::fetchDownloadableResult()</i>. 
 * The report ticket is returned by <i>Inx_Api_Reporting_ReportEngine::generate($oRequest, $blIgnoreCache)</i>. 
 * As the report generation is an asynchronous process, the <i>DownloadableResult</i> must be polled. 
 * <i>Inx_Api_Reporting_ReportTicket::fetchDownloadableResult()</i> will return <i>null</i> as long as the report 
 * generation has not finished.
 * <p/>
 * The following snippet shows how to download a report using the <i>DownloadableResult</i>:
 * 
 * <pre>
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
 * <p/>
 * Some output formats (e.g. <code>OUTPUT_FORMAT_HTML</code>, <code>OUTPUT_FORMAT_HTML_INXLINKS</code> or
 * <code>OUTPUT_FORMAT_CSV</code>) are provide as ZIP compressed archive file, as these formats usually contain several
 * files. 
 * The PDF output formats on the other hand are provided as single PDF files. 
 * The <code>download()</code> method presented in the following snippet is used to download these files, but will not 
 * uncompress ZIP files:
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
 * <p/>
 * For a more complete example on how to generate and download reports, see the <i>Inx_Api_Reporting_ReportEngine</i> documentation.
 * 
 * @see Inx_Api_Reporting_ReportEngine 
 * @since API 1.3 
 * @version $Revision: 9553 $ $Date: 2008-01-04 11:28:41 +0200 (Pn, 04 Sau 2008) $ $Author: vladas $
 * @package Inxmail
 * @subpackage Reporting
 */
interface Inx_Api_Reporting_DownloadableResult
{
	
	/**
	 * Returns an <i>Inx_Api_InputStream</i> which can be used to download the report.
	 * 
	 * @return Inx_Api_InputStream an <i>Inx_Api_InputStream</i> to download the report.
	 */
	public function getInputStream();
	
	
	/**
	 * This method returns the content type of the data in the form of a string.
	 * <p/>
	 * It always returns one of the following types:
	 * <ol>
	 * <li>"zip" - if the output format is one of:
	 * <ul>
	 * <li><i>Inx_Api_Reporting_ReportRequest::OUTPUT_FORMAT_HTML</i>,</li>
	 * <li><i>Inx_Api_Reporting_ReportRequest::OUTPUT_FORMAT_HTML_INXLINKS</i> or</li>
	 * <li><i>Inx_Api_Reporting_ReportRequest::OUTPUT_FORMAT_CSV</i></li>
	 * </ul>
         * </li>
	 * <li>"pdf" - if the output format is one of
	 * <ul>
	 * <li><i>Inx_Api_Reporting_ReportRequest::OUTPUT_FORMAT_PDF_A4</i></li>
	 * <li><i>Inx_Api_Reporting_ReportRequest::OUTPUT_FORMAT_PDF_US_LETTER</i></li>
	 * <li><i>Inx_Api_Reporting_ReportRequest::OUTPUT_FORMAT_PDF_US_LEGAL</i></li>
	 * </ul>
         * </li>
	 * </ol>
	 * 
	 * @return string the content type.
	 */
	public function getContentType();
	
	
	/**
	 * Returns the creation date of this report. 
	 * The date will be returned as ISO-8601 formatted datetime string.
	 * 
	 * @return string the creation date of this report.
	 */
	public function getCreationDate();

}
