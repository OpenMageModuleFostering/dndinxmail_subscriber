<?php
class Inx_Apiimpl_Action_CommandImpl_SendMailCmd 
                    extends Inx_Apiimpl_Action_CommandImpl 
                    implements Inx_Api_Action_SendMailCommand
{

	public function __construct( $mFirstParam, $iMailingId = null )
	{
		if (is_object($mFirstParam)) {
		    parent::__construct($mFirstParam);
		    return;
		}
		
	    parent::__construct( Inx_Apiimpl_Action_CommandImpl::createCommandData() );
	    $this->_oCommandData = new stdClass;
	    $this->_oCommandData->type = self::SEND_MAIL_CMD_TYPE;
	    $this->_oCommandData->keys = Inx_Apiimpl_TConvert::arrToTArr( array(self::ONE, self::TWO, self::THREE) );
	    
	    if ($iMailingId === null) {
	        $aValues = array(
	            (string) $mFirstParam,
	            '0',
	            (string) self::CMD_TYPE_LAST_MAILING
	        );
	    }
	    else {
	        if (!is_int($iMailingId)) {
	            throw new Inx_Api_IllegalArgumentException('Integer $iMailingId argument  or null expected');
	        }
	        $aValues = array(
	            (string) $mFirstParam,
	            (string) $iMailingId,
	            (string) self::CMD_TYPE_SPECIFIC_MAILING
	        );
	    }
	    
	    $this->_oCommandData->values = Inx_Apiimpl_TConvert::arrToTArr($aValues);
	}
	

	public function getCmdType()
	{
		$iType = $this->getInteger( self::THREE );
		
		if( $iType === null )
			return self::CMD_TYPE_LAST_MAILING;
		
		return $iType;
	}
	
	public function getListContextId()
	{
		return $this->getInteger( self::ONE );
	}

	public function getMailingId()
	{
		return $this->getInteger( self::TWO );
	}
	
	public function toString()
	{
		return "SendMailCommand - listContextId: " . $this->getInteger( self::ONE )
			. ", mailingId: " . $this->getInteger( self::TWO );
	}
	public function __toString() 
	{
	    return $this->toString();
	}
}