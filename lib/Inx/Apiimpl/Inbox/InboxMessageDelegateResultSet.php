<?php
class Inx_Apiimpl_Inbox_InboxMessageDelegateResultSet extends Inx_Apiimpl_Core_DelegateBOResultSet
{

	private $_aAttrGetterMapping;

	private $_oRecipientContext;

	private $_oSessionContext;

	private $_oInboxManagerImpl;
	
	protected $_oBuffer = null;


	public function __construct( Inx_Apiimpl_SessionContext $oSessionContext, Inx_Apiimpl_Core_BOResultSetDelegate $delegate, 
		$rs, $oRecipientContext, $aAttributes )
	{
		parent::__construct( $oSessionContext, $delegate, $rs->remoteRefId, $rs->size, null );
		$this->_oInboxManagerImpl = $delegate;
		$this->_aAttrGetterMapping = array();
		$this->_oRecipientContext = $oRecipientContext;
		$this->_oSessionContext = $oSessionContext;
		if( $aAttributes != null )
		{
			foreach ($aAttributes as $key => $val) 
			{
				$g = Inx_Apiimpl_Inbox_InboxMessageDelegateResultSet_AttrGetter::create($val);
				$g->typedIndex  = $rs->typedIndices[$key];
			
				$this->_aAttrGetterMapping[$aAttributes[$key]->getId()] = $g;
			}
		}
		
		$this->_oBuffer = new Inx_Apiimpl_Util_IndexedBuffer();
		if( $rs->data !== null && count($rs->data) > 0 ) 
		{
		    // set the first bulk, beginning at index 0.
		    $this->_oBuffer->setBuffer( 0, $this->convert( $rs->data ) );
		}
	}


	protected function fetchBOs( $iIndex, $iDirection )
	{
		return $this->convert( $this->_oInboxManagerImpl->fetchInboxMessages( $this->_remoteRef(), $iIndex, $iDirection ) );
	}


	public function convert( $aData )
	{
		if( $aData == null || count($aData) == 0 )
			return array();

		$res = array();
		foreach ($aData as $i => $entryValue ) 
		{
			if ($entryValue) 
			{
				$res[$i] = new Inx_Apiimpl_Inbox_InboxMessageImpl( $this->_oSessionContext, $entryValue, 
					$this->_oRecipientContext, $this->_aAttrGetterMapping  );
			}
		}
		return $res;
	}
}