<?php
/**
 * ResourceManagerImpl
 * 
 * @version $Revision: 5220 $ $Date: 2006-11-13 11:13:22 +0000 (Mo, 13 Nov 2006) $ $Author: bgn $
 */
class Inx_Apiimpl_Resource_ResourceManagerImpl 
                implements Inx_Api_Resource_ResourceManager, Inx_Apiimpl_Core_BOResultSetDelegate
{

    protected $_oSessionContext;

    protected $_oService;

    
    public function __construct( Inx_Apiimpl_SessionContext $sc )
    {
        $this->_oSessionContext = $sc;
    	$this->_oService = $sc->getService( Inx_Apiimpl_SessionContext::RESOURCE_SERVICE );    
    }
    
    /**
     * @throws Inx_Api_DataException
     */
	public function get( $iId ) 
	{
	    if (!is_int($iId)) {
		    throw new Inx_Api_IllegalArgumentException('Wrong parameter $iId type, integer expected');
		}
	    try
	    {
	        $oData = $this->_oService->get( $this->_oSessionContext->sessionId(), $iId );
	        if( $oData === null )
	            throw new Inx_Api_DataException( "resource is orphaned" );
	        
	        return new Inx_Apiimpl_Resource_ResourceImpl( $this->_oSessionContext, $oData );
	    }
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
			return null;
		}
    }
	
	
	public function remove( $iId )
	{
	    if (!is_int($iId)) {
		    throw new Inx_Api_IllegalArgumentException('Wrong parameter $iId type, integer expected');
		}
	    try
	    {
	        return $this->_oService->remove( $this->_oSessionContext->sessionId(), $iId );
	    }
	    catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
			return false;
		}
    }
	/*
    public BOResultSet selectAll( int orderAttribute, int orderType )
    {
        try
	    {
            switch( orderAttribute )
            {
	            case Resource.ATTRIBUTE_NAME:
	            case Resource.ATTRIBUTE_SIZE:
	            case Resource.ATTRIBUTE_CREATION_DATETIME:
	            case Resource.ATTRIBUTE_SHARING_TYPE:
	            case Resource.ATTRIBUTE_USER_ID:
	                break;
	            default:
	                throw new IllegalArgumentException( "illegal orderAttribute: " + orderAttribute );
            }
            ResultSetData rs = service.selectAll( sc.sessionId(), orderAttribute, orderType );
	        return new DelegateBOResultSet( sc, this, rs.getRemoteRefId(), rs.getSize(),
	        		ResourceImpl.convert( sc, rs.getData() ) );
	    }
		catch( RemoteException x )
		{
			sc.notify( x );
			return null;
		}
    }
	*/
	public function selectAll($iOrderAttribute = -1, $iOrderType = -1)
	{
	    if ($iOrderAttribute !== -1 || $iOrderType !== -1) {
	        switch ( $iOrderAttribute) {
	            case Inx_Api_Resource_Resource::ATTRIBUTE_NAME:
	            case Inx_Api_Resource_Resource::ATTRIBUTE_SIZE:
	            case Inx_Api_Resource_Resource::ATTRIBUTE_CREATION_DATETIME:
	            case Inx_Api_Resource_Resource::ATTRIBUTE_SHARING_TYPE:
	            case Inx_Api_Resource_Resource::ATTRIBUTE_USER_ID:
	                break;
	            default:
	                throw new Inx_Api_IllegalArgumentException("Illegal orderAttribute: ".$iOrderAttribute);
	        }
	    }
	    
	    
	    try
	    {
	    	$rs = $this->_oService->selectAll( $this->_oSessionContext->sessionId(), $iOrderAttribute, $iOrderType );
	        return new Inx_Apiimpl_Core_DelegateBOResultSet( 
	            $this->_oSessionContext, $this, $rs->remoteRefId, $rs->size,
	        		Inx_Apiimpl_Resource_ResourceImpl::convert( $this->_oSessionContext, $rs->data ) );
	    }
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
			return null;
		}
    }
    
    
    public function select( Inx_Api_Mailing_Mailing $mailing, $iOrderAttribute, $iOrderType )
    {
        
        switch( $iOrderAttribute )
        {
            case Inx_Api_Resource_Resource::ATTRIBUTE_NAME:
            case Inx_Api_Resource_Resource::ATTRIBUTE_SIZE:
            case Inx_Api_Resource_Resource::ATTRIBUTE_CREATION_DATETIME:
            case Inx_Api_Resource_Resource::ATTRIBUTE_SHARING_TYPE:
            case Inx_Api_Resource_Resource::ATTRIBUTE_USER_ID:
                break;
            default:
            	throw new Inx_Api_IllegalArgumentException( "illegal orderAttribute: " . $iOrderAttribute );
        }
        
        try
	    {
            $rs = $this->_oService->select( $this->_oSessionContext->sessionId(),
	                $mailing->getId(), $mailing->getListContextId(), $iOrderAttribute, $iOrderType );
	        return new Inx_Apiimpl_Core_DelegateBOResultSet( 
	                $this->_oSessionContext, $this, $rs->remoteRefId, $rs->size,
	        		    Inx_Apiimpl_Resource_ResourceImpl::convert( $this->_oSessionContext, $rs->data  ) );
	    }
    	catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
			return null;
		}
    }

    


    
    public function upload( $mOwner = null, $sFilename, $rsInputStream )
    {
        if (is_null($mOwner)) {
            
            return $this->_upload(
                $sFilename, 
                Inx_Api_Resource_Resource::SHARING_TYPE_SYSTEM, 
                0, 
                $rsInputStream
            );
        }
        elseif ($mOwner instanceof Inx_Api_Mailing_Mailing) {
            return $this->_upload(
                $sFilename, 
                Inx_Api_Resource_Resource::SHARING_TYPE_MAILING, 
                $mOwner->getId(), 
                $rsInputStream
            );
        }
        elseif($mOwner instanceof Inx_Api_List_ListContext ) {
            return $this->_upload(
                $sFilename, 
                Inx_Api_Resource_Resource::SHARING_TYPE_LIST, 
                $mOwner->getId(), 
                $rsInputStream
            );
        }
        
    }
    

    
    protected function _upload( $sFilename, $iSharingType, $iBoId, $rsInputStream)
    {
        if( $sFilename === null || strlen($sFilename)== 0 )
            throw new Inx_Api_IllegalArgumentException( "illegal filename value" );
        if (!is_resource($rsInputStream)) {
            throw new Inx_Api_IllegalArgumentException( 'the passed stream is not a stream');
        }
        $ref = null;
        try
	    {
            $ud = $this->_oService->upload( $this->_oSessionContext->sessionId(), $iSharingType, $iBoId, $sFilename );
            $ref = $this->_oSessionContext->createRemoteRef( $ud->remoteRefId );
	        
	        try
	        {
	            Inx_Apiimpl_Core_Uploader::upload( $ref, $rsInputStream, $ud->maxChunkSize, false );
	            
	            $data = $this->_oService->commitUpload( $this->_oSessionContext->sessionId(), $ref->refId() );
	            
	            if( $ref !== null )
		            $ref->release( false );
	            
		        if( $data === null )
		            return null;
		        else
		            return new Inx_Apiimpl_Resource_ResourceImpl( $this->_oSessionContext, $data );
		    }
			catch( Inx_Api_IOException $x )
			{
			    if( $ref !== null )
		            $ref->release( false );
			    return null;
			}
		}
		catch( Inx_Api_RemoteException $x )
		{
			if( $ref !== null )
		        $ref->release( false );
		    $this->_oSessionContext->notify( $x );
			return null;
		}
		if( $ref !== null )
		    $ref->release( false );

    }
    
    /**
     * @throws Inx_Api_RemoteException
     */
    public function removeBOs( Inx_Apiimpl_RemoteRef $resultSetRef, $indexRanges )
    {
    	 return $this->_oService->removeBOs( $resultSetRef->sessionId(), $resultSetRef->refId(), $indexRanges );
    }

    /**
     * @throws Inx_Api_RemoteException
     */
    public function fetchBOs( Inx_Apiimpl_RemoteRef $resultSetRef, $iIndex, $iDirection )
    {
    	return Inx_Apiimpl_Resource_ResourceImpl::convert( $resultSetRef, $this->_oService->fetchBOs(
    			$resultSetRef->sessionId(), $resultSetRef->refId(), $iIndex, $iDirection ) );
    }
}
