<?php
/**
 * @package Inxmail
 */
/**
 * An <i>Inx_Api_LockException</i> is thrown if a lockable object (e.g. Mailing) is already locked.
 *
 * @see	    Inx_Api_Mailing_Mailing#lock()
 * @since   API 1.0
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 */
class Inx_Api_LockException extends Exception
{

	private $_oLockTicket;
	
	
	/**
	 * Constructs a <i>Inx_Api_LockException</i> with the specified detail message and
	 * specific details from lock owner.
	 * 
	 * @param string 			 $sMsg the detail message.
	 * @param Inx_Api_LockTicket $oLockTicket the ticket of lock information.
	 */
	public function __construct( $sMsg, Inx_Api_LockTicket $oLockTicket )
	{
	    $this->_oLockTicket = $oLockTicket;
	    parent::__construct($sMsg);
	}
	
	
	/**
	 * Returns the lock ticket. The lock ticket contains specific details from the lock owner.
	 * 
	 * @return Inx_Api_LockTicket the lock ticket.
	 */
	public function getLockTicket()
    {
        return $this->_oLockTicket;
    }
	
}
