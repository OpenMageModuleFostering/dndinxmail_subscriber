<?php
/**
 * Inx_Apiimpl_Reporting_ReportEngineImpl
 * 
 * @version $Revision: 4685 $ $Date: 2006-09-19 12:23:02 +0000 (Di, 19 Sep 2006) $ $Author: bgn $
 */
class Inx_Apiimpl_Reporting_ReportEngineImpl implements Inx_Api_Reporting_ReportEngine
{

    protected $_oSessionContext;

    protected $_oService;
    
    
    
    public function __construct( Inx_Apiimpl_SessionContext $sc )
	{
		$this->_oSessionContext = $sc;
		$this->_oService = $sc->getService( Inx_Apiimpl_SessionContext::REPORTING_SERVICE );
	}

    
	/**
	 * @see com.inxmail.xpro.api.reporting.ReportEngine#generate(com.inxmail.xpro.api.reporting.ReportRequest, boolean)
	 */
	public function generate( Inx_Api_Reporting_ReportRequest $oRequest, $blIgnoreCache )
	{
		try
		{
			$aKeys = $oRequest->getParameterKeys();
			
			$aStrKeys = array();
			$aStrValues = array();
			
			foreach($aKeys as $i => $key) {
			    $aStrKeys[$i] = $key;
			    $aStrValues[$i] = $oRequest->getParameter($key); 
			}
			$params = new stdClass;
			$params->strKeys = $aStrKeys;
			$params->strValues = Inx_Apiimpl_TConvert::arrToTArr($aStrValues);
			$params->boolKeys = null;
			$params->boolValues = null;
			$params->intKeys = null;
			$params->intValues = null;
			$params->doubleKeys = null;
			$params->doubleValues = null;
			$params->datetimeKeys = null;
			$params->datetimeValues = null;
			$params->dateKeys = null;
			$params->dateValues = null;
			$params->timeKeys = null;
			$params->timeValues = null;

			$td = $this->_oService->generate( 
			    $this->_oSessionContext->createCxt(), 
			    $oRequest->getReportName(), 
			    $params,
				$oRequest->getOutputFormat(), 
				$oRequest->getOutputLocale(), 
				$oRequest->getOutputTimeZone(), 
				$blIgnoreCache );
			return new Inx_Apiimpl_Reporting_ReportTicketImpl( $this->_oSessionContext, $td, $oRequest );			
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
			return null;
		}
	}
	
	
	/**
	 * @see com.inxmail.xpro.api.reporting.ReportEngine#getReportNames()
	 */
	public function getReportNames()
	{
		try
		{
			return $this->_oService->getReportNames( $this->_oSessionContext->createCxt() );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
			return null;
		}
	}
	
	
	/**
	 * @see com.inxmail.xpro.api.reporting.ReportEngine#getDescriptor(java.lang.String, java.lang.String)
	 */
	public function getDescriptor( $sReportName, $sLocale )
	{
		try
		{
			return new Inx_Apiimpl_Reporting_ConfigDescriptorImpl( 
			        $this->_oService->getDescriptor( $this->_oSessionContext->createCxt(),
					    $sReportName, $sLocale ) );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( x );
			return null;
		}
	}
	
	
	/**
	 * @see com.inxmail.xpro.api.reporting.ReportEngine#getSupportedTimeZones()
	 */
	public function getSupportedTimeZones()
	{
		try
		{
			return $this->_oService->getSupportedTimeZones( $this->_oSessionContext->createCxt() );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
			return null;
		}
	}
}
