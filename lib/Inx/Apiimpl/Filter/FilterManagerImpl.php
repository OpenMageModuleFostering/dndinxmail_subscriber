<?php


/**
 * FilterManagerImpl
 *
 * @version $Revision$ $Date$ $Author$
 */
class Inx_Apiimpl_Filter_FilterManagerImpl implements Inx_Api_Filter_FilterManager, Inx_Apiimpl_Core_BOResultSetDelegate
{
	protected $_oSc;

	protected $_oService;


	public function __construct( Inx_Apiimpl_SessionContext $oSc )
	{
		$this->_oSc = $oSc;
		$this->_oService = $oSc->getService( Inx_Apiimpl_SessionContext::FILTER_SERVICE );
	}

	/**
	 * Enter description here...
	 *
	 * @param Inx_Api_List_ListContext $oListContext
	 * @return Inx_Api_Filter_Filter
	 */
	public function createFilter( Inx_Api_List_ListContext $oListContext )
	{

		$flData = new stdClass();
		$flData->id = null;
		$flData->listContextId = null;
		/**
		 * @var FilterImpl
		 */
		$f = new Inx_Apiimpl_Filter_FilterImpl( $this->_oSc, $flData );
		$f->updateListContextId( $oListContext->getId() );
		return $f;
	}


	/**
	 * Enter description here...
	 * 
	 * @return Inx_Api_BusinessObject
	 * @throws Inx_Api_DataException
	 */
	public function get( $iId )
	{
	    if (!is_int($iId)) {
		    throw new Inx_Api_IllegalArgumentException('Integer parameter $iId expected, got '.gettype($iId));
		}
	    try
		{
			$oBo = Inx_Apiimpl_Filter_FilterImpl::convert( $this->_oSc, $this->_oService->get( $this->_oSc->createCxt(), $iId ) );
			if( $oBo === null )
				throw new Inx_Api_DataException( "filter deleted" );
			return $oBo;
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSc->notify( $e );
			return null;
		}
	}

	/**
	 * Enter description here...
	 *
	 * @return boolean
	 */
	public function remove( $iId )
	{
	    if (!is_int($iId)) {
		    throw new Inx_Api_IllegalArgumentException('Integer parameter $iId expected, got '.gettype($iId));
		}
	    
	    try
		{
			return $this->_oService->remove( $this->_oSc->createCxt(), $iId );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSc->notify( $e );
			return false;
		}
	}

	/**
	 * Enter description here...
	 *
	 * @return Inx_Api_BOResultSet
	 */
	public function selectAll()
	{
		try
		{
			$aRs = $this->_oService->select( $this->_oSc->createCxt(), Inx_Apiimpl_Constants::ID_UNSPECIFIED, -1, -1 );
				
			return new Inx_Apiimpl_Core_DelegateBOResultSet( $this->_oSc, $this, $aRs->remoteRefId, $aRs->size,
				Inx_Apiimpl_Filter_FilterImpl::convert( $this->_oSc, $aRs->data ) );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSc->notify( $e );
			return null;
		}
	}

	/**
	 * Enter description here...
	 *
	 * @return Inx_Api_BOResultSet
	 */
	public function select( Inx_Api_List_ListContext $oListContext, $iOrderAttribute = -1, $iOrderType = -1)
	{
		if (!(is_int($iOrderAttribute) && is_int($iOrderType))) {
		    throw new Inx_Api_IllegalArgumentException('Wrong parameter type: $iOrderAttribute and $iOrderType should be integers');
		}
	    
	    try
		{
			$aRs = $this->_oService->select( $this->_oSc->createCxt(), $oListContext->getId(),
				$iOrderAttribute, $iOrderType );
				
			return new Inx_Apiimpl_Core_DelegateBOResultSet( $this->_oSc, $this, $aRs->remoteRefId, $aRs->size,
			Inx_Apiimpl_Filter_FilterImpl::convert( $this->_oSc, $aRs->data ) );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSc->notify( $e );
			return null;
		}
	}

	/**
	 * Enter description here...
	 * @return int
	 */
	public function removeBOs( Inx_Apiimpl_RemoteRef $oResultSetRef, $aIndexRanges )
	{
		return $this->_oService->removeSelection( $oResultSetRef->createCxt(), $oResultSetRef->refId(), $aIndexRanges );
	}

	/**
	 * @return array
	 */
	public function fetchBOs( Inx_Apiimpl_RemoteRef $oResultSetRef, $iIndex, $iDirection )
	{
		return Inx_Apiimpl_Filter_FilterImpl::convert( $oResultSetRef, $this->_oService->fetch(
			$oResultSetRef->createCxt(), $oResultSetRef->refId(), $iIndex, $iDirection ) );
	}
}
