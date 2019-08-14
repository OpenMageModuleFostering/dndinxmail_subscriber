<?php

class Inx_Apiimpl_List_StandardListImpl extends Inx_Apiimpl_List_ListImpl implements Inx_Api_List_StandardListContext
{
    public function __construct($oSessionContext, $oListData = null) {
        
        
        parent::__construct($oSessionContext, $oListData);
        
        if ($oListData == null) {
            $this->_writeAccess(Inx_Apiimpl_Constants::LIST_ATTR_LIST_TYPE);
            $this->oListData->listType = self::STANDARD_LIST;
        }
        
    }
}
