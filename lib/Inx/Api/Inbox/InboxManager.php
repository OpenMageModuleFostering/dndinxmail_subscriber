<?php
/**
* The <i>Inx_Api_Inbox_InboxManager</i> can be used to retrieve inbox messages. 
* There are different methods for the retrieval of inbox messages, for example you can retrieve messages by date. 
* The following example returns an <i>Inx_Api_BOResultSet</i> containing all inbox messages in the system:
*
* <PRE>
* $oInboxManager = $oSession->getInboxManager();
* $oBOResultSet = $oInboxManager->selectAll();
*
* for( $i = 0; $i &lt; $oBOResultSet->size(); $i++ )
* {
* 	$oInboxMessage = $oBOResultSet->get( $i );
* 	echo $oInboxMessage->getSubject() . '&lt;br&gt;';
* }
*
* $oBOResultSet->close();
* </PRE>
*
* Note: The <i>selectAll()</i> method retrieves no recipient information but the id. 
* If you wish to retrieve the recipient state or some of the recipients attributes, use the 
* <i>selectAll($oRecipientContext, $aAttributes)</i> method instead.
* <p>
* Note: The usage of the <i>Inbox</i> requires the api user right: <i>Inx_Api_UserRights::ERRORMAIL_FEATURE_USE</i>
* <p>
* For more information on inbox messages, see the <i>Inx_Api_Inbox_InboxMessage</i> documentation.
*
* @see Inx_Api_Inbox_InboxMessage
* @since API 1.9.0
* @version $Revision:$ $Date:$ $Author:$
* @package Inxmail
* @subpackage Inbox
*/
interface Inx_Api_Inbox_InboxManager extends Inx_Api_BOManager
{
	/**
	 * Returns a result set containing all inbox messages received before the specified date.
	 * The date has to be passed as ISO 8601 formatted datetime string. 
	 * If the <i>RecipientContext</i> is not null and the <i>Attribute</i> array contains at least one element, the
	 * retrieved messages will contain information about the recipient state and the specified recipient attributes.
	 *
	 * @param string $sSearchDate all inbox messages before this date will be selected.
	 * @param Inx_Api_Recipient_RecipientContext $rc the <i>RecipientContext</i>. 
	 * 			See <i>Inx_Api_Session::createRecipientContext()</i>.
	 * @param array $aAttributes an array of recipient attributes that will be fetched for later retrieval. 
	 * 			See <i>Inx_Api_Recipient_RecipientMetaData</i>.
	 * @return Inx_Api_BOResultSet a <i>BOResultSet</i> containing all inbox messages matching the condition.
	 */
	public function selectBefore( $sSearchDate, Inx_Api_Recipient_RecipientContext $rc, $aAttributes );


	/**
	 * Returns a result set containing all inbox messages received after the specified date. 
	 * The date has to be passed as ISO 8601 formatted datetime string.  
	 * If the <i>RecipientContext</i> is not null and the <i>Attribute</i> array contains at least one element, the
	 * retrieved messages will contain information about the recipient state and the specified recipient attributes.
	 *
	 * @param string $sSearchDate all inbox messages after this date will be selected.
	 * @param Inx_Api_Recipient_RecipientContext $rc the <i>RecipientContext</i>. 
	 * 			See <i>Inx_Api_Session::createRecipientContext()</i>.
	 * @param array $aAttributes an array of recipient attributes that will be fetched for later retrieval. 
	 * 			See <i>Inx_Api_Recipient_RecipientMetaData</i>.
	 * @return Inx_Api_BOResultSet a <i>BOResultSet</i> containing all inbox messages matching the condition.
	 */
	public function selectAfter( $sSearchDate, Inx_Api_Recipient_RecipientContext $rc, $aAttributes );


	/**
	 * Returns a result set containing all inbox messages received between the specified date. 
	 * The dates have to be passed as ISO 8601 formatted datetime string.  
	 * If the <i>RecipientContext</i> is not null and the <i>Attribute</i> array contains at least one element, the
	 * retrieved messages will contain information about the recipient state and the specified recipient attributes.
	 *
	 * @param string $sStartDate the start date of the search.
	 * @param string $sStopDate the end date of the search.
	 * @param Inx_Api_Recipient_RecipientContext $rc the <i>RecipientContext</i>. 
	 * 			See <i>Inx_Api_Session::createRecipientContext()</i>.
	 * @param array $aAttributes an array of recipient attributes that will be fetched for later retrieval. 
	 * 			See <i>Inx_Api_Recipient_RecipientMetaData</i>.
	 * @return Inx_Api_BOResultSet a <i>BOResultSet</i> containing all inbox messages matching the condition.
	 */
	public function selectBetween( $sStartDate, $sStopDate, Inx_Api_Recipient_RecipientContext $rc, $aAttributes );


	/**
	 * Returns a result set containing all inbox messages. 
	 * If there are no messages, an empty result set will be returned. 
	 * If the <i>RecipientContext</i> is not null and the <i>Attribute</i> array contains at least one element, the
	 * retrieved messages will contain information about the recipient state and the specified recipient attributes.
	 *
	 * @param Inx_Api_Recipient_RecipientContext $rc the <i>RecipientContext</i>. 
	 * 			See <i>Inx_Api_Session::createRecipientContext()</i>.
	 * @param array $aAttributes an array of recipient attributes that will be fetched for later retrieval. 
	 * 			See <i>Inx_Api_Recipient_RecipientMetaData</i>.
	 * @return Inx_Api_BOResultSet a <i>BOResultSet</i> containing all inbox messages matching the condition.
	 */
	public function selectAllInboxMessages( Inx_Api_Recipient_RecipientContext $rc = null, $aAttributes = null );

}