<?php

class Inx_Apiimpl_Core_DelegateBOResultSet extends Inx_Apiimpl_Core_AbstractBOResultSet
{
	private $_oDelegate;
	
	
	public function __construct( Inx_Apiimpl_SessionContext $oSc, Inx_Apiimpl_Core_BOResultSetDelegate $oDelegate, 
			$sRemoteRefId, $iSize, $oFirstChunk )
	{
		parent::__construct( $oSc, $sRemoteRefId, $iSize, $oFirstChunk );
		
		$this->_oDelegate = $oDelegate;
	}
	
	/**
	 * @throws RemoteException
	 */
    protected function _removeBOs( $aIndexRanges ) 
    {
    	return $this->_oDelegate->removeBOs( $this->_remoteRef(), $aIndexRanges );
    }
    
    /**
     * @throws RemoteException
     */
    protected function _fetchBOs( $iIndex, $iDirection )
    {
    	return $this->_oDelegate->fetchBOs( $this->_remoteRef(), $iIndex, $iDirection );
    }
}