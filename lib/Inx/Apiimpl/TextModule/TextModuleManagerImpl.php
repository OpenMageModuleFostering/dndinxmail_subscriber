<?php
class Inx_Apiimpl_TextModule_TextModuleManagerImpl 
            implements Inx_Api_TextModule_TextModuleManager, Inx_Apiimpl_Core_BOResultSetDelegate
{
	/**
	 * @var Inx_Apiimpl_SessionContext
	 */
    protected $_oSessionContext;

    /**
     * @var SoapClient
     */
	protected $_oService;

	public function __construct( Inx_Apiimpl_SessionContext $sc )
	{
		$this->_oSessionContext = $sc;
		$this->_oService = $sc->getService( Inx_Apiimpl_SessionContext::TEXTMODULE_SERVICE );
	}

	/**
	 * @throws Inx_Api_RemoteException
	 */
	public function fetchBOs( Inx_Apiimpl_RemoteRef $resultSetRef, $iIndex, $iDirection )
	{
		return Inx_Apiimpl_TextModule_TextModuleImpl::convertArr( $resultSetRef, $this->_oService->fetch(
			$resultSetRef->createCxt(), $resultSetRef->refId(), $iIndex, $iDirection ) );
	}

	/**
	 * @throws RemoteException 
	 */
	public function removeBOs( Inx_Apiimpl_RemoteRef $oResultSetRef, $aIndexRanges )
	{
		return $this->_oService->removeSelection( $oResultSetRef->createCxt(), $oResultSetRef->refId(), $aIndexRanges );
	}

	public function createTextmodule( Inx_Api_List_ListContext $listContext, $iMimeType )
	{
		
	    if (!is_int($iMimeType)) {
		    throw new Inx_Api_IllegalArgumentException('Wrong parameter $iMimeType type, integer expected');
		}
	    $f = new Inx_Apiimpl_TextModule_TextModuleImpl( $this->_oSessionContext, Inx_Apiimpl_TextModule_TextModuleImpl::createNewData());
		$f->updateListContextId( $listContext->getId() );
		$f->updateMimeType( $iMimeType );
		return $f;
	}


	public function select( Inx_Api_List_ListContext $listContext, $iOrderAttribute = -1, $iOrderType =-1 )
	{
		try
		{
			$rs = $this->_oService->select( $this->_oSessionContext->createCxt(), $listContext->getId(),
					$iOrderAttribute, $iOrderType );
			
			return new Inx_Apiimpl_Core_DelegateBOResultSet( $this->_oSessionContext, $this, $rs->remoteRefId, $rs->size,
					Inx_Apiimpl_TextModule_TextModuleImpl::convertArr( $this->_oSessionContext, $rs->data ) );
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
		    throw new Inx_Api_IllegalArgumentException('Wrong parameter $iId type, integer expected');
		}
	    try
		{
			$bo = Inx_Apiimpl_TextModule_TextModuleImpl::convert( 
			            $this->_oSessionContext, 
			            $this->_oService->get( $this->_oSessionContext->createCxt(), $iId ) 
			      );
		    if( $bo === null )
		        throw new Inx_Api_DataException( "textmodule deleted" );
		    return $bo;
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
			return $this->_oService->remove( $this->_oSessionContext->createCxt(), $iId );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
			return false;
		}
	}

	public function selectAll()
	{
		try
		{
			$rs = $this->_oService->select( $this->_oSessionContext->createCxt(), Inx_Apiimpl_Constants::ID_UNSPECIFIED, -1, -1 );
			
			return new Inx_Apiimpl_Core_DelegateBOResultSet( 
			        $this->_oSessionContext, 
			        $this, 
			        $rs->remoteRefId, 
			        $rs->size,
					Inx_Apiimpl_TextModule_TextModuleImpl::convertArr( $this->_oSessionContext, $rs->data) );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
			return null;
		}
	}

}
