<?php


class Inx_Apiimpl_List_SystemListImpl extends Inx_Apiimpl_List_ListImpl 
                                        implements Inx_Api_List_SystemListContext
{
	public function __construct( Inx_Apiimpl_SessionContext $oSc, $oData )
	{
		parent::__construct( $oSc, $oData );
	}
	
	
}