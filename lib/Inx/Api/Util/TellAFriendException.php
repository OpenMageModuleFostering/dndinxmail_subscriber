<?php
		
/**
 * @package Inxmail
 * @subpackage Util
 */
/**
 * Thrown by <i>Inx_Api_Util_Utilities::tellAFriend(Inx_Api_List_ListContext $oListContext, $iMailingId, $iRecipientId,
 * $blTakeProfile, $sEmail, $sTextIntro, $sHtmlIntro)</i> to indicate that the mail could not be forwarded. 
 * For further insight on the error, inspect the error code. The following error codes may occur:
 * <p>
 * <ul>
 * <li><i>TELLAFRIEND_MAILBUILD_ERROR</i>: The mailing could not be built.
 * <li><i>TELLAFRIEND_MAILSEND_ERROR</i>: The mail could not be sent.
 * <li><i>TELLAFRIEND_ORIGINAL_RECIPIENT_ERROR</i>: The original recipient could not be found.
 * <li><i>TELLAFRIEND_TARGET_RECIPIENT_ERROR</i>: The target recipient address is invalid.
 * <li><i>TELLAFRIEND_TASK_ERROR</i>: The task (mail) could not be found.
 * </ul>
 * 
 * @see Inx_Api_Util_Utilities::tellAFriend(Inx_Api_List_ListContext $oListContext, $iMailingId, $iRecipientId,
 * $blTakeProfile, $sEmail, $sTextIntro, $sHtmlIntro)
 * @since API 1.1.0
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 * @subpackage Util
 */
class Inx_Api_Util_TellAFriendException extends Exception
{

	/** 
	 * Error constant stating that the mail could not be built anymore. 
	 * This is probably permanent. 
	 */
	const TELLAFRIEND_MAILBUILD_ERROR 	= -200;
	
	/** 
	 * Error constant stating that the mail could not be sent. 
	 * This is most likely a runtime error, might succeed later. 
	 */
	const TELLAFRIEND_MAILSEND_ERROR 	= -201;
	
	/** 
	 * Error constant stating that the original recipient could not be found. 
	 */
	const TELLAFRIEND_ORIGINAL_RECIPIENT_ERROR = -202;
	
	/** 
	 * Error constant stating that the target recipient could not be determined. 
	 * This is most likely caused by an illegal email address, which is not conform to the RFC standard. 
	 */
	const TELLAFRIEND_TARGET_RECIPIENT_ERROR = -203;
	
	/** 
	 * Error constant stating that the task (mail) could not be found. 
	 */
	const TELLAFRIEND_TASK_ERROR = -204;
	
}
