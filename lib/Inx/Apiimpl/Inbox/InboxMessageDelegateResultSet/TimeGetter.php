<?php
	class Inx_Apiimpl_Inbox_InboxMessageDelegateResultSet_TimeGetter 
	                extends Inx_Apiimpl_Inbox_InboxMessageDelegateResultSet_AttrGetter
	{
		public function getObject( $oData )
		{
			return $this->getTime( $oData );
		}
		
		public function getTime( $oData )
		{
			return Inx_Apiimpl_TConvert::convert( $oData->timeData[$this->typedIndex] );
		}
	}