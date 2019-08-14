<?php

/**
 * RemoteObject
 * 
 * <P>Copyright (c) 2005 Inxmail GmbH. All Rights Reserved.
 * @version $Revision: 9350 $ $Date: 2007-12-10 09:36:24 +0200 (Pr, 10 Grd 2007) $ $Author: aurimas $
 */
abstract class Inx_Apiimpl_RemoteObject
{

	private $_oRemoteRef;
		

	protected function __construct( Inx_Apiimpl_SessionContext $oContext, $sRemoteRefId )
	{
		$this->_oRemoteRef = $oContext->createRemoteRef( $sRemoteRefId );
	}
	
	public function _remoteRef()
	{
		return $this->_oRemoteRef;
	}
	
	protected function _refId()
	{
		return $this->_oRemoteRef->refId();
	}
	
	protected function _sessionId()
	{
		return $this->_oRemoteRef->sessionId();
	}
	
	protected function _createCxt()
	{
		return $this->_oRemoteRef->createCxt();
	}

	protected function _release( $blImmediate )
	{
		$this->_oRemoteRef->release( $blImmediate );
	}
	
	protected function _isReleased()
	{
	    return $this->_oRemoteRef->isReleased();
	}

	protected function _notify( Exception $e )
	{
		
	    $this->_oRemoteRef->notify( $e );
	}

}
