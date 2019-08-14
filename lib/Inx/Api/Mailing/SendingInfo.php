<?php
/**
 * @package Inxmail
 * @subpackage Mail
 */

/**
 * An <i>Inx_Api_Mailng_SendingInfo</i> object contains additional information regarding the sending of a mailing. 
 * For example, the average mail size or the number of delivered mails.
 * 
 * @since API 1.4.3
 * @version $Revision: 9482 $ $Date: 2007-12-18 16:42:11 +0200 (An, 18 Grd 2007) $ $Author: vladas $
 * @package Inxmail
 * @subpackage Mail
 */
interface Inx_Api_Mailing_SendingInfo
{
	
	/**
	 * Returns the number of mailings which were successfully delivered by Inxmail.
	 * 
	 * @return int the number of mailings which were successfully delivered by Inxmail.
	 */
	public function getDeliveredMailsCount();


	/**
	 * Returns the number of mailings which encountered an error while sending.
	 * 
	 * @return int the number of mailings which encountered an error while sending.
	 */
	public function getSentErrorCount();
	
	/**
	 * Returns the number of mailings for which bounce messages were received.
	 * 
	 * @return int the number of mailings for which bounce messages were received.
	 */
	public function getBounceCount();	

	/**
	 * Returns the number of mailings which have not been sent by Inxmail, for example because of an existing no-mail tag.
	 * 
	 * @return int the number of mailings which have not been sent by Inxmail.
	 */
	public function getNotSentMailsCount();


	/**
	 * Returns the average mailing size for the sent mailing.
	 * 
	 * @return int the average mailing size for the sent mailing.
	 */
	public function getAverageMailSize();
}
?>
