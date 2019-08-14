<?php

/**
 * RemoteInputStream
 * 
 * <P>Copyright (c) 2005 Inxmail GmbH. All Rights Reserved.
 * @version $Revision: 4685 $ $Date: 2006-09-19 12:23:02 +0000 (Di, 19 Sep 2006) $ $Author: bgn $
 */
class Inx_Apiimpl_Core_RemoteInputStream extends Inx_Api_InputStream
{

	/**
	 * Enter description here...
	 *
	 * @var RemoteRef
	 */
    protected $_oRemoteRef;

    /**
     * Enter description here...
     *
     * @var CoreService
     */
	protected $_oService;

	/**
	 * Enter description here...
	 *
	 * @var boolean
	 */
	protected $_blClosed = false;
	
    /**
     * The internal buffer where the data is stored.
     * 
     * @var string $_sBuf buffer returned from the service
     */
    protected $_sBuf = '';
    
    /**
     * The current position in the buffer. This is the index of the next 
     * character to be read from the <code>buf</code> array.
     * 
     * @var int 
     */
    protected $_iPos;


    /**
     * Enter description here...
     *
     */
    public function __construct( Inx_Apiimpl_RemoteRef $oRemoteRef )
	{
	    $this->_oRemoteRef = $oRemoteRef; 
		$this->_oService = $oRemoteRef->getService( Inx_Apiimpl_RemoteRef::CORE_SERVICE );
	}

    
    /**
     * Fills the buffer with new data.
     * @throws IOException
     */
    private function fill()
    {
        try {
            $r = $this->_oService->readInputStream( $this->_oRemoteRef->sessionId(), 
    				$this->_oRemoteRef->refId() );
        }
        catch (Inx_Api_RemoteException $e) {
            throw new Exception( $e->getMessage() );
        }
        
        $this->_iPos = 0;
        if( $r->closed )
        {   
            $this->_blClosed = true;
        	$this->_sBuf = '';
        }
        else
            $this->_sBuf = $r->b;
    }
    
    public function multiRead(&$sB, $iOff = null, $iLen = null)
    {
        if( $this->_blClosed )
	    		return -1;
	    	
        if( ($iOff | $iLen | ($iOff + $iLen) | (strlen($sB) - ($iOff + $iLen)) ) < 0) {
    	    throw new Inx_Api_IndexOutOfBoundsException();
    	} else if( $iLen == 0 ) {
    	    return 0;
    	}

        if( $this->_iPos >= strlen($this->_sBuf) )
        {
    	    $this->fill();
    	    if( $this->_iPos >= strlen($this->_sBuf) )
    	        return -1;
    	}
        
        $iAvail = strlen($this->_sBuf) - $this->_iPos;
    	$iCnt = ($iAvail < $iLen) ? $iAvail : $iLen;
    	
    	
    	$this->_sBuf = substr($this->_sBuf, 0, $this->_iPos);
    	//System.arraycopy( $this->_aBuf, $this->_iPos, $aB, $iOff, $iCnt ); // TODO array_merge or smth
    	$sB = substr($this->_sBuf, $iOff, $iCnt);
    	$this->_iPos += $iCnt;
	    return $iCnt;
    }
    
   
    /**
     * Enter description here...
     *
     * @return unknown
     * throws IOException, Inx_Api_IndexOutOfBoundsException
     */
    public function read($sB = null, $iOff = null, $iLen = null) 
	{
		if(!is_null($sB) || !is_null($iOff) || !is_null($iLen)) {
		    throw new Exception ('not implemented yet');
	        if( $this->_blClosed )
	    		return -1;
	    	
	        if( ($iOff | $iLen | ($iOff + $iLen) | (strlen($sB) - ($iOff + $iLen)) ) < 0) {
	    	    throw new Inx_Api_IndexOutOfBoundsException();
	    	} else if( $iLen == 0 ) {
	    	    return 0;
	    	}
	
	        if( $this->_iPos >= strlen($this->_sBuf) )
	        {
	    	    $this->fill();
	    	    if( $this->_iPos >= strlen($this->_sBuf) )
	    	        return -1;
	    	}
	        
	        $iAvail = strlen($this->_sBuf) - $this->_iPos;
	    	$iCnt = ($iAvail < $iLen) ? $iAvail : $iLen;
	    	
	    	
	    	$this->_sBuf = substr($this->_sBuf, 0, $this->_iPos);
	    	//System.arraycopy( $this->_aBuf, $this->_iPos, $aB, $iOff, $iCnt ); // TODO array_merge or smth
	    	
	    	$this->_iPos += $iCnt;
	    	return $iCnt;
		} else {
		
	        if( $this->_blClosed )
	    		return -1;
	        
	        if( $this->_iPos >= strlen($this->_sBuf) )
	        {
	    	    $this->fill();
	    	    if( $this->_iPos >= strlen($this->_sBuf) )
	    	        return -1;
	    	}
	    	return $this->_sBuf{$this->_iPos++};
	    	
		}
	}
    
	    
	/**
	 * 
	 * 
	 * @throws Inx_Api_IOException
	 */
    public function close() 
	{
		if(! $this->_blClosed)
		{
			try {
				$h = $this->_oService->closeInputStream( $this->_oRemoteRef->sessionId(), $this->_oRemoteRef->refId() );
				$this->_oRemoteRef->release( false );
			} catch (Exception $e) {
				throw new Inx_Api_IOException( $e->getMessage(), $e->getCode() );
			}
           	$this->_blClosed = true;
		}
	}

}
