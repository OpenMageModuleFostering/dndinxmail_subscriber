<?php
/**
 * MailingImpl
 *
 * @version $Revision: 7335 $ $Date: 2007-09-10 14:58:22 +0200 (Mo, 10 Sep 2007) $ $Author: sbn $
 */
class Inx_Apiimpl_Mailing_SendingInfoImpl implements Inx_Api_Mailing_SendingInfo
{
	
	private $notSentMails;
	private $notDeliveredMails;
	private $deliveredMails;
	private $averageMailSize;
	private $bouncedMails;
	
	public function __construct($averageMailSize, $deliveredMails, $notDeliveredMails, $notSentMails, $bouncedMails )
	{
		$this->averageMailSize = $averageMailSize;
		$this->deliveredMails = $deliveredMails;
		$this->notDeliveredMails = $notDeliveredMails;
		$this->notSentMails = $notSentMails;
		$this->bouncedMails = $bouncedMails;
	}
	 
	 
	 /**
	 * Returns the number of mailings which are successful delivered by Inxmail
	 * 
	 * @return the mailing number as int
	 */
	public function getDeliveredMailsCount()
	{
		return $this->deliveredMails;
	}


	/**
	 * Returns the number of mailings which are produce an error while sending
	 * 
	 * @return the mailing number as int
	 */
	public function getSentErrorCount()
	{
		return $this->notDeliveredMails;
	}

	public function getBounceCount()
	{
		return $this->bouncedMails;
	}

	/**
	 * Returns the number of mailings which are not send by Inxmail, for example existing no-mail tag
	 * 
	 * @return the mailing number as int
	 */
	public function getNotSentMailsCount()
	{
		return $this->notSentMails;
	}


	/**
	 * Returns the average mailing size for this sended mailing.
	 * 
	 * @return the average mailing size in byte
	 */
	public function getAverageMailSize()
	{
		return $this->averageMailSize;
	}
	 
}
?>
