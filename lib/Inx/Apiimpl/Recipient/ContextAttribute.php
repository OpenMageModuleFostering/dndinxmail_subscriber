<?php

/*package com.inxmail.xpro.apiimpl.recipient;

import java.util.Date;

import com.inxmail.xpro.api.recipient.Attribute;
import com.inxmail.xpro.apiservice.TConvert;
import com.inxmail.xpro.apiservice.recipient.AttrUpdate;
import com.inxmail.xpro.apiservice.recipient.AttrData;
import com.inxmail.xpro.apiservice.recipient.RecipientData;*/


/**
 * ContextAttribute
 * 
 * @version $Revision: 4690 $ $Date: 2006-09-20 07:24:45 +0000 (Mi, 20 Sep 2006) $ $Author: bgn $
 */
abstract class Inx_Apiimpl_Recipient_ContextAttribute implements Inx_Api_Recipient_Attribute
{
	protected $_iId;
    protected $_sName;
    protected $_iMaxStringLength;
    protected $_iType;
    protected $_iListContextId;
    protected $_iFeatureId;
    protected $_iArrayIndex;
    protected $_iTypeAttrIndex;
    
    protected $_oRecipientContext;
    
    const TYPE_ARRAY_INDEX_NOT_ACCESSIBLE = -2;

    
	public function __construct( Inx_Apiimpl_Recipient_RecipientContextImpl $oRecipientContext, $oAttribute )
	{
		$this->_oRecipientContext = $oRecipientContext;
		$this->_iId = $oAttribute->id;
		$this->_iArrayIndex = $oAttribute->arrayIndex;
		$this->_iTypeAttrIndex = $oAttribute->typeArrayIndex;
		if( $oAttribute->attrType == Inx_Api_Recipient_Attribute::USER_ATTRIBUTE_TYPE
			|| $oAttribute->attrType == Inx_Api_Recipient_Attribute::EMAIL_ATTRIBUTE_TYPE )
			$this->_sName = $oAttribute->name;
		else
			$this->_sName = null;
		
		$this->_iMaxStringLength = $oAttribute->maxStringLength;
		$this->_iType = $oAttribute->attrType;
		$this->_iListContextId = $oAttribute->listContextId;
		$this->_iFeatureId = $oAttribute->featureId;
	}
	
	public function getId()
	{
		return $this->_iId;
	}

	public function getName()
	{
		return $this->_sName;
	}

	public function getType()
	{
		return $this->_iType;
	}

	
	public function isAccessible()
	{
		return $this->_iTypeAttrIndex != Inx_Apiimpl_Recipient_ContextAttribute::TYPE_ARRAY_INDEX_NOT_ACCESSIBLE;
	}
	
//	public abstract function getDataType();
	

	public function getMaxStringLength()
	{
		return $this->_iMaxStringLength;
	}
	
	public function getListContextId()
	{
		return $this->_iListContextId;
	}

	public function getFeatureId()
	{
		return $this->_iFeatureId;
	}
	
	public function getContext()
	{
		return $this->_oRecipientContext;
	}
	
	public function getTypeAttrIndex()
	{
		return $this->_iTypeAttrIndex;
	}
	
	
	public abstract function createAttrUpdate( $sNewValue );
	
	public abstract function getObject( $oRecipientData ); // @TODO object RecipientData

	public abstract function updateObject( $oRecipientData, &$aChangedAttrs, $sValue ); // @TODO value object or string

	
    public function getString( $oRecipientData )
    {
    	throw new Inx_Api_IllegalStateException( "attribute type mismatch" ); 
	}

    public function getBoolean( $oRecipientData )
    {
    	throw new Inx_Api_IllegalStateException( "attribute type mismatch" ); 
	}
    
    public function getInteger( $oRecipientData )
    {
    	throw new Inx_Api_IllegalStateException( "attribute type mismatch" ); 
	}

    public function getDouble( $oRecipientData )
    {
    	throw new Inx_Api_IllegalStateException( "attribute type mismatch" ); 
	}

    public function getDate( $oRecipientData )
    {
    	throw new Inx_Api_IllegalStateException( "attribute type mismatch" ); 
	}

    public function getTime( $oRecipientData )
    {
    	throw new Inx_Api_IllegalStateException( "attribute type mismatch" ); 
	}
    
    public function getDatetime( $oRecipientData )
    {
    	throw new Inx_Api_IllegalStateException( "attribute type mismatch" ); 
	}
    
    public function updateString( $oRecipientData, &$aChangedAttrs, $sValue )
    {
    	throw new Inx_Api_IllegalStateException( "attribute type mismatch" ); 
    }

    public function updateBoolean( $oRecipientData, &$aChangedAttrs, $blValue )
    {
    	throw new Inx_Api_IllegalStateException( "attribute type mismatch" ); 
    }
    
    public function updateInteger( $oRecipientData, &$aChangedAttrs, $iValue )
    {
    	throw new Inx_Api_IllegalStateException( "attribute type mismatch" ); 
    }
    
    public function updateDouble( $oRecipientData, &$aChangedAttrs, $iValue )
    {
    	throw new Inx_Api_IllegalStateException( "attribute type mismatch" ); 
    }

    public function updateDate( $oRecipientData, &$aChangedAttrs, $dValue )
    {
    	throw new Inx_Api_IllegalStateException( "attribute type mismatch" ); 
    }

    public function updateTime( $oRecipientData, &$aChangedAttrs, $dValue )
    {
    	throw new Inx_Api_IllegalStateException( "attribute type mismatch" ); 
    }

    public function updateDatetime( $oRecipientData, &$aChangedAttrs, $dValue )
    {
    	throw new Inx_Api_IllegalStateException( "attribute type mismatch" ); 
    }
	
	public static function getValue($value) 
	{
		return $value;
	}
	
    public static function validate($value) {
    	return true;
    }
}
