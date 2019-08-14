<?php

/**
 * BlacklistEntryImpl
 * 
 * @version $Revision: 9352 $ $Date: 2007-12-10 09:36:59 +0200 (Pr, 10 Grd 2007) $ $Author: aurimas $
 */
class Inx_Apiimpl_Blacklist_BlacklistEntryImpl implements Inx_Api_Blacklist_BlacklistEntry
{
	protected $_oSc;
    
    protected $_oData;
    
    protected $_aChangedAttrs;
    
    
    public function __construct( $oSc, stdClass $oData )
    {
	    $this->_oSc = $oSc;
	    $this->_oData = $oData;
	}
	
	public function getId()
	{
		return $this->_oData->id;
	}

	public function getPattern()
	{
		return$this->_oData->pattern;
	}
	
	public function getDescription()
	{
		return $this->_oData->description->value;
	}
	
	public function getHitCount()
	{
		return $this->_oData->hitCount;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param string $pattern
	 */
	public function updatePattern( $pattern )
	{
	    $this->writeAccess( Inx_Api_Blacklist_BlacklistEntry::ATTRIBUTE_PATTERN );
	    $this->_oData->pattern = $pattern;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param string $desc
	 */
	public function updateDescription( $desc )
	{
	    $this->writeAccess( Inx_Api_Blacklist_BlacklistEntry::ATTRIBUTE_DESCRIPTION );
	    $this->_oData->description = new stdClass();
	    $this->_oData->description->value = $desc;
	}
	
	
	public function commitUpdate()
	{
		try
	    {
			$service = $this->_oSc->getService( Inx_Apiimpl_SessionContext::BLACKLIST_SERVICE );
			try {
				$r = $service->update( $this->_oSc->createCxt(), $this->_oData, Inx_Apiimpl_TConvert::arrToTArr( $this->_aChangedAttrs ) );				
			} catch (Inx_Api_RemoteException $e) {
			    throw new Inx_Api_UpdateException( $e->getMessage(), $e->getCode(), $e);				
			}

			$this->_oData = $r->value;
	        $this->_aChangedAttrs = null;
			
			if( $this->_oData === null )
			    throw new Inx_Api_DataException( "blacklist entry deleted" );
	    }
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSc->notify( $e );
	    }
	}

	
	public function reload()
	{
		try
	    {
			$service = $this->_oSc->getService( Inx_Apiimpl_SessionContext::BLACKLIST_SERVICE );
		    $this->_oData = $service->get( $this->_oSc->createCxt(), $this->_oData->id );
		    $this->_aChangedAttrs = null;
			
			if( empty($this->_oData) )
			    throw new Inx_Api_DataException( "blacklist entry deleted" );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSc->notify( $e );
		}
	}
	
	
	protected function writeAccess( $iAttrIndex )
	{
		if( empty($this->_aChangedAttrs) )
			$this->_aChangedAttrs = array();
		$this->_aChangedAttrs[ $iAttrIndex ] = true;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param BlacklistData $this
	 * @return Inx_Api_Blacklist_BlacklistEntry
	 */
	public static function convert( Inx_Apiimpl_SessionContext $oSc, /*stdClass*/ $oData ) 
	{
		if( $oData === null )
			return null;
		
		return new Inx_Apiimpl_Blacklist_BlacklistEntryImpl( $oSc, $oData );
	}
	
	/**
	 * Enter description here...
	 *
	 * @param Inx_Apiimpl_SessionContext $oSc
	 * @param array $aData
	 */
	public static function convertArr( $oSc,  $aData )
	{
		
		if( empty($aData) )
			return array();
		
		$rs = array(); // new BlacklistEntry[ $this->_oData.length ];
		foreach ($aData as $i => $entryValue ) {
			if ($entryValue) {
				$rs[$i] = new Inx_Apiimpl_Blacklist_BlacklistEntryImpl( $oSc, $entryValue );
			}
		}
		return $rs;
	}
}
