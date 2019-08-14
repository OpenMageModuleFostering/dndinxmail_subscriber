<?php
/**
 * @package Inxmail
 * @subpackage Bounce
 */
/**
 * The <i>Inx_Api_Bounce_BounceManager</i> can be used to retrieve bounces. 
 * There are different methods for the retrieval of bounces, for example you can retrieve bounces by date. 
 * The following example returns an <i>Inx_Api_BOResultSet</i> containing all bounces in the system:
 * 
 * <PRE>
 * $oBounceManager = $oSession->getBounceManager();
 * $oBOResultSet = $oBounceManager->selectAll();
 * 
 * for( $i = 0; $i &lt; $oBOResultSet->size(); $i++ )
 * {
 * 	$oBounce = $oBOResultSet->get( $i );
 * 	echo $oBounce->getSubject()."&#60;br&#62;";
 * }
 * 
 * $oBOResultSet->close();
 * </PRE>
 * 
 * Note: The <i>select*()</i> methods retrieve no recipient information but the id. If you wish to retrieve the
 * recipient state or some of the recipients attributes, use the 
 * <i>select*(..., Inx_Api_Recipient_RecipientContext, Inx_Api_Recipient_Attribute[])</i> methods instead.
 * <p>
 * Note: The usage of bounces requires the api user right:
 * <i>Inx_Api_UserRights::ERRORMAIL_FEATURE_USE</i>
 * <p>
 * For more information on bounces, see the <i>Inx_Api_Bounce_Bounce</i> documentation.
 * 
 * @see Inx_Api_Bounce_Bounce
 * @since API 1.4.3
 * @version $Revision: 9553 $ $Date: 2008-01-04 11:28:41 +0200 (Pn, 04 Sau 2008) $ $Author: vladas $
 * @package Inxmail
 * @subpackage Bounce
 */
interface Inx_Api_Bounce_BounceManager extends Inx_Api_BOManager
{
	/**
	 * Returns a result set containing all bounces which occurred before the specified date. 
	 * If the <i>Inx_Api_Recipient_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> array 
	 * contains at least one element, the retrieved bounces will contain information about the recipient state and the 
	 * specified recipient attributes.
	 * 
	 * @param string $searchDate all bounces before this date will be selected. The date has to be formatted as ISO 8601.
	 * @param Inx_Api_Recipient_RecipientContext $oRc the <i>Inx_Api_Recipient_RecipientContext</i>. 
	 * 			See <i>Inx_Api_Session->createRecipientContext()</i>.
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 			See <i>Inx_Api_Recipient_RecipientMetaData</i>.
	 * @return an <i>Inx_Api_BOResultSet</i> containing all bounces matching the condition.
	 * @since API 1.6.1
	 */
	public function selectBefore( $searchDate, Inx_Api_Recipient_RecipientContext $oRc = null,array $aAttrs = null );


	/**
	 * Returns a result set containing all bounces which occurred after the specified date. 
	 * If the <i>Inx_Api_Recipient_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> array 
	 * contains at least one element, the retrieved bounces will contain information about the recipient state and the 
	 * specified recipient attributes.
	 * 
	 * @param string $searchDate all bounces after this date will be selected. The date has to be formatted as ISO 8601.
	 * @param Inx_Api_Recipient_RecipientContext $oRc the <i>Inx_Api_Recipient_RecipientContext</i>. 
	 * 			See <i>Inx_Api_Session->createRecipientContext()</i>.
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 			See <i>Inx_Api_Recipient_RecipientMetaData</i>.
	 * @return an <i>Inx_Api_BOResultSet</i> containing all bounces matching the condition.
	 * @since API 1.6.1
	 */
	public function selectAfter( $searchDate, Inx_Api_Recipient_RecipientContext $oRc = null,array $aAttrs = null );


	/**
	 * Returns a result set containing all bounces which occurred between the specified dates. 
	 * If the <i>Inx_Api_Recipient_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> array 
	 * contains at least one element, the retrieved bounces will contain information about the recipient state and the 
	 * specified recipient attributes.
	 * 
	 * @param string $startDate the start date. The date has to be formatted as ISO 8601.
	 * @param string $stopDate the stop date. The date has to be formatted as ISO 8601.
	 * @param Inx_Api_Recipient_RecipientContext $oRc the <i>Inx_Api_Recipient_RecipientContext</i>. 
	 * 			See <i>Inx_Api_Session->createRecipientContext()</i>.
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 			See <i>Inx_Api_Recipient_RecipientMetaData</i>.
	 * @return an <i>Inx_Api_BOResultSet</i> containing all bounces matching the condition.
	 * @since API 1.6.1
	 */
	public function selectBetween( $startDate, $stopDate, Inx_Api_Recipient_RecipientContext $oRc = null,array $aAttrs = null );
	
	/**
	 * Returns a result set containing all bounces regarding the specified mailing. 
	 * If there are no bounces, an empty result set will be returned.
	 * If the <i>Inx_Api_Recipient_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> array 
	 * contains at least one element, the retrieved bounces will contain information about the recipient state and the 
	 * specified recipient attributes.
	 * 
	 * @param int $mailingId the id of the mailing.
	 * @param Inx_Api_Recipient_RecipientContext $oRc the <i>Inx_Api_Recipient_RecipientContext</i>. 
	 * 			See <i>Inx_Api_Session->createRecipientContext()</i>.
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 			See <i>Inx_Api_Recipient_RecipientMetaData</i>.
	 * @return an <i>Inx_Api_BOResultSet</i> containing all bounces matching the condition.
	 * @since API 1.6.1
	 */
	public function selectByMailingId( $mailingId, Inx_Api_Recipient_RecipientContext $oRc = null,array $aAttrs = null );


	/**
	 * Returns a result set containing all bounces regarding the specified list. 
	 * If there are no bounces, an empty result set will be returned.
	 * If the <i>Inx_Api_Recipient_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> array 
	 * contains at least one element, the retrieved bounces will contain information about the recipient state and the 
	 * specified recipient attributes.
	 * 
	 * @param int $listId the id of the list.
	 * @param Inx_Api_Recipient_RecipientContext $oRc the <i>Inx_Api_Recipient_RecipientContext</i>. 
	 * 			See <i>Inx_Api_Session->createRecipientContext()</i>.
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 			See <i>Inx_Api_Recipient_RecipientMetaData</i>.
	 * @return an <i>Inx_Api_BOResultSet</i> containing all bounces matching the condition.
	 * @since API 1.6.1
	 */
	public function selectByListId( $listId, Inx_Api_Recipient_RecipientContext $oRc = null,array $aAttrs = null );
	
	/**
	 * Returns a result set containing all bounces. 
	 * If there are no bounces, an empty result set will be returned. 
	 * If the <i>Inx_Api_Recipient_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> array 
	 * contains at least one element, the retrieved bounces will contain information about the recipient state and the 
	 * specified recipient attributes.
	 * 
	 * @param Inx_Api_Recipient_RecipientContext $oRc the <i>Inx_Api_Recipient_RecipientContext</i>. 
	 * 			See <i>Inx_Api_Session->createRecipientContext()</i>.
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 			See <i>Inx_Api_Recipient_RecipientMetaData</i>.
	 * @return an <i>Inx_Api_BOResultSet</i> containing all bounces matching the condition.
	 * @since API 1.6.1
	 */
	public function selectAllBounces(Inx_Api_Recipient_RecipientContext $oRc = null,array $aAttrs = null);

}
