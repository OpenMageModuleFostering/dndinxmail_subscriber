<?php
/**
 * MailingRendererImpl
 * 
 * @version $Revision: 19494 $ $Date: 2010-12-14 10:11:12 +0100 (Di, 14 Dez 2010) $ $Author: sbn $
 */
class Inx_Apiimpl_TriggerMailing_TriggerMailingRendererImpl 
        implements Inx_Api_TriggerMail_TriggerMailingRenderer
{
	protected $sc;

	protected $remoteRef;

	protected $service;

	protected $state;


	public function __construct(Inx_Apiimpl_SessionContext $sc )
	{
		$this->sc = $sc;
		$this->service = $this->sc->getService( Inx_Apiimpl_SessionContext::TRIGGER_MAILING_SERVICE );
                $this->state = TriggerMailingRendererState::NOT_INITIALIZED();
	}


	public function parse( $iMailingId, Inx_Api_TriggerMail_BuildMode $buildMode, $iSendingId = null )
	{
		try
		{
			$this->state = TriggerMailingRendererState::NOT_INITIALIZED();

			if( $buildMode != Inx_Api_TriggerMail_BuildMode::NORMAL()
                                && $buildMode != Inx_Api_TriggerMail_BuildMode::PREVIEW()
                                && $buildMode != Inx_Api_TriggerMail_BuildMode::ALTERNATIVEVIEW_ACTIVE()
                                && $buildMode != Inx_Api_TriggerMail_BuildMode::ALTERNATIVEVIEW_INACTIVE()
                                && $buildMode != Inx_Api_TriggerMail_BuildMode::ARCHIVE()
                                && $buildMode != Inx_Api_TriggerMail_BuildMode::ALTERNATIVEVIEW_ACTIVE_SIMPLE_LINKS()
                                && $buildMode != Inx_Api_TriggerMail_BuildMode::NEWSLETTER_SIMPLE_LINKS() )
			{
				throw new Inx_Api_IllegalArgumentException( "illegal buildMode: " . $buildMode );
			}
			else
			{
				$result = null;
                                
                                if(null === $iSendingId)
                                {
                                    $result = $this->service->parseMail( $this->sc->createCxt(), $iMailingId, $buildMode->getId() );
                                }
                                else
                                {
                                    $result = $this->service->parseMailWithSendingId( $this->sc->createCxt(), $iMailingId, 
                                             $buildMode->getId(), $iSendingId );
                                }
                                
				$this->remoteRef = $this->sc->createRemoteRef( $result->remoteRefId );

				$resultCode = Inx_Api_TriggerMail_ParseResultCode::byId( $result->resultType );

				switch( $resultCode )
				{
					case Inx_Api_TriggerMail_ParseResultCode::PARSE_SUCCESSFUL():
						$this->state = TriggerMailingRendererState::PARSED();
						return;

					case Inx_Api_TriggerMail_ParseResultCode::PARSE_EXCEPTION():
						$this->state = TriggerMailingRendererState::PARSE_FAILED();
						throw new Inx_Api_TriggerMail_ParseException( 
                                                        $this->createMailErrors( $result->errors ) );

					case Inx_Api_TriggerMail_ParseResultCode::MAILING_NOT_FOUND():
						throw new Inx_Api_APIException( "mailing not found: " . $iMailingId );

					default:
						throw new Inx_Api_IllegalArgumentException( "illegal buildMode: " . $buildMode );
				}
			}
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->sc->notify( $x );
		}
	}


	public function build( $iRecipientId, Inx_Api_TriggerMail_TriggerMailingContentType $preferredMailType = null )
	{
                if(null === $preferredMailType)
                {
                    $preferredMailType = Inx_Api_TriggerMail_TriggerMailingContentType::SYSTEM();
                }
            
		try
		{
			if( $this->state !== TriggerMailingRendererState::PARSED() )
				throw new Inx_Api_IllegalStateException( "the parsing must be successful" );
                        
                        if( $preferredMailType === Inx_Api_TriggerMail_TriggerMailingContentType::UNKNOWN())
                                throw new Inx_Api_IllegalArgumentException( 'the UNKNOWN content type is illegal' );

			$result = $this->service->buildMail( $this->remoteRef->createCxt(), $this->remoteRef->refId(), 
                                $iRecipientId, $preferredMailType->getId() );

			$resultCode = Inx_Api_TriggerMail_BuildResultCode::byId( $result->resultType );

			if( $resultCode === Inx_Api_TriggerMail_BuildResultCode::BUILD_EXCEPTION() )
			{
				throw new Inx_Api_TriggerMail_BuildException( $result->errorEmail, 
                                        $this->createMailError( $result->errors ) );
			}
			else
			{
				return new Inx_Apiimpl_TriggerMailing_TriggerMailContentImpl( 
                                        $this->remoteRef, $result );
			}
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->sc->notify( $x );
			return null;
		}
	}


	public function close()
	{
		if( null === $this->remoteRef )
			return;

		$this->remoteRef->release( false );
	}


	protected function createMailError( stdClass $data )
	{
		return new Inx_Api_TriggerMail_RenderError( $data->errorType, $data->mailPart, $data->beginLine, 
                        $data->endLine, $data->beginColumn, $data->endColumn, Inx_Apiimpl_TConvert::TArrToArr( $data->msgArgs ) );
	}


	protected function createMailErrors( array $datas )
	{
		$es = array();
                
		for( $i = 0; $i < sizeof($es); $i++ )
                {
                    $es[$i] = $this->createMailError( $datas[$i] );
                }
                
		return $es;
	}
}

final class TriggerMailingRendererState
{
        private static $NOT_INITIALIZED = null;
        
        private static $PARSE_FAILED = null;
        
        private static $PARSED = null;
    
        public static final function NOT_INITIALIZED()
        {
            if(null === self::$NOT_INITIALIZED)
                self::$NOT_INITIALIZED = new TriggerMailingRendererState();
            
            return self::$NOT_INITIALIZED;
        }

        public static final function PARSE_FAILED()
        {
            if(null === self::$PARSE_FAILED)
                self::$PARSE_FAILED = new TriggerMailingRendererState();
            
            return self::$PARSE_FAILED;
        }

        public static final function PARSED()
        {
            if(null === self::$PARSED)
                self::$PARSED = new TriggerMailingRendererState();
            
            return self::$PARSED;
        }
        
        private function __construct()
        {
            
        }
}