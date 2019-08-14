<?php
class Inx_Apiimpl_TriggerMailing_TriggerMailingResultSet extends Inx_Apiimpl_Core_AbstractBOResultSet
{
	protected $service;


	public function __construct( Inx_Apiimpl_SessionContext $sc, stdClass $resultSet )
	{
                parent::__construct( $sc, $resultSet->remoteRefId, $resultSet->size, 
                    Inx_Apiimpl_TriggerMailing_TriggerMailingImpl::convert( $sc, $resultSet->data ) );

		$this->service = $sc->getService( Inx_Apiimpl_SessionContext::TRIGGER_MAILING_SERVICE );
	}


	protected function _removeBOs( $aIndexRanges )
	{
		return $this->service->removeBOs( $this->_createCxt(), $this->_refId(), $aIndexRanges );
	}


	protected function _fetchBOs( $iIndex, $iDirection )
	{
		return Inx_Apiimpl_TriggerMailing_TriggerMailingImpl::convert( $this->_remoteRef(), 
                        $this->service->fetchBOs( $this->_createCxt(), $this->_refId(), $iIndex, $iDirection ) );
	}
}