<?php
/**
 * @package Inxmail
 * @subpackage Mailing
 */

/**
 * An <i>Inx_Api_Mailing_Mailing</i> object represents a mailing in inxmail. 
 * An <i>Inx_Api_Mailing_Mailing</i> object can be used to perform various tasks:
 * <ul>
 * <li>Retrieve and update mailing meta information and content
 * <li>Send the mailing (immediately or scheduled)
 * <li>Stop sending the mailing
 * <li>Request the approval of a mailing
 * <li>Approve or revoke the approval for the mailing
 * </ul>
 * <strong>Handling mailing content</strong>
 * <p>
 * Content is put into mailings using content handlers. There are a number of such handlers:
 * <ul>
 * <li><i>Inx_Api_Mailing_PlainTextContentHandler</i> - Handles plain text content. This is the default content handler.
 * <li><i>Inx_Api_Mailing_HtmlTextContentHandler</i> - Handles HTML-only content.
 * <li><i>Inx_Api_Mailing_MultiPartContentHandler</i> - Handles multipart content (HTML and plain text), or mailings 
 * where the content type is selected depending on the recipient profile.
 * <li><i>Inx_Api_Mailing_XsltMultiPartContentHandler</i> - Handles multipart content defined by XML/XSLT, or mailings 
 * where the content type is selected depending on the recipient profile. Used by templates.
 * <li><i>Inx_Api_Mailing_XsltPlainTextContentHandler</i> - Handles plain text defined by XML/XSLT. Used by templates.
 * <li><i>Inx_Api_Mailing_XsltHtmlTextContentHandler</i> - Handles HTML text content defined by XML/XSLT. Used by templates.
 * </ul>
 * <p>
 * All of these handlers offer methods to edit the content of the mailing. 
 * The following snippet changes the content of a plain text mailing:
 * 
 * <pre>
 * $oMailing->setContentHandler( 'Inx_Api_Mailing_PlainTextContentHandler' );
 * $oContentHandler = $oMailing->getContentHandler();
 * $oContentHandler->updateContent( "...any mailing content..." );
 * $oMailing->commitUpdate();
 * </pre>
 * 
 * <strong>Approval and controlling dispatch</strong>
 * <p>
 * The following methods can be used for the approval of mailings:
 * <ul>
 * <li><i>approve($iApproverId, $sComment)</i>: approves the mailing using the given approver.
 * <li><i>denyApprove($iApproverId, $sComment)</i>: denies the approval of the mailing using the given approver.
 * <li><i>revokeApproval($sComment)</i>: revokes the approval of the mailing using the given approver.
 * <li><i>requestIdenticalApproval($sDeadline, $aApprovers, $aRecipients, $bIsTestRecipient, $sLocale)</i>: requests 
 * the approval of the mailing using the given equitable approvers.
 * <li><i>requestEscalationApproval($sEscalation, $sDeadline, $aApprovers, $aRecipients, $bIsTestRecipient, $sLocale)</i>: 
 * requests the approval of the mailing using the given hierarchical approvers.
 * </ul>
 * As listed above, there are two methods for requesting the approval of a mailing:
 * <i>requestIdenticalApproval(...)</i> and <i>requestEscalationApproval(...)</i>. 
 * Both methods require two approvers but involve them differently.<br>
 * The identical approval process sends the request to both approvers simultaneously and requires only one of the
 * approvers to approve the mailing. 
 * The escalation approval process at first sends the request only to the first approver. 
 * If the escalation date expires without the first approver having approved the mailing, the request is sent to the 
 * second approver.<br>
 * If the deadline date expires without any of the approvers having approved the mailing, the request will be cancelled.
 * In order to approve it, the mailing creator will have to request the approval again.
 * <p>
 * Note: The methods for approving a mailing are functional since Inxmail 3.8.1.
 * <p>
 * The Following methods can be used to send mailings:
 * <ul>
 * <li><i>startSending()</i>: starts the normal sending process.
 * <li><i>sendSingleMail($iRecipientId)</i>: send the mailing only to the specified recipient.
 * <li><i>sendTestMail($sTestAddress, $iRecipientId)</i>: send the mailing to the specified address, personalized for the 
 * given recipient.
 * <li><i>sendTestMailWithTestprofile($sTestAddress, $iTestRecipientId)</i>: send the mailing to the specified address, 
 * personalized for the given test profile.
 * </ul>
 * <p>
 * To schedule a mailing instead of sending it immediately, use the <i>scheduleMailing($sScheduleTime)</i> method. 
 * The following snippet shows how to schedule a mailing to be sent in one hour:
 * 
 * <pre>
 * $oMailing->scheduleMailing( date( 'c', strtotime("+1 hour") ) );
 * </pre>
 * <p>
 * The following snippet shows how to revoke the scheduled sending of a mailing:
 * 
 * <pre>
 * mailing->unscheduleMailing();
 * </pre>
 * <p>
 * <strong>Note:</strong> For existing mailings, always call <code>lock()</code> before updating it, and
 * <code>unlock()</code> after committing changes!
 * <p>
 * For an example on how to retrieve and create mailings, see the <i>Inx_Api_Mailing_MailingManager</i> documentation.
 * <p>
 * For more information on the creation of <i>Inx_Api_Approval_Approver</i>s, see the 
 * <i>Inx_Api_Approval_ApproverManager</i> documentation.
 * 
 * @see Inx_Api_Mailing_MailingManager
 * @see Inx_Api_Mailing_ContentHandler
 * @see Inx_Api_Approval_ApproverManager  
 * @since API 1.0
 * @version $Revision: 9553 $ $Date: 2008-01-04 11:28:41 +0200 (Pn, 04 Sau 2008) $ $Author: vladas $
 * @package Inxmail
 * @subpackage Mailing
 */
interface Inx_Api_Mailing_Mailing extends Inx_Api_BusinessObject
{

	const ATTRIBUTE_SUBJECT = 3;

	const ATTRIBUTE_PLAIN_TEXT = 4;

	const ATTRIBUTE_HTML_TEXT = 5;

	const ATTRIBUTE_XML_CONTENT = 6;

	const ATTRIBUTE_PLAIN_TEXT_XSL = 7;

	const ATTRIBUTE_HTML_TEXT_XSL = 8;

	const ATTRIBUTE_FILTER_ID = 9;

	const ATTRIBUTE_SENDER_ADDRESS = 10;
	
	const ATTRIBUTE_RECIPIENT_ADDRESS = 11;
	
	const ATTRIBUTE_REPLY_TO_ADDRESS = 12;
	
	const ATTRIBUTE_PRIORITY = 13;

	const ATTRIBUTE_SCHEDULE_DATETIME = 14;
	
	const ATTRIBUTE_MODIFICATION_DATETIME = 15;
	
	const ATTRIBUTE_STYLE = 16;

	const ATTRIBUTE_SENT_START_DATETIME = 17;
	
	const ATTRIBUTE_SENT_END_DATETIME = 18;
	
	const ATTRIBUTE_NAME = 19;
	
	const STATE_DRAFT = 1;
	
	const STATE_TO_BE_APPROVE = 2;
	
	const STATE_APPROVED = 4;
	
	const STATE_SCHEDULED = 8;
	
	const STATE_SENDING = 16;
	
	const STATE_INTERRUPTED = 32;
	
	const STATE_SENT = 64;

	const STATE_SENDING_FAILED = 128;

	
	/**
	 * @since API 1.6.0
	 */
	const FILTER_AND = 1;

	/**
	 * @since API 1.6.0
	 */
	const FILTER_OR = 2;

	/**
	 * @since API 1.6.0
	 */
	const FILTER_NOT_IN = 3;
	
	
	
	/**
	 * Sending this mailing to the test address. Using the specified recipient
	 * to generating the email content.
	 * 
	 * @param string $sTestAddresss	the email address 
	 * @param int $iRecipientId the recipient to generating the email content
	 * @throws Inx_Api_Mailing_SendException
	 * @throws Inx_Api_Mailing_MailingStateException	if this mailing has a illegal state
	 * @throws Inx_Api_DataException if this mailing is not found on the server
	 */
	public function sendTestMail( $sTestAddress, $iRecipientId );

	/**
	 * Sending this mailing to the test address. Using the specified recipient
	 * to generating the email content.
	 * 
	 * @param string $sTestAddresss	the email address 
	 * @param int $iTestprofileId the recipient to generating the email content
	 * @throws Inx_Api_Mailing_SendException
	 * @throws Inx_Api_Mailing_MailingStateException	if this mailing has a illegal state
	 * @throws Inx_Api_DataException if this mailing is not found on the server
	 * @since API 1.6.1
	 */
	public function sendTestMailWithTestprofile( $sTestAddress, $iTestprofileId );
	
	
	/**
	 * Sending this mailing to the specified recipient. Using the recipient
	 * to generating the email content.
	 * 
	 * @param int $iRecipientId the recipient to generating the email content
	 * @return the updated mailing
	 * @throws Inx_Api_Mailing_SendException
	 * @throws Inx_Api_Mailing_MailingStateException	if this mailing has a illegal state
	 * @throws Inx_Api_DataException	if this mailing is not found on the server
	 */
	public function sendSingleMail( $iRecipientId );

	
	/**
	 * Start or restart the sending of this mailing.
	 * 
	 * Allowed mailing states are:
	 * <ul>
	 * <li>Inx_Api_Mailing_Mailing::STATE_APPROVED	( -> STATE_SENDING )
	 * <li>Inx_Api_Mailing_Mailing::STATE_IInx_Api_Mailing_Mailing::ED	( -> STATE_SENDING )
	 * </ul>
	 * 
	 * @throws Inx_Api_Mailing_MailingStateException	if this mailing has a illegal state
	 * @throws Inx_Api_DataException	if this mailing is not found on the server
	 */
	public function startSending();

	
	/**
	 * Stop the sending of the specified mailing.
	 * 
	 * Allowed mailing states are:
	 * <ul>
	 * <li>Inx_Api_Mailing_Mailing::STATE_SENDING	( -> STATE_INTERRUPTED )
	 * </ul>
	 * 
	 * @throws Inx_Api_Mailing_MailingStateException	if this mailing has a illegal state
	 * @throws Inx_Api_DataException	if this mailing is not found on the server
	 */	
	public function stopSending();

	
	/**
	 * Approve this mailing for sending.
	 * <p>
	 * Allowed mailing states are:
	 * <ul>
	 * <li>Inx_Api_Mailing_Mailing::STATE_TO_BE_APPROVE ( -> STATE_APPROVED or STATE_STATE_SCHEDULED )
	 * </ul>
	 * 
	 * @param approverId id of the approver
	 * @param comment message of the approver
	 * @throws MailingStateException if this mailing has a illegal state
	 * @throws DataException if this mailing is not found on the server
	 * @throws UpdateException if the request goes wrong, for example approval not active
	 */
	public function approve( $iApproverId = 0, $sComment = null );


	/**
	 * Deny approval of this mailing.
	 * <p>
	 * Allowed mailing states are:
	 * <ul>
	 * <li>Inx_Api_Mailing_Mailing::STATE_TO_BE_APPROVE ( -> STATE_DRAFT )
	 * </ul>
	 * 
	 * @param approverId id of the approver
	 * @param comment message of the approver
	 * @throws MailingStateException if this mailing has a illegal state
	 * @throws DataException if this mailing is not found on the server
	 * @throws UpdateException if the request goes wrong, for example approval not active
	 */
	public function denyApprove( $iApproverId, $sComment );
	
	
	
	/**
	 * Request the approval for this mailing.
	 * 
	 * Allowed mailing states are:
	 * <ul>
	 * <li>Inx_Api_Mailing_Mailing::STATE_DRAFT	( -> STATE_TO_BE_APPROVE )
	 * </ul>
	 * @deprecated 
	 * @throws Inx_Api_Mailing_MailingStateException	if this mailing has a illegal state
	 * @throws Inx_Api_DataException	if this mailing is not found on the server
	 */	
	public function requestApproval();

	/**
	 * Request the escalating approval for this mailing.
	 * <p>
	 * Allowed mailing states are:
	 * <ul>
	 * <li>Inx_Api_Mailing_Mailing::STATE_DRAFT ( -> STATE_TO_BE_APPROVE )
	 * </ul>
	 * 
	 * @throws MailingStateException if this mailing has a illegal state
	 * @throws DataException if this mailing is not found on the server
	 * @throws UpdateException if the request goes wrong, for example approval not active
	 */
	public function requestEscalationApproval( $oEscalationDate, $oDeadline, $approverIds, $recipientIds,
			$bIsTestRecipient, $sLocale );


	/**
	 * Request the escalating approval for this mailing.
	 * <p>
	 * Allowed mailing states are:
	 * <ul>
	 * <li>Inx_Api_Mailing_Mailing::STATE_DRAFT ( -> STATE_TO_BE_APPROVE )
	 * </ul>
	 * 
	 * @throws MailingStateException if this mailing has a illegal state
	 * @throws DataException if this mailing is not found on the server
	 * @throws UpdateException if the request goes wrong, for example approval not active
	 */
	public function requestIdenticalApproval( $oDeadline, $approverIds, $recipientIds, $bIsTestRecipient,
			$sLocale );
	


	/**
	 * Revoke the approval or scheduling for this mailing.
	 * <p>
	 * Allowed mailing states are:
	 * <ul>
	 * <li>Inx_Api_Mailing_Mailing::STATE_APPROVED ( -> STATE_DRAFT )
	 * <li>Inx_Api_Mailing_Mailing::STATE_TO_BE_APPROVE ( -> STATE_DRAFT )
	 * <li>Inx_Api_Mailing_Mailing::STATE_SCHEDULED ( -> STATE_DRAFT )
	 * </ul>
	 * 
	 * @param comment reason why revoke is called
	 * @throws MailingStateException if this mailing has a illegal state
	 * @throws DataException if this mailing is not found on the server
	 * @throws UpdateException if the request goes wrong, for example approval not active
	 */
	public function revokeApproval( $sComment = null );


	/**
	 * Schedules the mailing with the given date.
	 * <p>
	 * Allowed mailing states are:
	 * <ul>
	 * <li>Inx_Api_Mailing_Mailing::STATE_DRAFT ( -> STATE_SHEDULED ) if no approval is active
	 * <li>Inx_Api_Mailing_Mailing::STATE_DRAFT ( -> STATE_DRAFT ) if approval is active
	 * <li>Inx_Api_Mailing_Mailing::STATE_TO_BE_APPROVED ( -> STATE_TO_BE_APPROVED )
	 * <li>Inx_Api_Mailing_Mailing::STATE_APPROVED ( -> STATE_SHEDULED )
	 * <li>Inx_Api_Mailing_Mailing::STATE_INTERRUPTED ( -> STATE_SHEDULED )
	 * </ul>
	 * 
	 * @param scheduleTime new schedule time of the mailing
	 * @throws MailingStateException if this mailing has a illegal state
	 * @throws DataException if this mailing is not found on the server
	 */
	public function scheduleMailing( $oScheduleTime = null ) ;


	/**
	 * Unschedules the mailing.
	 * <p>
	 * Allowed mailing states are:
	 * <ul>
	 * <li>Inx_Api_Mailing_Mailing::STATE_SHEDULED( -> STATE_APPROVED or STATE_DRAFT )
	 * <li>Inx_Api_Mailing_Mailing::STATE_DRAFT ( -> STATE_DRAFT )
	 * <li>Inx_Api_Mailing_Mailing::STATE_TO_BE_APPROVED ( -> STATE_TO_BE_APPROVED )
	 * </ul>
	 * 
	 * @throws MailingStateException if this mailing has a illegal state
	 * @throws DataException if this mailing is not found on the server
	 */
	public function unscheduleMailing();
	
	/**
	 * Lock the this <i>Inx_Api_Mailing_Mailing</i>. For existing mailings, always
	 * call <i>lock()</i> before updating it, and <i>unlock()</i>
	 * after committing changes!
	 * 
	 * @throws Inx_Api_LockException	if this mailing already locked
	 * @throws Inx_Api_Mailing_MailingStateException	if this mailing has a illegal state
	 * @throws Inx_Api_DataException if this mailing is not found on the server
	 */
	public function lock();

	
	/**
	 * Release the lock of this <i>Inx_Api_Mailing_Mailing</i>.
	 * 
	 * @param boolean forceForeignLock	<i>true</i> - release foreign and own locks,
	 * <i>false</i> - release only own locks  
	 * @return boolean <i>true</i> if this mailing was unlocked, <i>false</i> otherwise
	 * @throws Inx_Api_DataException
	 */
	public function unlock( $blForceForeignLock = false );

	
	/**
	 * Returns the mailing state.
	 * 
	 * @return int the mailing state
	 */
	public function getState(); 


	/**
	 * Checks if this mailing has a lock.
	 * 
	 * @return boolean true if this mailing has a lock, otherwise false
	 */
	public function isLocked(); 

	
	/**
	 * Returns the lock ticket.
	 * 
	 * @return Inx_Api_LockTicket the lock ticket
	 */
	public function getLockTicket();
	
	
	/**
	 * Returns the last modification datetime.
	 * 
	 * @return string the last modification datetime
	 */
	public function getModificationDatetime();


	/**
	 * Returns the schedule datetime.
	 * 
	 * @return string	the schedule datetime, can be null
	 */
	public function getScheduleDatetime();

	
	/**
	 * Sets the schedule datetime.
	 * 
	 * @param string $dtScheduleDatetime	the schedule datetime, or null
	 */
	public function updateScheduleDatetime( $dtScheduleDatetime );

	
	/**
	 * Returns the sent datetime, null if this mailing not yet sent.
	 * 
	 * @return string the sent datetime, or null
	 */
	public function getSentDatetime();

	
	/**
	* Returns the approval escalation datetime of this mailing if the mailing is in the state
	* <i>STATE_TO_BE_APPROVE</i> and the approval process is escalating. 
	* If the mailing state is not <i>STATE_TO_BE_APPROVE</i> or the approval process is identical, 
	* <i>null</i> may be returned.
	* The date will be returned as ISO 8601 formatted datetime string.
	*
	* @see requestEscalationApproval( $oEscalationDate, $oDeadline, $approverIds, $recipientIds, $bIsTestRecipient, $sLocale )
	* @return string the approval escalation datetime, or <i>null</i>.
	* @since API 1.9.0
	*/
	public function getEscalationDatetime();
	
	
	/**
	 * Returns the approval deadline datetime of this mailing if the mailing is in the state <i>STATE_TO_BE_APPROVE</i>. 
	 * If the mailing state is not <i>STATE_TO_BE_APPROVE</i>, <i>null</i> may be returned.
	 * The date will be returned as ISO 8601 formatted datetime string.
	 *
	 * @see requestIdenticalApproval( $oDeadline, $approverIds, $recipientIds, $bIsTestRecipient, $sLocale );
	 * @see requestEscalationApproval( $oEscalationDate, $oDeadline, $approverIds, $recipientIds, $bIsTestRecipient, $sLocale )
	 * @return string the approval deadline datetime, or <i>null</i>.
	 * @since API 1.9.0
	 */
	public function getDeadlineDatetime();
	
	
	/**
	 * Returns the id of list context which this mailing belongs to.
	 * 
	 * @return int the id of list context which this mailing belongs to
	 */
	public function getListContextId();


	/**
	 * Returns the sender address of this mailing.
	 * 
	 * @return String the sender address of this mailing
	 */
	public function getSenderAddress();
	
	
	/**
	 * Sets the sender address of this mailing.
	 * 
	 * @param string $sSenderAddress	the sender address of this mailing
	 */
	public function updateSenderAddress( $sSenderAddress );
	

	/**
	 * Returns the recipient address of this mailing.
	 * 
	 * @return String the recipient address of this mailing
	 */
	public function getRecipientAddress();
	
	
	/**
	 * Sets the recipient address of this mailing.
	 * 
	 * @param string $sRecipientAddress	the recipient address of this mailing
	 */
	public function updateRecipientAddress( $sRecipientAddress );
	

	/**
	 * Returns the recipient address of this mailing.
	 * 
	 * @return string the recipient address of this mailing
	 */
	public function getReplyToAddress();
	
	
	/**
	 * Sets the replyTo address of this mailing.
	 * 
	 * @param string $sReplyToAddress	the replyTo address of this mailing
	 */
	public function updateReplyToAddress( $sReplyToAddress );

	
	/**
	 * Returns a sending filter of this mailing.
	 * 
	 * @return int the filter id, 0 means that no filter is set
	 * @since API 1.1.0
	 */
	public function getFilterId();
	
	
	/**
	 * Sets a sending filter of this mailing.
	 * 
	 * @param int $iFilterId the filter id, 0 means that no filter is set
	 * @see  com.inxmail.xpro.api.filter.Filter#getId()
	 * @since API 1.1.0
	 */
	public function updateFilterId( $iFilterId );
	
		/**
	 * Returns the sending filter of this mailing.
	 * 
	 * @return the filter id, null means that no filter is set
	 * @since API 1.6.0
	 */
	public function getFilterIds();


	/**
	 * Returns the sending filter concatenation type of this mailing.
	 * 
	 * @return <code>FILTER_AND</code> or <code>FILTER_OR</code> or <code>FILTER_NOT_IN</code> or 0 if it is not set
	 * @since API 1.6.0
	 */
	public function getFilterConcatinationType();


	/**
	 * Sets a couple of sending filter to this mailing.
	 * 
	 * @param filterIds array of the filter ids, null for no filter is set
	 * @param concatinationType sets how the filter should be concatinated, <code>FILTER_AND</code>,
	 *            <code>FILTER_OR</code>, <code>FILTER_NOT_IN</code>
	 * @since API 1.6.0
	 */
	public function updateFilterIds( $filterIds, $iConcatinationType );
	
	
	/**
	 * Returns the value of X-Priority header. Allowed values are:
	 * <ul>
	 * <li><tt>null</tt> - not specified, the X-Priority header will not be set
	 * <li>5 - lowest priority
	 * <li>4 - low priority
	 * <li>3 - normal priority
	 * <li>2 - high priority
	 * <li>1 - highest priority
	 * </ul>
	 * 
	 * @return Integer the value of X-Priority header, or <tt>null</tt>
	 */
	public function getPriority();
	

	/**
	 * Sets the value of X-Priority header. Allowed values are:
	 * <ul>
	 * <li><tt>null</tt> - not specified, the X-Priority header will not be set
	 * <li>5 - lowest priority
	 * <li>4 - low priority
	 * <li>3 - normal priority
	 * <li>2 - high priority
	 * <li>1 - highest priority
	 * </ul>
	 * 
	 * @param Integer $iPriority	the value of X-Priority header, or <tt>null</tt>
	 */
	public function updatePriority( $iPriority );
	
	
	/**
	 * Returns the subject of this mailing.
	 * 
	 * @return String the subject of this mailing
	 */
	public function getSubject();
	
	
	/**
	 * Sets the subject of this mailing.
	 * 
	 * @param String subject	the subject of this mailing
	 */
	public function updateSubject(  $sSubject );

	/**
	 * Returns the name of this mailing.
	 * 
	 * @return String the name of this mailing
	 */
	public function getName();
	
	
	/**
	 * Sets the name of this mailing.
	 * 
	 * @param String name	the name of this mailing
	 */
	public function updateName( $sName );



	/**
	 * Returns the content handler, which contains the format-specific mail content.
	 * 
	 * @return Inx_Api_Mailing_ContentHandler the content handler
	 */
	public function getContentHandler();
	
	
	/**
	 * Creates a new content handler. Allowed classes are:
	 * <ul>
	 * <li><i>PlainTextContentHandler</i>
	 * <li><i>HtmlTextContentHandler</i>
	 * <li><i>MultiPartContentHandler</i>
	 * <li><i>XsltMultiPartContentHandler</i>
	 * <li><i>XsltHtmlTextContentHandler</i>
	 * <li><i>XsltPlainTextContentHandler</i>
	 * </ul>
	 *  
	 * @param string $oContentHandlerClazz	the <i>Class</i> of the content handler
	 */
	public function setContentHandler( $oContentHandlerClazz );


	/**
	 * Returns the mailing info object which contains the number sent mails.
	 * 
	 * @return the mailing info object
	 * @throws Inx_Api_DataException
	 */
	public function getSendingInfo();
	
	/**
	 * Returns the create date of the mailing
	 * 
	 * @return the creation date
	 * @since 1.7.1
	 */
	public function getCreationDatetime();
}
