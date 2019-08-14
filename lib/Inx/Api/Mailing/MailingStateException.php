<?php
/**
 * @package Inxmail
 * @subpackage Mailing
 */

/**
 * An <i>Inx_Api_Mailing_MailingStateException</i> is thrown when a mailing action is invoked which is not allowed 
 * to be performed in the current state. 
 * For example, invoking <i>Inx_Api_Mailing_Mailing::startSending()</i> is not allowed if the mailing is in the
 * state <i>Inx_Api_Mailing_Mailing::STATE_TO_BE_APPROVE</i>, thus raising a <i>MailingStateException</i>.
 * 
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 * @subpackage Mailing
 */
class Inx_Api_Mailing_MailingStateException extends Exception
{
    /**
     * <i>true</i> if the mailing is locked, <i>false</i> otherwise.
     *
     * @var boolean
     */
    private $_blLocked;
    
    /**
     * Creates a <code>MailingStateException</code> with the given detail message, current state and locking state.
     *
     * @param string $sMsg the detail message.
     * @param int $iCurrentState the current state of the affected mailing.
     * @param bool $blLocked <code>true</code> if the mailing is locked, <code>false</code> otherwise.
     */
    public function __construct( $sMsg = null, $iCurrentState = null, $blLocked = null )
    {
        parent::__construct( $sMsg, $iCurrentState );
        
        $this->_blLocked = $blLocked;
    }
    
    
    /**
     * Returns the current state of the affected mailing. 
     * Alias for <i>Inx_Api_Mailing_MailingStateException::getCode()</i>
     *
     * @return int the current state.
     */
    public function getCurrentState()
    {
        return $this->getCode();
    }
    
    /**
     * Checks if the mailing is locked.
     * 
     * @return bool <i>true</i> if the mailing is locked, <i>false</i> otherwise.
     */
    public function isLocked()
    {
        return $this->blLocked;
    }
}
