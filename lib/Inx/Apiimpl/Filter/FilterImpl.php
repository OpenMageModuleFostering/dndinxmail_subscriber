<?php



/**
 * FilterImpl
 * 
 * @version $Revision$ $Date$ $Author$
 */
class Inx_Apiimpl_Filter_FilterImpl implements Inx_Api_Filter_Filter
{
	/**
	 * Session context
	 *
	 * @var Inx_Apiimpl_SessionContext
	 */
	protected $_oSc;
    
	/**
	 * Enter description here...
	 *
	 * @var stdClass
	 */
    protected $_oData;
    
    protected $_aChangedAttrs;

    
    public function __construct( Inx_Apiimpl_SessionContext $oSc, stdClass $oData )
    {
	    $this->_oSc = $oSc;
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
	 * @return String
	 */
	public function getName()
	{
		return $this->_oData->name->value;
	}

	/**
	 * Enter description here...
	 *
	 * @return String
	 */
	public function getStatement()
	{
		return $this->_oData->stmt->value;
	}
	
	public function getCreationDatetime()
	{
		return $this->_oData->creation->value;
	}
	
	public function updateName( $sName )
	{
	    $this->writeAccess( Inx_Api_Filter_Filter::ATTRIBUTE_NAME );
	    $this->_oData->name = Inx_Apiimpl_TConvert::TConvert($sName);
	}
	
	/**
	 * Enter description here...
	 *
	 * @param string $sStatement
	 */
	public function updateStatement( $sStatement )
	{
	    $this->writeAccess( Inx_Api_Filter_Filter::ATTRIBUTE_STATEMENT );
	    $this->_oData->stmt = Inx_Apiimpl_TConvert::TConvert($sStatement);
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
	
	public function updateListContextId( $iListContextId )
	{
	    if (!is_int($iListContextId)) {
		    throw new Inx_Api_IllegalArgumentException('Integer parameter $iListContextId expected, got '.gettype($iListContextId));
		}
	    $this->writeAccess( Inx_Api_Filter_Filter::ATTRIBUTE_LIST_CONTEXT_ID );
	    $this->_oData->listContextId = $iListContextId;
	}
	
	/**
	 * Enter description here...
	 *
	 * @return unknown
	 * @throws Inx_Api_UpdateException, Inx_Api_DataException
	 */
	public function commitUpdate()
	{
		$service = $this->_oSc->getService( Inx_Apiimpl_SessionContext::FILTER_SERVICE );
                
                // fixes XAPI-181: implement correct error handling
		try 
                {
			$r = $service->update( $this->_oSc->createCxt(),$this->_oData, Inx_Apiimpl_TConvert::arrToTArr( $this->_aChangedAttrs ) );
                        
                        if($r->excDesc != null)
                        {
                            throw new Inx_Api_UpdateException($r->excDesc->msg, $r->excDesc->type, 
			            $r->excDesc->source);
                        }
                        
                        $this->_oData = $r->value;
                        $this->_aChangedAttrs = null;

                        if($this->_oData === null )
                        {
                            throw new Inx_Api_DataException( "filter entry deleted" );
                        }
		} 
                catch (Inx_Api_RemoteException $e) 
                {
                        $this->_oSc->notify( $e );
		}
	}

	/**
	 * Enter description here...
	 *
	 * @throws Inx_Api_DataException
	 */
	public function reload()
	{
		try
	    {
			$service = $this->_oSc->getService( Inx_Apiimpl_SessionContext::FILTER_SERVICE );
		    $this->_oData = $service->get( $this->_oSc->createCxt(), $this->_oData->id );
		    $this->_aChangedAttrs = null;
			
			if($this->_oData === null )
			    throw new Inx_Api_DataException( "textmodule entry deleted" );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSc->notify( $e );
		}
	}
	
	
	public function writeAccess( $iAttrIndex )
	{
	    if (!is_int($iAttrIndex)) {
		    throw new Inx_Api_IllegalArgumentException('Integer parameter $iAttrIndex expected, got '.gettype($iAttrIndex));
		}
	    if( !isset($this->_aChangedAttrs))
			$this->_aChangedAttrs = array_fill(0, Inx_Apiimpl_Filter_FilterConstants::MAX_ATTRIBUTES, null);
		$this->_aChangedAttrs[ $iAttrIndex ] = true;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param Inx_Apiimpl_SessionContext $oSc
	 * @param stdClass|array $data
	 * @return Inx_Api_Filter_Filter
	 */
	public static function convert( Inx_Apiimpl_SessionContext $oSc, $data )
	{
		if ( is_array($data) ) {
			if( empty($data) )
				return array();
			
			$rs = array();
			
			foreach ($data as $i=>$value) {
				if($value != null )
					$rs[$i] = new Inx_Apiimpl_Filter_FilterImpl( $oSc, $value );
			}
			return $rs;
		} else {
			if($data === null )
				return null;
			
			return new Inx_Apiimpl_Filter_FilterImpl( $oSc, $data );	
		}
	}
}
