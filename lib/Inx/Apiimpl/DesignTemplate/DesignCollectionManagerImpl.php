<?php
/**
 * @author nds
 * 
 */
class Inx_Apiimpl_DesignTemplate_DesignCollectionManagerImpl 
                    implements Inx_Api_DesignTemplate_DesignCollectionManager, Inx_Apiimpl_Core_BOResultSetDelegate
{
	private $_oSessionContext;

	private $_oService;

	/**
	 * 
	 */
	public function __construct( Inx_Apiimpl_SessionContext $sc )
	{
		$this->_oSessionContext = $sc;
		$this->_oService = $sc->getService( Inx_Apiimpl_SessionContext::DESIGN_COLLECTION2_SERVICE );
	}

	/*
	 * (non-Javadoc)
	 * 
	 * @see com.inxmail.xpro.api.designtemplate.DesignCollectionManager#importDesignCollection(java.io.InputStream)
	 * @throws IOException, ImportException, FeatureNotAvailableException
	 */
	public function importDesignCollection($itcFile, Inx_Api_List_ListContext $listCxt )
	{
		/*
		 * 1. Checke Stream (kann man gar nicht !) 2. Lege Datei auf Server an 3. Speichere Datei
		 * auf Server 4. Importiere ITC 5. Falls Fehler: Generiere Exception und gebe diese aus
		 */
		if (!is_resource($itcFile))
		{
			throw new Inx_Api_IllegalArgumentException("itc file must be a resource");
		}
		
		$ud = $this->_oService->createITCUpload( $this->_oSessionContext->createCxt() );
		$ref = $this->_oSessionContext->createRemoteRef( $ud->remoteRefId );


        Inx_Apiimpl_Core_Uploader::upload( $ref, $itcFile, $ud->maxChunkSize, false );
        
        if ($listCxt === null)
        {
        	throw new Inx_Api_IllegalArgumentException( "ListContext cannot be null !!" );
        }
        
        $ew = null;
        
        // Bug fix XAPI-15: Throw FeatureNotAvailableException if template feature is not enabled
        try
        {
        	$ew = $this->_oService->importITC( $this->_oSessionContext->createCxt(), $ud->remoteRefId, $listCxt->getId() );
        }
        catch( Inx_Api_RemoteException $e )
        {
        	throw new Inx_Api_FeatureNotAvailableException( "Template Feature" );
        }
        
        if ($ew->hasErrorsOrWarnings)
        {
        	throw new Inx_Api_DesignTemplate_ImportException("Import error occured. See warnings, errors or fatals for further information.", $ew->type, $ew->warning, $ew->error, $ew->fatal);
        }
        
        return new Inx_Apiimpl_DesignTemplate_DesignCollectionImpl( $this->_oSessionContext, $ew->returnValue );
	}

	/*
	 * (non-Javadoc)
	 * 
	 * @see com.inxmail.xpro.api.designtemplate.DesignCollectionManager#select(com.inxmail.xpro.api.list.ListContext)
	 */
	public function select( Inx_Api_List_ListContext $listContext )
	{
		try
		{
			if ($listContext === null)
				throw new Inx_Api_IllegalArgumentException( "ListContext cannot be null !!" );
			
			$oRS = $this->_oService->select( $this->_oSessionContext->createCxt(), $listContext->getId() );

			return new Inx_Apiimpl_Core_DelegateBOResultSet( $this->_oSessionContext, $this, $oRS->remoteRefId, $oRS->size,
				Inx_Apiimpl_DesignTemplate_DesignCollectionImpl::convert( $this->_oSessionContext, $oRS->data ) );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
			return null;
		}
	}

	/**
	 * @throws Inx_Api_DataException
	 */
	public function get( $iId )
	{
		if (!is_int($iId)) {
		    throw new Inx_Api_IllegalArgumentException('Integer parameter $iId expected, got '.gettype($iId));
		}
	    
	    try
		{
			$oData = $this->_oService->get( $this->_oSessionContext->createCxt(), $iId );
			if( $oData === null )
				throw new Inx_Api_DataException( "DesignCollection not available" );

			return new Inx_Apiimpl_DesignTemplate_DesignCollectionImpl( $this->_oSessionContext, $oData );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
			return null;
		}
	}

	/*
	 * (non-Javadoc)
	 * 
	 * @see com.inxmail.xpro.api.BOManager#remove(int)
	 */
	public function remove( $iId )
	{
	    if (!is_int($iId)) {
		    throw new Inx_Api_IllegalArgumentException('Integer parameter $iId expected, got '.gettype($iId));
		}
	    try
		{
			return $this->_oService->remove( $this->_oSessionContext->createCxt(), $iId );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
			return false;
		}
	}

	/*
	 * (non-Javadoc)
	 * 
	 * @see com.inxmail.xpro.api.BOManager#selectAll()
	 */
	public function selectAll()
	{
		try
		{
			$rs = $this->_oService->select( $this->_oSessionContext->createCxt(), 
			                Inx_Apiimpl_Constants::ID_UNSPECIFIED );
			                
			return new Inx_Apiimpl_Core_DelegateBOResultSet( $this->_oSessionContext, 
			    $this, $rs->remoteRefId, $rs->size,
				Inx_Apiimpl_DesignTemplate_DesignCollectionImpl::convert( $this->_oSessionContext, $rs->data) );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
			return null;
		}
	}
	
    /**
     * @throws RemoteException 
     */
	public function fetchBOs( Inx_Apiimpl_RemoteRef $resultSetRef, $iIndex, $iDirection )
		
	{
		return Inx_Apiimpl_DesignTemplate_DesignCollectionImpl::convert( 
		    $resultSetRef, 
		    $this->_oService->fetch( 
		        $resultSetRef->createCxt(),
    			$resultSetRef->refId(), 
    			$iIndex, 
    			$iDirection 
    		) 
		);
	}

	/**
	 * @throws Inx_Api_RemoteException
	 */
	public function removeBOs( Inx_Apiimpl_RemoteRef $resultSetRef, $aIndexRanges ) 
	{
		return $this->_oService->removeSelection( 
		    $resultSetRef->createCxt(), 
		    $resultSetRef->refId(), 
		    $aIndexRanges );
	}

	public function createPreviewImageStream( Inx_Api_DesignTemplate_Style $oStyle )
	{
		$sRemoteRefID;
		try
		{
			$sRemoteRefID = $this->_oService->createPreviewImageStream( 
			        $this->_oSessionContext->createCxt(), $oStyle->getTemplateId(), $oStyle->getStyleName() 
			);
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
		
		if ($sRemoteRefID === null)
			return null;
		
		return new Inx_Apiimpl_Core_RemoteInputStream( 
		        $this->_oSessionContext->createRemoteRef( $sRemoteRefID ) 
		    );
	}
}
