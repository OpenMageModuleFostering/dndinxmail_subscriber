<?php
/**
 * 
 * 
 * @author sbn, 16.01.2007
 * @copyright Inxmail GmbH
 * @version $Revision:$ $Date:$ $Author:$
 */
class Inx_Apiimpl_DataAccess_LinkDataImpl implements Inx_Api_DataAccess_LinkData
{

	private $_oSessionContext;
	private $_oService;
	private $_blNewBehavior;

	public function __construct( Inx_Apiimpl_SessionContext $oSC, $blNewBehavior )
	{
		$this->_oSessionContext = $oSC;
		$this->_oService = $oSC->getService( Inx_Apiimpl_SessionContext::DATAACCESS_SERVICE );
		$this->_blNewBehavior = $blNewBehavior;
	}

	public function selectByLink( $iLinkId )
	{
	    if (!is_int($iLinkId)) {
		    throw new Inx_Api_IllegalArgumentException('Integer parameter $iLinkId expected, got '.gettype($iLinkId));
		}
	    try
		{
			$oResult = null;

			if ($this->_blNewBehavior)
				$oResult = $this->_oService->selectNewLinkByLinkRequest( $this->_oSessionContext->createCxt(), $iLinkId);
			else
				$oResult = $this->_oService->selectLinkByLinkRequest( $this->_oSessionContext->createCxt(), $iLinkId);
			
			return new Inx_Apiimpl_DataAccess_LinkDataRowSetImpl($this->_oSessionContext,$oResult);
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}

	public function selectByMailing( $iMailingId )
	{
	    if (!is_int($iMailingId)) {
		    throw new Inx_Api_IllegalArgumentException('Integer parameter $iMailingId expected, got '.gettype($iMailingId));
		}
	    try
		{
			$oResult = null;
			
			if ($this->_blNewBehavior)
				$oResult = $this->_oService->selectNewLinkByMailingRequest( $this->_oSessionContext->createCxt(), $iMailingId);
			else
				$oResult = $this->_oService->selectLinkByMailingRequest( $this->_oSessionContext->createCxt(), $iMailingId);
			return new Inx_Apiimpl_DataAccess_LinkDataRowSetImpl($this->_oSessionContext,$oResult);
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}

	public function selectByRecipient( $iRecipient )
	{
	    if (!is_int($iRecipient)) {
		    throw new Inx_Api_IllegalArgumentException('Integer parameter $iRecipientId expected, got '.gettype($iRecipient));
		}
	    try
		{
			$oResult = null;
			if ($this->_blNewBehavior)
				$oResult = $this->_oService->selectNewLinkByRecipientRequest( $this->_oSessionContext->createCxt(), $iRecipient );
			else
				$oResult = $this->_oService->selectLinkByRecipientRequest($this->_oSessionContext->createCxt(), $iRecipient);
			
			return new Inx_Apiimpl_DataAccess_LinkDataRowSetImpl($this->_oSessionContext,$oResult);
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}


	public function selectByLinkName( $linkName )
	{
	    try
		{
			$oResult = $this->_oService->selectLinkByLinkNameRequest($this->_oSessionContext->createCxt(), $linkName);
			$oDesc = $oResult->excDesc;	
			if( !empty($oDesc) )
				throw new Inx_Api_IllegalArgumentException('Wrong parameter, can not null or zero string');
			return new Inx_Apiimpl_DataAccess_LinkDataRowSetImpl($this->_oSessionContext,$oResult->data);
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}
}
