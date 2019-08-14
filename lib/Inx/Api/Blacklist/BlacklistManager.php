<?php
/**
 * @package Inxmail
 * @subpackage Blacklist
 */
/**
 * Sometimes you might want to exclude particular e-mail addresses or whole address ranges from Inxmail. 
 * For this purpose, there is a 'blacklist' of addresses, which can not be added to the Inxmail recipient list, neither 
 * by import nor by subscription or in any other ways.
 * <p>
 * You can activate the blacklist feature from the <code>SystemListContext</code>. The following snippet shows how this
 * can be achieved:
 * <pre>
 *   $oListContextManager = $oSession->getListContextManager();
 *   $oSystemListContext = $oListContextManager->findByName( Inx_Api_List_SystemListContext::NAME );
 * 
 *   $oSystemListContext->enableFeature( Inx_Api_Features::BLACKLIST_FEATURE_ID );	    
 * </pre>
 * Using an <i>Inx_Api_Blacklist_BlacklistEntry</i>, you can block individual addresses or complete address ranges. 
 * A few examples:
 * <ul>
 * <LI>name@firm.com - The address 'name@firm.com' is blocked.
 * <LI>*@firm.com - All personnel of this firm is blocked.
 * <LI>*.tv - No addresses from Tuvalu.
 * <LI>spam* - All addresses beginning with 'spam' are blocked.
 * <LI>martin@* - All Martins are blocked.
 * </ul>
 * The following snippet shows how to create a blacklist entry that blocks all addresses ending on 'test.com':
 * 
 * <pre>
 * $oBlacklistManager = $oSession->getBlacklistManager();
 * 
 * $oBlacklistEntry = $oBlacklistManager->createBlacklistEntry();
 * $oBlacklistEntry->updateDescription( &quot;All *test.com users&quot; );
 * $oBlacklistEntry->updatePattern( &quot;*test.com&quot; );
 * $oBlacklistEntry->commitUpdate();
 * </pre>
 * Note: The selectAfter, selectBefore and selectBetween methods expect an ISO 8601 formatted date string.
 * This date string can be created as in the following snippet:
 * <pre>
 * $dateString = date('c');
 * </pre> 
 * Note: The usage of the blacklist requires the api user right: <i>Inx_Api_UserRights::BLACKLIST_FEATURE_USE</i>
 * <p>
 * For more information on blacklist entries, see the <i>Inx_Api_Blacklist_BlacklistEntry</i> documentation.
 * 
 * @see Inx_Api_Blacklist_BlacklistEntry
 * @since API 1.1.0
 * @version $Revision: 9553 $ $Date: 2008-01-04 11:28:41 +0200 (Pn, 04 Sau 2008) $ $Author: vladas $
 * @package Inxmail
 * @subpackage Blacklist
 */
interface Inx_Api_Blacklist_BlacklistManager extends Inx_Api_BOManager
{

	/**
	 * Creates a new <i>Inx_Api_Blacklist_BlacklistEntry</i>.
	 * 
	 * @return	Inx_Api_Blacklist_BlacklistEntry the new <i>Inx_Api_Blacklist_BlacklistEntry</i>.
	 */
	public function createBlacklistEntry();

	
	/**
	 * Returns the <i>Inx_Api_Blacklist_BlacklistEntry</i> with the specified pattern.
	 * The pattern is case insensitive.
	 * 
	 * @param string $sPattern	the pattern to find
	 * @return	Inx_Api_Blacklist_BlacklistEntry the entry, or null if no entry was found.
	 */
	public function findByPattern( $sPattern );
	
	
	/**
	 * Returns a result set containing all blacklist entries in the system which were created or changed after the
	 * specified date.
	 * 
	 * @param string $searchDate all entries after this date will be selected. The date has to be formatted as ISO 8601.
	 * @return an <i>Inx_Api_BOResultSet</i> containing all blacklist entries matching the condition.
	 * @throws SecurityException if the session user doesn't have the following permission:
	 *             <i>Inx_Api_UserRights::BLACKLIST_FEATURE_USE</i>
	 */
	public function selectAfter( $searchDate );


	/**
	 * Returns a result set containing all blacklist entries in the system which were created or changed before the
	 * specified date.
	 * 
	 * @param string $searchDate all entries before this date will be selected. The date has to be formatted as ISO 8601.
	 * @return an <i>Inx_Api_BOResultSet</i> containing all blacklist entries matching the condition.
	 * @throws SecurityException if the session user doesn't have the following permission:
	 *             <i>Inx_Api_UserRights::BLACKLIST_FEATURE_USE</i>
	 */
	public function selectBefore( $searchDate );


	/**
	 * Returns a result set containing all blacklist entries in the system which were created or changed between the
	 * specified dates.
	 * 
	 * @param startDate the start date for the search. The date has to be formatted as ISO 8601.
	 * @param stopDate the end date for the search. The date has to be formatted as ISO 8601.
	 * @return an <i>Inx_Api_BOResultSet</i> containing all blacklist entries matching the condition.
	 * @throws SecurityException if the session user doesn't have the following permission:
	 *             <i>Inx_Api_UserRights::BLACKLIST_FEATURE_USE</i>
	 */
	public function selectBetween( $startDate, $stopDate );
}
