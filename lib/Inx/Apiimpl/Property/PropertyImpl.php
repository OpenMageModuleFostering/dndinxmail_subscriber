<?php

/**
 * PropertyImpl
 * 
 * @version $Revision: 7335 $ $Date: 2007-09-10 14:58:22 +0200 (Mo, 10 Sep 2007) $ $Author: sbn $
 */
class Inx_Apiimpl_Property_PropertyImpl implements Inx_Api_Property_Property
{
    private $_oPropertyData;
    
    private $_aChangedAttrs = null;

    private $_oPropertyContext;
    
    
	public function __construct( Inx_Apiimpl_Property_PropertyContext $oContext, $oPropertyData )
	{
		$this->_oPropertyContext = $oContext;
	    $this->_oPropertyData = $oPropertyData;
	}
	
	
	public function getId()
	{
		return $this->_oPropertyData->id;
	}
	
	
	public function getName()
	{
		return $this->_oPropertyData->name;
	}

	
	public function getInternalValue()
	{
	    if (isset($this->_oPropertyData->value->value))
	        return $this->_oPropertyData->value->value;
	}
	
	public function updateInternalValue( $sValue )
	{
	    $this->_writeAccess( self::ATTRIBUTE_VALUE );
	    $this->_oPropertyData->value = new stdClass;
	    $this->_oPropertyData->value->value = $sValue;
	}
	
	/**
	 * @throws DataException
	 */
	public function reload()
	{
	    $this->_oPropertyData = $this->_oPropertyContext->get( $this->_oPropertyData->id );
		$this->_aChangedAttrs = null;
		
		if( $this->_oPropertyData == null )
		    throw new Inx_Api_DataException( "property deleted" );
	}

	/**
	 * @throws UpdateException, DataException
	 */
	public function commitUpdate()
	{
	    $this->_oPropertyData = $this->_oPropertyContext->update( $this->_oPropertyData, $this->_aChangedAttrs );
		$this->_aChangedAttrs  = null;
		
		if( $this->_oPropertyData == null )
		    throw new Inx_Api_DataException( "property deleted" );
	}
	
	
	protected function _writeAccess( $iAttrIndex )
	{
		if( $this->_aChangedAttrs == null )
			$this->_aChangedAttrs = array_fill(0, Inx_Apiimpl_Property_PropertyConstants::MAX_ATTRIBUTES, false); 

		$this->_aChangedAttrs[ $iAttrIndex ] = true;
	}
	
	public function getFormatter()
	{
		return new Inx_Apiimpl_Property_PropertyFormatterImpl( $this->_oPropertyContext );
	}
}
