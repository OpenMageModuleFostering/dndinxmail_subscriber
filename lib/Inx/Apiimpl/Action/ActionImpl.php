<?php
/**
 * <code>Inx_Apiimpl_Action_ActionImpl</code>
 * 
 * @since API 1.2.0
 * @version $Revision: 9739 $ $Date: 2008-01-23 14:44:04 +0200 (Tr, 23 Sau 2008) $ $Author: aurimas $
 */
class Inx_Apiimpl_Action_ActionImpl implements Inx_Api_Action_Action
{
    /**
     * @var Inx_Apiimpl_SessionContext
     */
	protected $_oSessionContext;
    
    protected $_oActionData;
    
    protected $_aChangedAttrs;

    protected $_aCmds;
    
    
    public function __construct( Inx_Apiimpl_SessionContext $sc, $oActionData )
    {
	    $this->_oSessionContext = $sc;
	    $this->_oActionData = $oActionData;
	}
    
	/**
	 * @see Inx_Api_BusinessObject#getId()
	 */
	public function getId()
	{
		return $this->_oActionData->id;
	}

	/**
	 * @see Inx_Api_Action_Action#getName()
	 */
	public function getName()
	{
		if (isset($this->_oActionData->name->value))
		    return $this->_oActionData->name->value;
	}
	
	/**
	 * @see Inx_Api_Action_Action#updateName(String)
	 */
	public function updateName( $sName )
	{
	    $this->_writeAccess( Inx_Api_Action_Action::ATTRIBUTE_NAME );
	    $this->_oActionData->name = new stdClass;
	    $this->_oActionData->name->value = $sName;
	}
	
	/**
	 * @see Inx_Api_Action_Action#getListContextId()
	 */
	public function getListContextId()
	{
		return $this->_oActionData->listContextId;
	}
	
	/**
	 * @param int listContextId
	 */
	public function updateListContextId( $iListContextId )
	{
	    if (!is_int($iListContextId)) {
	        throw new Inx_Api_IllegalArgumentException('Integer $iListContextId argument expected');
	    }
	    $this->_writeAccess( Inx_Api_Action_Action::ATTRIBUTE_LIST_CONTEXT_ID );
	    $this->_oActionData->listContextId = $iListContextId;
	}
	
	/**
	 * @see Inx_Api_Action_Action#getEventType()
	 */
	public function getEventType()
	{
		return $this->_oActionData->eventType;
	}
	
	/**
	 * @see Inx_Api_Action_Action#updateEventType(int)
	 */
	public function updateEventType( $iEventType )
	{
	    if (!is_int($iEventType)) {
	        throw new Inx_Api_IllegalArgumentException('Integer $$iEventType argument expected');
	    }
	    $this->_writeAccess( Inx_Api_Action_Action::ATTRIBUTE_EVENT_TYPE );
	    $this->_oActionData->eventType = $iEventType;
	}
	
    /**
     * @see Inx_Api_Action_Action#getCommands()
     */
    public function getCommands()
    {
    	if( !isset($this->_aCmds) )
    		$this->_aCmds = Inx_Apiimpl_Action_CommandImpl::convertDtArr( $this->_oActionData->cmds );
    	return $this->_aCmds;
    }

    /**
     * @see Inx_Api_Action_Action#updateCommands(com.inxmail.xpro.api.action.Command[])
     */
    public function updateCommands( $aCmds )
    {
    	$this->_aCmds = $aCmds;
    	$this->_writeAccess( Inx_Api_Action_Action::ATTRIBUTE_COMMANDS );
	    $this->_oActionData->cmds = Inx_Apiimpl_Action_CommandImpl::convertCmdArr( $aCmds ) ;
    }


	/**
	 * @see Inx_Api_BusinessObject#commitUpdate()
	 * @throws Inx_Api_UpdateException, Inx_Api_DataException
	 */
	public function commitUpdate() 
	{
		try
	    {
			$oService = $this->_oSessionContext->getService( Inx_Apiimpl_SessionContext::ACTION_SERVICE );
			$ret = $oService->update( $this->_oSessionContext->createCxt(), 
			        $this->_oActionData, Inx_Apiimpl_TConvert::arrToTArr( $this->_aChangedAttrs ) );
			$this->_oActionData = $ret->value;
	        $this->_aChangedAttrs = null;
			
			if( $this->_oActionData === null )
			    throw new Inx_Api_DataException( "action is deleted" );
	    }
	    catch(Inx_Apiimpl_SoapException $se) {
	        throw new Inx_Api_UpdateException( $se->getMessage(), $se->getCode(), $se->oReturnObj->excDesc->source);
	    }
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x);
	    }
	}

	
	/**
	 * @see Inx_Api_BusinessObject#reload()
	 * @throws Inx_Api_DataException
	 */
	public function reload()
	{
		try
	    {
			$oService = $this->_oSessionContext->getService( Inx_Apiimpl_SessionContext::ACTION_SERVICE );
		    $this->_oActionData = $oService->get( $this->_oSessionContext->createCxt(), $this->_oActionData->id );
		    $this->_aChangedAttrs = null;
			
			if( $this->_oActionData === null )
			    throw new Inx_Api_DataException( "action is deleted" );
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
		}
	}
	
	
	/**
	 * Helper method
	 * 
	 * @param int attrIndex
	 */
	protected function _writeAccess( $iAttrIndex )
	{
		if( !isset($this->_aChangedAttrs) )
			$this->_aChangedAttrs = array_fill(0, Inx_Apiimpl_Action_ActionConstants::MAX_ATTRIBUTES, false);
		$this->_aChangedAttrs[ $iAttrIndex ] = true;
	}
	
	/**
	 * Helper method
	 * 
	 * @param Inx_Apiimpl_SessionContext $sc
	 * @param stdClass $oData
	 * @return
	 */
	public static function convert( Inx_Apiimpl_SessionContext $sc, $oData )
	{
		if( $oData === null )
			return null;
		
		return new Inx_Apiimpl_Action_ActionImpl( $sc, $oData );
	}
	
	/**
	 * Helper method
	 * 
	 * @param Inx_Apiimpl_SessionContext $sc
	 * @param array $aoData
	 * @return array
	 */
	public static function convertArr( Inx_Apiimpl_SessionContext $sc, $aoData )
	{
		if( $aoData === null || count($aoData) == 0 )
			return array();
	    $rs = array();
		foreach($aoData as $oData) {
		    $rs[] = $oData === null ? null : new Inx_Apiimpl_Action_ActionImpl($sc, $oData);
		}
		return $rs;
	}
	
	/**
	 * Hleper method
	 * creates a stub for ActionData to be used in soap
	 */
	public static function createActionData() {
	    $oRet = new stdClass;
	    $oRet->id = null;
	    $oRet->name = null;
	    $oRet->condition = null;
	    $oRet->eventType = null;
	    $oRet->listContextId = null;
	    $oRet->cmds = null;
	    return $oRet;
	}
}
