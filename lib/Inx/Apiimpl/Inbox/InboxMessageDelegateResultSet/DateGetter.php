<?php
	class Inx_Apiimpl_Inbox_InboxMessageDelegateResultSet_DateGetter 
	                        extends Inx_Apiimpl_Inbox_InboxMessageDelegateResultSet_AttrGetter
	{
		public function getObject( $oData )
		{
			return $this->getDate( $oData );
		}
		
		public function getDate( $oData )
		{
			return Inx_Apiimpl_TConvert::convert( $oData->dateData[$this->typedIndex] );
		}
	}