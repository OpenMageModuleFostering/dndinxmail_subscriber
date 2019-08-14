<?php


class Inx_Apiimpl_List_FilterListImpl extends Inx_Apiimpl_List_ListImpl 
                                        implements Inx_Api_List_FilterListContext
{
	public function __construct( Inx_Apiimpl_SessionContext $oSc, $oData=null )
	{
	    parent::__construct( $oSc, $oData );
	    
	    if ($oData === null) {
	        $this->_writeAccess(Inx_Apiimpl_Constants::LIST_ATTR_LIST_TYPE);
	        $this->oListData->listType = self::DYNAMIC_LIST;
	    }
	    
	}
	
	public function getFilterStmt()
	{
	    if (isset($this->oListData->filterStmt->value))
	        return $this->oListData->filterStmt->value;
	    return null;
	}
	
	public function updateFilterStmt( $sFilterStmt )
	{
	    $this->oListData->filterStmt = new stdClass;
	    $this->oListData->filterStmt->value = $sFilterStmt;
	    $this->_writeAccess( Inx_Api_List_FilterListContext::ATTRIBUTE_FILTER_STMT );
	}
}

