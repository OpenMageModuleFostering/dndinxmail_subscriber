<?php

/**
 * <code>Inx_Apiimpl_Action_ActionManagerImpl</code>
 * 
 * @since API 1.2.0
 * @version $Revision: 9739 $ $Date: 2008-01-23 14:44:04 +0200 (Tr, 23 Sau 2008) $ $Author: aurimas $
 */
class Inx_Apiimpl_Action_ActionManagerImpl implements Inx_Api_Action_ActionManager, Inx_Apiimpl_Core_BOResultSetDelegate 
{
    /**
     * @var Inx_Apiimpl_SessionContext
     */
	protected $_oSessionContext;
	
	/**
	 * @var SoapClient
	 */
	protected $_oService;
	
	/**
	 * @var Inx_Apiimpl_Action_CommandFactory
	 */
	protected  $_oCmdFactory = null;
	
	
	public function __construct( Inx_Apiimpl_SessionContext $sc )
	{
		$this->_oSessionContext = $sc;
		$this->_oService = $sc->getService( Inx_Apiimpl_SessionContext::ACTION_SERVICE );
	}

	
	/**
	 * @see com.inxmail.xpro.api.action.ActionManager#createAction(com.inxmail.xpro.api.list.ListContext)
	 */
	public function createAction( Inx_Api_List_ListContext $listContext )
	{
		$a = new Inx_Apiimpl_Action_ActionImpl( $this->_oSessionContext, Inx_Apiimpl_Action_ActionImpl::createActionData() );
		$a->updateListContextId( $listContext->getId() );
		return $a;
	}
	
	
	/**
	 * @see com.inxmail.xpro.api.BOManager#get(int)
	 * @throws Inx_Api_DataException
	 */
	public function get( $iId ) 
	{
	    if (!is_int($iId)) {
	        throw new Inx_Api_IllegalArgumentException('Integer $iId argument or null expected');
	    }
	    try
		{
			$bo = Inx_Apiimpl_Action_ActionImpl::convert( $this->_oSessionContext, 
			                    $this->_oService->get( $this->_oSessionContext->createCxt(), $iId ) );
		    if( $bo === null )
		        throw new Inx_Api_DataException( "action is deleted" );
		    return $bo;
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
			return null;
		}
	}

	
	/**
	 * @see com.inxmail.xpro.api.BOManager#remove(int)
	 */
	public function remove( $iId )
	{
	    if (!is_int($iId)) {
	        throw new Inx_Api_IllegalArgumentException('Integer $iId argument or null expected');
	    }
	    try
		{
			return $this->_oService->remove( $this->_oSessionContext->createCxt(), $iId );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
			return false;
		}
	}
	
	
	/**
	 * @see com.inxmail.xpro.api.BOManager#selectAll()
	 */
	public function selectAll()
	{
		return $this->select( Inx_Apiimpl_Constants::ID_UNSPECIFIED, -1, -1 );
	}
	
	
	/**
	 * @param mixed listContextId ListContext or listcontext id 
	 * @param orderAttribute
	 * @param orderType
	 * @return
	 */
	public function select($mListContext, $iOrderAttribute= -1, $iOrderType = -1 )
	{
		if ($mListContext instanceof Inx_Api_List_ListContext ) {
		    $mListContext = $mListContext->getId();
		}
		
	    if (!is_int($iOrderAttribute)) {
	        throw new Inx_Api_IllegalArgumentException('Integer $iOrderAttribute argument or null expected');
	    }
	    if (!is_int($iOrderType)) {
	        throw new Inx_Api_IllegalArgumentException('Integer $$iOrderType argument or null expected');
	    }
		
	    try
		{
			$rs = $this->_oService->select( $this->_oSessionContext->createCxt(), $mListContext,
					$iOrderAttribute, $iOrderType );
			
			return new Inx_Apiimpl_Core_DelegateBOResultSet( 
			                     $this->_oSessionContext, $this, $rs->remoteRefId, $rs->size,
					                 Inx_Apiimpl_Action_ActionImpl::convertArr(
					                     $this->_oSessionContext, $rs->data) 
					                 );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
			return null;
		}
	}
	
	
	/**
	 * @see com.inxmail.xpro.apiimpl.core.BOResultSetDelegate#removeBOs(com.inxmail.xpro.apiimpl.RemoteRef, com.inxmail.xpro.apiservice.TInteger[])
	 * @throws RemoteException
	 */
	public function removeBOs( Inx_Apiimpl_RemoteRef $oResultSetRef, $aIndexRanges )
		
	{
		return $this->_oService->removeSelection( 
		    $oResultSetRef->createCxt(), $oResultSetRef->refId(), $aIndexRanges );
	}

	
	/**
	 * @see com.inxmail.xpro.apiimpl.core.BOResultSetDelegate#fetchBOs(com.inxmail.xpro.apiimpl.RemoteRef, int, int)
	 * @throws Inx_Api_RemoteException
	 */
	public function fetchBOs( Inx_Apiimpl_RemoteRef $oResultSetRef, $iIndex, $iDirection )
	{
		return Inx_Apiimpl_Action_ActionImpl::convertArr( $oResultSetRef, $this->_oService->fetch(
				$oResultSetRef->createCxt(), $oResultSetRef->refId(), $iIndex, $iDirection ) );
	}

	
	/**
	 * @see com.inxmail.xpro.api.action.ActionManager#getCommandFactory()
	 */
	public function getCommandFactory()
	{
		if( !isset($this->_oCmdFactory) )
			$this->_oCmdFactory = new Inx_Apiimpl_Action_CommandFactoryImpl();
		return $this->_oCmdFactory;
	}
}
