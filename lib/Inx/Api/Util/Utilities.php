<?php

/**
 * @package Inxmail
 * @subpackage Util
 */
/**
 * The <i>Inx_Api_Util_Utilities</i> class provides utility methods that can be used for special activities. 
 *
 * @since   API 1.1.0
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 * @subpackage Util
 */
interface Inx_Api_Util_Utilities
{
	/**
	 * Forwards a mailing to someone different from the original recipient. 
	 * The mailing may be personalized for the original recipient, and introductory information (e.g. who 
	 * forwarded the mail, and who to subscribe) may be added.
	 * 
	 * @param Inx_Api_List_ListContext $oListContext the list to which the mail was sent.
	 * @param int $iMailingId the mailing to forward.
	 * @param int $iRecipientId the original recipient.
	 * @param bool $blTakeProfile <code>true</code> if the mailing shall be personalized for the original recipient,
	 *            <code>false</code> otherwise.
	 * @param string $sEmail the address of the recipient to whom the mail shall be forwarded.
	 * @param string $sTextIntro introductory text, plain text format.
	 * @param string $sHtmlIntro introductory text, HTML format.
	 * @throws Inx_Api_Util_TellAFriendException if the mail could not be forwarded.
	 * @since API 1.1.0
	 */
	public function tellAFriend( Inx_Api_List_ListContext $oListContext, $iMailingId, $iRecipientId,
			$blTakeProfile, $sEmail, $sTextIntro, $sHtmlIntro );
			
	/**
	 * Checks whether the given test recipient id exists.
	 * 
	 * @param int $iIdToCheck the test recipient id to check.
	 * @return bool <i>true</i> if the given test recipient id exists, <i>false</i> otherwise.
	 * @since API 1.6.0
	 */
	public function existsTestRecipient( $iIdToCheck );
}
