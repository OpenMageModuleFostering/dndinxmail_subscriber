<?php


/**
 * RecipientRowSetImpl
 * 
 * <P>Copyright (c) 2005 Inxmail GmbH. All Rights Reserved.
 * @version $Revision: 4693 $ $Date: 2006-09-20 11:04:31 +0000 (Mi, 20 Sep 2006) $ $Author: bgn $
 */
class Inx_Apiimpl_Recipient_UnsubscriptionRecipientRowSetImpl extends Inx_Apiimpl_RemoteObject implements Inx_Api_Recipient_UnsubscriptionRecipientRowSet
{
		
	protected $_oService;
	
	protected $_oRecipientContext;

	protected $_iRowCount;

	protected $_iCurrentUpdateRow = -1;
	
	protected $_aCurrentRecipient = null;
	
	protected $_aOriginRecipient = null;

	protected $_aChangedAttrs;

	protected $_oBuffer;
	
	protected $_iLastAccessedIndex = -1;
	
	protected $_listContext;


	public function __construct( Inx_Apiimpl_Recipient_RecipientContextImpl $oRecipientManager, stdClass $oRowSet, Inx_Api_List_ListContext $list )
	{
		parent::__construct( $oRecipientManager->_remoteRef(), $oRowSet->remoteRefId );
		
		$this->_oBuffer = new Inx_Apiimpl_Util_IndexedBuffer();
		$this->_oRecipientContext = $oRecipientManager;
		$this->_oService = $oRecipientManager->_remoteRef()->getService( 
				Inx_Apiimpl_SessionContext::UNSUBSCRIBER_SERVICE );
		$this->_iRowCount = $oRowSet->rowCount;
		$this->_listContext = $list;

		$updateableAttributeCount = $oRecipientManager->getUpdateableAttributeCount();
		if ($updateableAttributeCount > 0) {
			$this->_aChangedAttrs = array_fill(0, $updateableAttributeCount, null);
		}
		
		if( ($oRowSet->data != null) && (sizeof($oRowSet->data) > 0) )
		    // set the first bulk, beginning at index 0.
		    $this->_oBuffer->setBuffer( 0, $oRowSet->data );
	}

	
	/** 
	 * @see com.inxmail.xpro.api.recipient.RecipientRowSet#beforeFirstRow()
	 */
	public function beforeFirstRow()
	{
		$this->_iCurrentUpdateRow = -1;
		$this->_aCurrentRecipient = null;
		$this->_aOriginRecipient = null;
	}
	
	/**
	 * @see com.inxmail.xpro.api.recipient.RecipientRowSet#afterLastRow()
	 */
	public function afterLastRow()
	{
		$this->_iCurrentUpdateRow =$this->_iRowCount;
		$this->_aCurrentRecipient = null;
		$this->_aOriginRecipient = null;
	}
	
	/** 
	 * @see com.inxmail.xpro.api.recipient.RecipientRowSet#setRow(int)
	 */
	public function setRow( $iRow )
	{
	    if (!is_int($iRow)) {
		    throw new Inx_Api_IllegalArgumentException('Wrong parameter $iRow type, integer expected');
		}
	    if( $iRow < 0 || $iRow >= $this->_iRowCount )
			throw new Inx_Api_IndexOutOfBoundsException( "Index: " . $iRow . ", Size: " . $this->_iRowCount );
		$this->_iCurrentUpdateRow = $iRow;
		$this->fetchRecipient();
	}

    /**
     * @see com.inxmail.xpro.api.recipient.RecipientRowSet#getRow()
     */
    public function getRow()
    {
    	return $this->_iCurrentUpdateRow;
    }

    /**
     * @see com.inxmail.xpro.api.recipient.RecipientRowSet#next()
     * @return boolean
     */
    public function next()
    {
    	if( $this->_iCurrentUpdateRow >= $this->_iRowCount-1 )
    		return false;
    	
    	$this->_iCurrentUpdateRow++;
    	$this->fetchRecipient();
    	return true;
    }
    
    /**
     * @see com.inxmail.xpro.api.recipient.RecipientRowSet#previous()
     * @return boolean
     */
    public function previous()
    {
    	if( $this->_iCurrentUpdateRow < 1 )
    		return false;
    	
    	$this->_iCurrentUpdateRow--;
    	$this->fetchRecipient();
    	return true;
    }
    
    /**
     * @see com.inxmail.xpro.api.recipient.RecipientRowSet#getRowCount()
     */
    public function getRowCount()
    {
    	return $this->_iRowCount;
    }

    /**
     * @see com.inxmail.xpro.api.recipient.RecipientRowSet#commitRowUpdate()
     * @throws BlackListException, IllegalValueException, DuplicateKeyException, Inx_Api_DataException
     */
   public function commitRowUpdate()
	{
    	if( $this->_aCurrentRecipient == null )
    		throw new Inx_Api_DataException( "recipient deleted" );
    	
    	$ru = $this->_oRecipientContext->createRecipientUpdate( $this->_aCurrentRecipient, $this->_aChangedAttrs );
    	
    	try
		{
    	    $h = $this->_oService->updateRecipient( $this->_sessionId(), $this->_refId(), $ru );
    	    if(! empty($h->updExcDesc))
    	    {
    	        $x = $h->updExcDesc;

    	        switch( $x->type )
    			{
        			case Inx_Apiimpl_Recipient_Constants::UPDATE_EXCEPTION_ILLEGAL_VALUE:
        				throw new Inx_Api_Recipient_IllegalValueException( $x->msg, $x->type );
        			case Inx_Apiimpl_Recipient_Constants::UPDATE_EXCEPTION_DUPLICATE_KEY:
        				throw new Inx_Api_Recipient_DuplicateKeyException( $x->msg, $x->type );
        			case Inx_Apiimpl_Recipient_Constants::UPDATE_EXCEPTION_BLACK_LIST:
        				throw new Inx_Api_Recipient_BlackListException( $x->msg, $x->type );
        			case Inx_Apiimpl_Recipient_Constants::UPDATE_EXCEPTION_RECIPIENT_NOT_FOUND:
        				throw new Inx_Api_DataException( "recipient deleted" );
    			}
    	    }
    	    $this->_aCurrentRecipient = $h->value;
    		$this->_aOriginRecipient = null;
    		
    		if( $ru->id == 0 ) { // it is a new recipient
    			$this->_iRowCount++;
    		}
    		
    		$this->_oBuffer->setBuffer( $this->_iCurrentUpdateRow, $this->_aCurrentRecipient);    		
    		$this->fetchRecipient();
		}
    	catch( Inx_Api_RemoteException $e )
		{
    		$this->_notify( $e );
		}
	}
    

    /** 
     * @see com.inxmail.xpro.api.recipient.RecipientRowSet#deleteRow()
     */
    public function deleteRow()
    {
    	$this->deleteRows( new Inx_Api_IndexSelection( $this->_iCurrentUpdateRow ) );
    }
    
    /**
     * @see com.inxmail.xpro.api.recipient.RecipientRowSet#deleteRows(IndexSelection)
     */
    public function deleteRows( Inx_Api_IndexSelection $oSelection  )
    {
    	Inx_Apiimpl_Util_SelectionUtils::checkIndex( $oSelection, $this->_iRowCount );
    	try
		{
    		$this->_iRowCount = $this->_oService->deleteRecipients( $this->_sessionId(), $this->_refId(), 
    				Inx_Apiimpl_Util_SelectionUtils::convertToArray( $oSelection ) );
    		
    		$this->_oBuffer->clear();
    		$this->beforeFirstRow();
		}
    	catch( Inx_Api_RemoteException $e )
		{
    		$this->_notify( $e );
		}
    }
        


    /**
     * @see com.inxmail.xpro.api.recipient.RecipientRowSet#isRowDeleted()
     */
    public function isRowDeleted()
    {
    	return ($this->_aCurrentRecipient == null);
	}

    /**
     * Enter description here...
     *
     * @return boolean
     */
    public function setResubscribe( $subscriptionDate, Inx_Api_IndexSelection $oSelection=null )
    {
    	if (is_null($oSelection)) {
			try
			{
	    		return $this->_oService->setAttributeValue1( $this->_sessionId(), $this->_refId(),
	    				Inx_Apiimpl_TConvert::TConvert($subscriptionDate));
			}
			catch( Inx_Api_RemoteException $e )
			{
				$this->_notify( $e );
				return false;
			}
			
			$this->_oBuffer->clear();
    	} else {
	    	try
			{
	    		return $this->_oService->setAttributeValue2( $this->_sessionId(), $this->_refId(), 
	    				Inx_Apiimpl_TConvert::TConvert($subscriptionDate),
						Inx_Apiimpl_Util_SelectionUtils::convertToArray( $oSelection ) );
			} catch( Inx_Api_RemoteException $e ) {
				$this->_notify( $e );
				return false;
			}
			
			$this->_oBuffer->clear();
    	}
    }
    
    /*
    public boolean setAttributeValue( Inx_Api_Recipient_Attribute $oAttr, $newValue, IndexSelection selection )
    {

    }
	*/
    
    /**
     * Enter description here...
     *
     * @return int
     * @throws Inx_Api_DataException
     */
    public function getId()
    {
    	return $this->_aCurrentRecipient->id;
	}

    
    /**
     * Enter description here...
     *
     * @return String
     * @throws Inx_Api_DataException
     */
    public function getString( Inx_Api_Recipient_Attribute $oAttr )
    {
    	return $this->checkReadAccess( $oAttr )
    		 		->getString( $this->_aCurrentRecipient );
	}
    
    /**
     * Enter description here...
     *
     * @return Boolean
     * @throws Inx_Api_DataException
     */
    public function getBoolean( Inx_Api_Recipient_Attribute $oAttr )
    {
    	return $this->checkReadAccess( $oAttr )
    		 		->getBoolean( $this->_aCurrentRecipient );
	}
    
    /**
     * Enter description here...
     *
     * @return Integer
     * @throws Inx_Api_DataException
     */    
    public function getInteger( Inx_Api_Recipient_Attribute $oAttr )
    {
    	return $this->checkReadAccess( $oAttr )
    		 		->getInteger( $this->_aCurrentRecipient );
	}
    
    /**
     * Enter description here...
     *
     * @return Double
     * @throws Inx_Api_DataException
     */
    public function getDouble( Inx_Api_Recipient_Attribute $oAttr )
    {
    	return $this->checkReadAccess( $oAttr )
    		 		->getDouble( $this->_aCurrentRecipient );
	}
    
    /**
     * Enter description here...
     *
     * @return Date
     * @throws Inx_Api_DataException
     */
    public function getDate( Inx_Api_Recipient_Attribute $oAttr )
    {
    	return $this->checkReadAccess( $oAttr )
    		 		->getDate( $this->_aCurrentRecipient );
	}
    
    /**
     * Enter description here...
     *
     * @return Date
     * @throws Inx_Api_DataException
     */
    public function getTime( Inx_Api_Recipient_Attribute $oAttr )
    {
    	return $this->checkReadAccess( $oAttr )
    		 		->getTime( $this->_aCurrentRecipient );
	}
        
    /**
     * Enter description here...
     *
     * @return Date
     * @throws Inx_Api_DataException
     */
    public function getDatetime( Inx_Api_Recipient_Attribute $oAttr )
    {
    	return $this->checkReadAccess( $oAttr )
    		 		->getDatetime( $this->_aCurrentRecipient );
	}
	    
    /**
     * Enter description here...
     *
     * @return Object
     * @throws Inx_Api_DataException
     */
	public function getObject( Inx_Api_Recipient_Attribute $oAttr )
	{
		return $this->checkReadAccess( $oAttr )
    		 		->getObject( $this->_aCurrentRecipient );
	}
        
  
    
    /**
     * Enter description here...
     *
     * @return void
     * @throws Inx_Api_DataException
     */
    public function updateDatetime( Inx_Api_Recipient_Attribute $oAttr, $value )
    {
    	$this->checkWriteAccess( $oAttr )
    		 ->updateDatetime( $this->_aCurrentRecipient, $this->_aChangedAttrs, $value );
    }
    
    
	public function resubscribe( $subscriptionDate )
	{
			$attr = $this->getMetaData()->getSubscriptionAttribute( $this->_listContext );
			//fixes XAPI-38: added $this->
			$this->updateDatetime( $attr, $subscriptionDate === null ? $this->getDatetime( $attr ) : $subscriptionDate );
	}
  
    
    /**
     * Enter description here...
     *
     * @return RecipientMetaData
     */
	public function getMetaData()
	{
		return $this->_oRecipientContext->getMetaData();
	}
	

    
    /**
     * Enter description here...
     * 
     * @return void
     */
	public function close()
	{
	    $this->_release( true );
	}
	
    /**
     * Enter description here...
     * 
     * @return ContextAttribute
     * @throws Inx_Api_DataException
     */
	private function checkReadAccess( Inx_Api_Recipient_Attribute $oAttr )
	{
		if( $this->_aCurrentRecipient == null )
    		throw new Inx_Api_DataException( "recipient deleted" );

		if( $oAttr->getContext() === $this->_oRecipientContext ) {
			return $oAttr;
		}
		
		throw new Inx_Api_IllegalStateException( "wrong context" );
	}
	
    /**
     * Enter description here...
     *
     * @return Inx_Apiimpl_Recipient_ContextAttribute
     * @throws Inx_Api_DataException
     */
	private function checkWriteAccess( Inx_Api_Recipient_Attribute $oAttr ) 
	{
		if( $this->_aCurrentRecipient == null )
    		throw new Inx_Api_DataException( "recipient deleted" );
		if( $this->_aOriginRecipient == null )
		{
			$this->_aOriginRecipient = $this->_aCurrentRecipient;
			
			// clone the current recipient
			$this->_aCurrentRecipient = new stdClass(); // @TODO RecipientData
			$this->_aCurrentRecipient->id = $this->_aOriginRecipient->id;
			
			$sa = $this->_aOriginRecipient->stringData;
			if(! empty($sa))
			{
				$this->_aCurrentRecipient->stringData = $sa;
			}
			$ba = $this->_aOriginRecipient->booleanData;
			if(! empty($ba))
			{
				$this->_aCurrentRecipient->booleanData = $ba;
			}
			$ia = $this->_aOriginRecipient->integerData;
			if(! empty($ia))
			{
				$this->_aCurrentRecipient->integerData = $ia;
			}
			$da = $this->_aOriginRecipient->doubleData;
			if(! empty($da) )
			{
				$this->_aCurrentRecipient->doubleData = $da;
			}
			$dta = $this->_aOriginRecipient->datetimeData;
			if(! empty($dta))
			{
				$this->_aCurrentRecipient->datetimeData = $dta;
			}
			$ta = $this->_aOriginRecipient->dateData;
			if(! empty($ta))
			{
				$this->_aCurrentRecipient->dateData = $ta;
			}
			$tta = $this->_aOriginRecipient->timeData;
			if(! empty($tta))
			{
				$this->_aCurrentRecipient->timeData = $tta;
			}
			if (sizeof($this->_aChangedAttrs) > 0)
				$this->_aChangedAttrs = array_fill(0, sizeof($this->_aChangedAttrs), false);
			else {
				$this->_aChangedAttrs = array();
			}
		}
		
		$a = $oAttr;

		if( $a->getContext() === $this->_oRecipientContext ) 
			return $a;
		
		throw new Inx_Api_IllegalStateException( "wrong context" );
	}
	
	protected function fetchRecipient()
	{
		$this->_aOriginRecipient = null;
		$this->_aCurrentRecipient = null;

		try
		{
			$this->_aCurrentRecipient = $this->_oBuffer->getObject($this->_iCurrentUpdateRow);
		}
		catch( Exception $e ) // @TODO IndexedBuffer.IndexException???
		{
			try
			{
				if( $this->_iCurrentUpdateRow >= $this->_iLastAccessedIndex )
				{
					$this->_oBuffer->setBuffer( $this->_iCurrentUpdateRow, $this->_oService->fetchRecipients(
							$this->_sessionId(), $this->_refId(), $this->_iCurrentUpdateRow, Inx_Apiimpl_Constants::FETCH_FORWARD_DIRECTION ));
				}
				else
				{
					$oa = $this->_oService->fetchRecipients($this->_sessionId(), $this->_refId(), $this->_iCurrentUpdateRow,
							Inx_Apiimpl_Constants::FETCH_BACKWARD_DIRECTION );
					$this->_oBuffer->setBuffer($this->_iCurrentUpdateRow - sizeof($oa) + 1, $oa);
				}
				$this->_iLastAccessedIndex = $this->_iCurrentUpdateRow;
			}
			catch( Inx_Api_RemoteException $rx )
			{
				$this->_notify( $rx );
			}	
			try
			{
				$this->_aCurrentRecipient = $this->_oBuffer->getObject($this->_iCurrentUpdateRow);
			}
			catch( Exception $ix ) // @TODO IndexedBuffer.IndexException???
			{
				throw new Inx_Api_APIException( "implementation error in RecipientResultSetImpl", $ix );
			}
		}
	}

}
