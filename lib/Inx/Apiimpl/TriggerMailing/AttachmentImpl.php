<?php
/**
 * AttachmentImpl
 * 
 * @version $Revision: 19494 $ $Date: 2010-12-14 10:11:12 +0100 (Di, 14 Dez 2010) $ $Author: sbn $
 */
class Inx_Apiimpl_TriggerMailing_AttachmentImpl implements Inx_Api_TriggerMail_Attachment
{

	protected $rendererRef;

	protected $data;


	public function __construct( Inx_Apiimpl_RemoteRef $rendererRef, stdClass $data )
	{
		$this->rendererRef = $rendererRef;
		$this->data = $data;
	}


	public function getName()
	{
		return $this->data->name;
	}


	public function getContentType()
	{
		return $this->data->contentType;
	}


	public function getSize()
	{
		return $this->data->size;
	}


	public function getContent()
	{
                try
                {
                    $service = $this->rendererRef->getService( Inx_Apiimpl_SessionContext::TRIGGER_MAILING_SERVICE );
	        
                    $sRefId = $service->getInputStream( $this->rendererRef->createCxt(), 
                              $this->rendererRef->refId(), $this->data->streamId );
                    return new Inx_Apiimpl_Core_RemoteInputStream( $this->rendererRef->createRemoteRef( $sRefId ) );
                }
		catch( Inx_Api_RemoteException $e )
		{
		    $this->rendererRef->notify( $e );
		    return null;
		}
	}
}