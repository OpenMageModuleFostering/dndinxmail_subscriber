<?php
/**
 * @package Inxmail
 * @subpackage TriggerMailing
 */

/**
 * An <i>Inx_Api_TriggerMailing_StateFilter</i> is used to retrieve trigger mailings according to their state. 
 * The <i>StateFilter</i> combines two different state types:
 * <ul>
 * <li><b>The mailing state:</b> Used to retrieve mailings in one or more states.
 * <li><b>The trigger state:</b> Used to retrieve mailings whose trigger is in a particular state.
 * </ul>
 * Neither type is mandatory to be set. It is possible to create a <i>StateFilter</i> that matches all mailing
 * states and/or all trigger states. Omitting both states will result in an all matching <i>StateFilter</i>. This
 * special filter is used to retrieve all trigger mailings of a specific list, disregarding their state, and can be
 * obtained using the <i>TriggerMailingManager::createAllMatchingStateFilter()</i> method which will return a singleton.
 * <p>
 * For an example on how to use <i>StateFilter</i>s, see the <i>TriggerMailingManager</i> documentation.
 *
 * @see Inx_Api_TriggerMailing_TriggerMailingManager::selectByState( Inx_Api_List_ListContext $listContext, 
 *      Inx_Api_TriggerMailing_StateFilter $stateFilter, Inx_Api_TriggerMailing_TriggerMailingAttribute $orderAttribute = null, 
 *      $iOrderType = null, $sFilter = null )
 * @see Inx_Api_TriggerMailing_TriggerMailingManager::createStateFilter( array $mailingStateFilter = null, 
        Inx_Api_TriggerMailing_TriggerState $triggerStateFilter = null )
 * @see Inx_Api_TriggerMailing_TriggerMailingState
 * @see Inx_Api_TriggerMailing_TriggerState
 * @since API 1.10.0
 * @author chge, 16.07.2012
 */
interface Inx_Api_TriggerMailing_StateFilter
{
	/**
	 * Returns the <i>Inx_Api_TriggerMailing_TriggerMailingState</i>s this <i>StateFilter</i> matches. May be <i>null</i>,
	 * indicating that this <i>StateFilter</i> matches any <i>TriggerMailingState</i>.
	 *
	 * @return array the <i>TriggerMailingState</i>s this <i>StateFilter</i> matches, or <i>null</i> if it
	 *         matches any <i>TriggerMailingState</i>.
	 */
	public function getMailingStateFilter();


	/**
	 * Returns the <i>Inx_Api_TriggerMailing_TriggerState</i> this <i>StateFilter</i> matches. May be <i>nullitt>, 
         * indicating that this <i>StateFilter</i> matches any <i>TriggerState</i>.
	 *
	 * @return Inx_Api_TriggerMailing_TriggerState the <i>TriggerState</i> this <i>StateFilter</i> matches, or <i>null</i> 
         *      if it matches any <i>TriggerState</i>.
	 */
	public function getTriggerStateFilter();


	/**
	 * Returns a <i>bool</i> indicating whether this <i>StateFilter</i> matches any mailing and trigger
	 * state. If it does, it is equivalent to the all matching <i>StateFilter</i> provided by
	 * <i>Inx_Api_TriggerMailing_TriggerMailingManager::createAllMatchingStateFilter()</i>.
	 *
	 * @return bool <i>true</i> if this <i>StateFilter</i> matches any state, <i>false</i> otherwise.
	 */
	public function matchesAllStates();


	/**
	 * Returns a <i>bool</i> indicating whether this <i>StateFilter</i> matches any <i>TriggerMailingState</i>.
	 *
	 * @return bool <i>true</i> if this <i>StateFilter</i> matches any <i>TriggerMailingState</i> state,
	 *         <i>false</i> otherwise.
	 */
	public function matchesAllMailingStates();


	/**
	 * Returns a <i>bool</i> indicating whether this <i>StateFilter</i> matches any <i>TriggerState</i>.
	 *
	 * @return bool <i>true</i> if this <i>StateFilter</i> matches any <i>TriggerState</i> state,
	 *         <i>false</i> otherwise.
	 */
	public function matchesAllTriggerStates();
}
