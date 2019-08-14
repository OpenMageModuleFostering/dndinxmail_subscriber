<?php


/**
 * MailingResultSet
 * 
 * @version $Revision: 5433 $ $Date: 2007-01-22 08:15:02 +0000 (Mo, 22 Jan 2007) $ $Author: bgn $
 */
class Inx_Apiimpl_Mailing_MailingResultSet extends Inx_Apiimpl_Core_AbstractBOResultSet
{
    protected $_oService;
	
	public function __construct( Inx_Apiimpl_SessionContext $oSc, stdClass $oResultSet )
	{
		parent::__construct( $oSc, $oResultSet->remoteRefId, $oResultSet->size,
		        Inx_Apiimpl_Mailing_MailingImpl::convert( $oSc, $oResultSet->data ) );
		
        $this->_oService = $oSc->getService( Inx_Apiimpl_SessionContext::MAILING6_SERVICE );
	}
	
	
	/**
	 * Enter description here...
	 *
	 * @param TInteger[] $aIndexRanges
	 * @return int
	 * @throws Inx_Api_RemoteException
	 */
    protected function _removeBOs(  $aIndexRanges ) 
    {
        return $this->_oService->removeBOs( $this->_createCxt(), $this->_refId(), $aIndexRanges );
    }
    
    /**
     * Enter description here...
     *
     * @param int $iIndex
     * @param int $iDirection
     * @return array of Inx_Api_BusinessObject's
     * @throws Inx_Api_RemoteException
     */
    protected function _fetchBOs( $iIndex, $iDirection ) 
    {
        return Inx_Apiimpl_Mailing_MailingImpl::convert( $this->_remoteRef(), $this->_oService->fetchBOs(
        		$this->_createCxt(), $this->_refId(), $iIndex, $iDirection ) );
    }

}
