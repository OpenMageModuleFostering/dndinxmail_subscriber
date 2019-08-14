<?php

class Inx_Apiimpl_TConvert 
{
    public static function stringToTString($sString) {
        if ($sString == null) {
            return null;
        }
        $oRet = new stdClass;
        $oRet->value = (string) $sString;
        return $oRet;
    }
    
    public static function arrBoolToArrTBool($aBool) {
        if ($aBool == null)
            return null;
        $aRet = array();
        foreach($aBool as $blVal) {
            
            $oVal = new stdClass;
            $oVal->value = $blVal;
            $aRet[] = $oVal; 
        }
        return $aRet;
        
    }
    
    public static function TArrToArr($aTArr) {
        $aRet = array();
        if ($aTArr === null) {
            return null;
        }
        foreach($aTArr as $mVal) {
            
            $aRet[] = isset($mVal->value) ? $mVal->value : null;
        }
        return $aRet;
    }
    
    public static function arrToTArr($arr) {
    	//fixes XAPI-54: added null check to return null instead of an empty array
    	if($arr == null)
    	{
    		return null;
    	}
    	
        $aRet = array();
        if (is_array($arr)) {
            foreach($arr as $val) {
            	if (! is_null($val)) {
    				$oVal = new stdClass();
    				$oVal->value = $val;     		
            	} else {
            		$oVal = null;
            	}
                
                $aRet[] = $oVal;
            }
        }
        return $aRet;
    }
    
    public static function convert($oValue) {
        if (isset($oValue->value))
        	return $oValue->value;
        else return null;
    }
    
    public static function TConvert($sValue) {
    	if ($sValue===null) {
    		return null;
    	}
    	$retObj = new stdClass();
    	$retObj->value = $sValue;
    	
        return $retObj;
    }
}