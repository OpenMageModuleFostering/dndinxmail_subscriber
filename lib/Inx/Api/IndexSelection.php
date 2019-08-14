<?php
/**
 * @package Inxmail
 */
/**
 * This class represents the current state of a selection. It encapsulates a single selection interval.
 * 
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 */
class Inx_Api_IndexSelection
{
	private $iBeginIndex;
	
	private $iEndIndex;
	
	/**
	 * Creates a selection. 
	 * If $iBeginIndex and $iEndIndex are omitted, this will create an empty selection. 
	 * If only $iEndIndex is omitted, the selection will contain only $iEndIndex.
	 * If both parameters are set, the selection will contain the set of indices between $iBeginIndex 
	 * and $iEndIndex inclusive.
	 * 
	 * @param int $iBeginIndex one end of the interval, may be omitted.
	 * @param int $iEndIndex other ent of the interval (inclusive), may be omitted.
	 */
	public function __construct($iBeginIndex = null, $iEndIndex = null)
	{		
		if ($iBeginIndex===null && $iEndIndex===null) {
			$this->iBeginIndex = -1;
			$this->iEndIndex = -1;			
		} elseif($iBeginIndex!==null && $iEndIndex===null){
			$this->setSelectionInterval( $iBeginIndex );
		} elseif($iBeginIndex!==null && $iEndIndex!==null){
			$this->setSelectionInterval( $iBeginIndex, $iEndIndex );
		}
	}
	
	
	/**
	 * Change the selection to be the set of indices between $iBeginIndex and $iEndIndex inclusive. 
	 * $iEndIndex may be omitted, thus changing the selection to only contain $iBeginIndex.
	 * 
	 * @param int $iBeginIndex	one end of the interval.
	 * @param int $iEndIndex	other end of the interval (inclusive), may be omitted.
	 */
	public function setSelectionInterval( $iBeginIndex = null, $iEndIndex = null )
	{
		if( $iBeginIndex < 0 || $iEndIndex < 0 ) {
			throw new Exception( "Indices must be positive" );
		}
		if($iEndIndex===null) {
			$iEndIndex = $iBeginIndex;
		}
		if( $iBeginIndex > $iEndIndex) {
			$this->iBeginIndex = $iEndIndex;
			$this->iEndIndex = $iBeginIndex;
		} else {
			$this->iBeginIndex = $iBeginIndex;
			$this->iEndIndex = $iEndIndex;
		}
	}
	
	
	/**
	 * Returns the number of selected elements.
	 * 
	 * @return int the number of selected elements
	 */
	public function getSelectionCount()
	{
		if( $this->iBeginIndex == -1 )
			return 0;
		
		return $this->iEndIndex - $this->iBeginIndex + 1;
	}
	
	
	/**
	 * Returns the first selected index or -1 if the selection is empty.
	 * 
	 * @return int the first selected index
	 */
	public function getFirstIndex()
	{
		return $this->iBeginIndex;
	}
	
	
	/**
	 * Returns the last selected index or -1 if the selection is empty.
	 * 
	 * @return int the last selected index
	 */
	public function getLastIndex()
	{
		return $this->iEndIndex;
	}

}
