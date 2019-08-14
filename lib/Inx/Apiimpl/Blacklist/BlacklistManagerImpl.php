<?php



/**
 * BlacklistManagerImpl
 *
 * @version $Revision: 9739 $ $Date: 2008-01-23 14:44:04 +0200 (Tr, 23 Sau 2008) $ $Author: aurimas $
 */
class Inx_Apiimpl_Blacklist_BlacklistManagerImpl implements Inx_Api_Blacklist_BlacklistManager, Inx_Apiimpl_Core_BOResultSetDelegate
{

	protected $_oSc;

	protected $_oService;


	public function __construct( $oSc )
	{
		$this->_oSc = $oSc;
		$this->_oService = $oSc->getService( Inx_Apiimpl_SessionContext::BLACKLIST_SERVICE );
	}


	public function createBlacklistEntry()
	{
		$blData = new stdClass();
		$blData->id = null;
		$blData->pattern = null;
		$blData->hitCount = null;
		return new Inx_Apiimpl_Blacklist_BlacklistEntryImpl( $this->_oSc,  $blData);
	}


	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id
	 * @return unknown
	 */
	public function get( $id )
	{
		if (!is_int($id)) {
		    throw new Inx_Api_IllegalArgumentException('Integer parameter $id expected');
		}
	    try
		{
			$entry = Inx_Apiimpl_Blacklist_BlacklistEntryImpl::convert( $this->_oSc, $this->_oService->get( $this->_oSc->createCxt(), $id ) );
			if( $entry === null )
				throw new DataException( "blacklist entry deleted" );
			return $entry;
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
	 * @param int $id
	 * @return boolean
	 */
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


	/**
	 * Enter description here...
	 *
	 * @return Inx_Api_BOResultSet
	 */
	public function selectAll( $iOrderAttribute = null, $iOrderType  = null )
	{
		if (isset($iOrderAttribute) && isset($iOrderType) && (!is_int($iOrderAttribute) || !is_int($iOrderType)))
		{
		    throw new Inx_Api_IllegalArgumentException('Wrong parameters, integers expected');
		}
	    
		if ($iOrderAttribute==null && $iOrderType === null) {
			try
			{
				/**
				 * @var stdClass
				 */
				$rs = $this->_oService->selectAll( $this->_oSc->createCxt(), -1, -1 );
				return new Inx_Apiimpl_Core_DelegateBOResultSet( $this->_oSc, $this, $rs->remoteRefId, $rs->size,
					Inx_Apiimpl_Blacklist_BlacklistEntryImpl::convertArr( $this->_oSc, $rs->data ) );
			}
			catch( Inx_Api_RemoteException $e )
			{
				$this->_oSc->notify( $e );
				return null;
			}
		} else {
			try
			{
				$rs = $this->_oService->selectAll( $this->_oSc->createCxt(), $iOrderAttribute, $iOrderType );
					
				return new Inx_Apiimpl_Core_DelegateBOResultSet( $this->_oSc, $this, $rs->remoteRefId, $rs->size,
				Inx_Apiimpl_Blacklist_BlacklistEntryImpl::convertArr( $this->_oSc, $rs->data ) );
			}
			catch( Inx_Api_RemoteException $e )
			{
				$this->_oSc->notify( $e );
				return null;
			}
		}
	}


	/**
	 * Enter description here...
	 *
	 * @param string $pattern
	 * @return Inx_Api_Blacklist_BlacklistEntry
	 */
	public function findByPattern( $pattern )
	{
		try
		{
			return Inx_Apiimpl_Blacklist_BlacklistEntryImpl::convert( $this->_oSc, $this->_oService->findByPattern(
			$this->_oSc->createCxt(), $pattern ) );
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
	 * @return unknown
	 */
	public function removeBOs( Inx_Apiimpl_RemoteRef $oResultSetRef, $aIndexRanges )
	{
		return $this->_oService->removeSelection( $oResultSetRef->createCxt(), $oResultSetRef->refId(), $aIndexRanges );
	}


	public function fetchBOs( Inx_Apiimpl_RemoteRef $oResultSetRef, $iIndex, $iDirection )
	{
		return Inx_Apiimpl_Blacklist_BlacklistEntryImpl::convertArr( $oResultSetRef, $this->_oService->fetch(
			$oResultSetRef->createCxt(), $oResultSetRef->refId(), $iIndex, $iDirection ) );
	}
	
	public function selectAfter( $searchDate )
	{
		try
		{
			$rs = $this->_oService->selectAfter( $this->_oSc->createCxt(), Inx_Apiimpl_TConvert::TConvert( $searchDate ) );
			return new Inx_Apiimpl_Core_DelegateBOResultSet( $this->_oSc, $this, $rs->remoteRefId, $rs->size,
				Inx_Apiimpl_Blacklist_BlacklistEntryImpl::convertArr( $this->_oSc, $rs->data ) );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSc->notify( $x );
			return null;
		}
	}


	public function selectBefore( $searchDate )
	{
		try
		{
			$rs = $this->_oService->selectBefore( $this->_oSc->createCxt(), Inx_Apiimpl_TConvert::TConvert( $searchDate ) );
			return new Inx_Apiimpl_Core_DelegateBOResultSet( $this->_oSc, $this, $rs->remoteRefId, $rs->size,
				Inx_Apiimpl_Blacklist_BlacklistEntryImpl::convertArr( $this->_oSc, $rs->data ) );		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSc->notify( $x );
			return null;
		}
	}


	public function selectBetween( $startDate, $stopDate )
	{
		try
		{
			$rs = $this->_oService->selectBetween( $this->_oSc->createCxt(), Inx_Apiimpl_TConvert::TConvert( $startDate ),
									 Inx_Apiimpl_TConvert::TConvert( $stopDate ) );
			return new Inx_Apiimpl_Core_DelegateBOResultSet( $this->_oSc, $this, $rs->remoteRefId, $rs->size,
				Inx_Apiimpl_Blacklist_BlacklistEntryImpl::convertArr( $this->_oSc, $rs->data ) );		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSc->notify( $x );
			return null;
		}
	}
}
