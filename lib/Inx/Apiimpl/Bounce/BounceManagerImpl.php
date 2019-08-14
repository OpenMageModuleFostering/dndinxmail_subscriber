<?php



/**
 * BounceManagerImpl
 *
 * @version
 */
class Inx_Apiimpl_Bounce_BounceManagerImpl implements Inx_Api_Bounce_BounceManager, Inx_Apiimpl_Core_BOResultSetDelegate
{

	protected $_oSc;

	protected $_oService;


	public function __construct( $oSc )
	{
		$this->_oSc = $oSc;
		$this->_oService = $oSc->getService( Inx_Apiimpl_SessionContext::BOUNCE2_SERVICE );
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
			$entry = Inx_Apiimpl_Bounce_BounceImpl::convert( $this->_oSc, $this->_oService->get( $this->_oSc->createCxt(), $id ) );
			if( $entry === null )
			throw new DataException( "bounce deleted" );
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
	public function selectAllBounces( Inx_Api_Recipient_RecipientContext $oRc = null,array $aAttrs = null  )
	{
		try
		{
			/**
			 * @var stdClass
			 */
			if( $oRc != null )
				$rcId = $oRc->_remoteRef()->refId();
			else
				$rcId = "-1";
			$aAttrIds = $this->_convertAttributesToIds( $aAttrs );
			$rs = $this->_oService->selectAll( $this->_oSc->createCxt(),$rcId, $aAttrIds );
			return new Inx_Apiimpl_Bounce_BounceDelegateResultSet( $this->_oSc, $this, $rs, $oRc, $aAttrs );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSc->notify( $e );
			return null;
		}
	}

	public function selectAll( )
	{
		return $this->selectAllBounces(null, null);
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
		//do nothing...
	}
	
	public function fetchBounces( Inx_Apiimpl_RemoteRef $oResultSetRef, $iIndex, $iDirection )
	{
		return  $this->_oService->fetch( $oResultSetRef->createCxt(), $oResultSetRef->refId(), $iIndex, $iDirection  );
	}

	public function selectAfter( $searchDate, Inx_Api_Recipient_RecipientContext $oRc = null,array $aAttrs = null )
	{
		try
		{
			if( $oRc != null )
				$rcId = $oRc->_remoteRef()->refId();
			else
				$rcId = "-1";
			$aAttrIds = $this->_convertAttributesToIds( $aAttrs );
			$rs = $this->_oService->selectAfter( $this->_oSc->createCxt(), Inx_Apiimpl_TConvert::TConvert( $searchDate ), $rcId, $aAttrIds );
			return new Inx_Apiimpl_Bounce_BounceDelegateResultSet( $this->_oSc, $this, $rs, $oRc, $aAttrs );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSc->notify( $x );
			return null;
		}
	}


	public function selectBefore( $searchDate, Inx_Api_Recipient_RecipientContext $oRc = null,array $aAttrs = null )
	{
		try
		{
			if( $oRc != null )
				$rcId = $oRc->_remoteRef()->refId();
			else
				$rcId = "-1";
			$aAttrIds = $this->_convertAttributesToIds( $aAttrs );
			$rs = $this->_oService->selectBefore( $this->_oSc->createCxt(), Inx_Apiimpl_TConvert::TConvert( $searchDate ), $rcId, $aAttrIds );
			return new Inx_Apiimpl_Bounce_BounceDelegateResultSet( $this->_oSc, $this, $rs, $oRc, $aAttrs );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSc->notify( $x );
			return null;
		}
	}


	public function selectBetween( $startDate, $stopDate, Inx_Api_Recipient_RecipientContext $oRc = null,array $aAttrs = null )
	{
		try
		{
			if( $oRc != null )
				$rcId = $oRc->_remoteRef()->refId();
			else
				$rcId = "-1";
			$aAttrIds = $this->_convertAttributesToIds( $aAttrs );
			$rs = $this->_oService->selectBetween( $this->_oSc->createCxt(), Inx_Apiimpl_TConvert::TConvert( $startDate ),
			Inx_Apiimpl_TConvert::TConvert( $stopDate ), $rcId, $aAttrIds );
			return new Inx_Apiimpl_Bounce_BounceDelegateResultSet( $this->_oSc, $this, $rs, $oRc, $aAttrs );
		}
			catch( Inx_Api_RemoteException $x )
			{
				$this->_oSc->notify( $x );
				return null;
			}
	}

	public function selectByListId( $listId, Inx_Api_Recipient_RecipientContext $oRc = null,array $aAttrs = null )
	{
		try
		{
			if( $oRc != null )
				$rcId = $oRc->_remoteRef()->refId();
			else
				$rcId = "-1";
			$aAttrIds = $this->_convertAttributesToIds( $aAttrs );
			$rs = $this->_oService->selectByListId( $this->_oSc->createCxt(), $listId, $rcId, $aAttrIds );
			return new Inx_Apiimpl_Bounce_BounceDelegateResultSet( $this->_oSc, $this, $rs, $oRc, $aAttrs );		}
			catch( Inx_Api_RemoteException $x )
			{
				$this->_oSc->notify( $x );
				return null;
			}
	}

	public function selectByMailingId( $mailingId, Inx_Api_Recipient_RecipientContext $oRc = null,array $aAttrs = null )
	{
		try
		{
			if( $oRc != null )
				$rcId = $oRc->_remoteRef()->refId();
			else
				$rcId = "-1";
			$aAttrIds = $this->_convertAttributesToIds( $aAttrs );
			$rs = $this->_oService->selectByMailingId( $this->_oSc->createCxt(), $mailingId, $rcId, $aAttrIds );
			return new Inx_Apiimpl_Bounce_BounceDelegateResultSet( $this->_oSc, $this, $rs, $oRc, $aAttrs );		}
			catch( Inx_Api_RemoteException $x )
			{
				$this->_oSc->notify( $x );
				return null;
			}
	}

	private function _convertAttributesToIds( array $aAttrs = null)
	{
		if($aAttrs === null)
		return array();
		$aAttrIds = array();
		foreach ($aAttrs as $key => $val) {
			$aAttrIds[$key] = $val->getId();
		}
		return $aAttrIds;
	}
}
