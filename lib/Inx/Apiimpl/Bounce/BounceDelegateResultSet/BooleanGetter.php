<?php
	class Inx_Apiimpl_Bounce_BounceDelegateResultSet_BooleanGetter 
	                    extends Inx_Apiimpl_Bounce_BounceDelegateResultSet_AttrGetter
	{
		public function getObject( $oData )
		{
			return $this->getBoolean( $oData );
		}
		
		public function getBoolean( $oData )
		{
		    return Inx_Apiimpl_TConvert::convert( $oData->booleanData[$this->typedIndex] );
		}
	}