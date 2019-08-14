<?php
/**
 * @package Inxmail
 * @subpackage TriggerMailing
 */

/**
 * An <i>Inx_Api_TriggerMailing_TriggerMailing</i> is a special kind of mailing introduced with Inxmail Professional 4.2. 
 * The difference between a normal mailing and a trigger mailing is the way they are sent. Normal mailings are sent on 
 * demand while trigger mailings are sent when the trigger they are bound to is fired.
 * <p>
 * For example, a birthday trigger mailing is sent each day on which one ore more recipients birthday is. This feature
 * can be combined with dynamic lists and target groups for full control over who receives which mailing.
 * <p>
 * Most trigger mailings are associated with a date or datetime attribute. The following trigger mailing types (see
 * <i>Inx_Api_TriggerMailing_Descriptor_TriggerType</i>) are supported:
 * <ul>
 * <li><i>TIME_TRIGGER_BIRTHDAY_MAILING</i>: A mailing of this type is sent to recipients on the annual recurrence of a 
 * specific date. A datetime attribute of the recipient acts as a baseline and the mailing is sent every year after this
 * baseline. An offset can be specified to send the mailing some time before or after the annual recurrence. The
 * condition is checked once a day. The birthday trigger is an attribute driven time trigger.
 * <li><i>TIME_TRIGGER_ANNIVERSARY_MAILING</i>: A mailing of this type is sent to recipients on the recurrence of a 
 * specific date. A datetime attribute of the recipient acts as baseline and the mailing is sent after a user defined 
 * period of time (years, months or days) after this baseline. An offset can be specified to send the mailing some time 
 * before or after the recurrence. The condition is checked once a day. The anniversary trigger is an attribute driven 
 * time trigger.
 * <li><i>TIME_TRIGGER_REMINDER_MAILING</i>: A mailing of this type is sent to recipients on a specific date. A datetime 
 * attribute of the recipient defines that date. An offset can be specified to send the mailing some time before the date. 
 * The condition is checked once a day. The reminder trigger is an attribute driven time trigger.
 * <li><i>TIME_TRIGGER_FOLLOW_UP_MAILING</i>: A mailing of this type is sent to recipients on a specific date. A datetime
 * attribute of the recipient defines that date. An offset can be specified to send the mailing some time after the
 * date. The condition is checked once a day. The follow up trigger is an attribute driven time trigger.
 * <li><i>TIME_TRIGGER_INTERVAL_MAILING</i>: A mailing of this type is sent to all recipients of the associated list at a 
 * freely definable interval (i.e. hourly, daily, weekly,...). The interval is described by a {@link TriggerInterval} object.
 * The interval trigger is a time trigger which is not related to a specific attribute.
 * <li><I>ACTION_MAILING ACTION_MAILING</i>: This mailing type is triggered by an action.
 * </ul>
 * <p>
 * A <i>TriggerMailing</i> object can be used to perform various tasks:
 * <ul>
 * <li>Retrieve and update trigger mailing meta information and content
 * <li>Activate or deactivate the sending of the trigger mailing
 * <li>Request the approval of a trigger mailing
 * <li>Approve or revoke the approval for the trigger mailing
 * </ul>
 * <strong>Handling trigger mailing content and approval</strong>
 * <p>
 * For the most part, the content handling and approval process of trigger mailings is identical to that of normal
 * mailings (see <i>Inx_Api_Mailing_Mailing</i>). There is only one difference regarding the approval process: instead of 
 * approving a mailing using the deprecated approval methods (especially approve()), a new  method - approveImmediateley - was 
 * introduced to bypass the approval process. Given the API user has the necessary permissions, it can be used to approve a 
 * trigger mailing directly.
 * <p>
 * <strong>Controlling dispatch of trigger mailings</strong>
 * <p>
 * As mentioned earlier, trigger mailings cannot be simply sent to all recipients of the mailing list. Instead, you
 * activate or deactivate the trigger of a trigger mailing, given the mailing is approved. The activation and
 * deactivation of the trigger is as simple as calling the appropriate method:
 * <ul>
 * <li><i>activateSending()</i>: Activates the trigger of the trigger mailing.
 * <li><i>deactivateSending($blStopActiveSending)</i>: Deactivates the trigger of the trigger mailing with the option to stop 
 * an active sending.
 * </ul>
 * <p>
 * <strong>Note:</strong> For existing trigger mailings, always call <i>lock()</i> before updating it, and
 * <i>unlock()</i> after committing changes!
 * <p>
 * For an example on how to retrieve and create trigger mailings, see the <i>Inx_Api_TriggerMailing_TriggerMailingManager</i> 
 * documentation.
 * <p>
 * For more information on the creation of <i>Inx_Api_Approval_Approver</i>s, see the
 * <i>Inx_Api_Approval_ApproverManager</i> documentation.
 *
 * @see Inx_Api_TriggerMailing_TriggerMailingManager
 * @see Inx_Api_Mailing_Mailing
 * @see Inx_Api_Mailing_ContentHandler
 * @see Inx_Api_Approval_ApproverManager
 * @since API 1.10.0
 * @author chge, 12.07.2012
 */
interface Inx_Api_TriggerMailing_TriggerMailing extends Inx_Api_BusinessObject
{
	/**
	 * Sends this trigger mailing to the specified test address. The specified recipient will be used to personalize the
	 * email content, creating a preview of the trigger mailing.
	 *
	 * @param string $sTestAddress the email address to which the trigger mailing shall be sent.
	 * @param int $iRecipientId the recipient to personalize the email content for.
	 * @throws Inx_Api_TriggerMailing_SendException if the trigger mailing could not be sent.
	 * @throws Inx_Api_TriggerMailing_TriggerMailingStateException if this trigger mailing is in an illegal state.
	 * @throws Inx_Api_DataException if this trigger mailing can not be found on the server.
	 */
	public function sendTestMail( $sTestAddress, $iRecipientId );


	/**
	 * Sends this trigger mailing to the specified test address. The specified test profile will be used to personalize
	 * the email content, creating a preview of the trigger mailing.
	 *
	 * @param string $sTestAddress the email address to which the trigger mailing shall be sent.
	 * @param int $iTestprofileId the test profile to personalize the email content for.
	 * @throws Inx_Api_TriggerMailing_SendException if the trigger mailing could not be sent.
	 * @throws Inx_Api_TriggerMailing_TriggerMailingStateException if this trigger mailing is in an illegal state.
	 * @throws Inx_Api_DataException if this trigger mailing can not be found on the server.
	 */
	public function sendTestMailWithTestprofile( $sTestAddress, $iTestprofileId );


	/**
	 * Activates the sending of this trigger mailing. More correctly, the trigger of the trigger mailing will be
	 * activated, so the mailing is ready to be sent. Once the sending is activated, the trigger mailing can be sent
	 * during the next dispatch cycle.
	 *
	 * @throws Inx_Api_TriggerMailing_TriggerMailingStateException if this trigger mailing is in an illegal state.
	 * @throws Inx_Api_DataException if this trigger mailing can not be found on the server.
	 */
	public function activateSending();


	/**
	 * Deactivates the sending of this trigger mailing. More correctly, the trigger of the trigger mailing will be
	 * deactivated, so the mailing can not be sent. The <i>bool</i> parameter is used to define the behaviour upon 
         * active sendings.
	 *
	 * @param bool $blStopActiveSending <i>true</i> if an active sending shall be interrupted, <i>false</i> if the
	 *            sending may be finished first.
	 * @throws Inx_Api_TriggerMailing_TriggerMailingStateException if this trigger mailing is in an illegal state.
	 * @throws Inx_Api_DataException if this trigger mailing can not be found on the server.
	 */
	public function deactivateSending( $blStopActiveSending );


	/**
	 * Approves this trigger mailing immediately, bypassing the normal approval process if necessary. The approval
	 * process can only be bypassed if the API user has the according right.
	 *
	 * @param string $sComment the comment for this approval.
	 * @throws Inx_Api_TriggerMailing_TriggerMailingStateException if the this trigger mailing is in an illegal state.
	 * @throws Inx_Api_DataException if this trigger mailing cannot be found on the server.
	 * @throws Inx_Api_UpdateException if the request cannot be completed.
	 */
	public function approveImmediately( $sComment );


	/**
	 * Approves this trigger mailing for activation.
	 * <p>
	 * The trigger mailing may only be approved if it is in the following state:
	 * <ul>
	 * <li>TriggerMailingState::APPROVAL_REQUESTED ( -> APPROVED )
	 * </ul>
	 * If the trigger mailing is in a state not listed here, a <i>TriggerMailingStateException</i> will be raised.
	 *
	 * @param int $iApproverId the id of the approver.
	 * @param string $sComment the comment of the approver.
	 * @throws Inx_Api_TriggerMailing_TriggerMailingStateException if this trigger mailing is in an illegal state.
	 * @throws Inx_Api_DataException if this trigger mailing can not be found on the server.
	 * @throws Inx_Api_UpdateException if the request cannot be completed, for example because the approval process 
         *      is not activated for the list or trigger mailing.
	 * @see self::requestIdenticalApproval( $sDeadline, array $approverIds, array $recipientIds, $blIsTestRecipient, 
         *      $sLocale );
	 * @see self::requestEscalationApproval( $sEscalationDate, $sDeadline, array $approverIds, array $recipientIds,
         *      $blIsTestRecipient, $sLocale )
	 * @see Inx_Api_Approval_ApproverManager
	 */
	public function approve( $iApproverId, $sComment );


	/**
	 * Denies the approval of this trigger mailing.
	 * <p>
	 * The approval of the trigger mailing may only be denied if it is in the following state:
	 * <ul>
	 * <li>TriggerMailingState::APPROVAL_REQUESTED ( -> DRAFT )
	 * </ul>
	 * If the trigger mailing is in another state, a <i>TriggerMailingStateException</i> will be raised.
	 *
	 * @param int $iApproverId id of the approver
	 * @param string $sComment the comment of the approver.
	 * @throws Inx_Api_TriggerMailing_TriggerMailingStateException if this trigger mailing is in an illegal state.
	 * @throws Inx_Api_DataException if this trigger mailing can not be found on the server.
	 * @throws Inx_Api_UpdateException if the request cannot be completed, for example because the approval process 
         *      is not activated for the list or trigger mailing.
	 * @see self::requestIdenticalApproval( $sDeadline, array $approverIds, array $recipientIds, $blIsTestRecipient, 
         *      $sLocale );
	 * @see self::requestEscalationApproval( $sEscalationDate, $sDeadline, array $approverIds, array $recipientIds,
         *      $blIsTestRecipient, $sLocale )
	 * @see Inx_Api_Approval_ApproverManager
	 */
	public function denyApprove( $iApproverId, $sComment );


	/**
	 * Requests escalating approval for this trigger mailing. At first sends the request only to the first approver. If
	 * the escalation date expires without the first approver having approved the trigger mailing, the request is sent
	 * to the second approver. If the deadline date expires without any of the approvers having approved the trigger
	 * mailing, the request will be cancelled. In order to approve it, the trigger mailing creator will have to request
	 * the approval again.
	 * <p>
	 * The approval of the trigger mailing may only be requested if it is in the following state:
	 * <ul>
	 * <li>TriggerMailingState::DRAFT ( -> APPROVAL_REQUESTED )
	 * </ul>
	 * If the trigger mailing is in another state, a <i>TriggerMailingStateException</i> will be raised.
	 *
	 * @param string $sEscalationDate the escalation date. If this datetime expires, the second approver will get involved.
         *      The date has to be specified as ISO-8601 formatted datetime string.
	 * @param string $sDeadline the deadline. If this datetime expires, the request will be cancelled. The date has to be 
         *      specified as ISO-8601 formatted datetime string.
	 * @param array $approverIds the ids of the two approvers involved in the approval process. You must specify exactly two
	 *      approvers.
	 * @param array $recipientIds the ids of the recipients used to generate a personalized preview of the mailing. You must
	 *      specify at least one recipient.
	 * @param bool $blIsTestRecipient <i>true</i> if the recipientId array contains test recipients (test profiles),
	 *      <i>false</i> if it contains regular recipients.
	 * @param string $sLocale the user local that will be used to localize the request message and approval page.
	 * @throws Inx_Api_TriggerMailing_TriggerMailingStateException if this trigger mailing is in an illegal state.
	 * @throws Inx_Api_DataException if this trigger mailing can not be found on the server.
	 * @throws Inx_Api_UpdateException if the request cannot be completed, for example because the approval process is not
	 *             activated for the list or trigger mailing.
	 */
	public function requestEscalationApproval( $sEscalationDate, $sDeadline, array $approverIds, array $recipientIds,
			$blIsTestRecipient, $sLocale );


	/**
	 * Requests identical approval for this trigger mailing. Sends the request to both approvers simultaneously and
	 * requires both approvers to approve the trigger mailing. If the deadline date expires without one of the approvers
	 * having approved the trigger mailing (and the other not reacted), the request will be cancelled. In order to
	 * approve it, the trigger mailing creator will have to request the approval again.
	 * <p>
	 * The approval of the trigger mailing may only be requested if it is in the following state:
	 * <ul>
	 * <li>TriggerMailingState::DRAFT ( -> APPROVAL_REQUESTED )
	 * </ul>
	 * If the trigger mailing is in another state, a <i>TriggerMailingStateException</i> will be raised.
	 *
	 * @param string $sDeadline the deadline. If this datetime expires, the request will be cancelled if none of 
         *      the approvers has approved the mailing.
	 * @param array $approverIds the ids of the two approvers involved in the approval process. You must specify 
         *      exactly two approvers.
	 * @param array $recipientIds the ids of the recipients used to generate a personalized preview of the mailing. 
         *      You must specify at least one recipient.
	 * @param bool $blIsTestRecipient <i>true</i> if the recipientId array contains test recipients (test profiles),
	 *      <i>false</i> if it contains regular recipients.
	 * @param string $sLocale the user local that will be used to localize the request message and approval page.
	 * @throws Inx_Api_TriggerMailing_TriggerMailingStateException if this trigger mailing is in an illegal state.
	 * @throws Inx_Api_DataException if this trigger mailing can not be found on the server.
	 * @throws Inx_Api_UpdateException if the request cannot be completed, for example because the approval process 
         *      is not activated for the list or trigger mailing.
	 */
	public function requestIdenticalApproval( $sDeadline, array $approverIds, array $recipientIds,
			$blIsTestRecipient, $sLocale );


	/**
	 * Revokes the approval for this trigger mailing.
	 * <p>
	 * The approval of the trigger mailing may only be revoked if it is in one of the following states:
	 * <ul>
	 * <li>TriggerMailingState::APPROVED ( -> DRAFT )
	 * <li>TriggerMailingState::APPROVAL_REQUESTED ( -> DRAFT )
	 * </ul>
	 * If the trigger mailing is in another state, a <i>TriggerMailingStateException</i> will be raised.
	 *
	 * @param string $sComment the reason why the approval request was revoked. May be omitted.
	 * @throws Inx_Api_TriggerMailing_TriggerMailingStateException if this trigger mailing is in an illegal state.
	 * @throws Inx_Api_DataException if this trigger mailing can not be found on the server.
	 * @throws Inx_Api_UpdateException if the request cannot be completed, for example because the approval process 
         *      is not activated for the list or trigger mailing.
	 */
	public function revokeApproval( $sComment = null );


	/**
	 * Locks this <i>TriggerMailing</i>, so it cannot be locked by another session.
	 * <p>
	 * <strong>Note:</strong> For existing trigger mailings, always call <i>lock()</i> before updating it, and
	 * <i>unlock()</i> after committing changes!
	 * <p>
	 * <strong>Updating existing trigger mailings without explicit locking is strongly discouraged.</strong>
	 *
	 * @throws Inx_Api_LockException if this trigger mailing is already locked by another session.
	 * @throws Inx_Api_TriggerMailing_TriggerMailingStateException if this trigger mailing is in an illegal state.
	 * @throws Inx_Api_DataException if this trigger mailing can not be found on the server.
	 */
	public function lock();


	/**
	 * Releases the lock of this <i>TriggerMailing</i>.
	 *
	 * @param bool $blForceForeignLock <i>true</i> - release foreign and own locks, <i>false</i> - release only own
	 *            locks (locks held by the current session). May be omitted, defaults to false.
	 * @return <i>true</i> if this trigger mailing was unlocked, <i>false</i> otherwise.
	 * @throws Inx_Api_DataException if this trigger mailing can not be found on the server.
	 */
	public function unlock( $blForceForeignLock = false );


	/**
	 * Returns the state of this trigger mailing. The state may be one of:
	 * <ul>
	 * <li><i>TriggerMailingState::DRAFT()</i>: The default state of a new trigger mailing.
	 * <li><i>TriggerMailingState::APPROVAL_REQUESTED()</i>: Approval has been requested for this trigger mailing.
	 * <li><i>TriggerMailingState::APPROVED()</i>: The trigger mailing has been approved.
	 * <li><i>TriggerMailingState::USED()</i>: The trigger mailing was activated at least once.
	 * <li><i>TriggerMailingState::UNKNOWN()</i>: The trigger mailing state is unknown. This indicates a version 
         * mismatch between API and server.
	 * </ul>
	 *
	 * @return Inx_Api_TriggerMailing_TriggerMailingState the state of this trigger mailing.
	 */
	public function getMailingState();


	/**
	 * Returns the state of the trigger of this trigger mailing. The state may be one of:
	 * <ul>
	 * <li><i>TriggerState::INACTIVE()</i>: The default state of a new time trigger mailing.
	 * <li><i>TriggerState::ACTIVE()</i>: The trigger of this trigger mailing is active.
	 * <li><i>TriggerState::UNSPECIFIED()</i>: This state is used when the trigger state can not be determined. 
         * This is the case for action trigger mailings.
	 * <li><i>TriggerState::UNKNOWN()</i>: The trigger state is unknown. This indicates a version mismatch between 
         * API and server.
	 * </ul>
	 *
	 * @return Inx_Api_TriggerMailing_TriggerState the state of the trigger of this trigger mailing.
	 */
	public function getTriggerState();
        
        
        /**
         * Returns a <i>bool</i> indicating whether this trigger mailing is active.
         * 
         * @return bool <i>true</i> if this trigger mailing is active, <i>false</i> otherwise.
         */
        public function isActive();


	/**
	 * Checks if this trigger mailing is locked by a session, regardless of the lock owner.
	 *
	 * @return bool <i>true</i> if this trigger mailing is locked, <i>false</i> otherwise.
	 */
	public function isLocked();


	/**
	 * Returns the lock ticket. The lock ticket contains the following information:
	 * <ul>
	 * <li>Who locked the trigger mailing? - User id, name and IP address.
	 * <li>When was the lock created?
	 * <li>Did I create the lock?
	 * </ul>
	 *
	 * @return Inx_Api_LockTicket the lock ticket.
	 */
	public function getLockTicket();


	/**
	 * Returns the last modification datetime.
	 *
	 * @return string the last modification datetime. The date is returned as ISO-8601 formatted datetime string.
	 */
	public function getModificationDatetime();


	/**
	 * Returns the approval escalation datetime of this trigger mailing if the trigger mailing is in the state
	 * <i>TriggerMailingState::APPROVAL_REQUESTED</i> and the approval process is escalating. If the mailing 
         * state is not <i>APPROVAL_REQUESTED</i> or the approval process is identical, null may be returned.
	 *
	 * @see self::requestEscalationApproval( $sEscalationDate, $sDeadline, array $approverIds, array $recipientIds,
         *      $blIsTestRecipient, $sLocale )
	 * @return string the approval escalation datetime, or null. The date is returned as ISO-8601 formatted datetime 
         *      string.
	 */
	public function getEscalationDatetime();


	/**
	 * Returns the approval deadline datetime of this trigger mailing if the trigger mailing is in the state
	 * <i>TriggerMailingState::APPROVAL_REQUESTED</i>. If the mailing state is not <i>APPROVAL_REQUESTED</i>, null
	 * may be returned.
	 *
	 * @see self::requestIdenticalApproval( $sDeadline, array $approverIds, array $recipientIds, $blIsTestRecipient, 
         *      $sLocale );
	 * @see self::requestEscalationApproval( $sEscalationDate, $sDeadline, array $approverIds, array $recipientIds,
         *      $blIsTestRecipient, $sLocale )
	 * @return string the approval deadline datetime, or null. The date is returned as ISO-8601 formatted datetime 
         *      string.
	 */
	public function getDeadlineDatetime();


	/**
	 * Returns the id of the list context this trigger mailing belongs to.
	 *
	 * @return int the id of the list context this trigger mailing belongs to.
	 */
	public function getListContextId();


	/**
	 * Returns the sender address of this trigger mailing.
	 *
	 * @return string the sender address of this trigger mailing.
	 */
	public function getSenderAddress();


	/**
	 * Returns the reply address of this trigger mailing.
	 *
	 * @return string the reply address of this trigger mailing.
	 */
	public function getReplyToAddress();


	/**
	 * Returns one of the sending filters (probably the first) of this trigger mailing.
	 * <p>
	 * For more information on <i>Filter</i>s, see the <i>Inx_Api_Filter_Filte</i> documentation.
	 *
	 * @return int one of the filter ids, 0 means that no filters are set.
	 * @see Inx_Api_Filter_Filter
	 */
	public function getFilterId();


	/**
	 * Sets the given filter as the only sending filter of this trigger mailing.
	 * <p>
	 * For more information on <i>Filter</i>s, see the <i>Inx_Api_Filter_Filter</i> documentation.
	 *
	 * @param int $iFilterId the filter id, 0 means that no filter is set.
	 * @see Inx_Api_Filter_Filter
	 */
	public function updateFilterId( $iFilterId );


	/**
	 * Returns the sending filters of this trigger mailing.
	 * <p>
	 * For more information on <i>Filter</i>s, see the <i>Inx_Api_Filter_Filter</i> documentation.
	 *
	 * @return array the filter ids, null means that no filter is set
	 * @see Inx_Api_Filter_Filter
	 */
	public function getFilderIds();


	/**
	 * Returns the sending filter concatenation type of this trigger mailing. May be one of the following:
	 * <ul>
	 * <li><i>FilterConcatenationType::AND()</i>,
	 * <li><i>FilterConcatenationType::OR()</i> or
	 * <li><i> FilterConcatenationType::NOT_IN()</i>
	 * </ul>
	 * <ul>
	 *
	 * @return Inx_Api_TriggerMailing_FilterConcatenationType the filter concatenation type, or <i>null</i> if 
         *      none is set.
	 */
	public function getFilterConcatinationType();


	/**
	 * Sets the filters used as the sending filters of this trigger mailing, concatenated using the given 
         * concatenation type. The possible types are:
	 * <ul>
	 * <li><i>FilterConcatenationType::AND()</i>,
	 * <li><i>FilterConcatenationType::OR()</i> or
	 * <li><i> FilterConcatenationType::NOT_IN()</i>
	 * </ul>
	 * <p>
	 * For more information on <i>Filter</i>s, see the <i>Inx_Api_Filter_Filter</i> documentation.
	 * 
	 * @param array $filterIds an array of the filter ids. May be null to use no filter at all.
	 * @param Inx_Api_TriggerMailing_FilterConcatenationType $oConcatinationType defines how the filters should be 
         * concatenated. The <i>UNKNOWN</i> type is illegal.
	 * @throws Inx_Api_IllegalArgumentException if the concatenation type is <i>UNKNOWN</i>.
	 * @see Inx_Api_Filter_Filter
	 */
	public function updateFilterIds( array $filterIds, Inx_Api_TriggerMailing_FilterConcatenationType $oConcatinationType );


	/**
	 * Returns the value of the X-Priority header. Allowed values are:
	 * <ul>
	 * <li><i>null</i> - not specified, the X-Priority header will not be set
	 * <li>5 - lowest priority
	 * <li>4 - low priority
	 * <li>3 - normal priority
	 * <li>2 - high priority
	 * <li>1 - highest priority
	 * </ul>
	 *
	 * @return int the value of the X-Priority header, or <i>null</i> if the priority is not set.
	 */
	public function getPriority();


	/**
	 * Sets the value of the X-Priority header. Allowed values are:
	 * <ul>
	 * <li><i>null</i> - not specified, the X-Priority header will not be set
	 * <li>5 - lowest priority
	 * <li>4 - low priority
	 * <li>3 - normal priority
	 * <li>2 - high priority
	 * <li>1 - highest priority
	 * </ul>
	 *
	 * @param int $iPriority the value of the X-Priority header, or <i>null</i> if the priority is not set.
	 */
	public function updatePriority( $iPriority );


	/**
	 * Returns the subject of this trigger mailing.
	 *
	 * @return string the subject of this trigger mailing.
	 */
	public function getSubject();


	/**
	 * Sets the subject of this trigger mailing.
	 *
	 * @param string $sSubject the subject of this trigger mailing.
	 */
	public function updateSubject( $sSubject );


	/**
	 * Returns the name of this trigger mailing.
	 *
	 * @return string the name of this trigger mailing.
	 */
	public function getName();


	/**
	 * Sets the name of this trigger mailing.
	 *
	 * @param string $sName the name of this trigger mailing.
	 */
	public function updateName( $sName );


	/**
	 * Returns the content handler, which contains the format-specific mail content.
	 *
	 * @return Inx_Api_Mailing_ContentHandler the content handler.
	 */
	public function getContentHandler();


	/**
	 * Creates a new content handler. Allowed classes are:
	 * <ul>
	 * <li>PlainTextContentHandler
	 * <li>HtmlTextContentHandler
	 * <li>MultiPartContentHandler
	 * <li>XsltMultiPartContentHandler
	 * <li>XsltHtmlTextContentHandler
	 * <li>XsltPlainTextContentHandler
	 * </ul>
	 *
	 * @param string $sContentHandlerClazz the <i>class name</i> of the content handler.
	 */
	public function setContentHandler( $sContentHandlerClazz );


	/**
	 * Returns the creation datetime of the trigger mailing.
	 *
	 * @return string the creation datetime. The date is returned as ISO-8601 formatted datetime string.
	 */
	public function getCreationDatetime();


	/**
	 * Returns the trigger descriptor of this trigger mailing. The trigger descriptor is used to define the mailing type
	 * and all settings regarding the trigger.
	 *
	 * @return Inx_Api_TriggerMailing_Descriptor_TriggerDescriptor the trigger descriptor of this trigger mailing.
	 */
	public function getTriggerDescriptor();


	/**
	 * Updates the trigger descriptor of this trigger mailing. Be aware that the trigger type can not be changed.
	 *
	 * @param Inx_Api_TriggerMailing_Descriptor_TriggerDescriptor $triggerDescriptor the updated trigger descriptor of 
         *      this trigger mailing.
	 */
	public function updateTriggerDescriptor( Inx_Api_TriggerMailing_Descriptor_TriggerDescriptor $triggerDescriptor );


	/**
	 * Returns the type of this trigger mailing. This is a shortcut for:
	 *
	 * <pre>
	 * getTriggerDescriptor()->getType()
	 * </pre>
	 *
	 * @return Inx_Api_TriggerMailing_Descriptor_TriggerType the type of this trigger mailing.
	 */
	public function getTriggerType();


	/**
	 * Returns the date of the next sending of this trigger mailing.
	 *
	 * @return string the date of the next sending of this trigger mailing. The date is returned as ISO-8601 
         *      formatted datetime string.
	 */
	public function getNextSending();
}
