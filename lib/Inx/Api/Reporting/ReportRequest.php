<?php

/**
 * @package Inxmail
 * @subpackage Reporting
 */
/**
 * The <i>Inx_Api_Reporting_ReportRequest</i> describes a report to be generated. 
 * To generate a report, you first need to create a <i>ReportRequest</i> which contains the relevant information 
 * needed to generate the report:
 * <p>
 * <ul>
 * <li>The report name
 * <li>The output format (e.g. OUTPUT_FORMAT_HTML, OUTPUT_FORMAT_PDF_A4)
 * <li>The output locale (e.g. "de_DE", "en_US")
 * <li>The output time zone (e.g. "Europe/Berlin", "America/New_York")
 * <li>Probably some report specific properties (e.g. "listid", "limit")
 * </ul>
 * The report request is sent to the server where the actual report generation takes place.
 * <p>
 * To specify dates, like the begin or end date of a report, use <i>putParameter()</i> and specify the number of 
 * milliseconds since the epoch. 
 * To do so, use the <i>strtotime()</i> function. 
 * The following snippet shows how to specify an end date one week ago:
 * 
 * <pre>
 * //strtotime returns the seconds since the epoch -> * 1000
 * $iOneWeekAgo = strtotime("-1 week") * 1000;
 * 
 * $oReportRequest = ...
 * $oReportRequest->putParameter("end", $iOneWeekAgo);
 * </pre>
 * 
 * To pass a specific date, use the english date format (YYYY-MM-DD HH:MM:SS). 
 * The following snippet shows how to specify the begin date 2000-01-01 00:00:
 * 
 * <pre>
 * //strtotime returns the seconds since the epoch -> * 1000
 * $iMillennium = strtotime("2000-01-01 00:00") * 1000;
 * 
 * $oReportRequest = ...
 * $oReportRequest->putParameter("begin", $iMillennium);
 * </pre>
 * <p>
 * For an example on how to retrieve a report, see the <i>Inx_Api_Reporting_ReportEngine</i> documentation.
 * 
 * @see Inx_Api_Reporting_ReportEngine
 * @since API 1.3 
 * @version $Revision: 9553 $ $Date: 2008-01-04 11:28:41 +0200 (Pn, 04 Sau 2008) $ $Author: vladas $
 * @package Inxmail
 * @subpackage Reporting
 */
class Inx_Api_Reporting_ReportRequest
{
	
	/**	Output format: HTML with inxmail special hyperlinks */
	const OUTPUT_FORMAT_HTML_INXLINKS = 10;

	/**	Output format: HTML */
	const OUTPUT_FORMAT_HTML = 11;
	
	/**	Output format: Character Separated Values (CSV) */
	const OUTPUT_FORMAT_CSV = 20;

	/**	Output format: PDF on A4 page size */
	const OUTPUT_FORMAT_PDF_A4 = 30;

	/**	Output format: PDF on US-Letter page size */
	const OUTPUT_FORMAT_PDF_US_LETTER = 31;

	/**	Output format: PDF on US-Legal page size */
	const OUTPUT_FORMAT_PDF_US_LEGAL = 32;
	
	/**
	 * The technical report name.
	 * @var string
	 */
	private $sReportName;
	
	/**
	 * The output format.
	 * @var int
	 */
	private $sOutputFormat;
	
	/**
	 * The output locale.
	 * @var string
	 */
	private $sOutputLocale;

	/**
	 * The output time zone.
	 * @var string
	 */
	private $sOutputTimeZone;
	
	/**
	 * The set of parameters for the report.
	 * @var associative array
	 */
	private $aParameterMap = array();
		
	
	/**
	 * Creates a new report request object for the report specified by the given name. 
	 * The report will be generated in the given output format, using the specified locale and time zone.
	 * 
	 * @param string $sReportName the name of the report to generate. 
	 * 			For a full list of the supported reports, see Appendix A of the API Developer Guide.
	 * @param int $sOutputFormat the output format. The supported formats are:
	 *            <ul>
	 *            <li><i>OUTPUT_FORMAT_HTML_INXLINKS</i>
	 *            <li><i>OUTPUT_FORMAT_HTML</i>
	 *            <li><i>OUTPUT_FORMAT_PDF_A4</i>
	 *            <li><i>OUTPUT_FORMAT_PDF_US_LETTER</i>
	 *            <li><i>OUTPUT_FORMAT_PDF_US_LEGAL</i>
	 *            <li><i>OUTPUT_FORMAT_CSV</i>
	 *            </ul>
	 * @param string $sOutputLocale the output locale. 
	 * 			Use the name of the locale, with the language (defined by ISO-639) or the language and country 
	 * 			(defined by ISO-3166) separated by an underscore. 
	 * 			For example: "de_DE", "de_CH", "de", "en", "en_GB", "it_IT", "fr_FR"
	 * @param string $sOutputTimeZone the output time zone. 
	 * 			Use <i>Inx_Api_Reporting_ReportEngine::getSupportedTimeZones()</i> to find out which time zones 
	 * 			are supported. 
	 * 			For example: "Europe/Berlin", "Europe/Rome", "America/New_York" 
	 */
	public function __construct( $sReportName, $sOutputFormat,
			$sOutputLocale, $sOutputTimeZone )
	{
		$this->sReportName = $sReportName;
		$this->sOutputFormat = $sOutputFormat;
		$this->sOutputLocale = $sOutputLocale;
		$this->sOutputTimeZone = $sOutputTimeZone;
	}
	
	
	/**
	 * Returns the name of the report to generate.
	 * 
	 * @return string the name of the report.
	 */
	public function getReportName()
	{
		return $this->sReportName;
	}

	
	/**
	 * Returns the output format of the report. May be one of:
	 * <ul>
	 * <li><i>OUTPUT_FORMAT_HTML_INXLINKS</i>
	 * <li><i>OUTPUT_FORMAT_HTML</i>
	 * <li><i>OUTPUT_FORMAT_PDF_A4</i>
	 * <li><i>OUTPUT_FORMAT_PDF_US_LETTER</i>
	 * <li><i>OUTPUT_FORMAT_PDF_US_LEGAL</i>
	 * <li><i>OUTPUT_FORMAT_CSV</i>
	 * </ul>
	 * 
	 * @return int the output format.
	 */
	public function getOutputFormat()
	{
		return $this->sOutputFormat;
	}
	
	
	/**
	 * Returns the output locale of the report. 
	 * Use the name of the locale, with the language (defined by ISO-639) or the language and 
	 * country (defined by ISO-3166) separated by an underscore.
	 * <p>
	 * For example: "de", "de_CH", "en", "en_GB", "it", "fr"
	 * 
	 * @return string the output locale of the report.
	 */
	public function getOutputLocale()
	{
		return $this->sOutputLocale;
	}
	
	
	/**
	 * Returns the output time zone of the report. 
	 * Use <i>Inx_Api_Reporting_ReportEngine::getSupportedTimeZones()</i> to find out which 
	 * time zones are supported.
	 * <p>
	 * For example: "Europe/Berlin", "Europe/Rome", "America/New_York"
	 * 
	 * @return string the output time zone of the report.
	 */
	public function getOutputTimeZone()
	{
		return $this->sOutputTimeZone;
	}
	
	
	/**
	 * Returns the value to which this <i>Inx_Api_Reportin_ReportRequest</i> maps the specified key. 
	 * Returns <i>null</i> if this report request contains no mapping for this key.
	 * 
	 * @param string $sKey the key whose value shall be returned.
	 * @return string the value to which this <i>ReportRequest</i> maps the specified key, or <i>null</i> if this
	 *         report request contains no mapping for this key.
	 */
	public function getParameter( $sKey )
	{
		if (isset($this->aParameterMap[$sKey]))
	        return $this->aParameterMap[$sKey];
	    return null;
	}
	
	
	/**
	 * Associates the specified value with the specified key in this report request.
	 * For an example on how to specify dates, see the documentation of this class.
	 * 
	 * @param string $sKey the key with which the specified value is to be associated.
	 * @param string $value the value to be associated with the specified key.
	 */
	public function putParameter( $sKey, $value )
	{
		$this->aParameterMap[$sKey] = $value;
	}

	
	/**
	 * Returns an array of the keys contained in this report request.
	 * 
	 * @return array an array of the keys contained in this report request.
	 */
	public function getParameterKeys()
	{
		return array_keys($this->aParameterMap);
	}
}
