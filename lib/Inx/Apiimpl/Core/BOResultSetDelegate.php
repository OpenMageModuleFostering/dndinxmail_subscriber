<?php

/**
 * BOResultSetDelegate
 * 
 * @version $Revision$ $Date$ $Author$
 */
interface Inx_Apiimpl_Core_BOResultSetDelegate
{

	public function removeBOs( Inx_Apiimpl_RemoteRef $oResultSetRef, $aIndexRanges );
		
	public function fetchBOs( Inx_Apiimpl_RemoteRef $oResultSetRef, $iIndex, $iDirection );
}
