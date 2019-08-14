<?php
class Inx_Apiimpl_Webpage_WebpageImpl implements Inx_Api_Webpage_Webpage
{
	protected $_oSessionContext;

	protected $_oData;


	public function __construct( Inx_Apiimpl_SessionContext $oSessionContext, stdClass $oData )
	{
		$this->_oSessionContext = $oSessionContext;
		$this->_oData = $oData;
	}


	public function commitUpdate()
	{
		//not implemented for webpage...
	}


	public function reload()
	{
		try
		{
			$service = $this->_oSessionContext->getService( Inx_Apiimpl_SessionContext::WEBPAGE_SERVICE );
			$this->_oData = $service->get( $this->_oSessionContext->createCxt(), $this->_oData->id );

			if( $this->_oData == null )
				throw new Inx_Api_DataException( "webpage is deleted" );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
		}
	}


	public function getCreationDate()
	{
		return Inx_Apiimpl_TConvert::convert( $this->_oData->creationDate );
	}


	public function getId()
	{
		return $this->_oData->id;
	}


	public function getName()
	{
		return $this->_oData->name;
	}


	public function getServerUrl()
	{
		return $this->_oData->serverUrl;
	}


	public function getSubType()
	{
		return $this->_oData->subType;
	}


	public function getType()
	{
		return $this->_oData->type;
	}


	public static function convert( Inx_Apiimpl_SessionContext $oSessionContext, stdClass $oData )
	{
		if( $oData == null )
			return null;

		return new Inx_Apiimpl_Webpage_WebpageImpl( $oSessionContext, $oData );
	}


	public static function convertList( Inx_Apiimpl_SessionContext $oSessionContext, $aData )
	{
		if( $aData == null || count($aData) == 0 )
			return array();

		$rs = array();

		foreach( $aData as $i => $val )
		{
			if( $val != null )
				$rs[$i] = new Inx_Apiimpl_Webpage_WebpageImpl( $oSessionContext, $val );
		}

		return $rs;
	}
}