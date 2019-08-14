<?php
/**
 * 
 * 
 * @author sbn, 16.01.2007
 * @copyright Inxmail GmbH
 * @version $Revision:$ $Date:$ $Author:$
 */


class Inx_Apiimpl_DataAccess_ClickDataRowSetImpl
                                    extends Inx_Apiimpl_RemoteObject 
                                    implements Inx_Api_DataAccess_ClickDataRowSet 
{

	private $_iRowCount;
	
	protected $_oBuffer = null;

	private $_iCurrentRow = -1;
	protected $_iLastAccessedIndex = -1;

	private $_oCurrentClick = null;

	private $_oService;

	private $_oRecipientContext = null;
	
	private $_aAttrGetterMapping = null;


	
	public function __construct( 
	            Inx_Apiimpl_SessionContext $sc, 
	            Inx_Api_Recipient_RecipientContext $rc, 
	            array $aAttrs = null, $oResult )
	{
		
	    parent::__construct($sc, $oResult->remoteRefId);
	    
		$this->_iRowCount = $oResult->rowCount;
		$this->_oService = $sc->getService( Inx_Apiimpl_SessionContext::DATAACCESS_SERVICE );
		$this->_oRecipientContext = $rc;
		if($aAttrs !== null) {
		    foreach ($aAttrs as $key => $val) {
		        $g = Inx_Apiimpl_DataAccess_ClickDataRowSetImpl_AttrGetter::create($val);
		        $g->typedIndex  = $oResult->typedIndices[$key];
		        
		        $this->_aAttrGetterMapping[$aAttrs[$key]->getId()] = $g;
		    }
		}
        $this->_oBuffer = new Inx_Apiimpl_Util_IndexedBuffer();
		if( $oResult->data !== null && count($oResult->data) > 0 ) {
		    // set the first bulk, beginning at index 0.
		    
		    $this->_oBuffer->setBuffer( 0, $oResult->data );
		}
	}
    /**
     * @throws Inx_Api_DataException
     */
	public function getBoolean( Inx_Api_Recipient_Attribute $oAttr ) 
	{
		return $this->_checkReadAccess( $oAttr )->getBoolean( $this->_oCurrentClick );
	}
    /**
     * @throws Inx_Api_DataException
     */
	public function getClickId() 
	{
		$this->_checkExists();
		return $this->_oCurrentClick->clickId;
	}

	/**
	 * @throws Inx_Api_DataException
	 */
	public function getClickTimestamp() 
	{
		$this->_checkExists();
		return Inx_Apiimpl_TConvert::convert( $this->_oCurrentClick->clickTimestamp);

	}

	/**
	 * @throws Inx_Api_DataException
	 */
	public function getDate( Inx_Api_Recipient_Attribute $oAttr )
	{
		
		return $this->_checkReadAccess( $oAttr )->getDate( $this->_oCurrentClick );
	}
	
	/**
	 * @throws Inx_Api_DataException
	 */
	public function getDatetime( Inx_Api_Recipient_Attribute $oAttr )
	{
		return $this->_checkReadAccess( $oAttr )->getDateTime( $this->_oCurrentClick );
	}
	
    /**
	 * @throws Inx_Api_DataException
	 */
	public function getDouble( Inx_Api_Recipient_Attribute $oAttr )
	{
		return $this->_checkReadAccess( $oAttr )->getDouble( $this->_oCurrentClick );
	}
	
    /**
	 * @throws Inx_Api_DataException
	 */
	public function getInteger( Inx_Api_Recipient_Attribute $oAttr ) 
	{
		return $this->_checkReadAccess( $oAttr )->getInteger( $this->_oCurrentClick );
	}

	/**
	 * @throws Inx_Api_DataException
	 */
	public function getLinkId()
	{
		$this->_checkExists();
		return $this->_oCurrentClick->linkId;

	}

	/**
	 * @throws Inx_Api_DataException
	 */
	public function getRecipientId()
	{
		$this->_checkExists();
		return $this->_oCurrentClick->recipientId;

	}
	
	/**
	 * @throws Inx_Api_DataException
	 */
	public function getRecipientState()
	{
		$this->_checkExists();
		return $this->_oCurrentClick->recipientState;
	}
	
	/**
	 * @throws Inx_Api_DataException
	 */
	public function getRemoteHost()
	{
		$this->_checkExists();
		return Inx_Apiimpl_TConvert::convert( $this->_oCurrentClick->remoteHost);
	}
    
	/**
	 * @throws DataException
	 */
	public function getString( Inx_Api_Recipient_Attribute $oAttr )
	{
		return $this->_checkReadAccess( $oAttr )->getString( $this->_oCurrentClick );
	}

	/**
	 * @throws DataException
	 */
	public function getTime( Inx_Api_Recipient_Attribute $oAttr ) 
	{
		return $this->_checkReadAccess( $oAttr )->getTime( $this->_oCurrentClick );
	}

	/**
	 * @throws DataException
	 */
	public function getUserAgent()
	{
		$this->_checkExists();
		return Inx_Apiimpl_TConvert::convert( $this->_oCurrentClick->userAgent );
	}

	/**
	 * @throws DataException
	 */
	public function getObject( Inx_Api_Recipient_Attribute $oAttr ) 
	{
		return $this->_checkReadAccess( $oAttr )->getObject( $this->_oCurrentClick );
	}
	
	public function getRow()
	{
		return $this->_iCurrentRow;
	}

	public function getRowCount()
	{
		return $this->_iRowCount;
	}

	public function next()
	{
    	if(  $this->_iCurrentRow >= $this->_iRowCount-1 )
    		return false;
    	
    	$this->_iCurrentRow++;
    	$this->_fetchClick();
    	return true;
	}

	public function previous()
	{
    	if( $this->_iCurrentRow < 1 )
    		return false;
    	
    	$this->_iCurrentRow--;
    	$this->_fetchClick();
    	return true;
	}

	public function setRow( $row )
	{
	    if (!is_int($row)) {
		    throw new Inx_Api_IllegalArgumentException('Integer parameter $row expected, got '.gettype($row));
		}
	    
	    if( $row < 0 || $row >= $this->_iRowCount )
			throw new Inx_Api_IndexOutOfBoundsException( "Index: ".$row.", Size: ".$this->_iRowCount );
		$this->_iCurrentRow = $row;
		$this->_fetchClick();

	}


	public function close()
	{
		$this->_release( true );
		
	}

	private function _fetchClick()
	{
		$this->_oCurrentClick = null;

		try
		{
			$this->_oCurrentClick = $this->_oBuffer->getObject( $this->_iCurrentRow );
		}
		catch( Inx_Apiimpl_Util_IndexException $x )
		{
			try
			{
				if( $this->_iCurrentRow >= $this->_iLastAccessedIndex )
				{
					$this->_oBuffer->setBuffer( 
					    $this->_iCurrentRow, 
					    $this->_oService->fetchClick( 
    						$this->_createCxt(), 
    						$this->_refId(), 
    						$this->_iCurrentRow, 
    						Inx_Apiimpl_Constants::FETCH_FORWARD_DIRECTION 
    					) 
    				);
				}
				else
				{
					$oa = $this->_oService->fetchClick(
					        $this->_createCxt(), 
					        $this->_refId(), 
					        $this->_iCurrentRow,
							Inx_Apiimpl_Constants::FETCH_BACKWARD_DIRECTION );
					buffer.setBuffer( $this->_iCurrentRow - count($oa) + 1, $oa );
				}
				$this->_iLastAccessedIndex = $this->_iCurrentRow;
			}
			catch( Inx_Api_RemoteException $rx )
			{
				$this->_notify( $rx );
			}	
			try
			{
				$this->_oCurrentClick = $this->_oBuffer->getObject( $this->_iCurrentRow );
			}
			catch( Inx_Apiimpl_Util_IndexException $ix )
			{
				throw new Inx_Api_APIException( "implementation error in Inx_Apiimpl_ClickDataRowSetImpl", $ix );
			}
		}
	}
	/**
	 * @param Inx_Api_Recipient_Attribute $oAttr attribute
	 * @return Inx_Apiimpl_DataAccess_ClickDataRowSetImpl_AttrGetter
	 * @throws Inx_Api_DataException
	 */
	private function _checkReadAccess( Inx_Api_Recipient_Attribute $oAttr ) 
	{
		if( $this->_oCurrentClick === null )
    		throw new Inx_Api_DataException( "click deleted" );
			
		if( $oAttr->getContext() === $this->_oRecipientContext )
		{
			$ret = $this->_aAttrGetterMapping[ $oAttr->getId() ];
			if($ret === null)
				throw new Inx_Api_IllegalArgumentException( "attribute not in fetch profile" );
			
			return $ret;
		}
		
		throw new IllegalStateException( "wrong context" );
		
	}
	
	/**
	 * @throws DataException
	 */
	private function _checkExists()
	{
		if($this->_oCurrentClick === null)
			throw new Inx_Api_DataException("click deleted");
		
	}

	public function afterLastRow()
	{
		$this->_iCurrentRow = $this->_iRowCount;
		$this->_currentClick = null;
	}

	public function beforeFirstRow()
	{
		$this->_iCurrentRow = -1;
		$this->_currentClick = null;
	}

}
