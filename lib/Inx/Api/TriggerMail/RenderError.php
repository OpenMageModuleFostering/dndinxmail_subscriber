<?php
/**
 * @package Inxmail
 * @subpackage TriggerMail
 */

/**
 * A <code>RenderError</code> object describes the details of an error which occurred during the parsing or building of
 * a trigger mailing. <code>RenderError</code> offers the following information:
 * <ul>
 * <li><i>Error type</i>: an internal error code
 * <li><i>Mail part</i>: the internal mail part code
 * <li><i>Begin line / column</i>: the line and column where the malicious token begins
 * <li><i>End line / column</i>: the line and column where the malicious token ends.
 * <li><i>Error messages</i>: the error messages
 * </ul>
 * <p>
 * <code>RenderError</code> is mainly used internally but may provide some insight on the error source to API
 * developers. For example, the token position will assist you in identifying syntax errors. The error messages may also
 * be analyzed to identify the error source.
 * 
 * @see BuildException#getError()
 * @see ParseException#getError(int)
 * @since API 1.10.0
 * @author chge, 09.07.2012
 */
class Inx_Api_TriggerMail_RenderError
{
	private $errorType;

	private $mailPart;

	private $beginLine;

	private $endLine;

	private $beginColumn;

	private $endColumn;

	private $msgArgs;


	/**
	 * Creates a <code>RenderError</code> with the given details.
	 * 
	 * @param errorType the internal error code.
	 * @param mailPart the internal mail part code.
	 * @param beginLine the line where the malicious token begins.
	 * @param endLine the line where the malicious token ends.
	 * @param beginColumn the column where the malicious token begins.
	 * @param endColumn the column where the malicious token ends.
	 * @param msgArgs the error messages.
	 */
	public function __construct( $iErrorType, $iMailPart, $iBeginLine, $iEndLine, $iBeginColumn, 
                $iEndColumn, $aMsgArgs )
	{
		$this->errorType = $iErrorType;
		$this->mailPart = $iMailPart;
		$this->beginLine = $iBeginLine;
		$this->endLine = $iEndLine;
		$this->beginColumn = $iBeginColumn;
		$this->endColumn = $iEndColumn;
		$this->msgArgs = $aMsgArgs;
	}


	/**
	 * Returns the internal error code.
	 * 
	 * @return the internal error code.
	 */
	public function getErrorType()
	{
		return $this->errorType;
	}


	/**
	 * Returns the internal mail part code.
	 * 
	 * @return the internal mail part code.
	 */
	public function getMailPart()
	{
		return $this->mailPart;
	}


	/**
	 * Returns the line where the malicious token begins.
	 * 
	 * @return the line where the malicious token begins.
	 */
	public function getBeginLine()
	{
		return $this->beginLine;
	}


	/**
	 * Returns the line where the malicious token ends.
	 * 
	 * @return the line where the malicious token ends.
	 */
	public function getEndLine()
	{
		return $this->endLine;
	}


	/**
	 * Returns the column where the malicious token begins.
	 * 
	 * @return the column where the malicious token begins.
	 */
	public function getBeginColumn()
	{
		return $this->beginColumn;
	}


	/**
	 * Returns the column where the malicious token ends.
	 * 
	 * @return the column where the malicious token ends.
	 */
	public function getEndColumn()
	{
		return $this->endColumn;
	}


	/**
	 * Returns the error messages.
	 * 
	 * @return the error messages.
	 */
	public function getMsgArgs()
	{
		return $this->msgArgs;
	}

}