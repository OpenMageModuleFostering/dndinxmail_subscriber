<?php
/**
 * 
 * 
 * @author sbn, 17.01.2007
 * @copyright Inxmail GmbH
 * @version $Revision:$ $Date:$ $Author:$
 */
class Inx_Apiimpl_DataAccess_LinkDataRowSetImpl
                 extends Inx_Apiimpl_RemoteObject implements Inx_Api_DataAccess_LinkDataRowSet
{

	private $_iRowCount;
	
	protected $_oBuffer = null;

	private $_iCurrentRow = -1;
	protected $_iLastAccessedIndex = -1;
	
	private $_oService;

	private $_oCurrentLink = null;

	public function __construct( Inx_Apiimpl_SessionContext $sc, $oResult )
	{
		parent::__construct( $sc, $oResult->remoteRefId );
		$this->_iRowCount = $oResult->rowCount;
		$this->_oService = $sc->getService( Inx_Apiimpl_SessionContext::DATAACCESS_SERVICE );
		$this->_oBuffer = new Inx_Apiimpl_Util_IndexedBuffer();
	}

	/**
	 * @throws Inx_Api_DataException
	 */
	public function getActionId()
	{
		$this->_checkExists();
		return $this->_oCurrentLink->actionId;
	}

	/**
	 * @throws Inx_Api_DataException
	 */
	public function getLinkId() 
	{
		$this->_checkExists();
		return $this->_oCurrentLink->linkId;
	}

	/**
	 * @throws Inx_Api_DataException
	 */
	public function getLinkName()
	{
		$this->_checkExists();
		return Inx_Apiimpl_TConvert::convert($this->_oCurrentLink->linkName);
	}

	/**
	 * @throws Inx_Api_DataException
	 */
	public function getLinkType()
	{
		$this->_checkExists();
		return $this->_oCurrentLink->linkType;
	}

	/**
	 * @throws Inx_Api_DataException
	 */
	public function getLinkUrl()
	{
		$this->_checkExists();
		return Inx_Apiimpl_TConvert::convert( $this->_oCurrentLink->linkUrl );
	}

	/**
	 * @throws Inx_Api_DataException
	 */
	public function getMailingId()
	{
		$this->_checkExists();
		return $this->_oCurrentLink->mailing;
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
    	$this->_fetchLink();
    	return true;
	}

	public function previous()
	{
    	if( $this->_iCurrentRow < 1 )
    		return false;
    	
    	$this->_iCurrentRow--;
    	$this->_fetchLink();
    	return true;
	}

	public function setRow( $iRow )
	{
		if (!is_int($iRow)) {
		    throw new Inx_Api_IllegalArgumentException('Integer parameter $iRow expected, got '.gettype($iRow));
		}
	    if( $iRow < 0 || $iRow >= $this->_iRowCount )
			throw new Inx_Api_IndexOutOfBoundsException( "Index: ".$iRow.", Size: ".$this->_iRowCount );
		$this->_iCurrentRow = $iRow;
		$this->_fetchLink();

	}


	public function close()
	{
		$this->_release( true );
		
	}
	
	private function _fetchLink()
	{
		$this->_oCurrentLink = null;

		try
		{
			$this->_oCurrentLink = $this->_oBuffer->getObject( $this->_iCurrentRow );
		}
		catch( Inx_Apiimpl_Util_IndexException $x )
		{
			try
			{
				if( $this->_iCurrentRow >= $this->_iLastAccessedIndex )
				{
					$this->_oBuffer->setBuffer( $this->_iCurrentRow, $this->_oService->fetchLink( 
						$this->_createCxt(), $this->_refId(), $this->_iCurrentRow, 
						Inx_Apiimpl_Constants::FETCH_FORWARD_DIRECTION ) );
				}
				else
				{
					$oa = $this->_oService->fetchLink($this->_createCxt(), $this->_refId(), $this->_iCurrentRow,
							Inx_Apiimpl_Constants::FETCH_BACKWARD_DIRECTION );
					$this->_oBuffer->setBuffer( $this->_iCurrentRow - count($oa) + 1, $oa );
				}
				$this->_iLastAccessedIndex = $this->_iCurrentRow;
			}
			catch( Inx_Api_RemoteException $rx )
			{
				$this->_notify( $rx );
			}	
			try
			{
				$this->_oCurrentLink = $this->_oBuffer->getObject( $this->_iCurrentRow );
			}
			catch( Inx_Apiimpl_Util_IndexException $ix )
			{
				throw new Inx_Api_APIException( "implementation error in LinkDataRowSetImpl", $ix );
			}
		}
	}
	
	/**
	 * @throws Inx_Api_DataException
	 */
	private function _checkExists()
	{
		if($this->_oCurrentLink == null)
			throw new Inx_Api_DataException("link deleted");
		
	}

	public function afterLastRow()
	{
		$this->_iCurrentRow = $this->_iRowCount;
		$this->_oCurrentLink = null;
	}

	public function beforeFirstRow()
	{
		$this->_iCurrentRow = -1;
		$this->_oCurrentLink = null;
	}

}
