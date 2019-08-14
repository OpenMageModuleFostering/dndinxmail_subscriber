<?php
/**
 * Inx_Apiimpl_ReportTicket_ReportTicketImpl
 * 
 * @version $Revision: 4685 $ $Date: 2006-09-19 12:23:02 +0000 (Di, 19 Sep 2006) $ $Author: bgn $
 */
class Inx_Apiimpl_Reporting_ReportTicketImpl 
                extends Inx_Apiimpl_RemoteObject implements Inx_Api_Reporting_ReportTicket
{

	protected $_oRequest;
	
	protected $_oResult;
	
	protected $_oReportException = null;
	
	protected $_blReportFinished = false;
	
	
	public function __construct( Inx_Apiimpl_SessionContext $sc, $oTicketData, Inx_Api_Reporting_ReportRequest $oRequest )
	{
		parent::__construct( $sc, $oTicketData->remoteRefId );
		$this->_oRequest = $oRequest;
		
		$this->setFetchData( $oTicketData->fetchData );
	}
	
	
	/**
	 * @see com.inxmail.xpro.api.reporting.ReportTicket#getReportRequest()
	 */
	public function getReportRequest()
	{
		return $this->_oRequest;
	}

	
	/**
	 * @see com.inxmail.xpro.api.reporting.ReportTicket#fetchDownloadableResult()
	 * @throws Inx_Api_Reporting_ReportException
	 */
	public function fetchDownloadableResult()
	{
		try
		{
			if( !$this->_blReportFinished )
			{
				$oService = $this->_remoteRef()->getService(
						Inx_Apiimpl_SessionContext::REPORTING_SERVICE );
				$oFetchData = $oService->fetch( $this->_remoteRef()->createCxt(), $this->_remoteRef()->refId() );
				$this->setFetchData( $oFetchData );
			}
			if( $this->_oReportException !== null )
				throw $this->_oReportException;
			
			return $this->_oResult;
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_remoteRef()->notify( $x );
			return null;
		}
	}

	
	/**
	 * @see com.inxmail.xpro.api.reporting.ReportTicket#close()
	 */
	public function close()
	{
		$this->_release( false );
	}

	
	protected function setFetchData( $oFetchData )
	{
		if( $oFetchData !== null )
		{
			if( $oFetchData->reportResult !== null )
			{
				$this->_oResult = new Inx_Apiimpl_Reporting_DownloadableResultImpl( 
				    $this->_remoteRef(), $oFetchData->reportResult, $this );
				$this->_blReportFinished = true;
			}
			if( $oFetchData->reportExcDesc !== null )
			{
				$this->_oReportException = new Inx_Api_Reporting_ReportException( $oFetchData->reportExcDesc->msg );
				$this->_blReportFinished = true;
			}
		}
	}
}
