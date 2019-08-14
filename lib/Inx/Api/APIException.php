<?php
/**
 * @package Inxmail
 */
/**
 * <i>Inx_Api_APIException</i> is the runtime exception that can be thrown during the normal operation of the API. 
 * 
 * @version $Revision: 9482 $ $Date: 2007-12-18 16:42:11 +0200 (An, 18 Grd 2007) $ $Author: vladas $
 * @package Inxmail
 */
class Inx_Api_APIException extends Exception
{
    /**
     * @var Exception the original exception that was thrown.
     */
    public $oCause = null;
    
    /**
     * Constructs a new api runtime exception with the specified detail message.
     * 
     * @param string $sMsg the detail message (which is saved for later retrieval by the {@link #getMessage()} method).
     * @param Exception $oCause the cause (which is saved for later retrieval by the {@link #getCause()} method). (A <tt>null</tt>
	 *            value is permitted, and indicates that the cause is nonexistent or unknown.)
     */
    function __construct($sMsg, Exception $oCause = null) {
        parent::__construct($sMsg);
        $this->oCause = $oCause;
    }
    
    /**
     * Returns the original exception.
     * 
     * @return Exception the original exception.
     */
    public function getCause() 
    {
        return $this->oCause;
    }
    
}