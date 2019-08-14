<?php

/**
 * <code>CommandImpl</code>
 * 
 * @since API 1.2.0
 * @version $Revision: 9739 $ $Date: 2008-01-23 14:44:04 +0200 (Tr, 23 Sau 2008) $ $Author: aurimas $
 */
abstract class Inx_Apiimpl_Action_CommandImpl implements Inx_Api_Action_Command
{

	const EMTPY_CMDS = null;
	
	
	/** Action: Set value */
	const SET_VALUE_CMD_TYPE = 1;

	/** Action: Change subscription */
	const CHANGE_SUBSCRIPTION_CMD_TYPE = 2;

	/** Action: Send a mail */
	const SEND_MAIL_CMD_TYPE = 3;

	/** Action: Delete member */
	const DELETE_MEMBER_CMD_TYPE = 4;
	
	
	/** Action: subscribe member */
	const SUBSCRIBE_MEMBER_CMD_TYPE = 5;

	/** Action: unsubscribe member */
	const UNSUBSCRIBE_MEMBER_CMD_TYPE = 6;

        /** Action: Send an action mail */
        const SEND_ACTION_MAIL_CMD_TYPE = 7;
	
	const ONE = 1;

	const TWO = 2;

	const THREE = 3;
	
	
	protected $_oCommandData;
		
	protected $_aParams;
	
	
	public function __construct( $oCommandData )
	{
		$this->_oCommandData = $oCommandData;
	}
	
	
	/**
	 * @return
	 */
	public function getCmdType()
	{
		return $this->_oCommandData->type;
	}
	
	
	/**
	 * @param parameterKey
	 * @return
	 */
	protected function getInteger( $iParameterKey )
	{
		if (!is_int($iParameterKey)) {
	        throw new Inx_Api_IllegalArgumentException('Integer $iParameterKey argument expected');
	    }
	    $sTmp = $this->getParameter( $iParameterKey );
		if( $sTmp==null || strlen($sTmp) == 0 )
			return null;
		else
			return (int)$sTmp;
	}
	
	/**
	 * @param parameterKey
	 * @return
	 */
	protected function getParameter( $iParameterKey )
	{
	    if (!is_int($iParameterKey)) {
	        throw new Inx_Api_IllegalArgumentException('Integer $iParameterKey argument expected');
	    }
	    if( !isset($this->_aParams) )
		{
			$this->_aParams = array();
			$aKeys = Inx_Apiimpl_TConvert::TArrToArr($this->_oCommandData->keys);
			$aValues = Inx_Apiimpl_TConvert::TArrToArr($this->_oCommandData->values);
			
			foreach($aKeys as $key => $val) {
			    $this->_aParams[$val] = $aValues[$key];
			}
		}
		return (string)$this->_aParams[$iParameterKey];
	}
	
	/**
	 * @return
	 */
	protected function getCommandData()
	{
		return $this->_oCommandData;
	}
	
	
	/**
	 * @param datas CommandData[] datas
	 * @return array of Inx_Api_Action_Command
	 */
	public static function convertDtArr( $aDatas )
	{
		if( $aDatas === null || count($aDatas) == 0 )
			return self::EMTPY_CMDS;
		
		$cs = array();
		foreach($aDatas as $key => $val) {
		    switch ($val->type) {
		        case self::SET_VALUE_CMD_TYPE:
		            $cs[$key] = new Inx_Apiimpl_Action_CommandImpl_SetValueCmd($val); 
		            break;
		        case self::CHANGE_SUBSCRIPTION_CMD_TYPE:
		            $cs[$key] = new Inx_Apiimpl_Action_CommandImpl_SubUnsubscriptionCmd($val);
		            break;
		        case self::SEND_MAIL_CMD_TYPE:
		            $cs[$key] = new Inx_Apiimpl_Action_CommandImpl_SendMailCmd($val);
		            break;
		        case self::DELETE_MEMBER_CMD_TYPE:
		            $cs[$key] = new Inx_Apiimpl_Action_CommandImpl_RemoveRecipientCmd($val);
		            break;
		        case self::SUBSCRIBE_MEMBER_CMD_TYPE:
		            $cs[$key] = new Inx_Apiimpl_Action_CommandImpl_SubscriptionCmd($val);
		            break;		            
		        case self::UNSUBSCRIBE_MEMBER_CMD_TYPE:
		            $cs[$key] = new Inx_Apiimpl_Action_CommandImpl_UnsubscriptionCmd($val);
		            break;		            
		        default:
		            $cs[$key] = new Inx_Apiimpl_Action_CommandImpl_UnknownCmd($val);
		            break;
		    }
		    
		}
		
		return $cs;

	}
	
	/**
	 * @param cmds
	 * @return
	 */
	public static function convertCmdArr( $aCmds )
	{
		if( $aCmds === null )
			return null;
		$cs = array();
		
		foreach($aCmds as $key => $val) {
		    $cs[$key] = $val->getCommandData();
		}
		
		return $cs;
	}
	
	public static function createCommandData() 
	{
	    $oRet = new stdClass;
	    $oRet->type = null;
	    $oRet->keys = array();
	    $oRet->values = array();
	}

}
