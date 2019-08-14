<?php

/**
 * PropertyResultSet
 * 
 * @version $Revision: 2934 $ $Date: 2005-07-04 15:00:09 +0000 (Mo, 04 Jul 2005) $ $Author: bgn $
 */
class Inx_Apiimpl_Property_PropertyResultSet extends Inx_Apiimpl_Core_AbstractBOResultSet
{
	
    protected $_oPropertyService;

    protected $_oPropertyContext;

	
	public function __construct( Inx_Apiimpl_SessionContext $oSc, $oResultSet, Inx_Apiimpl_Property_PropertyContext $oPropertyContext )
	{
		
		parent::__construct($oSc, $oResultSet->remoteRefId, $oResultSet->size, $oPropertyContext->convert($oResultSet->data));
		        
		$this->_oPropertyContext = $oPropertyContext;
        $this->_oPropertyService = $oSc->getService( Inx_Apiimpl_SessionContext::PROPERTY_SERVICE );
	}
	
	/**
	 * @throws RemoteException
	 */
    protected function _removeBOs( $aIndexRanges ) 
    {
        // properties can not remove
        return -1;
    }
    
    /**
     * @throws RemoteException
     */
    protected function _fetchBOs( $iIndex, $iDirection )
    {
        return $this->_oPropertyContext->convert( $this->_oPropertyService->fetch(
	        $this->_sessionId(), $this->_refId(), $iIndex, $iDirection ) );
    }

}