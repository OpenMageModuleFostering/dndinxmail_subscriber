<?php


/**
 * MailingRendererImpl
 * 
 * @version $Revision: 6324 $ $Date: 2007-05-16 11:28:15 +0000 (Mi, 16 Mai 2007) $ $Author: sbn $
 */
class Inx_Apiimpl_Mailing_MailingRendererImpl implements Inx_Api_Mail_MailingRenderer
{

    const NOT_INITIALIZED_STATE = 0;

    const PARSE_FAILED_STATE = 1;

    const PARSED_STATE = 2;

    /**
     * @var Inx_Apiimpl_SessionContext
     */
    protected $_oSc;

    /**
     * @var Inx_Apiimpl_RemoteRef
     */
    protected $_oRemoteRef;

    protected $_oService;

    /**
     * @var int 
     */
    protected $_iState = self::NOT_INITIALIZED_STATE;

    
    public function __construct( Inx_Apiimpl_SessionContext $oSc )
    {
        $this->_oSc = $oSc;
        $this->_oService = $this->_oSc->getService( Inx_Apiimpl_SessionContext::MAILING6_SERVICE );
    }
    
    /**
     * Enter description here...
     *
     * @param int $iMailingId
     * @param int $iBuildMode
     * @throws Inx_Api_Mail_ParseException
     */
    public function parse( $iMailingId, $iBuildMode ) 
    {
        if (!is_int($iMailingId)) {
	        throw new Inx_Api_IllegalArgumentException('Integer parameter $iMailingId expected, got '.gettype($iMailingId));
	    }
        if (!is_int($iBuildMode)) {
	        throw new Inx_Api_IllegalArgumentException('Integer parameter $iBuildMode expected, got '.gettype($iBuildMode));
	    }
        try
        {
            $this->_iState = self::NOT_INITIALIZED_STATE;
            
            if( $iBuildMode != self::BUILD_MODE_NORMAL
                && $iBuildMode != self::BUILD_MODE_PREVIEW
                && $iBuildMode != self::BUILD_MODE_ALTERNATIVEVIEW_ACTIVE
                && $iBuildMode != self::BUILD_MODE_ALTERNATIVEVIEW_INACTIVE
                && $iBuildMode != self::BUILD_MODE_ARCHIVE)
                throw new Inx_Api_IllegalArgumentException( "illegal buildMode: " . $iBuildMode );
            
            $oResult = $this->_oService->parseMail( $this->_oSc->createCxt(), $iMailingId, $iBuildMode );
	        $this->_oRemoteRef = $this->_oSc->createRemoteRef( $oResult->remoteRefId );
	        
	        switch( $oResult->resultType )
	        {
	        	case Inx_Api_Mailing_MailingConstants::PARSE_SUCCESSFUL:
	        	    $this->_iState = self::PARSED_STATE;
	            	return;
	            case Inx_Api_Mailing_MailingConstants::PARSE_EXCEPTION:
	                $this->_iState = self::PARSE_FAILED_STATE;
	            	throw new Inx_Api_Mail_ParseException( $this->createMailErrors( $oResult->errors ) );
	            case Inx_Api_Mailing_MailingConstants::MAILING_NOT_FOUND:
	                throw new Inx_Api_APIException( "mailing not found: " . $iMailingId );
	            default:
	                throw new Inx_Api_IllegalArgumentException( "illegal buildMode: " . $iBuildMode );
	        }
	    }
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSc->notify( $e );
		}
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
            
            $oResult = $this->_oService->buildMail( $this->_oRemoteRef->createCxt(),
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

    
    public function close()
    {
        if( $this->_oRemoteRef == null )
            return;
        
        $this->_oRemoteRef->release( false );
    }
    
    /**
     * Enter description here...
     *
     * @param stdClass $oData RenderErrorData
     * @return Inx_Api_Mail_RenderError
     */
    protected function createMailError( stdClass $oData )
    {
        return new Inx_Api_Mail_RenderError( $oData->errorType, $oData->mailPart, $oData->beginLine,
                $oData->endLine, $oData->beginColumn, $oData->endColumn,
                Inx_Apiimpl_TConvert::TArrToArr( $oData->msgArgs ) );
    }
    
    /**
     * Enter description here...
     *
     * @param array $aDatas 
     * @return RenderError[]
     */
    protected function createMailErrors( $aDatas )
    {
    	$es = array();
    	
    	foreach ($aDatas as $i=>$oValue) {
    		$es[$i] = $this->createMailError($oValue);
    	}
    	
    	return $es;
    }
}
