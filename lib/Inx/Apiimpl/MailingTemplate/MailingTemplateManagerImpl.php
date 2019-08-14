<?php


class Inx_Apiimpl_MailingTemplate_MailingTemplateManagerImpl implements Inx_Api_MailingTemplate_MailingTemplateManager, Inx_Apiimpl_Core_BOResultSetDelegate
{
	/**
	 * @var Inx_Apiimpl_SessionContext
	 */
	protected $_oSessionContext;

	protected $_oService;

	public function __construct( Inx_Apiimpl_SessionContext $sc )
	{
		$this->_oSessionContext = $sc;
		$this->_oService = $sc->getService( Inx_Apiimpl_SessionContext::MAILING_TEMPLATE_SERVICE );
	}

	/**
	 * Enter description here...
	 * 
	 * @return Inx_Api_BusinessObject
	 */
	public function fetchBOs( Inx_Apiimpl_RemoteRef $oResultSetRef, $iIndex, $iDirection )
	{
		return Inx_Apiimpl_MailingTemplate_MailingTemplateImpl::convert( $oResultSetRef, $this->_oService->fetch(
			$oResultSetRef->createCxt(), $oResultSetRef->refId(), $iIndex, $iDirection ) );
	}

	/**
	 * Enter description here...
	 *
	 * @return int
	 * @throws Inx_Api_RemoteException
	 */
	public function removeBOs( Inx_Apiimpl_RemoteRef $oResultSetRef, $indexRanges )
	{
		return $this->_oService->removeSelection( $oResultSetRef->createCxt(), $oResultSetRef->refId(), $indexRanges );
	}

	/**
	 * Enter description here...
	 *
	 * @return Inx_Api_MailingTemplate_MailingTemplate
	 */
	public function createTemplate( Inx_Api_List_ListContext $oListContext, $iMimeType )
	{
		$f = new Inx_Apiimpl_MailingTemplate_MailingTemplateImpl( $this->_oSessionContext, self::createNewMailingTemplateData() );
		$f->updateListContextId( $oListContext->getId() );
		$f->updateMimeType( $iMimeType );
		return $f;
	}

	/**
	 * Enter description here...
	 *
	 * @param Inx_Api_List_ListContext $oListContext
	 * @param int $iOrderAttribute
	 * @param int $iOrderType
	 * @return Inx_Api_BOResultSet
	 */
	public function select( Inx_Api_List_ListContext $oListContext, $iOrderAttribute = -1, $iOrderType = -1 )
	{
		try
		{
			$rs = $this->_oService->select( $this->_oSessionContext->createCxt(), $oListContext->getId(),
					$iOrderAttribute, $iOrderType );
			
			return new Inx_Apiimpl_Core_DelegateBOResultSet( $this->_oSessionContext, $this, $rs->remoteRefId, $rs->size,
				Inx_Apiimpl_MailingTemplate_MailingTemplateImpl::convert( $this->_oSessionContext, $rs->data ) );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}
	
	/**
	 * Enter description here...
	 *
	 * @param int $id
	 * @return Inx_Apiimpl_MailingTemplate_MailingTemplateImpl
	 * @throws Inx_Api_DataException
	 */
	public function get( $id )
	{
	    if (!is_int($id)) {
	        throw new Inx_Api_IllegalArgumentException('Integer parameter type $id expected, got '.gettype($id));
	    }
	    try
		{
			$bo = Inx_Apiimpl_MailingTemplate_MailingTemplateImpl::convert( $this->_oSessionContext, $this->_oService->get( $this->_oSessionContext->createCxt(), $id ) );
		    if( $bo === null )
		        throw new Inx_Api_DataException( "mailing template deleted" );
		    return $bo;
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}

	/**
	 * Enter description here...
	 *
	 * @param int $id
	 * @return boolean
	 */
	public function remove( $id )
	{
	    if (!is_int($id)) {
	        throw new Inx_Api_IllegalArgumentException('Integer parameter type $id expected, got '.gettype($id));
	    }
	    try
		{
			return $this->_oService->remove( $this->_oSessionContext->createCxt(), $id );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return false;
		}
	}

	/**
	 * Enter description here...
	 *
	 * @return Inx_Api_BOResultSet
	 */
	public function selectAll()
	{
		try
		{
			$rs = $this->_oService->select( $this->_oSessionContext->createCxt(), Inx_Apiimpl_Constants::ID_UNSPECIFIED, -1, -1 );
			
			return new Inx_Apiimpl_Core_DelegateBOResultSet( $this->_oSessionContext, $this, $rs->remoteRefId, $rs->size,
				Inx_Apiimpl_MailingTemplate_MailingTemplateImpl::convert( $this->_oSessionContext, $rs->data ) );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
			return null;
		}
	}
	
	public static function createNewMailingTemplateData()
	{
		$mailingTemplateData = new stdClass();
		$mailingTemplateData->id = 0;
		$mailingTemplateData->listContextId = null;
		$mailingTemplateData->name = null;
		$mailingTemplateData->htmlTextContent = null;
		$mailingTemplateData->plainTextContent = null;
		$mailingTemplateData->mimeType = null;
		
		return $mailingTemplateData;
	}
}
