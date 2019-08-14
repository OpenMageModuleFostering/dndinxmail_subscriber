<?php
/**
 * @package Inxmail
 */
/**
 * Agents, like "Mailing", "Subscription" or "Resource" are called "Features"
 * in the API language. Which features are available can be obtained
 * from the <i>Inx_Api_Features</i> interface.
 *
 * Features are enabled and disabled from the Inx_Api_List_ListContext, as following example
 * demonstrates, which enables the "Subscription" agent in the choosen mailing list:
 *
 * <PRE>
 * $oListContext = $oListManager->findByName( $sListName );
 * $oListContext->enableFeature( Inx_Api_Features::SUBSCRIPTION_FEATURE_ID );
 * </PRE>
 * 
 *
 * Not every feature is accessible for every type of list. For example, subscription
 * feature is available in standard lists, only. The mailing feature can be used in
 * standard and filter lists.
 *
 * @see	    Inx_Api_List_ListContext#isFeatureEnabled(int)
 * @see	    Inx_Api_List_ListContext#enableFeature(int)
 * @see	    Inx_Api_List_ListContext#disableFeature(int)
 * @since   API 1.0
 * @version $Revision: 9553 $ $Date: 2008-01-04 11:28:41 +0200 (Pn, 04 Sau 2008) $ $Author: vladas $
 * @package Inxmail
 */
interface Inx_Api_Features
{

	/**
	 * The subscription feature is available in:
	 * <ul>
     * <li> standard lists </li>
     * </ul>
	 * @since   API 1.0 
	 */
	const SUBSCRIPTION_FEATURE_ID = 10000;

	/**
	 * The mailing feature is available in:
	 * <ul>
     * <li> standard lists
     * <li> and filter lists
     * </ul>
     * @since   API 1.0
	 */
	const MAILING_FEATURE_ID = 10001;

	/**
	 * The resource feature is available in:
	 * <ul>
     * <li> system list
     * </ul>
     * @since   API 1.0
	 */
	const RESOURCE_FEATURE_ID = 10002;

	/**
	 * The blacklist feature is available in:
	 * <ul>
     * <li> system list
     * </ul>
     * @since   API 1.1.0
	 */
	const BLACKLIST_FEATURE_ID = 10003;
	
	/**
	 * The filter feature is available in:
	 * <ul>
     * <li> system list
     * </ul>
     * @since   API 1.1.0
	 */
	const FILTER_FEATURE_ID = 10004;

	/**
	 * The report feature is available in:
	 * <ul>
	 * <li> standard lists
     * <li> filter lists
     * <li> and system list
     * </ul>
     * @since   API 1.1.0
	 */
	const REPORT_FEATURE_ID = 10005;

	/**
	 * The action feature is available in:
	 * <ul>
     * <li> system list
     * </ul>
     * 
     * @since   API 1.1.2
	 */
	const ACTION_FEATURE_ID = 10006;

	/**
	 * The textmodule, mailing template and design template feature is available in:
	 * <ul>
	 * <li> standard lists
     * <li> filter lists
     * <li> and system list
     * </ul>
     * 
     * @since   API 1.4.0
	 */
	const TEXTMODULE_FEATURE_ID = 10007;
	
	
		/**
	 * The testprofiles feature is available in:
	 * <ul>
	 * <li> standard lists
     * <li> filter lists
     * <li> and system list
     * </ul>
     * 
     * @since   API 1.6.0
	 */
	const TESTPROFILES_FEATURE_ID = 10008;
	
		/**
	 * The template feature is available in:
	 * <ul>
	 * <li>standard lists
	 * <li>filter lists
	 * <li>and system list
	 * 
	 * @since API 1.7.0
	 */
	const TEMPLATE_FEATURE_ID = 10009;
	
}
