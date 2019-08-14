<?php


/**
 * MailingRendererImpl
 * 
 * @version $Revision: 6324 $ $Date: 2007-05-16 11:28:15 +0000 (Mi, 16 Mai 2007) $ $Author: sbn $
 */
class Inx_Apiimpl_Mailing_MailingRendererTestRecipientImpl extends Inx_Apiimpl_Mailing_MailingRendererImpl
{


    
    public function __construct( Inx_Apiimpl_SessionContext $oSc )
    {
    	parent::__construct( $oSc );
    }
    
   
    
    /**
     * Enter description here...
     *
     * @param int $iRecipientId
     * @param int $iPreferredMailType
     * @return Inx_Api_Mail_MailContent
     * @throws Inx_Api_Mail_BuildException
     */
    public function build( $iRecipientId, $iPreferredMailType = Inx_Api_Mailing_MailingConstants::MAIL_TYPE_SYSTEM )
    {
        if (!is_int($iRecipientId)) {
	        throw new Inx_Api_IllegalArgumentException('Integer parameter $iRecipientId expected, got '.gettype($iRecipientId));
	    }
        if (!is_int($iPreferredMailType)) {
	        throw new Inx_Api_IllegalArgumentException('Integer parameter $iPreferredMailType expected, got '.gettype($iPreferredMailType));
	    }
        try
        {
            if( $this->_iState != self::PARSED_STATE )
                throw new Inx_Api_IllegalStateException( "the parsing must be successful" );
            
            $oResult = $this->_oService->buildMailForTestRecipient( $this->_oRemoteRef->createCxt(),
                    $this->_oRemoteRef->refId(), $iRecipientId, $iPreferredMailType );
	        
	        if( $oResult->resultType == Inx_Api_Mailing_MailingConstants::BUILD_EXCEPTION )
	        {
	            throw new Inx_Api_Mail_BuildException( $oResult->errorEmail, $this->createMailError( $oResult->errors ) );
	        }
	        else
	            return new Inx_Apiimpl_Mailing_MailContentImpl( $this->_oRemoteRef, $oResult );
	    }
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSc->notify( $e );
			return null;
		}
    }

}
