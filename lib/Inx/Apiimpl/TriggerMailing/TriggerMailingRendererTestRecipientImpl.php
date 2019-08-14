<?php
class Inx_Apiimpl_TriggerMailing_TriggerMailingRendererTestRecipientImpl 
        extends Inx_Apiimpl_TriggerMailing_TriggerMailingRendererImpl
{
	public function __construct( Inx_Apiimpl_SessionContext $sc )
	{
		parent::__construct( $sc );
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
                        
			$result = $this->service->buildMailForTestRecipient( $this->remoteRef->createCxt(), 
                                $this->remoteRef->refId(), $iRecipientId, $preferredMailType->getId() );

			$resultCode = Inx_Api_TriggerMail_BuildResultCode::byId( $result->resultType );

			if( $resultCode === Inx_Api_TriggerMail_BuildResultCode::BUILD_EXCEPTION() )
			{
				throw new Inx_Api_TriggerMail_BuildException( $result->errorEmail, 
                                        $this->createMailError( $result->errors ) );
			}
			else
			{
				return new Inx_Apiimpl_TriggerMailing_TriggerMailContentImpl( $this->remoteRef, $result );
			}
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->sc->notify( $x );
			return null;
		}
	}
}
