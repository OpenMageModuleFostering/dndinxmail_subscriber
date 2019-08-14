<?php
/**
 * @package Inxmail
 * @subpackage DataAccess
 */


/**
 * An <i>Inx_Api_DataAccess_ClickData</i> object can be used to retrieve information about a specific click 
 * accessible through an <i>Inx_Api_DataAccess_ClickDataRowSet</i>. 
 * A row set can be obtained using various filters:
 * <ul>
 * <li>mailing: <i>selectByMailing(int, RecipientContext, Attribute[])</i>
 * <li>link: <i>selectByLink(int, RecipientContext, Attribute[])</i>
 * <li>recipient: <i>selectByRecipient(int, RecipientContext, Attribute[])</i>
 * <li>recipient and mailing: <i>selectByRecipientAndMailing(int, int, RecipientContext, Attribute[])</i>
 * </ul>
 * <p>
 * All of these methods offer variants to filter the result by date. You can search for click data before or after a
 * specific date or between two specific dates.
 * <p>
 * The following example returns a result set containing click data for the specified mailing and fetches the email
 * address of the recipients:
 * 
 * <pre>
 * $oDataAccess = $oSession->getDataAccess();
 * $oClickData = $oDataAccess->getClickData();
 * $oRecipientContext = $oSession->createRecipientContext();
 * $oEmail = $oRecipientContext->getMetaData()->getEmailAttribute();
 * ...
 * $oClickDataRowSet = $oClickData->selectByMailing( $iMailingId, $oRecipientContext, array($oEmail) );
 * </pre>
 * 
 * For more information on the data available for clicks, see the <i>Inx_Api_DataAccess_ClickDataRowSet</i> documentation.
 * 
 * @see Inx_Api_DataAccess_DataAccess
 * @see Inx_Api_DataAccess_ClickDataRowSet
 * @since API 1.4.0
 * @version $Revision: 9553 $ $Date: 2008-01-04 11:28:41 +0200 (Pn, 04 Sau 2008) $ $Author: vladas $
 * @package Inxmail
 * @subpackage DataAccess
 */
interface Inx_Api_DataAccess_ClickData
{	
    
    /**
	 * This method returns an <i>Inx_Api_DataAccess_ClickDataRowSet</i> containing information about all clicks 
	 * regarding the specified mailing. 
	 * If there is no click data, an empty row set will be returned. 
	 * If the <i>Inx_Api_Recipielt_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> 
	 * array contains at least one element, the retrieved click data will contain information about the recipient 
	 * state and the specified recipient attributes.
	 * 
	 * @param int $iMailingId the id of the mailing.
	 * @param Inx_Api_Recipient_RecipientContext $oRc	the recipient context. 
	 * 				See <i>Inx_Api_Session->createRecipientContext()</i>
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 				See <i>Inx_Api_Recipient_RecipientMetaData</i>
	 * @return Inx_Api_DataAccess_ClickDataRowSet an <i>Inx_Api_DataAccess_ClickDataRowSet</i> object that contains 
	 * 				the data produced by the given query.
	 */
	public function selectByMailing( $iMailingId, Inx_Api_Recipient_RecipientContext $oRc,array $aAttrs = null);
	
	
	/**
	 * This method returns an <i>Inx_Api_DataAccess_ClickDataRowSet</i> containing information about all clicks 
	 * regarding the specified mailing which occurred before the specified date. 
	 * If there is no click data, an empty row set will be returned. 
	 * If the <i>Inx_Api_Recipielt_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> 
	 * array contains at least one element, the retrieved click data will contain information about the recipient 
	 * state and the specified recipient attributes.
	 * 
	 * @param int $iMailingId the id of the mailing.
	 * @param string $dtSearchDate all clicks before this date will be selected. 
	 * 				The date has to be formatted as ISO 8601 date string.
	 * @param Inx_Api_Recipient_RecipientContext $oRc	the recipient context. 
	 * 				See <i>Inx_Api_Session->createRecipientContext()</i>
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 				See <i>Inx_Api_Recipient_RecipientMetaData</i>
	 * @return Inx_Api_DataAccess_ClickDataRowSet an <i>Inx_Api_DataAccess_ClickDataRowSet</i> object that contains 
	 * 				the data produced by the given query.
	 * @since API 1.6.2
	 */
	public function selectByMailingBefore( $iMailingId, $dtSearchDate, Inx_Api_Recipient_RecipientContext $oRc,array $aAttrs = null);
	
	/**
	 * This method returns an <i>Inx_Api_DataAccess_ClickDataRowSet</i> containing information about all clicks 
	 * regarding the specified mailing which occurred after the specified date. 
	 * If there is no click data, an empty row set will be returned. 
	 * If the <i>Inx_Api_Recipielt_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> 
	 * array contains at least one element, the retrieved click data will contain information about the recipient 
	 * state and the specified recipient attributes.
	 * 
	 * @param int $iMailingId the id of the mailing.
	 * @param string $dtSearchDate all clicks after this date will be selected. 
	 * 				The date has to be formatted as ISO 8601 date string.
	 * @param Inx_Api_Recipient_RecipientContext $oRc	the recipient context. 
	 * 				See <i>Inx_Api_Session->createRecipientContext()</i>
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 				See <i>Inx_Api_Recipient_RecipientMetaData</i>
	 * @return Inx_Api_DataAccess_ClickDataRowSet an <i>Inx_Api_DataAccess_ClickDataRowSet</i> object that contains 
	 * 				the data produced by the given query.
	 * @since API 1.6.2
	 */
	public function selectByMailingAfter( $iMailingId, $dtSearchDate, Inx_Api_Recipient_RecipientContext $oRc,array $aAttrs = null);

	
	/**
	 * This method returns an <i>Inx_Api_DataAccess_ClickDataRowSet</i> containing information about all clicks 
	 * regarding the specified mailing which occurred between the specified dates. 
	 * If there is no click data, an empty row set will be returned. 
	 * If the <i>Inx_Api_Recipielt_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> 
	 * array contains at least one element, the retrieved click data will contain information about the recipient 
	 * state and the specified recipient attributes.
	 * 
	 * @param int $iMailingId the id of the mailing.
	 * @param string $dtStartDate the start date for the search. 
	 * 				The date has to be formatted as ISO 8601 date string.
	 * @param string $dtEndDate the end date for the search. 
	 * 				The date has to be formatted as ISO 8601 date string.
	 * @param Inx_Api_Recipient_RecipientContext $oRc	the recipient context. 
	 * 				See <i>Inx_Api_Session->createRecipientContext()</i>
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 				See <i>Inx_Api_Recipient_RecipientMetaData</i>
	 * @return Inx_Api_DataAccess_ClickDataRowSet an <i>Inx_Api_DataAccess_ClickDataRowSet</i> object that contains 
	 * 				the data produced by the given query.
	 * @since API 1.6.2
	 */
	public function selectByMailingBetween( $iMailingId, $dtStartDate, $dtEndDate, Inx_Api_Recipient_RecipientContext $oRc,array $aAttrs = null);
	
	
	
    /**
     * This method returns an <i>Inx_Api_DataAccess_ClickDataRowSet</i> containing information about all clicks 
	 * regarding the specified link. 
	 * If there is no click data, an empty row set will be returned. 
	 * If the <i>Inx_Api_Recipielt_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> 
	 * array contains at least one element, the retrieved click data will contain information about the recipient 
	 * state and the specified recipient attributes.
	 * 
	 * @param int $iLinkId the id of the link.
	 * @param Inx_Api_Recipient_RecipientContext $oRc	the recipient context. 
	 * 				See <i>Inx_Api_Session->createRecipientContext()</i>
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 				See <i>Inx_Api_Recipient_RecipientMetaData</i>
	 * @return Inx_Api_DataAccess_ClickDataRowSet an <i>Inx_Api_DataAccess_ClickDataRowSet</i> object that contains 
	 * 				the data produced by the given query.
	 */
	public function selectByLink( $iLinkId,Inx_Api_Recipient_RecipientContext $oRc, array $aAttrs = null );

	
	/**
	 * This method returns an <i>Inx_Api_DataAccess_ClickDataRowSet</i> containing information about all clicks 
	 * regarding the specified link which occurred before the specified date. 
	 * If there is no click data, an empty row set will be returned. 
	 * If the <i>Inx_Api_Recipielt_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> 
	 * array contains at least one element, the retrieved click data will contain information about the recipient 
	 * state and the specified recipient attributes.
	 * 
	 * @param int $iLinkId the id of the link.
	 * @param string $dtSearchDate all clicks before this date will be selected. 
	 * 				The date has to be formatted as ISO 8601 date string.
	 * @param Inx_Api_Recipient_RecipientContext $oRc	the recipient context. 
	 * 				See <i>Inx_Api_Session->createRecipientContext()</i>
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 				See <i>Inx_Api_Recipient_RecipientMetaData</i>
	 * @return Inx_Api_DataAccess_ClickDataRowSet an <i>Inx_Api_DataAccess_ClickDataRowSet</i> object that contains 
	 * 				the data produced by the given query.
	 * @since API 1.6.2
	 */
	public function selectByLinkBefore( $iLinkId, $dtSearchDate, Inx_Api_Recipient_RecipientContext $oRc, array $aAttrs = null );
	
	/**
	 * This method returns an <i>Inx_Api_DataAccess_ClickDataRowSet</i> containing information about all clicks 
	 * regarding the specified link which occurred after the specified date. 
	 * If there is no click data, an empty row set will be returned. 
	 * If the <i>Inx_Api_Recipielt_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> 
	 * array contains at least one element, the retrieved click data will contain information about the recipient 
	 * state and the specified recipient attributes.
	 * 
	 * @param int $iLinkId the id of the link.
	 * @param string $dtSearchDate all clicks after this date will be selected. 
	 * 				The date has to be formatted as ISO 8601 date string.
	 * @param Inx_Api_Recipient_RecipientContext $oRc	the recipient context. 
	 * 				See <i>Inx_Api_Session->createRecipientContext()</i>
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 				See <i>Inx_Api_Recipient_RecipientMetaData</i>
	 * @return Inx_Api_DataAccess_ClickDataRowSet an <i>Inx_Api_DataAccess_ClickDataRowSet</i> object that contains 
	 * 				the data produced by the given query.
	 * @since API 1.6.2
	 */
	public function selectByLinkAfter( $iLinkId, $dtSearchDate, Inx_Api_Recipient_RecipientContext $oRc, array $aAttrs = null );

	/**
	 * This method returns an <i>Inx_Api_DataAccess_ClickDataRowSet</i> containing information about all clicks 
	 * regarding the specified link which occurred between the specified dates. 
	 * If there is no click data, an empty row set will be returned. 
	 * If the <i>Inx_Api_Recipielt_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> 
	 * array contains at least one element, the retrieved click data will contain information about the recipient 
	 * state and the specified recipient attributes.
	 * 
	 * @param int $iLinkId the id of the link.
	 * @param string $dtStartDate the start date for the search. 
	 * 				The date has to be formatted as ISO 8601 date string.
	 * @param string $dtEndDate the end date for the search. 
	 * 				The date has to be formatted as ISO 8601 date string.
	 * @param Inx_Api_Recipient_RecipientContext $oRc	the recipient context. 
	 * 				See <i>Inx_Api_Session->createRecipientContext()</i>
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 				See <i>Inx_Api_Recipient_RecipientMetaData</i>
	 * @return Inx_Api_DataAccess_ClickDataRowSet an <i>Inx_Api_DataAccess_ClickDataRowSet</i> object that contains 
	 * 				the data produced by the given query.
	 * @since API 1.6.2
	 */
	public function selectByLinkBetween( $iLinkId, $dtStartDate, $dtEndDate, Inx_Api_Recipient_RecipientContext $oRc, array $aAttrs = null );
	
    /**
     * This method returns an <i>Inx_Api_DataAccess_ClickDataRowSet</i> containing information about all clicks 
	 * regarding the specified recipient. 
	 * If there is no click data, an empty row set will be returned. 
	 * If the <i>Inx_Api_Recipielt_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> 
	 * array contains at least one element, the retrieved click data will contain information about the recipient 
	 * state and the specified recipient attributes.
	 * 
	 * @param int $iRecipientId the id of the recipient.
	 * @param Inx_Api_Recipient_RecipientContext $oRc	the recipient context. 
	 * 				See <i>Inx_Api_Session->createRecipientContext()</i>
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 				See <i>Inx_Api_Recipient_RecipientMetaData</i>
	 * @return Inx_Api_DataAccess_ClickDataRowSet an <i>Inx_Api_DataAccess_ClickDataRowSet</i> object that contains 
	 * 				the data produced by the given query.
	 */
	public function selectByRecipient( $iRecipientId, Inx_Api_Recipient_RecipientContext $oRc, array $aAttrs = null );
	
    /**
	 * This method returns an <i>Inx_Api_DataAccess_ClickDataRowSet</i> containing information about all clicks 
	 * regarding the specified recipient which occurred before the specified date. 
	 * If there is no click data, an empty row set will be returned. 
	 * If the <i>Inx_Api_Recipielt_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> 
	 * array contains at least one element, the retrieved click data will contain information about the recipient 
	 * state and the specified recipient attributes.
	 * 
	 * @param int $iRecipientId the id of the recipient.
	 * @param string $dtSearchDate all clicks before this date will be selected. 
	 * 				The date has to be formatted as ISO 8601 date string.
	 * @param Inx_Api_Recipient_RecipientContext $oRc	the recipient context. 
	 * 				See <i>Inx_Api_Session->createRecipientContext()</i>
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 				See <i>Inx_Api_Recipient_RecipientMetaData</i>
	 * @return Inx_Api_DataAccess_ClickDataRowSet an <i>Inx_Api_DataAccess_ClickDataRowSet</i> object that contains 
	 * 				the data produced by the given query.
	 * @since API 1.6.2
	 */
	public function selectByRecipientBefore( $iRecipientId, $dtSearchDate, Inx_Api_Recipient_RecipientContext $oRc, array $aAttrs = null );	
	
	
	/**
	 * This method returns an <i>Inx_Api_DataAccess_ClickDataRowSet</i> containing information about all clicks 
	 * regarding the specified recipient which occurred after the specified date. 
	 * If there is no click data, an empty row set will be returned. 
	 * If the <i>Inx_Api_Recipielt_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> 
	 * array contains at least one element, the retrieved click data will contain information about the recipient 
	 * state and the specified recipient attributes.
	 * 
	 * @param int $iRecipientId the id of the recipient.
	 * @param string $dtSearchDate all clicks after this date will be selected. 
	 * 				The date has to be formatted as ISO 8601 date string.
	 * @param Inx_Api_Recipient_RecipientContext $oRc	the recipient context. 
	 * 				See <i>Inx_Api_Session->createRecipientContext()</i>
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 				See <i>Inx_Api_Recipient_RecipientMetaData</i>
	 * @return Inx_Api_DataAccess_ClickDataRowSet an <i>Inx_Api_DataAccess_ClickDataRowSet</i> object that contains 
	 * 				the data produced by the given query.
	 * @since API 1.6.2
	 */
	public function selectByRecipientAfter( $iRecipientId, $dtSearchDate, Inx_Api_Recipient_RecipientContext $oRc, array $aAttrs = null );	
	
	/**
	 * This method returns an <i>Inx_Api_DataAccess_ClickDataRowSet</i> containing information about all clicks 
	 * regarding the specified recipient which occurred between the specified dates. 
	 * If there is no click data, an empty row set will be returned. 
	 * If the <i>Inx_Api_Recipielt_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> 
	 * array contains at least one element, the retrieved click data will contain information about the recipient 
	 * state and the specified recipient attributes.
	 * 
	 * @param int $iRecipientId the id of the recipient.
	 * @param string $dtStartDate the start date for the search. 
	 * 				The date has to be formatted as ISO 8601 date string.
	 * @param string $dtEndDate the end date for the search. 
	 * 				The date has to be formatted as ISO 8601 date string.
	 * @param Inx_Api_Recipient_RecipientContext $oRc	the recipient context. 
	 * 				See <i>Inx_Api_Session->createRecipientContext()</i>
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 				See <i>Inx_Api_Recipient_RecipientMetaData</i>
	 * @return Inx_Api_DataAccess_ClickDataRowSet an <i>Inx_Api_DataAccess_ClickDataRowSet</i> object that contains 
	 * 				the data produced by the given query.
	 * @since API 1.6.2
	 */
	public function selectByRecipientBetween( $iRecipientId, $dtStartDate, $dtEndDate, Inx_Api_Recipient_RecipientContext $oRc, array $aAttrs = null );	
	
	
    /**
	 * This method returns an <i>Inx_Api_DataAccess_ClickDataRowSet</i> containing information about all clicks 
	 * regarding the specified recipient and mailing. 
	 * If there is no click data, an empty row set will be returned. 
	 * If the <i>Inx_Api_Recipielt_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> 
	 * array contains at least one element, the retrieved click data will contain information about the recipient 
	 * state and the specified recipient attributes.
	 * 
	 * @param int $iRecipientId the id of the recipient.
	 * @param int $iMailingId the id of the mailing.
	 * @param Inx_Api_Recipient_RecipientContext $oRc	the recipient context. 
	 * 				See <i>Inx_Api_Session->createRecipientContext()</i>
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 				See <i>Inx_Api_Recipient_RecipientMetaData</i>
	 * @return Inx_Api_DataAccess_ClickDataRowSet an <i>Inx_Api_DataAccess_ClickDataRowSet</i> object that contains 
	 * 				the data produced by the given query.
	 */
	public function selectByRecipientAndMailing( $iRecipientId, $iMailingId, Inx_Api_Recipient_RecipientContext $oRc, array $aAttrs = null);
	
    /**
	 * This method returns an <i>Inx_Api_DataAccess_ClickDataRowSet</i> containing information about all clicks 
	 * regarding the specified recipient and mailing which occurred before the specified date. 
	 * If there is no click data, an empty row set will be returned. 
	 * If the <i>Inx_Api_Recipielt_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> 
	 * array contains at least one element, the retrieved click data will contain information about the recipient 
	 * state and the specified recipient attributes.
	 * 
	 * @param int $iRecipientId the id of the recipient.
	 * @param int $iMailingId the id of the mailing.
	 * @param string $dtSearchDate all clicks before this date will be selected. 
	 * 				The date has to be formatted as ISO 8601 date string.
	 * @param Inx_Api_Recipient_RecipientContext $oRc	the recipient context. 
	 * 				See <i>Inx_Api_Session->createRecipientContext()</i>
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 				See <i>Inx_Api_Recipient_RecipientMetaData</i>
	 * @return Inx_Api_DataAccess_ClickDataRowSet an <i>Inx_Api_DataAccess_ClickDataRowSet</i> object that contains 
	 * 				the data produced by the given query.
	 * @since API 1.6.2
	 */
	public function selectByRecipientAndMailingBefore( $iRecipientId, $iMailingId, $dtSearchDate, Inx_Api_Recipient_RecipientContext $oRc, array $aAttrs = null);
	
	/**
	 * This method returns an <i>Inx_Api_DataAccess_ClickDataRowSet</i> containing information about all clicks 
	 * regarding the specified recipient and mailing which occurred after the specified date. 
	 * If there is no click data, an empty row set will be returned. 
	 * If the <i>Inx_Api_Recipielt_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> 
	 * array contains at least one element, the retrieved click data will contain information about the recipient 
	 * state and the specified recipient attributes.
	 * 
	 * @param int $iRecipientId the id of the recipient.
	 * @param int $iMailingId the id of the mailing.
	 * @param string $dtSearchDate all clicks after this date will be selected. 
	 * 				The date has to be formatted as ISO 8601 date string.
	 * @param Inx_Api_Recipient_RecipientContext $oRc	the recipient context. 
	 * 				See <i>Inx_Api_Session->createRecipientContext()</i>
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 				See <i>Inx_Api_Recipient_RecipientMetaData</i>
	 * @return Inx_Api_DataAccess_ClickDataRowSet an <i>Inx_Api_DataAccess_ClickDataRowSet</i> object that contains 
	 * 				the data produced by the given query.
	 * @since API 1.6.2
	 */
	public function selectByRecipientAndMailingAfter( $iRecipientId, $iMailingId, $dtSearchDate, Inx_Api_Recipient_RecipientContext $oRc, array $aAttrs = null);
	
	/**
	 * This method returns an <i>Inx_Api_DataAccess_ClickDataRowSet</i> containing information about all clicks 
	 * regarding the specified recipient and mailing which occurred between the specified dates. 
	 * If there is no click data, an empty row set will be returned. 
	 * If the <i>Inx_Api_Recipielt_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> 
	 * array contains at least one element, the retrieved click data will contain information about the recipient 
	 * state and the specified recipient attributes.
	 * 
	 * @param int $iRecipientId the id of the recipient.
	 * @param int $iMailingId the id of the mailing.
	 * @param string $dtStartDate the start date for the search. 
	 * 				The date has to be formatted as ISO 8601 date string.
	 * @param string $dtEndDate the end date for the search. 
	 * 				The date has to be formatted as ISO 8601 date string.
	 * @param Inx_Api_Recipient_RecipientContext $oRc	the recipient context. 
	 * 				See <i>Inx_Api_Session->createRecipientContext()</i>
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 				See <i>Inx_Api_Recipient_RecipientMetaData</i>
	 * @return Inx_Api_DataAccess_ClickDataRowSet an <i>Inx_Api_DataAccess_ClickDataRowSet</i> object that contains 
	 * 				the data produced by the given query.
	 * @since API 1.6.2
	 */
	public function selectByRecipientAndMailingBetween( $iRecipientId, $iMailingId, $dtStartDate, $dtEndDate, Inx_Api_Recipient_RecipientContext $oRc, array $aAttrs = null);
	
	
}
