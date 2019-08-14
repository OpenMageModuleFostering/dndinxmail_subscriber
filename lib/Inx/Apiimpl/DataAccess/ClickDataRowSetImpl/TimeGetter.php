<?php
	class Inx_Apiimpl_DataAccess_ClickDataRowSetImpl_TimeGetter 
	                extends Inx_Apiimpl_DataAccess_ClickDataRowSetImpl_AttrGetter
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