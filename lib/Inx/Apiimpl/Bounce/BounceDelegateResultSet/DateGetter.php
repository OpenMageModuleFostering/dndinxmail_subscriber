<?php
	class Inx_Apiimpl_Bounce_BounceDelegateResultSet_DateGetter 
	                        extends Inx_Apiimpl_Bounce_BounceDelegateResultSet_AttrGetter
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