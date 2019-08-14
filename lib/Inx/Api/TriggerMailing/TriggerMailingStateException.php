<?php
/**
 * @package Inxmail
 * @subpackage TriggerMailing
 */

/**
 * An <i>Inx_Api_TriggerMailing_TriggerMailingStateException</i> is thrown when a trigger mailing action is invoked  which 
 * is not allowed to be performed in the current state. For example, invoking <i>TriggerMailing::activateSending()</i> is 
 * not allowed if the mailing is in the state <i>TriggerMailingState::APPROVAL_REQUESTED()</i>, thus raising a
 * <i>TriggerMailingStateException</i>.
 *
 * @since API 1.10.0
 * @author chge, 31.05.2012
 */
final class Inx_Api_TriggerMailing_TriggerMailingStateException extends Exception
{
	private $currentMailingState;

	private $currentTriggerState;

	private $locked;


	/**
	 * Creates a <i>TriggerMailingStateException</i> with the given detail message, current state and locking
	 * state.
	 *
	 * @param string $sMsg the detail message.
	 * @param Inx_Api_TriggerMailing_TriggerMailingState $currentMailingState the current state of the affected 
         *      mailing.
	 * @param bool $blLocked <i>true</i> if the mailing is locked, <i>false</i> otherwise.
	 */
	public function __construct( $sMsg, Inx_Api_TriggerMailing_TriggerMailingState $currentMailingState,
			Inx_Api_TriggerMailing_TriggerState $currentTriggerState, $blLocked )
	{
		parent::__construct( $sMsg );

		$this->currentMailingState = $currentMailingState;
		$this->currentTriggerState = $currentTriggerState;
		$this->locked = $blLocked;
	}


	/**
	 * Returns the current state of the affected trigger mailing.
	 *
	 * @return Inx_Api_TriggerMailing_TriggerMailingState the current state of the trigger mailing.
	 */
	public function getCurrentMailingState()
	{
		return $this->currentMailingState;
	}


	/**
	 * Returns the current state of the trigger of the affected trigger mailing.
	 *
	 * @return Inx_Api_TriggerMailing_TriggerState the current state of the trigger.
	 */
	public function getCurrentTriggerState()
	{
		return $this->currentTriggerState;
	}


	/**
	 * Checks if the trigger mailing is locked.
	 *
	 * @return bool <i>true</i> if the trigger mailing is locked, <i>false</i> otherwise.
	 */
	public function isLocked()
	{
		return $this->locked;
	}
}
