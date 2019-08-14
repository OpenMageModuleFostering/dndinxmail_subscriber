<?php

class Inx_Apiimpl_Bounce_BounceDelegateResultSet extends Inx_Apiimpl_Core_DelegateBOResultSet
{
	private $_oDelegate;

	private $_oService;
	private $_oRecipientContext = null;
	
	private $_aAttrGetterMapping = null;
	protected $_oBuffer = null;
	private $oSc;
	
	public function __construct( Inx_Apiimpl_SessionContext $oSc, Inx_Apiimpl_Core_BOResultSetDelegate $oDelegate, 
			$rs, $rc, $aAttrs )
	{
		parent::__construct( $oSc, $oDelegate, $rs->remoteRefId, $rs->size, null );
		$this->_oService = $oSc->getService( Inx_Apiimpl_SessionContext::BOUNCE2_SERVICE );
		$this->_oRecipientContext = $rc;
		$this->oSc = $oSc;
		$this->_oDelegate = $oDelegate;
		if($aAttrs !== null) {
		    foreach ($aAttrs as $key => $val) {
		        $g = Inx_Apiimpl_Bounce_BounceDelegateResultSet_AttrGetter::create($val);
		        $g->typedIndex  = $rs->typedIndices[$key];
		        
		        $this->_aAttrGetterMapping[$aAttrs[$key]->getId()] = $g;
		    }
		}
		$this->_oBuffer = new Inx_Apiimpl_Util_IndexedBuffer();
		if( $rs->data !== null && count($rs->data) > 0 ) {
		    // set the first bulk, beginning at index 0.
		    
		    $this->_oBuffer->setBuffer( 0, $this->convert( $rs->data ) );
		}
	}	
	
    
    /**
     * @throws RemoteException
     */
    protected function _fetchBOs( $iIndex, $iDirection )
    {
    	return $this->convert($this->_oDelegate->fetchBounces( $this->_remoteRef(), $iIndex, $iDirection ));
    }
    
/**
	 * Enter description here...
	 *
	 * @param Inx_Apiimpl_SessionContext $oSc
	 * @param array $aData
	 */
	public function convert( $aData )
	{
		
		if( empty($aData) )
			return array();
		
		$rs = array(); 
		foreach ($aData as $i => $entryValue ) {
			if ($entryValue) {
				$rs[$i] = new Inx_Apiimpl_Bounce_BounceImpl( $this->oSc, $entryValue, $this->_oRecipientContext, $this->_aAttrGetterMapping  );
			}
		}
		return $rs;
	}
    
    
}