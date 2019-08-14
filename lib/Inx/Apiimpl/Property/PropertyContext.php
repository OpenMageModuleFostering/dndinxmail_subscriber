<?php


/**
 * PropertyContext
 * 
 * @version $Revision: 2934 $ $Date: 2005-07-04 15:00:09 +0000 (Mo, 04 Jul 2005) $ $Author: bgn $
 */
class Inx_Apiimpl_Property_PropertyContext
{

    private $_oSessionContext;

    private $_oService;

    private $_iListContextId;
    
    
    public function __construct( Inx_Apiimpl_SessionContext $oSC, $iListContextId )
    {
        $this->_oSessionContext = $oSC;
        $this->_iListContextId = $iListContextId;
        $this->_oService = $this->_oSessionContext->getService( Inx_Apiimpl_SessionContext::PROPERTY_SERVICE );
    }
    
    
    public function findByName( $sPropertyName )
    {
        try
        {
	        return $this->_oService->findByName($this->_oSessionContext->sessionId(), 
	                                    $this->_iListContextId, $sPropertyName );
	    }
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
			return null;
		}
    }
    
    
    public function selectAll()
    {
        try
        {
	        return new Inx_Apiimpl_Property_PropertyResultSet( 
	                    $this->_oSessionContext, 
	                    $this->_oService->selectAll( $this->_oSessionContext->sessionId(), $this->_iListContextId ), 
	                    $this );
	    }
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
			return null;
		}
    }
    
    
    public function get( $iId )
    {
        if (!is_int($iId)) {
	        throw new Inx_Api_IllegalArgumentException('Integer parameter type $iId expected, got '.gettype($iId));
	    }
        try
        {
	        return $this->_oService->get( $this->_oSessionContext->sessionId(), $this->_iListContextId, $iId );
	    }
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
			return null;
		}
    }
    
    /**
     * @throws UpdateException
     */
    public function update( $oPropertyData, $aChangedAttrs ) 
    {
        try {
            $oHolder = $this->_oService->update( 
                        $this->_oSessionContext->sessionId(), 
                        $this->_iListContextId, 
                        $oPropertyData,
                        Inx_Apiimpl_TConvert::arrToTArr( $aChangedAttrs ) );
            return $oHolder->value;
	    }
	    catch (Inx_Apiimpl_SoapException $x) {
	        throw new Inx_Api_UpdateException($x->getMessage(), $x->getCode(), $x->oReturnObj->excDesc->source);
	    }
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
			return null;
		}
    }
    
    
    public function convert( $aPropertyData = array() )
    {
        $aReturn = array();
        foreach($aPropertyData as $oPropData)
        {
            $aReturn[] = new Inx_Apiimpl_Property_PropertyImpl($this, $oPropData);
        }
        return $aReturn;
    }
    
	public function parseApprovalProperty( $internalValue )
	{
		try
		{
			$data = new stdClass();
			$data->value = Inx_Apiimpl_TConvert::stringToTString($internalValue);
			$apd = $this->_oService->parseApprovalProperty( $this->_oSessionContext->sessionId(), $data );
			
			if( $apd->excDesc != null )
				throw new Inx_Api_IllegalArgumentException( $apd->excDesc->getMsg() );
			$apv = new Inx_Api_Property_ApprovalPropertyValue( $apd->approvalType, $apd->id1, $apd->id2 );
			return $apv;
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
			return null;
		}
	}


	public function createApprovalPropertyValue( $value )
	{
		try
		{

			$iapd = $this->_oService->getInternalApprovalPropertyValue( $this->_oSessionContext->sessionId(), $value->getApprovalType(),
			 $value->getPrimaryApproverId(), $value->getSecondaryApproverId() );
			if( $iapd->excDesc != null )
				throw new Inx_Api_IllegalArgumentException( $iapd->excDesc->getMsg() );
			if( $iapd->internalValue === null )
				return null;
			return Inx_Apiimpl_TConvert::convert( $iapd->internalValue );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
			return null;
		}
	}
    
    
    
}
