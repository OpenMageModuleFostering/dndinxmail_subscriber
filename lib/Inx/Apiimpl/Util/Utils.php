<?php

/**
 * Utils
 * 
 * @version $Revision: 2934 $ $Date: 2005-07-04 15:00:09 +0000 (Mo, 04 Jul 2005) $ $Author: bgn $
 */
class Inx_Apiimpl_Util_Utils
{

	/**
	public static function toArray( $aInt )
	{
		final int len = ia.length;
		final int[] ret = new int[ len ];
		for( int i=0; i<len; i++ )
			ret[i] = ia[i].intValue();
		return ret;
	}
	
	
	public static int[] toIntArray( List list )
	{
		final int len = list.size();
		final int[] ret = new int[ len ];
		for( int i=0; i<len; i++ )
			ret[i] = ((Integer)list.get(i)).intValue();
		return ret;
	}
*/
	
	
	public static function trimEnd( $array, $count )
	{
		$i=0;
		$ret = array();
		foreach ($array as $key => $value) {
			
			if ($i>=$count) {
				return $ret;
			}
			$ret[] = $value;
			$i++;
			
		}
		return $ret;
	}
}
