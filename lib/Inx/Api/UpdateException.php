<?php
/**
 * @package Inxmail
 */
/**
 * This exception is thrown by the <i>commitUpdate()</i> method in the <i>Inx_Api_BusinessObject</i> class to
 * indicate that the update failed.
 * <p>
 * There are several error types associated with this exception:
 * <ul>
 * <li>ERROR_TYPE_PERSISTENCE - the update could not be persisted
 * <li>ERROR_TYPE_ILLEGAL_VALUE - an illegal value was committed
 * <li>ERROR_TYPE_DUPLICATE_KEY_VALUE - a duplicate key was committed
 * <li>ERROR_TYPE_ILLEGAL_OPERATION - an illegal operation was triggered
 * </ul>
 * 
 * @see Inx_Api_BusinessObject#commitUpdate()
 * @version $Revision$ $Date$ $Author$
 * @package Inxmail
 */
class Inx_Api_UpdateException extends Exception
{
	/** Error type indicating that a persistence error has occurred. */
	const ERROR_TYPE_PERSISTENCE = -1;
	
	/** Error type indicating that an illegal value was committed. */
	const ERROR_TYPE_ILLEGAL_VALUE = -2;

	/** Error type indicating that a duplicate key was committed. */
	const ERROR_TYPE_DUPLICATE_KEY_VALUE = -3;
	
	/** Error type indicating that an illegal operation was triggered. */
	const ERROR_TYPE_ILLEGAL_OPERATION = -4;

	/** Indicates that no error source was specified. */
	const ERROR_SOURCE_NOT_SPECIFIED = -1000;

	/** The error type of this exception. */
	protected $iErrorType;
		
	/** The error source of this exception. */
	protected $iErrorSource;
	
	
	/**
	 * Creates a new <i>Inx_Api_UpdateException</i> with the given error type, error source and detail message.
	 *
	 * @param $sMsg the detail message.
	 * @param $iErrorCode the error type. One of the error type constants defined in this exception.
	 * @param $iErrorSource the error source. Can be either <i>Inx_Api_UpdateException.ERROR_SOURCE_NOT_SPECIFIED</i> or a
	 *            more specific constant of a related <i>Inx_Api_BusinessObject</i> (e.g.
	 *            <i>Inx_Api_List_ListContext.ATTRIBUTE_NAME</i>).
	 */
	public function __construct( $sMsg, $iErrorCode, $iErrorSource)
	{
		parent::__construct( $sMsg, $iErrorCode );
		$this->iErrorSource = $iErrorSource;		
	}
		
	/**
	 * Returns the error source. The error source can be <i>Inx_ApiUpdateException::ERROR_SOURCE_NOT_SPECIFIED</i> 
	 * or a more specific constant of a related <i>Inx_Api_BusinessObject</i>.
	 * <p>
	 * e.g. <i>Inx_Api_List_ListContext::ATTRIBUTE_NAME</i> if the list name is illegal or already exists.
	 * 
	 * @return int the error source.
	 */
	public function getErrorSource()
	{
		return $this->iErrorSource;
	}
}
