<?php 

/**
 * The implementation of <code>RecipientContext</code>
 * <P>
 * Copyright (c) 2005 Inxmail GmbH. All Rights Reserved.
 * 
 * @version $Revision: 14351 $ $Date: 2009-10-06 13:05:28 +0200 (Di, 06 Okt 2009) $ $Author: sbn $
 */
class Inx_Apiimpl_Testprofiles_TestRecipientContextImpl implements Inx_Api_Testprofiles_TestRecipientContext
{

	private $rc;

	protected $_oSc;

	protected $_oService;


	public function __construct( $oSc, $rc )
	{
		$this->_oSc = $oSc;
		$this->rc = $rc;
		$this->_oService = $oSc->getService( Inx_Apiimpl_SessionContext::TESTRECIPIENT_SERVICE );
	}
	

	public function createRowSet(Inx_Api_List_ListContext $lc )
	{
		try
		{
			return new Inx_Apiimpl_Testprofiles_TestRecipientRowSetImpl( $this->_oSc, 
					$this->rc, $this->_oService->createRowSet( $this->_oSc->sessionId(), $this->rc->_remoteRef()->refId(), 
					$lc->getId() ) );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_notify( $e );
			return null;
		}
	}

	/**
	 * @see com.inxmail.xpro.api.recipient.RecipientContext#select(com.inxmail.xpro.api.list.ListContext,
	 *      com.inxmail.xpro.api.filter.Filter, java.lang.String)
	 */
	public function select( Inx_Api_List_ListContext $list=null, Inx_Api_Filter_Filter $oFilter=null, $sAdditionalFilter=null )
	{
		try
		{
			
			$listContextId = $list != null ? $list->getId() : Inx_Apiimpl_Constants::ID_UNSPECIFIED;
			$filterId = $oFilter != null ? $oFilter->getId() : Inx_Apiimpl_Constants::ID_UNSPECIFIED;
			if( $sAdditionalFilter == null )
				$sAdditionalFilter = "";
			
			
			$data = $this->_oService->selectTestrecipients($this->_oSc->sessionId(), $this->rc->_remoteRef()->refId(),
					$listContextId, $filterId, $sAdditionalFilter );
			if(! empty($data->selectExcDesc))
			    throw new Inx_Api_Recipient_SelectException( $data->selectExcDesc->msg, $data->selectExcDesc->type);
			
			return new Inx_Apiimpl_Testprofiles_TestRecipientRowSetImpl( $this->_oSc, $this->rc, $data );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_notify( $e );
			return null;
		}
	}


	public function close()
	{
		$this->rc->_remoteRef()->release( true );
	}

}
