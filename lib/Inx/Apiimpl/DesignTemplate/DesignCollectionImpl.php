<?php
/**
 * @author nds
 * 
 */
class Inx_Apiimpl_DesignTemplate_DesignCollectionImpl 
                    implements Inx_Api_DesignTemplate_DesignCollection
{

	private $_oSessionContext;

	private $_oData;

	/**
	 * 
	 */
	public function __construct( Inx_Apiimpl_SessionContext $sc, stdClass $oData )
	{
		$this->_oSessionContext = $sc;
		$this->_oData = $oData;
	}

	/**
	 * @see com.inxmail.xpro.api.designtemplate.DesignCollection#getLastModificationDate()
	 */
	public function getLastModificationDate()
	{
	    return Inx_Apiimpl_TConvert::convert($this->_oData->last_save_date);
	}

	/**
	 * @see com.inxmail.xpro.api.designtemplate.DesignCollection#getName()
	 */
	public function getName()
	{
	    return Inx_Apiimpl_TConvert::convert($this->_oData->name);
	}
	
   /**
	* @see Inx_Api_DesignTemplate_DesignCollection::getDisplayName()
	*/
	public function getDisplayName()
	{
		return Inx_Apiimpl_TConvert::convert( $this->_oData->displayName );
	}

	/**
	 * @see com.inxmail.xpro.api.designtemplate.DesignCollection#getTemplates()
	 */
	public function getTemplates()
	{
		$ad = $this->_oData->templates;
		$ret = array();
		foreach ($ad as $key => $d) {
		    $ret[$key] = Inx_Apiimpl_DesignTemplate_TemplateImpl::convert( $d ); 
		}
		return $ret;
	}

	/**
	 * @see com.inxmail.xpro.api.designtemplate.DesignCollection#getVendor()
	 */
	public function getVendor()
	{
		
	    return Inx_Apiimpl_TConvert::convert( $this->_oData->vendor );
	}

	/**
	 * @see com.inxmail.xpro.api.designtemplate.DesignCollection#getVendorURL()
	 */
	public function getVendorURL()
	{
		return Inx_Apiimpl_TConvert::convert( $this->_oData->vendor_url );
	}

	/**
	 * @see com.inxmail.xpro.api.designtemplate.DesignCollection#getVersion()
	 */
	public function getVersion()
	{
		return Inx_Apiimpl_TConvert::convert( $this->_oData->version );
	}

	/**
	 * @see com.inxmail.xpro.api.BusinessObject#commitUpdate()
	 * @throws UpdateException, DataException
	 */
	public function commitUpdate()
	{
		throw new Inx_Api_UpdateException( 
			"No updates are allowed for DesignCollections. Please reimport the new DesignCollection.",
		    Inx_Api_UpdateException::ERROR_TYPE_ILLEGAL_OPERATION,
			Inx_Api_UpdateException::ERROR_SOURCE_NOT_SPECIFIED );
	}

	/**
	 * @throws DataException
	 */
	public function reload()
	{
		try
		{
			$oService = $this->_oSessionContext
				->getService( Inx_Apiimpl_SessionContext::DESIGN_COLLECTION2_SERVICE );
			$this->_oData = $oService->get($this->_oSessionContext->createCxt(), $this->_oData->id);

			if( $this->_oData === null )
				throw new Inx_Api_DataException( "design collection entry deleted" );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
		}
	}

	/**
	 * @see com.inxmail.xpro.api.BusinessObject#getId()
	 */
	public function getId()
	{
		return $this->_oData->id;
	}

	public static function convert( Inx_Apiimpl_SessionContext $sc2, array $oData2 )
	{
		$aRet = array();
		foreach($oData2 as $key => $val) {
		    $aRet[$key] = new Inx_Apiimpl_DesignTemplate_DesignCollectionImpl($sc2, $val);
		}
		return $aRet;
	}
}
