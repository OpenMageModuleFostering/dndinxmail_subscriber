<?php



/**
 * ListManagerImpl
 * 
 * @version $Revision: 5220 $ $Date: 2006-11-13 11:13:22 +0000 (Mo, 13 Nov 2006) $ $Author: bgn $
 */
class Inx_Apiimpl_List_ListManagerImpl implements Inx_Api_List_ListContextManager, Inx_Apiimpl_Core_BOResultSetDelegate
{
	
    protected $_oSessionContext;
    
	protected $_oService;

	
	public function __construct( Inx_Apiimpl_SessionContext $oSessionContext )
	{
		$this->_oSessionContext = $oSessionContext;
		$this->_oService = $oSessionContext->getService( Inx_Apiimpl_SessionContext::LIST_SERVICE );
	}
	
	
	/**
	 * @see com.inxmail.xpro.api.BOManager#get(int)
	 * @throws DataException
	 */
	public function get( $iId ) 
	{
	    if (!is_int($iId)) {
	        throw new Inx_Api_IllegalArgumentException('Integer parameter $iId expected, got '.gettype($iId));
	    }
		try
		{
		    $oList = Inx_Apiimpl_List_ListImpl::convertBO( 
		        $this->_oSessionContext, $this->_oService->get( $this->_oSessionContext->sessionId(), $iId ) 
		    );
		    
		    if( $oList == null ) {
		        
		        throw new Inx_Api_DataException( "list deleted" );
		    }
		    return $oList;
		}
		catch( Inx_Api_RemoteException $x )
		{
			//fixes XAPI-136
			$this->_oSessionContext->notify( $x );
			return null;
		}
	}

	
	/**
	 * @see com.inxmail.xpro.api.BOManager#remove(int)
	 */
	public function remove( $iId )
	{
	    if (!is_int($iId)) {
	        throw new Inx_Api_IllegalArgumentException('Integer parameter $iId expected, got '.gettype($iId));
	    }
		try
		{
			return $this->_oService->remove( $this->_oSessionContext->sessionId(), $iId );
		}
		catch( Inx_Api_RemoteException $x )
		{
			//fixes XAPI-136
			$this->_oSessionContext->notify( $x );
			return false;
		}
	}
	
	
    /**
     * @see com.inxmail.xpro.api.list.ListContextManager#createStandardList()
     */
    public function createStandardList()
    {
        return new Inx_Apiimpl_List_StandardListImpl( $this->_oSessionContext );
    }
    
    
    /**
     * @see com.inxmail.xpro.api.list.ListContextManager#createFilterList()
     */
    public function createFilterList()
    {
        return new Inx_Apiimpl_List_FilterListImpl( $this->_oSessionContext );
    }
    
    
	/**
	 * @see com.inxmail.xpro.api.BOManager#selectAll()
	 */
	public function selectAll()
	{
		try
		{
			$oRs = $this->_oService->selectAll( $this->_oSessionContext->sessionId() );
			return new Inx_Apiimpl_Core_DelegateBOResultSet( $this->_oSessionContext, $this, $oRs->remoteRefId, $oRs->size,
					Inx_Apiimpl_List_ListImpl::convertList($this->_oSessionContext, $oRs->data) );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
			return null;
		}
	}

	
	/**
	 * @see com.inxmail.xpro.api.list.ListContextManager#findByName(java.lang.String)
	 */
	public function findByName( $sListName )
	{
		try
		{
			return Inx_Apiimpl_List_ListImpl::convertBO( $this->_oSessionContext, $this->_oService->findByName(
					$this->_oSessionContext->sessionId(), $sListName ) );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
			return null;
		}
	}
	
	
	/**
	 * @see com.inxmail.xpro.apiimpl.core.BOResultSetDelegate#removeBOs(com.inxmail.xpro.apiimpl.RemoteRef, com.inxmail.xpro.apiservice.TInteger[])
	 * @throws RemoteException
	 */
	public function removeBOs( Inx_Apiimpl_RemoteRef $oResultSetRef, $oIndexRanges ) 
	{
		return $this->_oService->removeSelection( $oResultSetRef->sessionId(), $oResultSetRef->refId(), $oIndexRanges );
	}


	/**
	 * @see com.inxmail.xpro.apiimpl.core.BOResultSetDelegate#fetchBOs(com.inxmail.xpro.apiimpl.RemoteRef, int, int)
	 * @throws  RemoteException
	 */
	public function fetchBOs( Inx_Apiimpl_RemoteRef $oResultSetRef, $iIndex, $iDirection ) 
	{
		return Inx_Apiimpl_List_ListImpl::convertList($this->_oSessionContext, $this->_oService->fetch(
				$oResultSetRef->sessionId(), $oResultSetRef->refId(), $iIndex, $iDirection ) );
	}
}
