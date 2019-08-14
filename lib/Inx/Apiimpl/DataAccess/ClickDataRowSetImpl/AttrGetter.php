<?php
abstract class Inx_Apiimpl_DataAccess_ClickDataRowSetImpl_AttrGetter
{
	public $typedIndex;
    
	
	public static function create( Inx_Api_Recipient_Attribute $oAttr )
	{
		$g = null;
		switch( $oAttr->getDataType() )
		{
			case Inx_Api_Recipient_Attribute::DATA_TYPE_BOOLEAN:
				$g = new Inx_Apiimpl_DataAccess_ClickDataRowSetImpl_BooleanGetter();
				break;
			case Inx_Api_Recipient_Attribute::DATA_TYPE_DATE:
				$g = new Inx_Apiimpl_DataAccess_ClickDataRowSetImpl_DateGetter();
				break;
			case Inx_Api_Recipient_Attribute::DATA_TYPE_DATETIME:
				$g = new Inx_Apiimpl_DataAccess_ClickDataRowSetImpl_DateTimeGetter();
				break;
			case Inx_Api_Recipient_Attribute::DATA_TYPE_DOUBLE:
				$g = new Inx_Apiimpl_DataAccess_ClickDataRowSetImpl_DoubleGetter();
				break;
			case Inx_Api_Recipient_Attribute::DATA_TYPE_INTEGER:
				$g = new Inx_Apiimpl_DataAccess_ClickDataRowSetImpl_IntegerGetter();
				break;
			case Inx_Api_Recipient_Attribute::DATA_TYPE_STRING:
				$g = new Inx_Apiimpl_DataAccess_ClickDataRowSetImpl_StringGetter();
				break;
			case Inx_Api_Recipient_Attribute::DATA_TYPE_TIME:
				$g = new Inx_Apiimpl_DataAccess_ClickDataRowSetImpl_TimeGetter();
				break;
		}
		return $g;
	}
			
	public function getDateTime( $oCurrentClick )
	{
		throw new Inx_Api_IllegalStateException( "attribute type mismatch" );
	}

	public function getTime(  $oCurrentClick )
	{
		throw new Inx_Api_IllegalStateException( "attribute type mismatch" );
	}

	public function getString(  $oCurrentClick )
	{
		throw new Inx_Api_IllegalStateException( "attribute type mismatch" );
	}

	public function getDouble(  $oCurrentClick )
	{
		throw new Inx_Api_IllegalStateException( "attribute type mismatch" );
	}

	public function getDate(  $oCurrentClick )
	{
		throw new Inx_Api_IllegalStateException( "attribute type mismatch" );
	}

	public abstract function getObject(  $oData );
	
	public function getInteger( $oData )
	{
		throw new Inx_Api_IllegalStateException( "attribute type mismatch" );
	}
	
	public function getBoolean( $oData )
	{
		throw new Inx_Api_IllegalStateException( "attribute type mismatch" );
	}
	
	
}