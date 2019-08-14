<?php

class Inx_Apiimpl_List_AdminListImpl extends Inx_Apiimpl_List_ListImpl 
                                    implements Inx_Api_List_AdminListContext
{
	public function __construct( Inx_Apiimpl_SessionContext $oSc, $oData )
	{
		parent::__construct($oSc, $oData);
	}
}