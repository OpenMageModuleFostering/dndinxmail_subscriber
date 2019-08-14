<?php
class Inx_Apiimpl_Webpage_WebpageManagerImpl implements Inx_Api_Webpage_WebpageManager, Inx_Apiimpl_Core_BOResultSetDelegate
{
	protected $_oSessionContext;

	protected $_oService;


	public function __construct( Inx_Apiimpl_SessionContext $oSessionContext )
	{
		$this->_oSessionContext = $oSessionContext;
		$this->_oService = $this->_oSessionContext->getService( Inx_Apiimpl_SessionContext::WEBPAGE_SERVICE );
	}


	public function get( $iId )
	{
		try
		{
			$bo = Inx_Apiimpl_Webpage_WebpageImpl::convert( $this->_oSessionContext, $this->_oService->get( 
				$this->_oSessionContext->createCxt(), $iId ) );
			if( $bo == null )
				throw new Inx_Api_DataException( "webpage is deleted" );
			return $bo;
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}


	public function selectAll()
	{
		try
		{
			$rs = $this->_oService->selectAll( $this->_oSessionContext->createCxt() );

			return new Inx_Apiimpl_Core_DelegateBOResultSet( $this->_oSessionContext, $this, $rs->remoteRefId, 
				$rs->size, Inx_Apiimpl_Webpage_WebpageImpl::convertList( $this->_oSessionContext, $rs->data ) );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}


	public function selectBySubType( $sSubType )
	{
		try
		{
			$rs = $this->_oService->selectBySubType( $this->_oSessionContext->createCxt(), $sSubType );

			return new Inx_Apiimpl_Core_DelegateBOResultSet( $this->_oSessionContext, $this, $rs->remoteRefId, 
				$rs->size, Inx_Apiimpl_Webpage_WebpageImpl::convertList( $this->_oSessionContext, $rs->data ) );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}


	public function selectAllForms()
	{
		try
		{
			$rs = $this->_oService->selectAllForms( $this->_oSessionContext->createCxt() );

			return new Inx_Apiimpl_Core_DelegateBOResultSet( $this->_oSessionContext, $this, $rs->remoteRefId, 
				$rs->size, Inx_Apiimpl_Webpage_WebpageImpl::convertList( $this->_oSessionContext, $rs->data ) );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}


	public function selectAllJsps()
	{
		try
		{
			$rs = $this->_oService->selectAllJsps( $this->_oSessionContext->createCxt() );

			return new Inx_Apiimpl_Core_DelegateBOResultSet( $this->_oSessionContext, $this, $rs->remoteRefId, 
				$rs->size, Inx_Apiimpl_Webpage_WebpageImpl::convertList( $this->_oSessionContext, $rs->data ) );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}


	public function selectFormsBySubType( $sSubType )
	{
		try
		{
			$rs = $this->_oService->selectFormsBySubType( $this->_oSessionContext->createCxt(), $sSubType );

			return new Inx_Apiimpl_Core_DelegateBOResultSet( $this->_oSessionContext, $this, $rs->remoteRefId, 
				$rs->size, Inx_Apiimpl_Webpage_WebpageImpl::convertList( $this->_oSessionContext, $rs->data ) );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}


	public function selectJspsBySubType( $sSubType )
	{
		try
		{
			$rs = $this->_oService->selectJspsBySubType( $this->_oSessionContext->createCxt(), $sSubType );

			return new Inx_Apiimpl_Core_DelegateBOResultSet( $this->_oSessionContext, $this, $rs->remoteRefId, 
				$rs->size, Inx_Apiimpl_Webpage_WebpageImpl::convertList( $this->_oSessionContext, $rs->data ) );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}


	public function removeBOs( Inx_Apiimpl_RemoteRef $resultSetRef, $aIndexRanges )
	{
		return -1;
	}


	public function fetchBOs( Inx_Apiimpl_RemoteRef $resultSetRef, $iIndex, $iDirection )
	{
		return Inx_Apiimpl_Webpage_WebpageImpl::convertList( $resultSetRef, $this->_oService->fetch( 
			$resultSetRef->createCxt(), $resultSetRef->refId(), $iIndex, $iDirection ) );
	}

}