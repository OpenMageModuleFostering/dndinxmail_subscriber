<?php

/**
 * UtilitiesImpl
 * 
 * @author bgn, 24.10.2005
 * @copyright inxnet GmbH
 * @version $Revision$ $Date$ $Author$
 */
class Inx_Apiimpl_Util_UtilitiesImpl implements Inx_Api_Util_Utilities
{

	/**
	 * @var Inx_Apiimpl_SessionContext
	 */
	protected $_oSessionContext;

	/**
	 * 
	 *
	 * @param Inx_Apiimpl_SessionContext $oSc
	 */
	public function __construct( Inx_Apiimpl_SessionContext $oSc )
	{
		$this->_oSessionContext = $oSc;
	}
	
	/**
	 * 
	 *
	 * @param Inx_Api_List_ListContext $oListContext
	 * @param int $iMailingId
	 * @param int $iRecipientId
	 * @param boolean $blTakeProfile
	 * @param string $sEmail
	 * @param string $sTextIntro
	 * @param string $sHtmlIntro
	 * 
	 * @throws Inx_Api_Util_TellAFriendException
	 */
	public function tellAFriend( Inx_Api_List_ListContext $oListContext, $iMailingId, $iRecipientId,
			$blTakeProfile, $sEmail, $sTextIntro, $sHtmlIntro )
	{
		
	    if (!is_int($iMailingId)) {
		    throw new Inx_Api_IllegalArgumentException('Wrong parameter $iMailingId type, integer expected');
		}
	    if (!is_int($iRecipientId)) {
		    throw new Inx_Api_IllegalArgumentException('Wrong parameter $$iRecipientId type, integer expected');
		}
	    try
		{
			$service = $this->_oSessionContext->getService( Inx_Apiimpl_SessionContext::CORE_SERVICE );
			try 
			{
				$ret = $service->tellAFriend( $this->_oSessionContext->sessionId(), $oListContext->getId(),
		    			$iMailingId, $iRecipientId, $blTakeProfile, $sEmail, $sTextIntro, $sHtmlIntro );
			} 
			catch (Inx_Api_RemoteException $e) 
			{
				if (isset($e->oReturnObj) && $excDesc = $e->oReturnObj->excDesc) {
			    	if( $excDesc->type == -1 )
			    		throw new Inx_Api_FeatureNotAvailableException( "feature not enabled" );
			    	else
			    		throw new Inx_Api_Util_TellAFriendException( $excDesc->msg, $excDesc->type );
				} else {
					throw new Inx_Api_RemoteException($e->getMessage(), $e->getCode());
				}
				
				
			}
			
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
		}
	}
	
	
	public function existsTestRecipient( $iIdToCheck )
	{
		try
		{
			$service = $this->_oSessionContext->getService( Inx_Apiimpl_SessionContext::MAILING6_SERVICE );

			return $service->existsTestRecipient($this->_oSessionContext->createCxt(), $iIdToCheck );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->_oSessionContext->notify( $e );
		}
		return false;
	}
	
	
}
