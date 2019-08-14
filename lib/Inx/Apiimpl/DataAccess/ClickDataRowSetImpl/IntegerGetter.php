<?php

	class Inx_Apiimpl_DataAccess_ClickDataRowSetImpl_IntegerGetter 
	                extends Inx_Apiimpl_DataAccess_ClickDataRowSetImpl_AttrGetter
	{
		public function getObject( $oData )
		{
			return $this->getInteger( $oData );
		}
		
		public function getInteger( $oData )
		{
			return Inx_Apiimpl_TConvert::convert( $oData->integerData[$this->typedIndex] );
		}
	}