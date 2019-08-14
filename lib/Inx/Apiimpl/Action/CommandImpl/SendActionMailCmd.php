<?php
class Inx_Apiimpl_Action_CommandImpl_SendActionMailCmd 
    extends Inx_Apiimpl_Action_CommandImpl 
    implements Inx_Api_Action_SendActionMailCommand
{
        public function __construct( $mFirstParam, $iActionMailingId = null )
        {
                //first parameter is either the command data (and therefore an object) or 
                //it is the list context id (and therefore no object).
                if (is_object($mFirstParam)) 
                {
		    parent::__construct($mFirstParam);
		    return;
		}
            
                parent::__construct( Inx_Apiimpl_Action_CommandImpl::createCommandData() );
                $this->_oCommandData = new stdClass();
                $this->_oCommandData->type = self::SEND_ACTION_MAIL_CMD_TYPE;
                $this->_oCommandData->keys = Inx_Apiimpl_TConvert::arrToTArr( array( self::ONE, self::TWO ) );
                
                if ($iActionMailingId === null) 
                {
                    throw new Inx_Api_IllegalArgumentException('if first parameter is the list context id, ' .
                        'the second parameter may not be null');
                }
                else 
                {
                    if (!is_int($iActionMailingId)) 
                    {
                        throw new Inx_Api_IllegalArgumentException('Integer $iActionMailingId argument expected');
                    }
                    
                    $aValues = array(
                        (string) $mFirstParam,
                        (string) $iActionMailingId,
                    );
                    
                    $this->_oCommandData->values = Inx_Apiimpl_TConvert::arrToTArr($aValues);
                }
        }


        public function getListContextId()
        {
                return $this->getInteger( self::ONE );
        }


        public function getMailingId()
        {
                return $this->getInteger( self::TWO );
        }


        public function __toString()
        {
                return "SendActionMailCommand - listContextId: " . $this->getInteger( self::ONE ) . 
                        ", actionMailingId: " . $this->getInteger( self::TWO );
        }
}