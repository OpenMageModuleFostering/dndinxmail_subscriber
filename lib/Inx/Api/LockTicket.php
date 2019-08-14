<?php
/**
 * @package Inxmail
 */
/**
 * An <i>Inx_Api_LockTicket</i> contains specific informations about a lock of an object (e.g. Mailing).
 * <p>
 * The information provided includes:
 * <ul>
 * <li>The id of the user who holds the lock
 * <li>The name of the user who holds the lock
 * <li>The internet address of the lock owner
 * <li>The creation date of the lock
 * <li>Whether the object is locked by this session
 * </ul>
 *
 * @see	    Inx_Api_Mailing_Mailing#getLockTicket()
 * @since   API 1.0
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 */
class Inx_Api_LockTicket
{

	private $_iUserId;
	
	private $_sUserName;
	
	private $_sSource;

	private $_sCreationDatetime;

	private $_blForeignLock;
    
	
	/**
	 * Constructs a <i>Inx_Api_LockTicket</i> with the specified details of the lock owner.
	 * 
	 * @param integer	$iUserId	the user id from of the lock owner.
	 * @param string	$sUserName	the user name of the lock owner.
	 * @param string	$sSource	the internet address of the lock owner.
	 * @param string	$sCreationDatetime	the creation date of the existing lock.
	 * @param boolean	$blForeignLock	true if locked by another session, false if locked by this session.
	 */
	public function __construct( $iUserId, $sUserName, $sSource, $sCreationDatetime,
	        $blForeignLock )
	{
	    $this->_iUserId = $iUserId;
	    $this->_sUserName = $sUserName;
	    $this->_sSource = $sSource;
	    $this->_sCreationDatetime = $sCreationDatetime;
	    $this->_blForeignLock = $blForeignLock;
	}
	
	
	/**
	 * Returns the creation date of the existing lock as ISO 8601 formatted date string.
	 * 
	 * @return string the creation date of the existing lock.
	 */
	public function getCreationDatetime()
    {
        return $this->_sCreationDatetime;
    }
    
    /**
     * Returns the internet address of the lock owner.
     * 
     * @return string the internet address of the lock owner.
     */
    public function getSource()
    {
        return $this->_sSource;
    }
    
    /**
     * Returns the user id of the lock owner.
     * 
     * @return string the user id of the lock owner.
     */
    public function getUserId()
    {
        return $this->_sUserId;
    }
    
    /**
     * Returns the user name of the lock owner.
     * 
     * @return string the user name of the lock owner.
     */
    public function getUserName()
    {
        return $this->_sUserName;
    }
   
    /**
     * Checks if the object is locked by this session.
     * 
     * @return boolean true if locked by another session, false if locked by this session.
     */
    public function isForeignLock()
    {
        return $this->_blForeignLock;
    }
}
