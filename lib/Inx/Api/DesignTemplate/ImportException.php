<?php
/**
 * @package Inxmail
 * @subpackage DesignTemplate
 */

/**
 * The <i>Inx_Api_DesignTemplate_ImportException</i> is thrown, when an error occurs while importing an itc file.
 * <p>
 * There are several types of this exception:
 * <ul>
 * <li>NO_ITC_FILE: the provided file is no valid itc file.
 * <li>IMPORT_ERROR: the import failed due to a non specific error.
 * <li>XML_ERROR: the XML data of the itc file is not valid.
 * <li>SYSTEM_ERROR: a major system error occurred.
 * </ul>
 * For further insight on the cause of the error, check the warnings, errors and fatals of this exception, using 
 * the corresponding method.
 * 
 * @see Inx_Api_DesignTemplate_DesignCollectionManager::importDesignCollection($resource, $oListContext) 
 * @since API 1.4.0
 * @version $Revision: 9497 $Date: 2007-01-25 15:00:09 $ $Author: nds$
 * @package Inxmail
 * @subpackage DesignTemplate
 */
class Inx_Api_DesignTemplate_ImportException extends Exception
{
	/**
	 * The provided import file is no valid itc file.
	 */
	const NO_ITC_FILE = -1;

	/**
	 * A non specific error occurred during the import. 
	 * For further insight on the cause of the error, check the warnings, errors and fatals of this exception.
	 */
	const IMPORT_ERROR = -2;

	/**
	 * A major system error occurred during the import. Please check what happened exactly to prevent further failures.
	 * Tips for error analysis:
	 * <ul>
	 * <li>Check the warnings, errors and fatals of this exception
	 * <li>Check the customer log of your inxmail server (if possible)
	 * <li>Check the tomcat log of your inxmail server (if possible)
	 * </ul>
	 */
	const SYSTEM_ERROR = -5;

	/**
	 * The XML data of the itc file is not valid and cannot be parsed.
	 */
	const XML_ERROR = -6;

	private $aWarnings;

	private $aErrors;

	private $aFatals;

	/**
	* Creates an <i>Inx_Api_DesignTemplate_ImportException</i> with the given type, detail message, warnings, 
	* errors and fatals.
	*
	* @param int $iCode the type of the exception. Can be one of the constants defined by this exception.
	* @param string $sMessage the detail message of the exception.
	* @param array $aWarnings the warning messages (string) of the exception.
	* @param array $aErrors the error messages (string) of the exception.
	* @param array $aFatals the fatal messages (string) of the exception.
	*/
	public function __construct( $sMessage, $iCode, $aWarnings, $aErrors,
		$aFatals )
	{
		parent::__construct( $sMessage, $iCode );

		$this->aWarnings = $aWarnings;
		$this->aErrors = $aErrors;
		$this->aFatals = $aFatals;
	}

	/**
	* Returns the error level messages produced by exceptions during the import.
	*
	* @return array the error level messages (string).
	*/
	public function getErrors()
	{
		return $this->aErrors;
	}

	/**
	* Returns the fatal level messages produced by exceptions during the import.
	*
	* @return array the fatal level messages (string).
	*/
	public function getFatals()
	{
		return $this->aFatals;
	}

	/**
	* Returns the warning level messages produced by exceptions during the import.
	*
	* @return array the warning level messages (string).
	*/
	public function getWarnings()
	{
		return $this->aWarnings;
	}

}
