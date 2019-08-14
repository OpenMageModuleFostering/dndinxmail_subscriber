<?php
/**
 * ReportResultImpl
 * 
 * @version $Revision: 5007 $ $Date: 2006-10-17 11:39:33 +0000 (Di, 17 Okt 2006) $ $Author: bgn $
 */
class Inx_Apiimpl_Reporting_DownloadableResultImpl implements Inx_Api_Reporting_DownloadableResult
{

	protected $_oSessionContext;

	protected $_oTicket;

	protected $_sFormatType;
	
	protected $_sCreationDate;
	
	
	public function __construct( Inx_Apiimpl_SessionContext $sc, $oResultData,
			Inx_Apiimpl_Reporting_ReportTicketImpl $oTicket )
	{
		$this->_oSessionContext = $sc;
		$this->_oTicket = $oTicket;
		$this->_sFormatType = $oResultData->formatType;
		$this->_sCreationDate = Inx_Apiimpl_TConvert::convert( $oResultData->creationDate );
	}
	
	
	/**
	 * @see com.inxmail.xpro.api.reporting.DownloadableResult#getInputStream()
	 */
	public function getInputStream()
	{
		try
		{
			$oService = $this->_oTicket->_remoteRef()->getService(
					Inx_Apiimpl_SessionContext::REPORTING_SERVICE );
			$sStreamRefId = $oService->createStream( 
			    $this->_oSessionContext->createCxt(), 
			    $this->_oTicket->_remoteRef()->refId() 
			);
			return new Inx_Apiimpl_Core_RemoteInputStream( $this->_oSessionContext->createRemoteRef( $sStreamRefId ) );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
			return null;
		}
	}
	
	
	/**
	 * @see com.inxmail.xpro.api.reporting.DownloadableResult#getContentType()
	 */
	public function getContentType()
	{
		return $this->_sFormatType;
	}
	
	
	/**
	 * @see com.inxmail.xpro.api.reporting.DownloadableResult#getCreationDate()
	 */
	public function getCreationDate()
	{
		return $this->_sCreationDate;
	}
}
