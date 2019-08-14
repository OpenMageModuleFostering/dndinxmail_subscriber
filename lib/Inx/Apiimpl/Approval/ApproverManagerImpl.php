<?php

/**
 * ApproverManagerImpl
 * 
 * @version 
 */


class Inx_Apiimpl_Approval_ApproverManagerImpl implements Inx_Api_Approval_ApproverManager, Inx_Apiimpl_Core_BOResultSetDelegate
{

	protected $_oSc;

	protected $_oService;


	public function __construct( $oSc )
	{
		$this->_oSc = $oSc;
		$this->_oService = $oSc->getService( Inx_Apiimpl_SessionContext::APPROVER_SERVICE );
	}
	


	public function select( $listContext )
	{
		
		try
		{
			$rs = $this->_oService->selectApprover( $this->_oSc->createCxt(), $listContext->getId() );
			return new Inx_Apiimpl_Core_DelegateBOResultSet( $this->_oSc, $this, $rs->remoteRefId, $rs->size,
				Inx_Apiimpl_Approval_ApproverImpl::convertArr( $this->_oSc, $rs->data ) );		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSc->notify( $x );
			return null;
		}
	}


	public function get( $id )
	{
		
		if (!is_int($id)) {
		    throw new Inx_Api_IllegalArgumentException('Integer parameter $id expected');
		}
	    try
		{
			$entry = Inx_Apiimpl_Approval_ApproverImpl::convert( $this->_oSc, $this->_oService->get( $this->_oSc->createCxt(), $id ) );
			if( $entry === null )
				throw new DataException( "approver deleted" );
			return $entry;
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSc->notify( $e );
			return null;
		}
	}


	public function remove( $id )
	{
	 if (!is_int($id)) {
		    throw new Inx_Api_IllegalArgumentException('Integer parameter $id expected');
		}
	    try
		{
			return $this->_oService->remove( $this->_oSc->createCxt(), $id );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSc->notify( $e );
			return false;
		}
	}


	public function removeBOs( Inx_Apiimpl_RemoteRef $oResultSetRef, $aIndexRanges )
	{
		return $this->_oService->removeSelection( $oResultSetRef->createCxt(), $oResultSetRef->refId(), $aIndexRanges );
	}


	public function fetchBOs( Inx_Apiimpl_RemoteRef $oResultSetRef, $iIndex, $iDirection )
	{
		return Inx_Apiimpl_Approval_ApproverImpl::convertArr( $oResultSetRef, $this->_oService->fetch(
			$oResultSetRef->createCxt(), $oResultSetRef->refId(), $iIndex, $iDirection ) );
	}
	



	public function createApprover()
	{
		$oData = new stdClass();
		$oData->id = null;
		$oData->listIds = array();
		$oData->name = null;
		$oData->email = null;
		$oData->comment = null;
		
		return new Inx_Apiimpl_Approval_ApproverImpl( $this->_oSc, $oData );
	}


	public function selectAll()
	{
	    try
		{

			$rs = $this->_oService->selectAll( $this->_oSc->createCxt() );
			return new Inx_Apiimpl_Core_DelegateBOResultSet( $this->_oSc, $this, $rs->remoteRefId, $rs->size,
				Inx_Apiimpl_Approval_ApproverImpl::convertArr( $this->_oSc, $rs->data ) );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSc->notify( $e );
			return null;
		}
	}

}
