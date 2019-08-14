<?php

class Inx_Apiimpl_MailingTemplate_MailingTemplateImpl implements Inx_Api_MailingTemplate_MailingTemplate
{
    /**
     * @var Inx_Apiimpl_SessionContext
     */
	protected $_oSessionContext;
    
    protected $_oData;
    
    protected $_aChangedAttrs;

    const MAX_ATTRIBUTES = 5;
    
    public function __construct( Inx_Apiimpl_SessionContext $sc, stdClass $oData )
    {
	    $this->_oSessionContext = $sc;
	    $this->_oData = $oData;
	}
    
	/**
	 * Enter description here...
	 *
	 * @return int
	 */
	public function getId()
	{
		return $this->_oData->id;
	}

	/**
	 * Enter description here...
	 *
	 * @return string
	 */
	public function getName()
	{
		return Inx_Apiimpl_TConvert::convert( $this->_oData->name );
	}
	
	
	/**
	 * Enter description here...
	 *
	 * @return string
	 */
	public function getHtmlTextContent()
	{
		return Inx_Apiimpl_TConvert::convert( $this->_oData->htmlTextContent );
	}

	/**
	 * Enter description here...
	 *
	 * @return int
	 */
	public function getListContextId()
	{
		return $this->_oData->listContextId;
	}

	/**
	 * Enter description here...
	 *
	 * @return int
	 */
	public function getMimeType()
	{
		return $this->_oData->mimeType;
	}

	/**
	 * Enter description here...
	 *
	 * @return string
	 */
	public function getPlainTextContent()
	{
		return Inx_Apiimpl_TConvert::convert( $this->_oData->plainTextContent );
	}

	/**
	 * Enter description here...
	 *
	 * @param string $sHtmlTextContent
	 */
	public function updateHtmlTextContent( $sHtmlTextContent )
	{
		$this->writeAccess( Inx_Api_MailingTemplate_MailingTemplate::ATTRIBUTE_HTML_TEXT );
	    $this->_oData->htmlTextContent = Inx_Apiimpl_TConvert::TConvert( $sHtmlTextContent );
	}

	/**
	 * Enter description here...
	 *
	 * @param string $name
	 */
	public function updateName( $name )
	{
	    $this->writeAccess( Inx_Api_MailingTemplate_MailingTemplate::ATTRIBUTE_NAME );
	    $this->_oData->name = Inx_Apiimpl_TConvert::TConvert( $name );
	}

	/**
	 * Enter description here...
	 *
	 * @param string $plainTextContent
	 */
	public function updatePlainTextContent( $plainTextContent )
	{
		$this->writeAccess( Inx_Api_MailingTemplate_MailingTemplate::ATTRIBUTE_PLAIN_TEXT );
	    $this->_oData->plainTextContent = Inx_Apiimpl_TConvert::TConvert( $plainTextContent );
	}

	/**
	 * Enter description here...
	 *
	 * @return unknown
	 * @throws Inx_Api_UpdateException, Inx_Api_DataException
	 */
	public function commitUpdate()
	{
		try
	    {
			$service = $this->_oSessionContext->getService( Inx_Apiimpl_SessionContext::MAILING_TEMPLATE_SERVICE );
			try {
				$dataHolder = $service->update( $this->_oSessionContext->createCxt(), $this->_oData, Inx_Apiimpl_TConvert::arrToTArr( $this->_aChangedAttrs ) );				
			} catch (Inx_Apiimpl_SoapException $e ) {
				throw new Inx_Api_UpdateException($e->getMessage(), $e->getCode(), $e->oReturnObj->excDesc->source);	
			}

			$this->_oData = $dataHolder->value;
	        $this->_aChangedAttrs = null;
			
			if( empty($this->_oData) )
			    throw new Inx_Api_DataException( "mailing template entry deleted" );
	    }
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
	    }
	}

	/**
	 * @throws Inx_Api_DataException
	 */
	public function reload()
	{
		try
	    {
			$service = $this->_oSessionContext->getService( Inx_Apiimpl_SessionContext::MAILING_TEMPLATE_SERVICE );
		    $this->_oData = $service->get( $this->_oSessionContext->createCxt(), $this->_oData->id );
		    $this->_aChangedAttrs = null;
			
			if( $this->_oData == null )
			    throw new Inx_Api_DataException( "mailing template entry deleted" );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
		}
	}
	
	/**
	 * Enter description here...
	 *
	 * @param int $iAttrIndex
	 */
	protected function writeAccess( $iAttrIndex )
	{
		if( empty($this->_aChangedAttrs) )
			$this->_aChangedAttrs = array_fill(0, self::MAX_ATTRIBUTES, false);
		$this->_aChangedAttrs[ $iAttrIndex ] = true;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param Inx_Apiimpl_SessionContext $sc
	 * @param stdClass|array $data
	 * @return Inx_Api_MailingTemplate_MailingTemplate | array
	 */
	public static function convert( Inx_Apiimpl_SessionContext $sc, $data )
	{
		if ($data instanceof stdClass) {
			if( empty($data) )
				return null;
			
			return new Inx_Apiimpl_MailingTemplate_MailingTemplateImpl( $sc, $data );
		} elseif (is_array($data)) {
			if( $data == null || sizeof($data) == 0 )
				return array();
			
			$rs = array();
			foreach ($data as $i=>$_data) {
				if($_data !== null)
					$rs[$i] = new Inx_Apiimpl_MailingTemplate_MailingTemplateImpl( $sc, $_data );
				else 
					$rs[$i] = null;
			}

			return $rs;
		}
	}
	
	/**
	 * Enter description here...
	 *
	 * @param int $iListContextId
	 */
	public function updateListContextId( $iListContextId )
	{
	    if (!is_int($iListContextId)) {
	        throw new Inx_Api_IllegalArgumentException('Integer parameter type $iListContextId expected, got '.gettype($iListContextId));
	    }
	    $this->writeAccess( Inx_Api_MailingTemplate_MailingTemplate::ATTRIBUTE_LIST_CONTEXT_ID );
	    $this->_oData->listContextId = $iListContextId;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param int $iMimeType
	 */
	public function updateMimeType( $iMimeType )
	{
	    if (!is_int($iMimeType)) {
	        throw new Inx_Api_IllegalArgumentException('Integer parameter type $iMimeType expected, got '.gettype($iMimeType));
	    }
	    $this-> writeAccess( Inx_Api_MailingTemplate_MailingTemplate::ATTRIBUTE_MIME_TYPE );
	    $this->_oData->mimeType = $iMimeType;
	}
}
