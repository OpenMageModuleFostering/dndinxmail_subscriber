<?php
/**
 * @package Inxmail
 * @subpackage TriggerMail
 */

/**
 * A <code>BuildException</code> is thrown when the building of a trigger mailing fails. This may be due to an illegal
 * recipient address or a general building failure. For a deeper insight on the error, consult the {@link RenderError}
 * associated with the exception.
 * 
 * @see com.inxmail.xpro.api.triggermail.RenderError
 * @see com.inxmail.xpro.api.triggermail.TriggerMailingRenderer#build(int)
 * @see com.inxmail.xpro.api.triggermail.TriggerMailingRenderer#build(int, int)
 * @since API 1.10.0
 * @author chge, 09.07.2012
 */
class Inx_Api_TriggerMail_BuildException extends Exception
{
	/** The email address of the recipient for which the trigger mailing was built. */
	protected $emailAddress;

	/** Contains detail information about the error. */
	protected $error;


	/**
	 * Creates a <code>BuildException</code> with the given recipient address and render error.
	 * 
	 * @param emailAddress the email address of the recipient for which the trigger mailing was built.
	 * @param error contains detail information about the error.
	 */
	public function __construct( $sEmailAddress, Inx_Api_TriggerMail_RenderError $error )
	{
		$this->emailAddress = $sEmailAddress;
		$this->error = $error;
	}


	/**
	 * Returns detail information about the error.
	 * 
	 * @return detail information about the error.
	 */
	public function getError()
	{
		return $this->error;
	}


	/**
	 * Returns the email address of the recipient for which the trigger mailing was built.
	 * 
	 * @return the recipients email address.
	 */
	public function getEmailAddress()
	{
		return $this->emailAddress;
	}

}