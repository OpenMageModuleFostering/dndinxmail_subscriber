<?php


class Inx_Apiimpl_Util_SelectionUtils
{

	public static function convertToArray( Inx_Api_IndexSelection $oSelection )
	{
		if( $oSelection->getFirstIndex() == -1 ) {
		    return array();
		}
		else {
			$oStart = new stdClass;
			$oStart->value = (int)$oSelection->getFirstIndex();
			$oEnd = new stdClass;
			$oEnd->value = (int)$oSelection->getLastIndex() + 1;

		    return array($oStart, $oEnd);
		}
	}

	
	public static function checkIndex( Inx_Api_IndexSelection $oSelection, $iSize )
	{
	    if (!is_int($iSize)) {
		    throw new Inx_Api_IllegalArgumentException('Wrong parameter $iSize type, integer expected');
		}
	    if( $oSelection->getLastIndex() >= $iSize )
			throw new Inx_Api_IndexOutOfBoundsException(
				"last index in IndexSelection too great: " . $oSelection->getLastIndex() );
	}
}