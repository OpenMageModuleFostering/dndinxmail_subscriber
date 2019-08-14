<?php


/**
 * AttachmentImpl
 * 
 * @version $Revision: 5433 $ $Date: 2007-01-22 08:15:02 +0000 (Mo, 22 Jan 2007) $ $Author: bgn $
 */
class Inx_Apiimpl_Mailing_AttachmentImpl implements Inx_Api_Mail_Attachment
{

	/**
	 * @var Inx_Apiimpl_RemoteRef
	 */
    protected $_oRendererRef;

    /**
     * @var stdClass
     */
    protected $_oData;
    
    /**
     * Enter description here...
     *
     * @param Inx_Apiimpl_RemoteRef $oRendererRef
     * @param stdClass $oData
     */
    public function __construct( Inx_Apiimpl_RemoteRef $oRendererRef, stdClass $oData )
    {
        $this->_oRendererRef = $oRendererRef;
        $this->_oData = $oData;
    }
    
    /**
     * Enter description here...
     *
     * @return String
     */
    public function getName()
    {
        return $this->_oData->name;
    }

    /**
     * Enter description here...
     *
     * @return String
     */
    public function getContentType()
    {
        return $this->_oData->contentType;
    }
    
    /**
     * Enter description here...
     *
     * @return long
     */
    public function getSize()
    {
        return $this->_oData->size;
    }

    /**
     * Enter description here...
     *
     * @return InputStream
     */
    public function getContent()
    {
        try
	    {
	        $service = $this->_oRendererRef->getService( Inx_Apiimpl_SessionContext::MAILING6_SERVICE );
	        
	        $sRefId = $service->getInputStream( $this->_oRendererRef->createCxt(), 
	                $this->_oRendererRef->refId(), $this->_oData->streamId );
	        return new Inx_Apiimpl_Core_RemoteInputStream( $this->_oRendererRef->createRemoteRef( $sRefId ) );
	    }
		catch( Inx_Api_RemoteException $e )
		{
		    $this->_oRendererRef->notify( $e );
		    return null;
		}
    }
  
}
