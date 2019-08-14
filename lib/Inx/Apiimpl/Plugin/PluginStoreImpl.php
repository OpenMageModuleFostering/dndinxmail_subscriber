<?php

class Inx_Apiimpl_Plugin_PluginStoreImpl implements Inx_Api_Plugin_PluginStore
{

	protected $_oSessionContext;

	protected $_oService;



	public function __construct( Inx_Apiimpl_SessionContext $sc )
	{
		$this->_oSessionContext = $sc;
		$this->_oService = $sc->getService( Inx_Apiimpl_SessionContext::PLUGIN_SERVICE );
	}


	public function get( $secretId, $key )
	{
		try
		{
			$remoteRef = $this->_oService->getInputStream( $this->_oSessionContext->sessionId(), $secretId, $key );
			if( $remoteRef == null )
			throw new Inx_Api_DataException( "not found" );
			//fixes XAPI-85
			return new Inx_Apiimpl_Core_RemoteInputStream( $this->_oSessionContext->createRemoteRef( $remoteRef ) );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
			return null;
		}
	}


	public function getKeys( $secretId )
	{
		try
		{
			return $this->_oService->get( $this->_oSessionContext->sessionId(), $secretId );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
			return null;
		}
	}


	public function put( $secretId, $key, $is )
	{
		$ref = null;
		try
		{
			$ud = $this->_oService->upload( $this->_oSessionContext->sessionId(), $secretId, $key );
			$ref = $this->_oSessionContext->createRemoteRef( $ud->remoteRefId );
			 

			try
			{
				//fixes XAPI-33: changed stream to $is
				Inx_Apiimpl_Core_Uploader::upload( $ref, $is, $ud->maxChunkSize, false );
				return $this->_oService->commitUpload( $this->_oSessionContext->sessionId(), $ref->refId() );


			}
			catch( Inx_Api_IOException $x )
			{
				if( $ref !== null )
				$ref->release( false );
				return false;
			}
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
			if( $ref !== null )
			$ref->release( false );
			return null;
		}
		if( $ref !== null )
		$ref->release( false );

	}


	public function remove( $secretId, $key )
	{
		try
		{
			$this->_oService->remove( $this->_oSessionContext->sessionId(), $secretId, $key );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
			return null;
		}
	}


	public function removeAll( $secretId )
	{
		try
		{
			$this->_oService->removeAll( $this->_oSessionContext->sessionId(), $secretId );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
			return null;
		}
	}

}
