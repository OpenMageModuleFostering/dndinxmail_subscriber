<?php
/**
 * 
 * 
 * @author sbn, 16.01.2007
 * @copyright Inxmail GmbH
 * @version $Revision:$ $Date:$ $Author:$
 */

class Inx_Apiimpl_DataAccess_ClickDataImpl implements Inx_Api_DataAccess_ClickData 
{

	private $_oSessionContext;
	private $_oService;

	public function __construct( Inx_Apiimpl_SessionContext $oSC )
	{
		$this->_oSessionContext = $oSC;
		$this->_oService =$this->_oSessionContext->getService( Inx_Apiimpl_SessionContext::DATAACCESS_SERVICE );
	}

	public function selectByLink( $iLinkId,  Inx_Api_Recipient_RecipientContext $rc, array $aAttrs = null )
	{
		if (!is_int($iLinkId)) {
		    throw new Inx_Api_IllegalArgumentException('Integer parameter $iLinkId expected, got '.gettype($iLinkId));
		}
	    
	    try
		{
			$aAttrIds = $this->_convertAttributesToIds( $aAttrs );
			
			$oResult = $this->_oService->selectClickByLinkRequest( 
			    $this->_oSessionContext->createCxt(),$iLinkId, $rc->_remoteRef()->refId() , $aAttrIds );
			return new Inx_Apiimpl_DataAccess_ClickDataRowSetImpl(
			        $this->_oSessionContext,$rc,$aAttrs,$oResult);
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}
	
	public function selectByLinkBefore( $iLinkId, $dtSearchDate,  Inx_Api_Recipient_RecipientContext $rc, array $aAttrs = null )
	{
		if (!is_int($iLinkId)) {
		    throw new Inx_Api_IllegalArgumentException('Integer parameter $iLinkId expected, got '.gettype($iLinkId));
		}
	    if(empty($dtSearchDate))
	    	throw new Inx_Api_IllegalArgumentException('searchDate can not be null');
	    try
		{
			$aAttrIds = $this->_convertAttributesToIds( $aAttrs );
			
			$oResult = $this->_oService->selectClickByLinkBeforeRequest( 
			    $this->_oSessionContext->createCxt(),$iLinkId,Inx_Apiimpl_TConvert::TConvert( $dtSearchDate ), $rc->_remoteRef()->refId() , $aAttrIds );
			return new Inx_Apiimpl_DataAccess_ClickDataRowSetImpl(
			        $this->_oSessionContext,$rc,$aAttrs,$oResult);
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}
	
	public function selectByLinkAfter( $iLinkId, $dtSearchDate,  Inx_Api_Recipient_RecipientContext $rc, array $aAttrs = null )
	{
		if (!is_int($iLinkId)) {
		    throw new Inx_Api_IllegalArgumentException('Integer parameter $iLinkId expected, got '.gettype($iLinkId));
		}
	    if(empty($dtSearchDate))
	    	throw new Inx_Api_IllegalArgumentException('searchDate can not be null');
	    try
		{
			$aAttrIds = $this->_convertAttributesToIds( $aAttrs );
			
			$oResult = $this->_oService->selectClickByLinkAfterRequest( 
			    $this->_oSessionContext->createCxt(),$iLinkId,Inx_Apiimpl_TConvert::TConvert( $dtSearchDate ), $rc->_remoteRef()->refId() , $aAttrIds );
			return new Inx_Apiimpl_DataAccess_ClickDataRowSetImpl(
			        $this->_oSessionContext,$rc,$aAttrs,$oResult);
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}
	
	public function selectByLinkBetween( $iLinkId, $dtStartDate, $dtEndDate,  Inx_Api_Recipient_RecipientContext $rc, array $aAttrs = null )
	{
		if (!is_int($iLinkId)) {
		    throw new Inx_Api_IllegalArgumentException('Integer parameter $iLinkId expected, got '.gettype($iLinkId));
		}
	    if(empty($dtStartDate))
	    	throw new Inx_Api_IllegalArgumentException('startDate can not be null');
	    if(empty($dtEndDate))
	    	throw new Inx_Api_IllegalArgumentException('endDate can not be null');
	   
	    try
		{
			$aAttrIds = $this->_convertAttributesToIds( $aAttrs );
			
			$oResult = $this->_oService->selectClickByLinkBetweenRequest( 
			    $this->_oSessionContext->createCxt(),$iLinkId,Inx_Apiimpl_TConvert::TConvert( $dtStartDate ),Inx_Apiimpl_TConvert::TConvert( $dtEndDate ), $rc->_remoteRef()->refId() , $aAttrIds );
			return new Inx_Apiimpl_DataAccess_ClickDataRowSetImpl(
			        $this->_oSessionContext,$rc,$aAttrs,$oResult);
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}


	public function selectByMailing( $iMailingId, Inx_Api_Recipient_RecipientContext $rc, array $aAttrs = null)
	{
	    if (!is_int($iMailingId)) {
		    throw new Inx_Api_IllegalArgumentException('Integer parameter $iMailingId expected, got '.gettype($iMailingId));
		}
		try
		{
			$aAttrIds = $this->_convertAttributesToIds( $aAttrs );
			$oResult = $this->_oService->selectClickByMailingRequest( 
			    $this->_oSessionContext->createCxt(), $iMailingId,$rc->_remoteRef()->refId() , $aAttrIds );
			return new Inx_Apiimpl_DataAccess_ClickDataRowSetImpl(
			        $this->_oSessionContext,$rc,$aAttrs,$oResult);
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}

	public function selectByMailingBefore( $iMailingId, $dtSearchDate, Inx_Api_Recipient_RecipientContext $rc, array $aAttrs = null)
	{
	    if (!is_int($iMailingId)) {
		    throw new Inx_Api_IllegalArgumentException('Integer parameter $iMailingId expected, got '.gettype($iMailingId));
		}
		  if(empty($dtSearchDate))
	    	throw new Inx_Api_IllegalArgumentException('searchDate can not be null');
	  
		try
		{
			$aAttrIds = $this->_convertAttributesToIds( $aAttrs );
			$oResult = $this->_oService->selectClickByMailingBeforeRequest( 
			    $this->_oSessionContext->createCxt(), $iMailingId,Inx_Apiimpl_TConvert::TConvert( $dtSearchDate ), $rc->_remoteRef()->refId() , $aAttrIds );
			return new Inx_Apiimpl_DataAccess_ClickDataRowSetImpl(
			        $this->_oSessionContext,$rc,$aAttrs,$oResult);
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}
	
	public function selectByMailingAfter( $iMailingId, $dtSearchDate, Inx_Api_Recipient_RecipientContext $rc, array $aAttrs = null)
	{
	    if (!is_int($iMailingId)) {
		    throw new Inx_Api_IllegalArgumentException('Integer parameter $iMailingId expected, got '.gettype($iMailingId));
		}
		  if(empty($dtSearchDate))
	    	throw new Inx_Api_IllegalArgumentException('searchDate can not be null');
	  
		try
		{
			$aAttrIds = $this->_convertAttributesToIds( $aAttrs );
			$oResult = $this->_oService->selectClickByMailingAfterRequest( 
			    $this->_oSessionContext->createCxt(), $iMailingId,Inx_Apiimpl_TConvert::TConvert( $dtSearchDate ), $rc->_remoteRef()->refId() , $aAttrIds );
			return new Inx_Apiimpl_DataAccess_ClickDataRowSetImpl(
			        $this->_oSessionContext,$rc,$aAttrs,$oResult);
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}	
	
	public function selectByMailingBetween( $iMailingId, $dtStartDate, $dtEndDate, Inx_Api_Recipient_RecipientContext $rc, array $aAttrs = null)
	{
	    if (!is_int($iMailingId)) {
		    throw new Inx_Api_IllegalArgumentException('Integer parameter $iMailingId expected, got '.gettype($iMailingId));
		}
		 if(empty($dtStartDate))
	    	throw new Inx_Api_IllegalArgumentException('startDate can not be null');
	    if(empty($dtEndDate))
	    	throw new Inx_Api_IllegalArgumentException('endDate can not be null');
	   
		try
		{
			$aAttrIds = $this->_convertAttributesToIds( $aAttrs );
			$oResult = $this->_oService->selectClickByMailingBetweenRequest( 
			    $this->_oSessionContext->createCxt(), $iMailingId,Inx_Apiimpl_TConvert::TConvert( $dtStartDate ),Inx_Apiimpl_TConvert::TConvert( $dtEndDate ), $rc->_remoteRef()->refId() , $aAttrIds );
			return new Inx_Apiimpl_DataAccess_ClickDataRowSetImpl(
			        $this->_oSessionContext,$rc,$aAttrs,$oResult);
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}	
	
	public function selectByRecipient( $iRecipientId, Inx_Api_Recipient_RecipientContext $rc, array $aAttrs = null)
	{
	    if (!is_int($iRecipientId)) {
		    throw new Inx_Api_IllegalArgumentException('Integer parameter $iRecipientId expected, got '.gettype($iRecipientId));
		}

		try
		{
			$aAttrIds = $this->_convertAttributesToIds( $aAttrs );
			$oResult = $this->_oService->selectClickByRecipientRequest( 
			    $this->_oSessionContext->createCxt(), $iRecipientId, $rc->_remoteRef()->refId(), $aAttrIds );
			return new Inx_Apiimpl_DataAccess_ClickDataRowSetImpl(
					$this->_oSessionContext,$rc,$aAttrs,$oResult);
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}
	
	public function selectByRecipientBefore( $iRecipientId, $dtSearchDate, Inx_Api_Recipient_RecipientContext $rc, array $aAttrs = null)
	{
	    if (!is_int($iRecipientId)) {
		    throw new Inx_Api_IllegalArgumentException('Integer parameter $iRecipientId expected, got '.gettype($iRecipientId));
		}
  		if(empty($dtSearchDate))
	    	throw new Inx_Api_IllegalArgumentException('searchDate can not be null');
	  
		try
		{
			$aAttrIds = $this->_convertAttributesToIds( $aAttrs );
			$oResult = $this->_oService->selectClickByRecipientBeforeRequest( 
			    $this->_oSessionContext->createCxt(), $iRecipientId,Inx_Apiimpl_TConvert::TConvert( $dtSearchDate ), $rc->_remoteRef()->refId(), $aAttrIds );
			return new Inx_Apiimpl_DataAccess_ClickDataRowSetImpl(
					$this->_oSessionContext,$rc,$aAttrs,$oResult);
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}
	
	public function selectByRecipientAfter( $iRecipientId, $dtSearchDate, Inx_Api_Recipient_RecipientContext $rc, array $aAttrs = null)
	{
	    if (!is_int($iRecipientId)) {
		    throw new Inx_Api_IllegalArgumentException('Integer parameter $iRecipientId expected, got '.gettype($iRecipientId));
		}
  		if(empty($dtSearchDate))
	    	throw new Inx_Api_IllegalArgumentException('searchDate can not be null');
	  
		try
		{
			$aAttrIds = $this->_convertAttributesToIds( $aAttrs );
			$oResult = $this->_oService->selectClickByRecipientAfterRequest( 
			    $this->_oSessionContext->createCxt(), $iRecipientId,Inx_Apiimpl_TConvert::TConvert( $dtSearchDate ), $rc->_remoteRef()->refId(), $aAttrIds );
			return new Inx_Apiimpl_DataAccess_ClickDataRowSetImpl(
					$this->_oSessionContext,$rc,$aAttrs,$oResult);
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}
	
	public function selectByRecipientBetween( $iRecipientId, $dtStartDate, $dtEndDate, Inx_Api_Recipient_RecipientContext $rc, array $aAttrs = null)
	{
	    if (!is_int($iRecipientId)) {
		    throw new Inx_Api_IllegalArgumentException('Integer parameter $iRecipientId expected, got '.gettype($iRecipientId));
		}
  	   if(empty($dtStartDate))
	    	throw new Inx_Api_IllegalArgumentException('startDate can not be null');
	    if(empty($dtEndDate))
	    	throw new Inx_Api_IllegalArgumentException('endDate can not be null');
	 	try
		{
			$aAttrIds = $this->_convertAttributesToIds( $aAttrs );
			$oResult = $this->_oService->selectClickByRecipientBetweenRequest( 
			    $this->_oSessionContext->createCxt(), $iRecipientId,Inx_Apiimpl_TConvert::TConvert( $dtStartDate ),Inx_Apiimpl_TConvert::TConvert( $dtEndDate ), $rc->_remoteRef()->refId(), $aAttrIds );
			return new Inx_Apiimpl_DataAccess_ClickDataRowSetImpl(
					$this->_oSessionContext,$rc,$aAttrs,$oResult);
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}
	
	
	public function selectByRecipientAndMailing( $iRecipientId, $iMailingId, Inx_Api_Recipient_RecipientContext $rc, array $aAttrs=null )
	{
	    if (!is_int($iRecipientId)) {
		    throw new Inx_Api_IllegalArgumentException('Integer parameter $iRecipientId expected, got '.gettype($iRecipientId));
		}
	    if (!is_int($iMailingId)) {
		    throw new Inx_Api_IllegalArgumentException('Integer parameter $iMailingId expected, got '.gettype($iMailingId));
		}
		try
		{
			$aAttrIds = $this->_convertAttributesToIds( $aAttrs );
			$oResult = $this->_oService->selectClickByRecipientMailingRequest(
			     $this->_oSessionContext->createCxt(), $iRecipientId, $iMailingId, $rc->_remoteRef()->refId(), $aAttrIds );
			return new Inx_Apiimpl_DataAccess_ClickDataRowSetImpl(
			        $this->_oSessionContext,$rc,$aAttrs,$oResult);
		}
		catch( RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}
	
	
	public function selectByRecipientAndMailingBefore( $iRecipientId, $iMailingId, $dtSearchDate, Inx_Api_Recipient_RecipientContext $rc, array $aAttrs=null )
	{
	    if (!is_int($iRecipientId)) {
		    throw new Inx_Api_IllegalArgumentException('Integer parameter $iRecipientId expected, got '.gettype($iRecipientId));
		}
	    if (!is_int($iMailingId)) {
		    throw new Inx_Api_IllegalArgumentException('Integer parameter $iMailingId expected, got '.gettype($iMailingId));
		}
		if(empty($dtSearchDate))
	    	throw new Inx_Api_IllegalArgumentException('searchDate can not be null');
	  
		try
		{
			$aAttrIds = $this->_convertAttributesToIds( $aAttrs );
			$oResult = $this->_oService->selectClickByRecipientMailingBeforeRequest(
			     $this->_oSessionContext->createCxt(), $iRecipientId, $iMailingId, Inx_Apiimpl_TConvert::TConvert( $dtSearchDate ), $rc->_remoteRef()->refId(), $aAttrIds );
			return new Inx_Apiimpl_DataAccess_ClickDataRowSetImpl(
			        $this->_oSessionContext,$rc,$aAttrs,$oResult);
		}
		catch( RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}
	
	public function selectByRecipientAndMailingAfter( $iRecipientId, $iMailingId, $dtSearchDate, Inx_Api_Recipient_RecipientContext $rc, array $aAttrs=null )
	{
	    if (!is_int($iRecipientId)) {
		    throw new Inx_Api_IllegalArgumentException('Integer parameter $iRecipientId expected, got '.gettype($iRecipientId));
		}
	    if (!is_int($iMailingId)) {
		    throw new Inx_Api_IllegalArgumentException('Integer parameter $iMailingId expected, got '.gettype($iMailingId));
		}
		if(empty($dtSearchDate))
	    	throw new Inx_Api_IllegalArgumentException('searchDate can not be null');
	  
		try
		{
			$aAttrIds = $this->_convertAttributesToIds( $aAttrs );
			$oResult = $this->_oService->selectClickByRecipientMailingAfterRequest(
			     $this->_oSessionContext->createCxt(), $iRecipientId, $iMailingId, Inx_Apiimpl_TConvert::TConvert( $dtSearchDate ), $rc->_remoteRef()->refId(), $aAttrIds );
			return new Inx_Apiimpl_DataAccess_ClickDataRowSetImpl(
			        $this->_oSessionContext,$rc,$aAttrs,$oResult);
		}
		catch( RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}
	
	public function selectByRecipientAndMailingBetween( $iRecipientId, $iMailingId, $dtStartDate, $dtEndDate, Inx_Api_Recipient_RecipientContext $rc, array $aAttrs=null )
	{
	    if (!is_int($iRecipientId)) {
		    throw new Inx_Api_IllegalArgumentException('Integer parameter $iRecipientId expected, got '.gettype($iRecipientId));
		}
	    if (!is_int($iMailingId)) {
		    throw new Inx_Api_IllegalArgumentException('Integer parameter $iMailingId expected, got '.gettype($iMailingId));
		}
   		if(empty($dtStartDate))
	    	throw new Inx_Api_IllegalArgumentException('startDate can not be null');
	    if(empty($dtEndDate))
	    	throw new Inx_Api_IllegalArgumentException('endDate can not be null');
		
		try
		{
			$aAttrIds = $this->_convertAttributesToIds( $aAttrs );
			$oResult = $this->_oService->selectClickByRecipientMailingBetweenRequest(
			     $this->_oSessionContext->createCxt(), $iRecipientId, $iMailingId, Inx_Apiimpl_TConvert::TConvert( $dtStartDate ),Inx_Apiimpl_TConvert::TConvert( $dtEndDate ), $rc->_remoteRef()->refId(), $aAttrIds );
			return new Inx_Apiimpl_DataAccess_ClickDataRowSetImpl(
			        $this->_oSessionContext,$rc,$aAttrs,$oResult);
		}
		catch( RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}
	
	private function _convertAttributesToIds( array $aAttrs = null)
	{
		if($aAttrs === null)
			return array();
		$aAttrIds = array();
		foreach ($aAttrs as $key => $val) {
		    $aAttrIds[$key] = $val->getId(); 
		}
		return $aAttrIds;
	}

}
    