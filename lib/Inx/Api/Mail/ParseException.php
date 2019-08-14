<?php
/**
 * @package Inxmail
 * @subpackage Mail
 */
/**
 * An <i>Inx_Api_Mail_ParseException</i> is thrown when the parsing of a mailing fails. 
 * The reason for such a failure usually is a syntax error. 
 * For a deeper insight on the error, consult the {@link RenderError}s associated with the exception.
 * 
 * @see Inx_Api_Mail_RenderError
 * @see Inx_Api_Mail_MailingRenderer::parse( $iRecipientId, $iPreferredMailType=null )
 * @version $Revision: 9479 $ $Date: 2007-12-18 15:43:23 +0200 (An, 18 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 * @subpackage Mail
 */
class Inx_Api_Mail_ParseException extends Exception
{
    /**
     * Contains detail information about the error.
     * @var array() of Inx_Api_Mail_RenderError objects
     */
    protected $aErrors = array();
    
    
    /**
    * Creates an <i>Inx_Api_Mail_ParseException</i> with the given render errors.
    *
    * @param array $aErrors the render errors which occurred during the parsing.
    */
    public function __construct( $aErrors )
    {
        $this->aErrors = $aErrors;
    }
    
    /**
    * Returns detail information about the error by returning the render error with the given index.
    *
    * @param int $iIndex the index of the render error to be returned.
    * @return Inx_Api_Mail_RenderError the render error with the given index.
    */
    public function getError( $iIndex )
    {
        return $this->aErrors[$iIndex];
    }
    
    /**
    * Returns the number of render errors associated with this <i>Inx_Api_Mail_ParseException</i>.
    *
    * @return int the number of render errors.
    */
    public function getErrorCount()
    {
        return count($this->aErrors);
    }
    
}
