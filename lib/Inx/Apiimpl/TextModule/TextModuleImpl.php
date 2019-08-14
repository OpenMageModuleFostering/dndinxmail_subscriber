<?php
class Inx_Apiimpl_TextModule_TextModuleImpl implements Inx_Api_TextModule_TextModule
{
    protected $_oSessionContext;
    
    protected $_oData = null;
    
    protected $_aChangedAttrs = null;

    const MAX_ATTRIBUTES = 5;
    
    public function __construct( Inx_Apiimpl_SessionContext $sc, $oData )
    {
	    $this->_oSessionContext = $sc;
	    $this->_oData = $oData;
	}
    
	public function getId()
	{
		return $this->_oData->id;
	}

	public function getName()
	{
		return Inx_Apiimpl_TConvert::convert( $this->_oData->name);
	}
	
	public function getHtmlTextContent()
	{
		return Inx_Apiimpl_TConvert::convert( $this->_oData->htmlTextContent );
	}

	public function getListContextId()
	{
		return $this->_oData->listContextId;
	}

	public function getMimeType()
	{
		return $this->_oData->mimeType;
	}

	public function getPlainTextContent()
	{
		return Inx_Apiimpl_TConvert::convert( $this->_oData->plainTextContent );
	}

	public function updateHtmlTextContent( $sHtmlTextContent )
	{
		$this->_writeAccess( Inx_Api_TextModule_TextModule::ATTRIBUTE_HTML_TEXT);
		$this->_oData->htmlTextContent = Inx_Apiimpl_TConvert::TConvert($sHtmlTextContent);

	}

	public function updateName( $sName )
	{
	    $this->_writeAccess( Inx_Api_TextModule_TextModule::ATTRIBUTE_NAME );
	    $this->_oData->name = Inx_Apiimpl_TConvert::TConvert($sName);
	}

	public function updatePlainTextContent( $sPlainTextContent )
	{
		$this->_writeAccess( Inx_Api_TextModule_TextModule::ATTRIBUTE_PLAIN_TEXT );
		
	    $this->_oData->plainTextContent = Inx_Apiimpl_TConvert::TConvert($sPlainTextContent);
	}

	/**
	 * @throws UpdateException, DataException
	 */
	public function commitUpdate()
	{
		try
	    {
	        $oService = $this->_oSessionContext->getService( Inx_Apiimpl_SessionContext::TEXTMODULE_SERVICE );
			
	        $r = $oService->update( 
			    $this->_oSessionContext->createCxt(), 
			    $this->_oData, 
			    Inx_Apiimpl_TConvert::arrToTArr( $this->_aChangedAttrs ) );
			
			if (isset($r->value))
	            $this->_oData = $r->value;
	        else {
	            $this->_oData = null;
	        }
	        $this->_aChangedAttrs = null;
			    
			if( $this->_oData === null ) {
			    throw new Inx_Api_DataException( "textmodule entry deleted" );
			}
	    }
	    catch(Inx_Api_RemoteException $e) {
	        if ($e instanceof Inx_Apiimpl_SoapException) {
	            throw new Inx_Api_UpdateException($e->getMessage(), $e->getCode(), $e->oReturnObj->excDesc->source);
	        }
	        else {
	            $this->_oSessionContext->notify($e);
	        }
	    }
		
	}

	/**
	 * @throws DataException
	 */
	public function reload() 
	{
		try
	    {
			$oService = $this->_oSessionContext->getService( Inx_Apiimpl_SessionContext::TEXTMODULE_SERVICE );
		    $this->_oData = $oService->get( $this->_oSessionContext->createCxt(), $this->_oData->id);
		    $this->_aChangedAttrs = null;
			
			if( $this->_oData === null )
			    throw new Inx_Api_DataException( "textmodule entry deleted" );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify($x);
		}
	}
	
	protected function _writeAccess( $iAttrIndex )
	{
		if( $this->_aChangedAttrs === null )
			$this->_aChangedAttrs = array_fill(0, self::MAX_ATTRIBUTES, false);
		$this->_aChangedAttrs [ $iAttrIndex ] = true;
	}
	
	public static function convert( Inx_Apiimpl_SessionContext $sc, $oData )
	{
		if( $oData === null )
			return null;
		
		return new Inx_Apiimpl_TextModule_TextModuleImpl( $sc, $oData );
	}
	
	public static function convertArr( Inx_Apiimpl_SessionContext $sc, $aData )
	{
		if( $aData === null || count($aData) == 0 )
			return array();
		
	    $rs = array();
	    foreach($aData as $key => $val) {
	        $rs[$key] = new Inx_Apiimpl_TextModule_TextModuleImpl($sc, $val);
	    }

		return $rs;
	}
	
	public static function createNewData()
	{
	    $oRet = new stdClass;
	    $oRet->id = 0;
	    $oRet->listContextId = null;
	    $oRet->name = null;
	    $oRet->htmlTextContent = null;
	    $oRet->plainTextContent = null;
	    $oRet->mimeType = null;
	    return $oRet;
	}
	
	public function updateListContextId( $iListContextId )
	{
	    if (!is_int($iListContextId)) {
		    throw new Inx_Api_IllegalArgumentException('Wrong parameter $iListContextId type, integer expected');
		}
	    $this->_writeAccess( Inx_Api_TextModule_TextModule::ATTRIBUTE_LIST_CONTEXT_ID );
	    $this->_oData->listContextId = $iListContextId ;
	}
	
	public function updateMimeType( $iMimeType )
	{
	    if (!is_int($iMimeType)) {
		    throw new Inx_Api_IllegalArgumentException('Wrong parameter $iMimeType type, integer expected');
		}
	    $this->_writeAccess( Inx_Api_TextModule_TextModule::ATTRIBUTE_MIME_TYPE );
	    $this->_oData->mimeType =  $iMimeType ;
	}
}
