<?php

	class Inx_Apiimpl_Bounce_BounceDelegateResultSet_IntegerGetter 
	                extends Inx_Apiimpl_Bounce_BounceDelegateResultSet_AttrGetter
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