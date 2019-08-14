<?php
/**
 * @package Inxmail
 * @subpackage TriggerMail
 */

/**
 * The <code>TriggerMailingConstants</code> define some parameters for trigger mailings. The constants are used
 * internally only.
 * 
 * @author chge, 02.08.2012
 */
interface Inx_Api_TriggerMail_TriggerMailingConstants
{
	/**
	 * the array index of list type of trigger mailing business object
	 */
	const INTERNAL_TRIGGER_MAILING_LIST_ID = 0;

	const INTERNAL_TRIGGER_MAILING_CONTENT_TYPE = 1;

	const INTERNAL_TRIGGER_MAILING_FEATURE_ID = 2;

	const TRIGGER_MAILING_MAX_CHANGEDATTR_SIZE = 20;
}