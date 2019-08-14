<?php
/**
 * SubscriptionManagerImpl
 * 
 * @version $Revision: 3456 $ $Date: 2005-10-25 08:47:44 +0000 (Di, 25 Okt 2005) $ $Author: bgn $
 */
class Inx_Apiimpl_Core_SubscriptionManagerImpl implements Inx_Api_Subscription_SubscriptionManager
{

	protected $_oCoreService;
	
    protected $_oSessionContext;


	public function __construct( Inx_Apiimpl_SessionContext $oSc )
	{
		$this->_oSessionContext = $oSc;
		$this->_oCoreService = $oSc->getService( Inx_Apiimpl_SessionContext::CORE_SERVICE );
	}
	
	/**
	 * @throws FeatureNotAvailableException
	 */
	public function processSubscription( $sSourceIdentifier = null, $sRemoteAddress = null, 
			Inx_Api_List_StandardListContext $oListContext, $sEmailAddress,
			$aAttrKeyValuePairs = array() ) 
	{
		if (!isset($sSourceIdentifier) && !isset($sRemoteAddress) && count($aAttrKeyValuePairs) == 0) {
		    $this->processSubscription2($oListContext, $sEmailAddress);
		}
	    
		$oAttrs = new stdClass;
		
		if( count($aAttrKeyValuePairs) != 0 )
		{
			$aStrKeys = array();
			$aStrValues = array();
			$aBoolKeys = array();
			$aBoolValues = array();
			$aIntKeys = array();
			$aIntValues = array();
			$aDoubleKeys = array();
			$aDoubleValues = array();
			$aDatetimeKeys = array();
			$aDatetimeValues = array();
			$aDateKeys = array();
			$aDateValues = array();
			$aTimeKeys = array();
			$aTimeValues = array();
			
			foreach( $aAttrKeyValuePairs as $key => $val )
			{
			    
				if( $val === null ) {
					$aStrKeys[] = $key;
					$aStrValues[] = null;
				}
				elseif( is_string($val) ) {
					// check if this is iso8601 date
$sPregDatetime = '/^-?[0-9]{4}-([0-9]{2})-([0-9]{2})T([0-9]{2}):([0-9]{2}):([0-9]{2})(\\.[0-9]{3})?(Z|[+\-][0-9]{4}|[+\-][0-9]{2}:[0-9]{2})?$/u';
$sPregDate = '/^[0-9]{4}-([0-9]{2})-([0-9]{2})(Z|[+\-][0-9]{4}|[+\-][0-9]{2}:[0-9]{2})?$/u';
$sPregTime = '/^[0-9]{2}:([0-9]{2}):([0-9]{2})(\\.[0-9]{3})?(Z|[+\-][0-9]{4}|[+\-][0-9]{2}:[0-9]{2})?$/u';
				    
				    if( 0 != preg_match($sPregDatetime, $val))  { 
				        
    				    $aDatetimeKeys[] = $key;
    				    $oVal = new stdClass;
    				    $oVal->value = $val; 
    					$aDatetimeValues[] = $oVal;
    				}
    				elseif( 0 != preg_match($sPregDate, $val) ) {
    				    $aDateKeys[] = $key;
    				    $oVal = new stdClass;
    				    $oVal->value = $val; 
    					$aDateValues[] = $oVal;
    				}
    				elseif( 0 != preg_match($sPregTime, $val) ) {
    				    $aTimeKeys[] = $key;
    				    $oVal = new stdClass;
    				    $oVal->value = $val; 
    					$aTimeValues[] = $oVal;
    				}
    				else {    
    				    $aStrKeys[] = $key;
    					$oVal = new stdClass;
    					$oVal->value = (string)$val;
    					$aStrValues[] = $oVal;
    				}
				}
				elseif( is_bool($val) ) {
					$aBoolKeys[] = $key;
					$oVal = new stdClass;
					$oVal->value = (boolean)$val;
				    $aBoolValues[] = $oVal;
				}
				elseif( is_int($val) )	{
				    $aIntKeys[] = $key;
				    $oVal = new stdClass;
				    $oVal->value = (int)$val;
					$aIntValues[] = $oVal;
				}
				elseif( is_float($val) ) {
				    $aDoubleKeys[] = $key;
				    $oVal = new stdClass;
				    $oVal->value = (double)$val;
				    $aDoubleValues[] = $oVal;
				}
			}
			$oAttrs->strKeys = null;
			$oAttrs->setStrValues = null;
			if( count($aStrKeys) > 0 ) {
				$oAttrs->strKeys = $aStrKeys;
				$oAttrs->strValues = $aStrValues;
			}
			$oAttrs->boolKeys = null;
			$oAttrs->boolValues = null;
			if( count($aBoolKeys) > 0 )
			{
				$oAttrs->boolKeys = $aBoolKeys;
				$oAttrs->boolValues = $aBoolValues;
			}
			$oAttrs->intKeys = null;
			$oAttrs->intValues = null;
			if( count($aIntKeys) > 0 )
			{
    			$oAttrs->intKeys = $aIntKeys;
    			$oAttrs->intValues = $aIntValues;
			}
			$oAttrs->doubleKeys = null;
			$oAttrs->doubleValues = null;
			if( count($aDoubleKeys) > 0 )
			{
				$oAttrs->doubleKeys = $aDoubleKeys;
				$oAttrs->doubleValues = $aDoubleValues;
			}
			$oAttrs->datetimeKeys = null;
			$oAttrs->datetimeValues = null;
			if( count($aDatetimeKeys) )
			{
			    $oAttrs->datetimeKeys = $aDatetimeKeys;
			    $oAttrs->datetimeValues = $aDatetimeValues;
			}
		    $oAttrs->dateKeys = null;
			$oAttrs->dateValues = null;
			if( count($aDateKeys) )
			{
			    $oAttrs->dateKeys = $aDateKeys;
			    $oAttrs->dateValues = $aDateValues;
			}
		    $oAttrs->timeKeys = null;
			$oAttrs->timeValues = null;
			if( count($aTimeKeys) )
			{
			    $oAttrs->timeKeys = $aTimeKeys;
			    $oAttrs->timeValues = $aTimeValues;
			}
		}	

		try
		{
		    $oRet = $this->_oCoreService->processSubUnsubscription( 
		                                $this->_oSessionContext->sessionId(), 
		                                true,
		    		                    $sSourceIdentifier, 
		    		                    $sRemoteAddress, 
		    		                    $oListContext->getId(), 
		    		                    $sEmailAddress, 
		    		                    $oAttrs );
		    return $oRet->value;
		}
		catch( Inx_Apiimpl_SoapException $x) {
		    throw new Inx_Api_FeatureNotAvailableException(Inx_Api_Features::SUBSCRIPTION_FEATURE_ID);
		}
		catch( Inx_Api_RemoteException $x )
		{
		    $this->_oSessionContext->notify( $x );
			return -1;
		}
	}
	
	/**
	 * @throws FeatureNotAvailableException
	 */
	public function processUnsubscription( $sSourceIdentifier=null, $sRemoteAddress=null,
			Inx_Api_List_StandardListContext $oListContext, $sEmailAddress, $mailingId = 0 ) 
	{
	    if (is_null($sSourceIdentifier) && is_null($sRemoteAddress)) {
	        $this->processUnsubscription2($oListContext, $sEmailAddress);
	    }
	    
		try
		{
		    $oRet = $this->_oCoreService->processSubUnsubscription2( 
		                            $this->_oSessionContext->sessionId(), 
		                            false,
		    		                $sSourceIdentifier, 
		    		                $sRemoteAddress, 
		    		                $oListContext->getId(), 
		    		                $sEmailAddress, 
		    		                null, 
		    		                $mailingId );
		    return $oRet->value;
		}
		catch( Inx_Apiimpl_SoapException $x) {
		    throw new Inx_Api_FeatureNotAvailableException(Inx_Api_Features::SUBSCRIPTION_FEATURE_ID);
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
			return -1;
		}
	}
	
	
	public function processSubscription2( Inx_Api_List_StandardListContext $oListContext, $sEmailAddress )
	{
		try
		{
		    $oRet = $this->_oCoreService->processSubscription( $this->_oSessionContext->sessionId(), 
					$oListContext->getId(), $sEmailAddress );
					
		    return $oRet->value;
		}
	    catch( Inx_Apiimpl_SoapException $x) {
		    throw new Inx_Api_FeatureNotAvailableException(Inx_Api_Features::SUBSCRIPTION_FEATURE_ID);
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
			return -1;
		}
	}
	
	
	public function processUnsubscription2( Inx_Api_List_StandardListContext $oListContext, $sEmailAddress )
	{
		try
		{
		    $oRet = $this->_oCoreService->processUnsubscription( $this->_oSessionContext->sessionId(),
					$oListContext->getId(), $sEmailAddress );

		    return $oRet->value;
		}
		catch( Inx_Apiimpl_SoapException $x) {
		    throw new Inx_Api_FeatureNotAvailableException(Inx_Api_Features::SUBSCRIPTION_FEATURE_ID);
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
			return -1;
		}
	}
	
	public function processUnsubscription3( $sSourceIdentifier, $sRemoteAddress, 
		Inx_Api_List_StandardListContext $oListContext, $sEmailAddress, $iMailingId, $aAttrKeyValuePairs = null )
	{
		$oAttrs = new stdClass;
		
		if( count($aAttrKeyValuePairs) != 0 )
		{
			$aStrKeys = array();
			$aStrValues = array();
			$aBoolKeys = array();
			$aBoolValues = array();
			$aIntKeys = array();
			$aIntValues = array();
			$aDoubleKeys = array();
			$aDoubleValues = array();
			$aDatetimeKeys = array();
			$aDatetimeValues = array();
			$aDateKeys = array();
			$aDateValues = array();
			$aTimeKeys = array();
			$aTimeValues = array();
				
			foreach( $aAttrKeyValuePairs as $key => $val )
			{
				if( $val === null ) 
				{
					$aStrKeys[] = $key;
					$aStrValues[] = null;
				}
				elseif( is_string($val) ) {
					// check if this is iso8601 date
					$sPregDatetime = '/^-?[0-9]{4}-([0-9]{2})-([0-9]{2})T([0-9]{2}):([0-9]{2}):([0-9]{2})(\\.[0-9]{3})?(Z|[+\-][0-9]{4}|[+\-][0-9]{2}:[0-9]{2})?$/u';
					$sPregDate = '/^[0-9]{4}-([0-9]{2})-([0-9]{2})(Z|[+\-][0-9]{4}|[+\-][0-9]{2}:[0-9]{2})?$/u';
					$sPregTime = '/^[0-9]{2}:([0-9]{2}):([0-9]{2})(\\.[0-9]{3})?(Z|[+\-][0-9]{4}|[+\-][0-9]{2}:[0-9]{2})?$/u';
		
					if( 0 != preg_match($sPregDatetime, $val))  {
		
						$aDatetimeKeys[] = $key;
						$oVal = new stdClass;
						$oVal->value = $val;
						$aDatetimeValues[] = $oVal;
					}
					elseif( 0 != preg_match($sPregDate, $val) ) {
						$aDateKeys[] = $key;
						$oVal = new stdClass;
						$oVal->value = $val;
						$aDateValues[] = $oVal;
					}
					elseif( 0 != preg_match($sPregTime, $val) ) {
						$aTimeKeys[] = $key;
						$oVal = new stdClass;
						$oVal->value = $val;
						$aTimeValues[] = $oVal;
					}
					else {
						$aStrKeys[] = $key;
						$oVal = new stdClass;
						$oVal->value = (string)$val;
						$aStrValues[] = $oVal;
					}
				}
				elseif( is_bool($val) ) {
					$aBoolKeys[] = $key;
					$oVal = new stdClass;
					$oVal->value = (boolean)$val;
					$aBoolValues[] = $oVal;
				}
				elseif( is_int($val) )	{
					$aIntKeys[] = $key;
					$oVal = new stdClass;
					$oVal->value = (int)$val;
					$aIntValues[] = $oVal;
				}
				elseif( is_float($val) ) {
					$aDoubleKeys[] = $key;
					$oVal = new stdClass;
					$oVal->value = (double)$val;
					$aDoubleValues[] = $oVal;
				}
			}
			$oAttrs->strKeys = null;
			$oAttrs->setStrValues = null;
			if( count($aStrKeys) > 0 ) {
				$oAttrs->strKeys = $aStrKeys;
				$oAttrs->strValues = $aStrValues;
			}
			$oAttrs->boolKeys = null;
			$oAttrs->boolValues = null;
			if( count($aBoolKeys) > 0 )
			{
				$oAttrs->boolKeys = $aBoolKeys;
				$oAttrs->boolValues = $aBoolValues;
			}
			$oAttrs->intKeys = null;
			$oAttrs->intValues = null;
			if( count($aIntKeys) > 0 )
			{
				$oAttrs->intKeys = $aIntKeys;
				$oAttrs->intValues = $aIntValues;
			}
			$oAttrs->doubleKeys = null;
			$oAttrs->doubleValues = null;
			if( count($aDoubleKeys) > 0 )
			{
				$oAttrs->doubleKeys = $aDoubleKeys;
				$oAttrs->doubleValues = $aDoubleValues;
			}
			$oAttrs->datetimeKeys = null;
			$oAttrs->datetimeValues = null;
			if( count($aDatetimeKeys) )
			{
				$oAttrs->datetimeKeys = $aDatetimeKeys;
				$oAttrs->datetimeValues = $aDatetimeValues;
			}
			$oAttrs->dateKeys = null;
			$oAttrs->dateValues = null;
			if( count($aDateKeys) )
			{
				$oAttrs->dateKeys = $aDateKeys;
				$oAttrs->dateValues = $aDateValues;
			}
			$oAttrs->timeKeys = null;
			$oAttrs->timeValues = null;
			if( count($aTimeKeys) )
			{
				$oAttrs->timeKeys = $aTimeKeys;
				$oAttrs->timeValues = $aTimeValues;
			}
		}
		
		try
		{
			$oRet = $this->_oCoreService->processSubUnsubscription2(
				$this->_oSessionContext->sessionId(),
				false,
				$sSourceIdentifier,
				$sRemoteAddress,
				$oListContext->getId(),
				$sEmailAddress,
				$oAttrs,
				$iMailingId );
			
			if($oRet->excDesc != null)
			{
				throw new Inx_Api_FeatureNotAvailableException(Inx_Api_Features::SUBSCRIPTION_FEATURE_ID);
			}
			
			return $oRet->value;
		}
		catch( Inx_Api_RemoteException $x )
		{
			$this->_oSessionContext->notify( $x );
			return -1;
		}
	}
	
	
	public function processUnsubscription4( $sSourceIdentifier, $sRemoteAddress, 
		Inx_Api_List_StandardListContext $oListContext, $sEmailAddress, $sMailingRef, $aAttrKeyValuePairs = null )
	{
		$oAttrs = new stdClass;
		
		if( count($aAttrKeyValuePairs) != 0 )
		{
			$aStrKeys = array();
			$aStrValues = array();
			$aBoolKeys = array();
			$aBoolValues = array();
			$aIntKeys = array();
			$aIntValues = array();
			$aDoubleKeys = array();
			$aDoubleValues = array();
			$aDatetimeKeys = array();
			$aDatetimeValues = array();
			$aDateKeys = array();
			$aDateValues = array();
			$aTimeKeys = array();
			$aTimeValues = array();
				
			foreach( $aAttrKeyValuePairs as $key => $val )
			{
				if( $val === null ) 
				{
					$aStrKeys[] = $key;
					$aStrValues[] = null;
				}
				elseif( is_string($val) ) {
					// check if this is iso8601 date
					$sPregDatetime = '/^-?[0-9]{4}-([0-9]{2})-([0-9]{2})T([0-9]{2}):([0-9]{2}):([0-9]{2})(\\.[0-9]{3})?(Z|[+\-][0-9]{4}|[+\-][0-9]{2}:[0-9]{2})?$/u';
					$sPregDate = '/^[0-9]{4}-([0-9]{2})-([0-9]{2})(Z|[+\-][0-9]{4}|[+\-][0-9]{2}:[0-9]{2})?$/u';
					$sPregTime = '/^[0-9]{2}:([0-9]{2}):([0-9]{2})(\\.[0-9]{3})?(Z|[+\-][0-9]{4}|[+\-][0-9]{2}:[0-9]{2})?$/u';
		
					if( 0 != preg_match($sPregDatetime, $val))  {
		
						$aDatetimeKeys[] = $key;
						$oVal = new stdClass;
						$oVal->value = $val;
						$aDatetimeValues[] = $oVal;
					}
					elseif( 0 != preg_match($sPregDate, $val) ) {
						$aDateKeys[] = $key;
						$oVal = new stdClass;
						$oVal->value = $val;
						$aDateValues[] = $oVal;
					}
					elseif( 0 != preg_match($sPregTime, $val) ) {
						$aTimeKeys[] = $key;
						$oVal = new stdClass;
						$oVal->value = $val;
						$aTimeValues[] = $oVal;
					}
					else {
						$aStrKeys[] = $key;
						$oVal = new stdClass;
						$oVal->value = (string)$val;
						$aStrValues[] = $oVal;
					}
				}
				elseif( is_bool($val) ) {
					$aBoolKeys[] = $key;
					$oVal = new stdClass;
					$oVal->value = (boolean)$val;
					$aBoolValues[] = $oVal;
				}
				elseif( is_int($val) )	{
					$aIntKeys[] = $key;
					$oVal = new stdClass;
					$oVal->value = (int)$val;
					$aIntValues[] = $oVal;
				}
				elseif( is_float($val) ) {
					$aDoubleKeys[] = $key;
					$oVal = new stdClass;
					$oVal->value = (double)$val;
					$aDoubleValues[] = $oVal;
				}
			}
			$oAttrs->strKeys = null;
			$oAttrs->setStrValues = null;
			if( count($aStrKeys) > 0 ) {
				$oAttrs->strKeys = $aStrKeys;
				$oAttrs->strValues = $aStrValues;
			}
			$oAttrs->boolKeys = null;
			$oAttrs->boolValues = null;
			if( count($aBoolKeys) > 0 )
			{
				$oAttrs->boolKeys = $aBoolKeys;
				$oAttrs->boolValues = $aBoolValues;
			}
			$oAttrs->intKeys = null;
			$oAttrs->intValues = null;
			if( count($aIntKeys) > 0 )
			{
				$oAttrs->intKeys = $aIntKeys;
				$oAttrs->intValues = $aIntValues;
			}
			$oAttrs->doubleKeys = null;
			$oAttrs->doubleValues = null;
			if( count($aDoubleKeys) > 0 )
			{
				$oAttrs->doubleKeys = $aDoubleKeys;
				$oAttrs->doubleValues = $aDoubleValues;
			}
			$oAttrs->datetimeKeys = null;
			$oAttrs->datetimeValues = null;
			if( count($aDatetimeKeys) )
			{
				$oAttrs->datetimeKeys = $aDatetimeKeys;
				$oAttrs->datetimeValues = $aDatetimeValues;
			}
			$oAttrs->dateKeys = null;
			$oAttrs->dateValues = null;
			if( count($aDateKeys) )
			{
				$oAttrs->dateKeys = $aDateKeys;
				$oAttrs->dateValues = $aDateValues;
			}
			$oAttrs->timeKeys = null;
			$oAttrs->timeValues = null;
			if( count($aTimeKeys) )
			{
				$oAttrs->timeKeys = $aTimeKeys;
				$oAttrs->timeValues = $aTimeValues;
			}
		}
		
		try 
		{
			$oRet = $this->_oCoreService->processSubUnsubscription3(
				$this->_oSessionContext->sessionId(),
				false,
				$sSourceIdentifier,
				$sRemoteAddress,
				$oListContext->getId(),
				$sEmailAddress,
				$oAttrs,
				$sMailingRef );
			
			if($oRet->excDesc != null)
			{
				throw new Inx_Api_FeatureNotAvailableException( Inx_Api_Features::SUBSCRIPTION_FEATURE_ID );
			}
			
			return $oRet->value;
		}
		catch( Inx_Api_RempteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return -1;
		}
	}

	public function getAllLogEntries( $rc, $attrs )
	{
		return $this->_getEntries( null, null, null, $rc, $attrs );
	}


	public function getLogEntriesAfter( $after, $rc, $attrs )
	{
		return $this->_getEntries( null, $after, null, $rc, $attrs );
	}


	public function getLogEntriesAfterAndList( $lc, $after, $rc, $attrs )
	{
		return $this->_getEntries( $lc, $after, null, $rc, $attrs );
	}


	public function getLogEntriesBefore( $before, $rc, $attrs )
	{
		return $this->_getEntries( null, null, $before, $rc, $attrs );
	}


	public function getLogEntriesBeforeAndList( $lc, $before, $rc, $attrs )
	{
		return $this->_getEntries( $lc, null, $before, $rc, $attrs );
	}


	public function getLogEntriesBetween( $start, $end, $rc, $attrs )
	{
		return $this->_getEntries( null, $start, $end, $rc, $attrs );
	}


	public function getLogEntriesBetweenAndList( $lc, $start, $end, $rc, $attrs )
	{
		return $this->_getEntries( $lc, $start, $end, $rc, $attrs );
	}


	public function getLogEntriesForList( $lc, $rc, $attrs )
	{
		return $this->_getEntries( $lc, null, null, $rc, $attrs );
	}


	private function _getEntries( $lc, $start, $end, $rc, $attrs )
	{
		try
		{
			$aAttrIds = $this->_convertAttributesToIds( $attrs );
			$listId = -1;
			if( $lc == null )
				$listId = Inx_Apiimpl_Constants::ID_UNSPECIFIED;
			else
				$listId = $lc->getId();
			//fixes XAPI-40: added $ sign to listId
			$oResult = $this->_oCoreService->selectSubscriptionLogEntries( $this->_oSessionContext->createCxt(), $listId, 
					Inx_Apiimpl_TConvert::TConvert( $start ), Inx_Apiimpl_TConvert::TConvert( $end ), $rc->_remoteRef()->refId(), $aAttrIds );

			return new Inx_Apiimpl_Core_SubscriptionLogEntryRowSetImpl( $this->_oSessionContext,$rc,$attrs,$oResult );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}


	private function _convertAttributesToIds( array $aAttrs = null)
	{
		if($aAttrs === null)
			return array();
		$aAttrIds = array();
		foreach ($aAttrs as $key => $val) {
		    $aAttrIds[$key] = $val->getId(); 
		}
		return $aAttrIds;
	}


}
