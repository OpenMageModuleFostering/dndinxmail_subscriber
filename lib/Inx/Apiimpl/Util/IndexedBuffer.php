<?php
/**
 * IndexedBuffer
 * 
 * @author bgn, 18.06.2004
 * @copyright inxnet GmbH
 * @version $Revision: 2934 $ $Date: 2005-07-04 15:00:09 +0000 (Mo, 04 Jul 2005) $ $Author: bgn $
 */
class Inx_Apiimpl_Util_IndexedBuffer
{

	protected $_aFetchObjects;

	protected $_iBeginIndex = PHP_INT_MAX;

	protected $_iEndIndex = -1;

	
	/**
	 * @throws IndexException
	 */
	public function getObject( $iIndex ) 
	{
	    if (!is_int($iIndex)) {
		    throw new Inx_Api_IllegalArgumentException('Wrong parameter $iIndex type, integer expected');
		}
	    if( $iIndex < $this->_iBeginIndex || $iIndex > $this->_iEndIndex )
			throw new Inx_Apiimpl_Util_IndexException();
	    
		return $this->_aFetchObjects[ $iIndex - $this->_iBeginIndex ];
	}


	public function setBuffer( $iBeginIndex, $mFetchObjects )
	{
	    if (!is_int($iBeginIndex)) {
		    throw new Inx_Api_IllegalArgumentException('Wrong parameter $iBeginIndex type, integer expected');
		}
	    if (is_array($mFetchObjects)) {
    	    $this->_iBeginIndex = $iBeginIndex;
    		$this->_aFetchObjects = $mFetchObjects;
    		$this->_iEndIndex = $iBeginIndex + count($mFetchObjects) - 1;
		} else {
		    if( $iBeginIndex < $this->_iBeginIndex || $iBeginIndex > $this->_iEndIndex  )
			    return;
		
		    $this->_aFetchObjects[ $iBeginIndex - $this->_iBeginIndex ] = $mFetchObjects;
		}
	}


	
	
	public function clear()
	{
		$this->_iBeginIndex  = PHP_INT_MAX;
		$this->_aFetchObjects = null;
		$this->_iEndIndex = -1;
	}

}