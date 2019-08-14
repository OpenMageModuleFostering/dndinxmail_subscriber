<?php
		


/**
 * ResourceImpl
 * 
 * @version $Revision: 3268 $ $Date: 2005-09-26 09:33:26 +0000 (Mo, 26 Sep 2005) $ $Author: bgn $
 */
class Inx_Apiimpl_Resource_ResourceImpl implements Inx_Api_Resource_Resource
{
    
	/**
	 * Enter description here...
	 *
	 * @var SessionContext
	 */
    protected $_oSc;
    
    /**
     * Enter description here...
     *
     * @var ResourceData
     */
    protected $_oData;
    
    
    public function __construct( Inx_Apiimpl_SessionContext $oSc, stdClass $oData )
    {
        $this->_oSc = $oSc;
        $this->_oData = $oData;
    }
    
    
	public function getId()
	{
	    return $this->_oData->id;
	}
    
	/**
	 * Enter description here...
	 *
	 * @throws UpdateException, DataException
	 */
	public function commitUpdate()
	{
	    $this->reload();
	}
	
	/**
	 * Enter description here...
	 *
	 * @return unknown
	 * @throws DataException
	 */
	public function reload()
	{
	    try
	    {
	        $service = $this->_oSc->getService( Inx_Apiimpl_SessionContext::RESOURCE_SERVICE );
            $retData = $service->get( $this->_oSc->sessionId(), $this->_oData->id );
            
	        if( $retData === null ) {
	            throw new Inx_Api_DataException( "deleted object" );
	        }
	        else {
	            $this->_oData = $retData;
	        }
	    }
	    catch( Inx_Api_RemoteException $e )
	    {
	        $this->_oSc->notify( $e );
	    }
	}
    
	/**
	 * Enter description here...
	 *
	 * @return String
	 */
    public function getName()
    {
        return $this->_oData->name;
    }
    
    /**
     * Enter description here...
     *
     * @return Date
     */
    public function getCreationDatetime()
    {
        return $this->_oData->creationDatetime->value;
    }
    
    /**
     * Enter description here...
     * 
     * @return long
     */
    public function getSize()
    {
        return $this->_oData->size;
    }
    
    /**
     * Enter description here...
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->_oData->userId;
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
    public function getMailingId()
    {
        return $this->_oData->mailingId;
    }
    
    /**
     * Enter description here...
     *
     * @return int
     */
    public function getSharingType()
    {
        return $this->_oData->sharingType;
    }
    
    /**
     * Enter description here...
     *
     * @return String
     */
    public function getContentType()
    {
        return $this->_oData->contentType;
    }
    
    /**
     * 
     * @return Inx_Apiimpl_Core_RemoteInputStream
     */
    public function getInputStream()
    {
        try
	    {
            $service = $this->_oSc->getService( Inx_Apiimpl_SessionContext::RESOURCE_SERVICE );
            return new Inx_Apiimpl_Core_RemoteInputStream( $this->_oSc->createRemoteRef( 
                    $service->getInputStream( $this->_oSc->sessionId(), $this->_oData->id ) ) );
	    }
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSc->notify( $e );
			return null;
		}
    }
    
    /**
     * Enter description here...
     * @return Resource[]
     */
	public static function convert( Inx_Apiimpl_SessionContext $oSc, $aData )
	{
	    if( empty($aData) )
	        return null;
	    
	    $rs = array();
	    foreach ($aData as $i=>&$val) {
	    	if (! is_null($val))
	    		$rs[$i] = new Inx_Apiimpl_Resource_ResourceImpl( $oSc, $val );
	    }
	    return $rs;
 	}

}
