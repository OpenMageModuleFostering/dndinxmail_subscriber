<?php

	class Inx_Apiimpl_Inbox_InboxMessageDelegateResultSet_DoubleGetter 
	                extends Inx_Apiimpl_Inbox_InboxMessageDelegateResultSet_AttrGetter
	{
		public function getObject( $oData )
		{
			return $this->getDouble( $oData );
		}
		
		public function getDouble( $oData )
		{
			return Inx_Apiimpl_TConvert::convert( $oData->doubleData[$this->typedIndex] );
		}
	}