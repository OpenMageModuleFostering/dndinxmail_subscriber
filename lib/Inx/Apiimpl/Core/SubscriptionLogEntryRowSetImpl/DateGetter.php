<?php
	class Inx_Apiimpl_DataAccess_ClickDataRowSetImpl_DateGetter 
	                        extends Inx_Apiimpl_DataAccess_ClickDataRowSetImpl_AttrGetter
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