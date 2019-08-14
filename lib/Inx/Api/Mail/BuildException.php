<?php
/**
 * @package Inxmail
 * @subpackage Mail
 */
/**
 * An <i>Inx_Api_Mail_BuildException</i> is thrown when the building of a mailing fails. 
 * This may be due to an illegal recipient address or a general building failure. 
 * For a deeper insight on the error, consult the <i>Inx_Api_Mail_RenderError</i> associated with the exception.
 * 
 * @see Inx_Api_Mail_RenderError
 * @see Inx_Api_Mail_MailingRenderer::build($iRecipientId, $iPreferredMailType=null)
 * @version $Revision: 9479 $ $Date: 2007-12-18 15:43:23 +0200 (An, 18 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 * @subpackage Mail
 */
class Inx_Api_Mail_BuildException extends Exception
{
	/**
	 * The email address of the recipient for which the mailing was built.
	 * @var string
	 */
    protected $sEmailAddress;
    
    /**
     * Contains detail information about the error.
     * @var Inx_Api_Mail_RenderError
     */
    protected $oError;
    
    /**
     * Creates an <i>Inx_Api_Mail_BuildException</i> with the given recipient address and render error.
     * 
     * @param string $sEmailAddress the email address of the recipient for which the mailing was built.
     * @param Inx_Api_Mail_RenderError $oError contains detail information about the error.
     */
    public function __construct( $sEmailAddress, $oError )
    {
        $this->sEmailAddress = $sEmailAddress;
        $this->oError = $oError;
    }
    
    /**
     * Returns detail information about the error.
     * 
     * @return Inx_Api_Mail_RenderError detail information about the error.
     */
    public function getError()
    {
        return $this->oError;
    }
    
    /**
     * Returns the email address of the recipient for which the mailing was built.
	 * 
	 * @return string the recipients email address.
     */
    public function getEmailAddress()
    {
        return $this->sEmailAddress;
    }
    
}
