<?php
/**
 * @package Inxmail
 * @subpackage Blacklist
 */
/**
 * An <i>Inx_Api_Blacklist_BlacklistEntry</i> can block individual addresses or complete address ranges so 
 * they can not be added to the Inxmail recipient list, neither by import nor by subscription or in any other ways. 
 * A few examples:
 * <ul>
 * <LI>name@firm.com - The address 'name@firm.com' is blocked.
 * <LI>*@firm.com - All personnel of this firm is blocked.
 * <LI>*.tv - No addresses from Tuvalu.
 * <LI>spam* - All addresses beginning with 'spam' are blocked.
 * <LI>martin@* - All Martins are blocked.
 * </ul>
 * Note: The usage of the blacklist requires the api user right: <i>Inx_Api_UserRights::BLACKLIST_FEATURE_USE</i>
 * <p>
 * For an example on how to use the blacklist, see the <i>Inx_Api_Blacklist_BlacklistManager</i> documentation.
 * 
 * @see Inx_Api_Blacklist_BlacklistManager
 * @since API 1.1.0
 * @version $Revision: 9482 $ $Date: 2007-12-18 16:42:11 +0200 (An, 18 Grd 2007) $ $Author: vladas $
 * @package Inxmail
 * @subpackage Blacklist
 */
interface Inx_Api_Blacklist_BlacklistEntry extends Inx_Api_BusinessObject
{
	
    /**
     * Constant of pattern attribute. Used to indicate a change of this attribute and to define the order in which
	 * <i>Inx_Api_Blacklist_BlacklistEntry</i> objects are fetched.
	 * 
	 * @see Inx_Api_Blacklist_BlacklistManager::selectAll(int, int)
     */
    const ATTRIBUTE_PATTERN = 0;
    
    /**
     * Constant of descriptionn attribute. Used to indicate a change of this attribute and to define the order in which
	 * <i>Inx_Api_Blacklist_BlacklistEntry</i> objects are fetched.
	 * 
	 * @see Inx_Api_Blacklist_BlacklistManager::selectAll(int, int)
     */
    const ATTRIBUTE_DESCRIPTION = 1;
    
    /**
     * Constant of hit count attribute. Used to indicate a change of this attribute and to define the order in which
	 * <i>Inx_Api_Blacklist_BlacklistEntry</i> objects are fetched.
	 * 
	 * @see Inx_Api_Blacklist_BlacklistManager::selectAll(int, int)
     */
    const ATTRIBUTE_HIT_COUNT = 2;

	
	/**
	 * Returns the email address pattern.
	 *
	 * @return string the email address pattern
	 */
	public function getPattern();

	
	/**
	 * Changes the email address pattern.
	 * A few examples:
	 * <ul>
	 * <LI>name@firm.com - The address 'name@firm.com' is blocked.
 	 * <LI>*@firm.com - All personnel of this firm is blocked.
 	 * <LI>*.tv - No addresses from Tuvalu.
 	 * <LI>spam* - All addresses beginning with 'spam' are blocked.
 	 * <LI>martin@* - All Martins are blocked.
	 * </ul>
	 * 
	 * @param string $sPattern	the new email address pattern
	 */
	public function updatePattern( $sPattern );
	

	/**
	 * Returns the entry description.
	 * 
	 * @return string the entry description.
	 */
	public function getDescription();

	
	/**
	 * Changes the entry description.
	 * 
	 * @param string $sDescription	the new entry description.
	 */
	public function updateDescription( $sDescription );
	
	
	/**
	 * Returns the number of addresses which were blocked by this entry.
	 * 
	 * @return int the number of addresses which were blocked by this entry.
	 */
	public function getHitCount();
	
}
