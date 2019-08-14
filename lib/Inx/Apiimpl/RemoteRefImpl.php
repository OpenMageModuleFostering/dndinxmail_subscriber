<?php


class Inx_Apiimpl_RemoteRefImpl implements Inx_Apiimpl_RemoteRef
{
	protected $_sRemoteRefId = null;
	
	protected $_oSession;
	
	public function __construct( $sRemoteRefId, Inx_Apiimpl_AbstractSession $oSc )
	{
		$this->_sRemoteRefId = $sRemoteRefId;
		$this->_oSession = $oSc;
	}

	public function refId()
	{
		if( $this->_sRemoteRefId == null )
			throw new Inx_Api_APIException( "Remote ref is released" );
		return $this->_sRemoteRefId;
	}
	
	public function sessionId()
	{

		return $this->_oSession->sessionId();
	}
	
	public function createCxt()
	{
		if( $this->_oSession->sessionClosed() )
			throw new Inx_Api_APIException( "Illegal session state: session is closed" );
	    $oSessionCxt = new stdClass;
	    $oSessionCxt->sid = $this->_oSession->sessionId();
	    $oSessionCxt->relRefIds = $this->_oSession->fetchReleasedRemoteRefs();
	    return $oSessionCxt;
	}

	public function release( $blImmediate )
	{
		if( $this->_sRemoteRefId == null )
			return;

		$this->_oSession->releaseRemoteRef( $this->_sRemoteRefId, $blImmediate );
		$this->_sRemoteRefId = null;
	}
	
	public function isReleased()
	{
		return ($this->_sRemoteRefId == null);
	}

	public function createRemoteRef( $sRemoteRefId )
	{
		return new Inx_Apiimpl_RemoteRefImpl( $sRemoteRefId, $this->_oSession );
	}
	
	public function getService( $sService )
	{
		return $this->_oSession->getService($sService);
	}

	public function getIntProperty( $sKey )
	{
	    return $this->_oSession->getIntProperty($sKey);
	}
	
	public function notify( Inx_Api_RemoteException $x )
	{
	    $this->_oSession->rebuildException( $x );
	}
	
	protected function finalize()
	{
		$this->release( false );
	}
}