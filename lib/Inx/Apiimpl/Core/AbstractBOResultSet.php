<?php

abstract class Inx_Apiimpl_Core_AbstractBOResultSet extends Inx_Apiimpl_RemoteObject 
                                                    implements Inx_Api_BOResultSet
{
	protected $_oBuffer = null;

	protected $_iLastAccessedIndex = -1;
	
	protected $_iSize;
	
    
    public function __construct( Inx_Apiimpl_SessionContext $oSc, $sRemoteRefId, $iSize, $aFirstChunk )
	{
        $this->_oBuffer = new Inx_Apiimpl_Util_IndexedBuffer();
	    parent::__construct( $oSc, $sRemoteRefId );
        
        $this->_iSize = $iSize;
        
        if( $aFirstChunk != null && count($aFirstChunk) > 0 )
            $this->_oBuffer->setBuffer( 0, $aFirstChunk );
	}
    
    /**
     * @throws RemoteException
     */
    protected abstract function _removeBOs( $aIndexRanges );
    
    /**
     * @throws RemoteException
     */
    protected abstract function _fetchBOs( $iIndex, $iDirection );

    /**
     * @throws DataException
     */
	public function get( $iIndex ) 
	{
	    if (!is_int($iIndex)) {
	        throw new Inx_Api_IllegalArgumentException('Integer parameter $iIndex expected');
	    }
	    
	    $this->check();
	    
		if( $iIndex < 0 || $iIndex >= $this->_iSize )
			throw new Inx_Api_IndexOutOfBoundsException( "illegal index: " . $iIndex . " / size: " . $this->_isReleased() );
		try
		{
			
		    $oBo = $this->_oBuffer->getObject( $iIndex );
			
			if( $oBo != null )
				return $oBo;
			else
				throw new Inx_Api_DataException( "BusinessObject not found" );
		}
		catch( Inx_Apiimpl_Util_IndexException $x )
		{
			try
			{	
				if( $iIndex >= $this->_iLastAccessedIndex )
				{
					$this->_oBuffer->setBuffer( $iIndex, $this->_fetchBOs( $iIndex, Inx_Apiimpl_Constants::FETCH_FORWARD_DIRECTION ) );
				}
				else
				{
					$aOa = $this->_fetchBOs( $iIndex, Inx_Apiimpl_Constants::FETCH_BACKWARD_DIRECTION );
					$this->_oBuffer->setBuffer( $iIndex - count($aOa) + 1, $aOa );
				}
				$this->_iLastAccessedIndex = $iIndex;
			}
			catch( Inx_Api_RemoteException $rx )
			{
				$this->_notify( $rx );
			}	
			try
			{
				$oBo = $this->_oBuffer->getObject( $iIndex );
				if( $oBo != null )
					return $oBo;
				else
					throw new Inx_Api_DataException( "BusinessObject not found" );
			}
			catch( Inx_Apiimpl_Util_IndexException $ix )
			{
				throw new Inx_Api_APIException( "implementation error in AbstractBOResultSet " . $ix->getMessage(), $ix );
			}
		}
	}
	
    
    public function size()
    {
    	return $this->_iSize;
    }

    
    public function remove( Inx_Api_IndexSelection $oSelection )
    {
        $this->check();
    	Inx_Apiimpl_Util_SelectionUtils::checkIndex( $oSelection, $this->_iSize );
    	try
		{	
    		$iNewSize = $this->_iSize - $oSelection->getSelectionCount();
    		$this->_oBuffer->clear();
    		$iRetSize = $this->_removeBOs( Inx_Apiimpl_Util_SelectionUtils::convertToArray( $oSelection ) );
    		if( $iRetSize != -1 )
    		    $this->_iSize = $iRetSize;
    		
    		return $this->_iSize == $iNewSize;
		}
		catch( Inx_Api_RemoteException $rx )
		{
		    $this->_notify( $rx );
			return false;
		}
    }

    
    public function close()
    {
    	$this->_release( false );
    }
    
    
    protected function check()
    {
        if( $this->_isReleased() )
            throw new Inx_Api_APIException( "result set is closed" );
    }
}