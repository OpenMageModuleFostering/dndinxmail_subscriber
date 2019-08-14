<?php

class Inx_Apiimpl_Action_CommandImpl_SetValueCmd 
                        extends Inx_Apiimpl_Action_CommandImpl 
                        implements Inx_Api_Action_SetValueCommand
{

	/**
	 * @param mixed $mFirstParam command data object, if the other two values are null, and attributeId otherwise
	 * @param int $iType
	 * @param string $sExpr
	 */
	public function __construct( $mFirstParam,$iType = null, $sExpr = null )
	{
		if (is_object($mFirstParam) && is_null($iType) && is_null($sExpr)) {
		    return parent::__construct($mFirstParam);
		}
	    
	    if (!is_int($iType)) {
	        throw new Inx_Api_IllegalArgumentException('Integer $iType argument or null expected');
	    }
		
	    parent::__construct( Inx_Apiimpl_Action_CommandImpl::createCommandData() );
		$this->_oCommandData = new stdClass;
	    $this->_oCommandData->type = self::SET_VALUE_CMD_TYPE ;
		$this->_oCommandData->keys = Inx_Apiimpl_TConvert::arrToTArr( array(self::ONE, self::TWO, self::THREE) );
		$this->_oCommandData->values = Inx_Apiimpl_TConvert::arrToTArr(
		                            array(
		                                (string) $mFirstParam,
		                                (string) $iType,
		                                $sExpr
		                            )
		                        );
	}

	public function getAttributeId()
	{
		return $this->getInteger( self::ONE );
	}

	public function getCmdType()
	{
		$iType = $this->getInteger( self::TWO );
		if( $iType==null )
			return self::CMD_TYPE_ABSOLUTE;
		
		return $iType;
	}
	
	public function getExpression()
	{
		return $this->getParameter( self::THREE );
	}
	
	public function toString()
	{
		return "SetValueCommand - attributeId: " . $this->getInteger( self::ONE )
			. ", cmdType: " . $this->getInteger( self::TWO ) . ", expression: " 
			. $this->getParameter( self::THREE );
	}
	
	public function __toString() 
	{
	    return $this->toString();
	}
}