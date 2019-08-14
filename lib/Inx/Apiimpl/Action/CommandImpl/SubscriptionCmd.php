<?php

class Inx_Apiimpl_Action_CommandImpl_SubscriptionCmd 
                                extends Inx_Apiimpl_Action_CommandImpl 
                                implements Inx_Api_Action_SubscriptionCommand
{
	/**
	 * @param mixed $mFirstParam if this is integer, than - listcontextid, else command data from service
	 * @param int $iType command type
	 * @param bool $blProcessingEnabled 
	 */
	public function __construct( $mFirstParam, $iType=null, $blProcessingEnabled = null )
	{
		if (is_object($mFirstParam)) {
		    return parent::__construct($mFirstParam);
		}

		parent::__construct(Inx_Apiimpl_Action_CommandImpl::createCommandData());
		$this->_oCommandData = new stdClass;
		$this->_oCommandData->type = self::SUBSCRIBE_MEMBER_CMD_TYPE;
		$this->_oCommandData->keys = Inx_Apiimpl_TConvert::arrToTArr(
		                                    array(self::ONE, self::TWO, self::THREE)
		                                );
		$this->_oCommandData->values = Inx_Apiimpl_TConvert::arrToTArr(
		                                    array(
		                                        (string) $mFirstParam, 
		                                        (string) $iType,
		                                        $blProcessingEnabled ? '1' : '0' 
		                                    )
		                                );
	}
			
	public function getListContextId()
	{
		return $this->getInteger( self::ONE );
	}
	
	public function getCmdType()
	{
		$iType = $this->getInteger( self::TWO );
		if( $iType==null )
			return self::CMD_TYPE_SUBSCRIBE;
		return $iType;
	}
	
	public function isProcessingEnabled()
	{
		$bool = $this->getInteger( self::THREE );
		if( $bool==null )
			return false;
		
		return $bool == 1;
	}
	
	public function toString()
	{
		return "SubscriptionCommand - listContextId: " . $this->getInteger( self::ONE )
			. ", cmdType: " . $this->getInteger( self::TWO ) . ", processingEnabled: " 
			. $this->getInteger( self::THREE );
	}
	
	public function __toString() {
	    return $this->toString();
	}
}