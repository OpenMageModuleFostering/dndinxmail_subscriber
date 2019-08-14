<?php
/**
 * ListImpl
 * 
 * @version $Revision: 7335 $ $Date: 2007-09-10 14:58:22 +0200 (Mo, 10 Sep 2007) $ $Author: sbn $
 */
class Inx_Apiimpl_List_ListImpl implements Inx_Api_List_ListContext
{
    /** defined in com.inxmail.xpro.InxmailConstants*/
	const SYSTEM_LIST         = 1;
    const STANDARD_LIST       = 2;
    const DYNAMIC_LIST        = 3;
    const ADMINISTRATION_LIST = 4;
    
    const MAX_ATTRIBUTES = 5;
    
    protected $_oPropertyContext = null;
		
    public $oSessionContext;

    public $oListData;

    protected $_aChangedAttrs;

    
	public function __construct( Inx_Apiimpl_SessionContext $oSc, $oData=null )
	{
	    $this->oSessionContext = $oSc;
	    $this->oListData = $oData;
	    if ($oData === null)
	        $this->createListData();
	}
	
	public function getId()
	{
		return $this->oListData->id;
	}

	public function getListType()
	{
		return $this->oListData->listType;
	}

	public function getName()
	{
		return $this->oListData->name;
	}
	
	public function getDescription()
	{
	    if (isset($this->oListData->description->value))
	        return $this->oListData->description->value ;
	}

	public function getCreationDatetime()
	{
		if (isset($this->oListData->creationDatetime->value))
	        return $this->oListData->creationDatetime->value;
	}
	
	public function updateName( $sName )
	{
	    $this->_writeAccess( Inx_Api_List_ListContext::ATTRIBUTE_NAME );
	    $this->oListData->name = $sName;
	}
	
	public function updateDescription( $sDesc )
	{
	    $this->_writeAccess(Inx_Api_List_ListContext::ATTRIBUTE_DESCRIPTION );
	    $this->oListData->description = new stdClass();
	    $this->oListData->description->value = $sDesc;
	}
	
	/**
	 * @throws DataException
	 */
	public function reload() 
	{
	    try
	    {
	        $oService = $this->oSessionContext->getService( Inx_Apiimpl_SessionContext::LIST_SERVICE );
		    $this->oListData = $oService->get( $this->oSessionContext->sessionId(), $this->oListData->id );
		    $this->_aChangedAttrs = null;
			
			if( $this->oListData === null )
			    throw new Inx_Api_DataException( "list deleted" );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->oSessionContext->notify( $x );
		}
	}

	/**
	 * @throws UpdateException, DataException
	 */
	public function commitUpdate() 
	{
	    try {
	        $oService = $this->oSessionContext->getService( Inx_Apiimpl_SessionContext::LIST_SERVICE);
	        $oReturn = $oService->update( $this->oSessionContext->sessionId(), $this->oListData, Inx_Apiimpl_TConvert::arrBoolToArrTBool($this->_aChangedAttrs ));//FIXME convert for soap
			$this->oListData = $oReturn->value;
	        $this->_aChangedAttrs = null;
			
			if( $this->oListData == null )
			    throw new Inx_Api_DataException( "list deleted" );
	    }
	    catch (Inx_Apiimpl_SoapException $e) {
	        throw new Inx_Api_UpdateException( $e->getMessage(), $e->getCode(), 
			            $e->oReturnObj->excDesc->source);
	    }
		catch(Inx_Api_RemoteException $x ) {
			$this->oSessionContext->notify( $x );
		}
	}
	
	/**
	 * @throws FeatureNotAvailableException
	 */
	public function isFeatureEnabled( $iFeatureId )  
	{
	    if (!is_int($iFeatureId)) {
	        throw new Inx_Api_IllegalArgumentException('Integer parameter $iFeatureId expected, got '.gettype($iFeatureId));
	    }
	    
	    $aFeatureIds = Inx_Apiimpl_TConvert::TArrToArr($this->oListData->featureIds);
	    $iKey = array_search($iFeatureId, $aFeatureIds);
	    if ($iKey === false) {
	        throw new Inx_Api_FeatureNotAvailableException( $iFeatureId );
	    }
	    
	    return isset($this->oListData->featureEnabled[$iKey]->value) && ($this->oListData->featureEnabled[$iKey]->value == true);
	}
	
	/**
	 * @throws SecurityException, FeatureNotAvailableException
	 */
	public function enableFeature( $iFeatureId ) 
	{
	    if (!is_int($iFeatureId)) {
	        throw new Inx_Api_IllegalArgumentException('Integer parameter $iFeatureId expected, got '.gettype($iFeatureId));
	    }
	    $oService = $this->oSessionContext->getService( Inx_Apiimpl_SessionContext::LIST_SERVICE );
	    try {
	        $oResult = $oService->setFeatureEnabled($this->oSessionContext->sessionId(), $this->getId(),
	                                        $iFeatureId, true);
            $this->oListData = $oResult->listData;
            return $oResult->result;
	    }
	    catch(Inx_Apiimpl_SoapException $ex) {
	        throw new Inx_Api_FeatureNotAvailableException($iFeatureId);
	    }
	    catch(Inx_Api_RemoteException $x) {
	        $this->oSessionContext->notify( $x);
	        return false;
	    }

	}
	
	/**
	 * @throws SecurityException, FeatureNotAvailableException
	 */
	public function disableFeature( $iFeatureId ) 
	{
	    if (!is_int($iFeatureId)) {
	        throw new Inx_Api_IllegalArgumentException('Integer parameter $iFeatureId expected, got '.gettype($iFeatureId));
	    }
	    $oService = $this->oSessionContext->getService( Inx_Apiimpl_SessionContext::LIST_SERVICE );
		try {
	        $oResult = $oService->setFeatureEnabled($this->oSessionContext->sessionId(), $this->getId(),
	                                        $iFeatureId, false);
            $this->oListData = $oResult->listData;
            return $oResult->result;
	    }
	    catch(Inx_Apiimpl_SoapException $ex) {
	        throw new Inx_Api_FeatureNotAvailableException($iFeatureId);
	    }
	    catch(Inx_Api_RemoteException $x) {
	        $this->oSessionContext->notify( $x);
	        return false;
	    }

	}
	
	
	public function findProperty( $sPropertyName )
	{
		if( $this->_oPropertyContext == null )
			$this->_oPropertyContext = new Inx_Apiimpl_Property_PropertyContext( $this->oSessionContext, $this->getId() );
		
		$oPropertyData = $this->_oPropertyContext->findByName( $sPropertyName );
		if( $oPropertyData == null )
		    throw new Inx_Api_IllegalArgumentException( "unknown property: " . $sPropertyName );
		
		return new Inx_Apiimpl_Property_PropertyImpl( $this->_oPropertyContext, $oPropertyData );
	}
	
	
	public function selectProperties()
	{
        if( $this->_oPropertyContext == null )
			$this->_oPropertyContext = new Inx_Apiimpl_Property_PropertyContext( $this->oSessionContext, $this->getId() );
		return $this->_oPropertyContext->selectAll();
	}
	
	
	protected function _writeAccess( $iAttrIndex )
	{
		if( $this->_aChangedAttrs == null )
		{
		    $this->_aChangedAttrs = array_fill(0, self::MAX_ATTRIBUTES, false);
		}
		$this->_aChangedAttrs[$iAttrIndex] = true;
	}

	public static function convertList(Inx_Apiimpl_SessionContext $oSc, $aListDatas) 
	{
	    $aRet = array(); 
	    foreach($aListDatas as $oListData) {
	        $aRet[] = self::convertBO($oSc, $oListData);
	    }
	    return $aRet;
	}
	
	public static function convertBO(Inx_Apiimpl_SessionContext $oSc, $oListData) 
	{
	    if ($oListData == null) {
	        return null;
	    }
	    $iType = $oListData->listType;
	    switch($iType) {
	        case self::STANDARD_LIST:
	            return new Inx_Apiimpl_List_StandardListImpl( $oSc, $oListData );
	        case self::DYNAMIC_LIST:
	            return new Inx_Apiimpl_List_FilterListImpl( $oSc, $oListData );
	        case self::SYSTEM_LIST:
	            return new Inx_Apiimpl_List_SystemListImpl( $oSc, $oListData );
	        case self::ADMINISTRATION_LIST:
	            return new Inx_Apiimpl_List_AdminListImpl( $oSc, $oListData );
	        default:
	            throw new Inx_Api_IllegalArgumentException('illegal list type: '.$iType);
	    }
	}

	
	public function createListData() 
	{
	    $this->oListData = new stdClass;
	    $this->oListData->id = null;
	    $this->oListData->listType = null;
	    $this->oListData->name = null;
	    $this->oListData->description = null;
	    $this->oListData->creationDatetime = null;
	    $this->oListData->filterStmt = null;
	    $this->oListData->featureIds = null;
	    $this->oListData->featureEnabled = null;
	    
	}
	
	public function getListSize( $computeNow=false )
	{
		  $oService = $this->oSessionContext->getService( Inx_Apiimpl_SessionContext::LIST_SERVICE );
		  try
		  {
			$lszDto = $oService->getListSizeRequest( $this->oSessionContext->sessionId(), $this->getId(), $computeNow );
			return  new Inx_Apiimpl_List_ListSizeImpl( $lszDto->size, Inx_Apiimpl_TConvert::convert( $lszDto->creationDatetime ) );
		  }
	      catch(Inx_Apiimpl_SoapException $ex) {
	         throw new Inx_Api_DataException( "list deleted" );
	      }
	      catch(Inx_Api_RemoteException $x) {
	        $this->oSessionContext->notify( $x);
	        return new Inx_Apiimpl_List_ListSizeImpl( 0, '12:45 1.1.1900' );
	      }
	}


}
