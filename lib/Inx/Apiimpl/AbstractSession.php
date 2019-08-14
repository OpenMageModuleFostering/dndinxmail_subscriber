<?php

abstract class Inx_Apiimpl_AbstractSession extends Inx_Api_Session implements Inx_Apiimpl_SessionContext 
{	
 	private 			$_sSessionId 			= null;
 	protected 			$_blSessionClosed 		= false;
 	protected       	$_aServiceMap           = array();
 	protected 			$_sApplicationUrl 		= null;
 	
 	protected           $_aPropertyMap          = array();
 	
 	protected $_oListManager                    = null;
	protected $_oAttributeManager               = null;
	protected $_oMailingManager                 = null;
        protected $_oTriggerMailingManager          = null;
	protected $_oSubscriptionManager            = null;
	protected $_oResourceManager                = null;
	protected $_oReportEngine                   = null;
	protected $_oBlacklistManager               = null;	
	protected $_oBounceManager               	= null;
	protected $_oFilterManager                  = null;
	protected $_oActionManager                  = null;
	protected $_oUserContext                    = null;
	protected $_oInboxManager					= null;
 	
	protected $_aReleasedRemoteRefs             = array();
	protected $_maxReleasedRefs                 = null;
 	
	public function sessionId()
	{
		if( $this->_blSessionClosed )
			throw new Inx_Api_APIException( "Illegal session state: session is closed" );
 		if ($this->_sSessionId == null) {
 		    throw new Exception('Empty sessionId.');
 		}
 		return $this->_sSessionId;
	}
	
 	protected static $_aServiceDescriptors 	= array(
 		self::CORE_SERVICE => 'http://core.apiservice.xpro.inxmail.com',
 		self::RECIPIENT_SERVICE => 'http://recipient.apiservice.xpro.inxmail.com',
 		self::LIST_SERVICE => 'http://list.apiservice.xpro.inxmail.com',
 		self::MAILING6_SERVICE => 'http://mailing6.apiservice.xpro.inxmail.com',
                self::TRIGGER_MAILING_SERVICE => 'http://triggermailing.apiservice.xpro.inxmail.com',
 		self::PROPERTY_SERVICE => 'http://property.apiservice.xpro.inxmail.com',
 		self::RESOURCE_SERVICE => 'http://resource.apiservice.xpro.inxmail.com',
 		self::BLACKLIST_SERVICE => 'http://blacklist.apiservice.xpro.inxmail.com',
 		self::FILTER_SERVICE   => 'http://filter.apiservice.xpro.inxmail.com',
 		self::ACTION_SERVICE   => 'http://action.apiservice.xpro.inxmail.com',
 		self::REPORTING_SERVICE => 'http://reporting.apiservice.xpro.inxmail.com',
 		self::TEXTMODULE_SERVICE => 'http://textmodule.apiservice.xpro.inxmail.com',
 		self::MAILING_TEMPLATE_SERVICE => 'http://mailingtemplate.apiservice.xpro.inxmail.com',
 		self::DESIGN_COLLECTION2_SERVICE => 'http://designtemplate2.apiservice.xpro.inxmail.com',
 		self::BOUNCE2_SERVICE => 'http://bounce2.apiservice.xpro.inxmail.com',
 		self::DATAACCESS_SERVICE => 'http://dataaccess.apiservice.xpro.inxmail.com',
 		self::APPROVER_SERVICE => 'http://approver.apiservice.xpro.inxmail.com',
 		self::TESTRECIPIENT_SERVICE => 'http://testrecipient.apiservice.xpro.inxmail.com',
 		self::UNSUBSCRIBER_SERVICE => 'http://unsubscriber.apiservice.xpro.inxmail.com',
 		self::PLUGIN_SERVICE => 'http://plugin.apiservice.xpro.inxmail.com', 
 		self::INBOX_SERVICE => 'http://inbox.apiservice.xpro.inxmail.com',
 		self::WEBPAGE_SERVICE => 'http://webpage.apiservice.xpro.inxmail.com'
 	);
    


	
	public function notify( Inx_Api_RemoteException $e )
	{
	    $this->rebuildException( $e );
	}


/*

		public void release( boolean immediate )
		{
			if( remoteRefId == null )
				return;

			releaseRemoteRef( remoteRefId, immediate );
			remoteRefId = null;
		}
		
		public boolean isReleased()
		{
			return remoteRefId == null;
		}

		public RemoteRef createRemoteRef( String remoteRefId )
		{
			return new RemoteRefImpl( remoteRefId );
		}
		
*/

	

	
	protected function _login($sUsername, $sPassword, $blPwdEncrypted=false, $sAppId)
 	{
 		$oService = $this->getService(self::CORE_SERVICE);
 		if ($blPwdEncrypted) {
 			$params = $oService->newInitSecureLogin( $sUsername, $sAppId );
			$sl = new Inx_Apiimpl_SecureLogin( $params );
			$oLogin = $oService->newSecureLogin( $params[0], $sUsername, $sl->encodePassword( $sPassword ) );
 		}
 		else
 		{
 			$oLogin = $oService->login($sUsername, $sPassword, $sAppId);
 		}
 		if (isset($oLogin->excDesc) && $oLogin->excDesc) {
 			throw new Inx_Api_LoginException($oLogin->excDesc->msg, $oLogin->excDesc->type);
 		}
		foreach ($oLogin->propKeys as $i=>$kvalue) {
				$this->_aPropertyMap[$kvalue] = $oLogin->propValues[$i]->value;
		}	
 		$this->_maxReleasedRefs = $this->getIntProperty(Inx_Apiimpl_PropertyConstants::MAX_RELEASED_REFS);
 	
 		if (! empty($oLogin->sessionId)) {
 			$this->_sSessionId = $oLogin->sessionId;
 		} else {
 			throw new Exception('Empty sessionId.');
 		}
 	} 
	
	protected function _login2( $sLoginToken, $sAppId)
 	{
 		$oService = $this->getService(self::CORE_SERVICE);
 		$oLogin = $oService->loginWithToken($sLoginToken, $sAppId);
 		if (isset($oLogin->excDesc) && $oLogin->excDesc) {
 			throw new Inx_Api_LoginException($oLogin->excDesc->msg, $oLogin->excDesc->type);
 		}
		foreach ($oLogin->propKeys as $i=>$kvalue) {
				$this->_aPropertyMap[$kvalue] = $oLogin->propValues[$i]->value;
		}	
 		$this->_maxReleasedRefs = $this->getIntProperty(Inx_Apiimpl_PropertyConstants::MAX_RELEASED_REFS);
 	
 		if (! empty($oLogin->sessionId)) {
 			$this->_sSessionId = $oLogin->sessionId;
 		} else {
 			throw new Exception('Empty sessionId.');
 		}
 	}
 	
 	protected function _login3($pluginSecretId,$sUsername, $sPassword, $blPwdEncrypted=false, $sAppId)
 	{
 		$oService = $this->getService(self::CORE_SERVICE);
 		if ($blPwdEncrypted) {
 			$params = $oService->newInitSecureLogin( $sUsername, $sAppId );
			$sl = new Inx_Apiimpl_SecureLogin( $params );
			$oLogin = $oService->newPluginSecureLogin( $pluginSecretId, $params[0], $sUsername, $sl->encodePassword( $sPassword ) );
 		}
 		else
 		{
 			$oLogin = $oService->pluginLogin($pluginSecretId, $sUsername, $sPassword, $sAppId);
 		}
 		if (isset($oLogin->excDesc) && $oLogin->excDesc) {
 			throw new Inx_Api_LoginException($oLogin->excDesc->msg, $oLogin->excDesc->type);
 		}
		foreach ($oLogin->propKeys as $i=>$kvalue) {
				$this->_aPropertyMap[$kvalue] = $oLogin->propValues[$i]->value;
		}	
 		$this->_maxReleasedRefs = $this->getIntProperty(Inx_Apiimpl_PropertyConstants::MAX_RELEASED_REFS);
 	
 		if (! empty($oLogin->sessionId)) {
 			$this->_sSessionId = $oLogin->sessionId;
 		} else {
 			throw new Exception('Empty sessionId.');
 		}
 	} 
	
	public function createCxt()
	{
		if ($this->_blSessionClosed)
		    throw new Inx_Api_APIException( "Illegal session state: session is closed" );
		
		$oRet = new stdClass;
		$oRet->sid = $this->_sSessionId;
		$oRet->relRefIds = $this->fetchReleasedRemoteRefs();
		return $oRet;

	}

	
	public function createRemoteRef( $sRemoteRefId )
	{
		return new Inx_Apiimpl_RemoteRefImpl($sRemoteRefId, $this);
	}

	
	public function getIntProperty( $sKey ) 
	{
		return (int) $this->_aPropertyMap[$sKey];
	}

	/**
	 * Create a new <code>Inx_Api_Recipient_RecipientContext</code>.
	 * 
	 * @return Inx_Api_Recipient_RecipientContext a new <code>Inx_Api_Recipient_RecipientContext</code>
	 * @since API 1.0
	 */
	public function createRecipientContext() 
	{
		try
		{
			$oRs = $this->getService( Inx_Apiimpl_SessionContext::RECIPIENT_SERVICE );
			return new  Inx_Apiimpl_Recipient_RecipientContextImpl( $this, $oRs->fetchRecipientContext( $this->_sSessionId) );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->notify( $e );
			return null;
		}
	}
	
	
	/**
	 * Returns the <code>Inx_Api_List_ListContextManager</code> object that will used to manage lists.
	 * 
	 * @return Inx_Api_List_ListContextManager the list manager
	 * @since API 1.0
	 */
	public function getListContextManager()
	{
	    if (!isset($this->_oListManager)) {
	        $this->_oListManager = new Inx_Apiimpl_List_ListManagerImpl($this);
	    }
	    return $this->_oListManager;
	}
	
	
	/**
	 * Returns the <code>Inx_Api_Recipient_AttributeManager</code> object that will used to manage attributes.
	 * 
	 * @return Inx_Api_Recipient_AttributeManager the attribute manager
	 * @since API 1.0
	 */
	public function getAttributeManager()
	{
		if( $this->_oAttributeManager == null )
			$this->_oAttributeManager = new Inx_Apiimpl_Recipient_AttributeManagerImpl( $this );
		return $this->_oAttributeManager;
	}

	
	/**
	 * Returns the <code>Inx_Api_Mailing_MailingManager</code> object that will used to manage mailings
	 * and creating mail views.
	 *
	 * @return Inx_Apiimpl_Mailing_MailingManagerImpl the mailing manager
	 * @since API 1.0
	 */
	public function getMailingManager(){
	    if (!isset($this->_oMailingManager))
	        $this->_oMailingManager = new Inx_Apiimpl_Mailing_MailingManagerImpl( $this );
	    return $this->_oMailingManager;	
	}
        
        
        /**
	 * Returns the <i>Inx_Api_TriggerMailing_TriggerMailingManager</i> object that will be used to manage 
         * trigger mailings and produce the trigger mailing output (HTML and/or plain test) for a single recipient.
	 * 
	 * @return Inx_Api_TriggerMailing_TriggerMailingManager the trigger mailing manager.
	 * @since API 1.10.0
	 */
        public function getTriggerMailingManager() 
        {
            if (!isset($this->_oTriggerMailingManager))
                $this->_oTriggerMailingManager = new Inx_Apiimpl_TriggerMailing_TriggerMailingManagerImpl ( $this );
            return $this->_oTriggerMailingManager;
        }

	
	/**
	 * Returns the <code>SubscriptionManager</code> object that will used to subscribe
	 * an unsubscribe recipients.
	 *
	 * @return	the subscription manager
	 * @since API 1.0
	 */
	public function getSubscriptionManager()
	{
	    if ($this->_oSubscriptionManager == null) {
	        $this->_oSubscriptionManager = new Inx_Apiimpl_Core_SubscriptionManagerImpl( $this );
	    }
	    return $this->_oSubscriptionManager;
	}

	/**
	 * Returns the <code>ActionManager</code> object that will used to manage actions.
	 * 
	 * @return	the action manager
	 * @since API 1.2.0
	 */
	public function getActionManager()
	{
	    if (!isset($this->_oActionManager))
	        $this->_oActionManager = new Inx_Apiimpl_Action_ActionManagerImpl( $this );
	    return $this->_oActionManager;
	}

	
	/**
	 * Returns the <code>ReportEngine</code> object that will used to generate reports.
	 * 
	 * @return Inx_Api_Reporting_ReportEngine	the report engine
	 * @since API 1.3.0
	 */
	public function getReportEngine()
	{
	    if ($this->_oReportEngine === null) {
	        $this->_oReportEngine = new Inx_Apiimpl_Reporting_ReportEngineImpl($this);
	    }
	    return $this->_oReportEngine;
	}

	
	/**
	 * Returns the <code>BlacklistManager</code> object that will used to manage blacklist entries.
	 * 
	 * @return Inx_Api_Blacklist_BlacklistManager the blacklist manager
	 * @since API 1.1.0
	 */
	public function getBlacklistManager()
	{
		if( $this->_oBlacklistManager == null )
			$this->_oBlacklistManager = new Inx_Apiimpl_Blacklist_BlacklistManagerImpl( $this );
		return $this->_oBlacklistManager;
	}


	/**
	 * Returns the <code>BounceManager</code> object that will used to get bounce mails.
	 * 
	 * @return Inx_Api_Bounce_BounceManager the bounce manager
	 * @since API 1.4.3
	 */
	public function getBounceManager()
	{
		if( $this->_oBounceManager == null )
			$this->_oBounceManager = new Inx_Apiimpl_Bounce_BounceManagerImpl( $this );
		return $this->_oBounceManager;
	}
	
	/**
	 * Returns the <code>FilterManager</code> object that will used to manage filters.
	 * 
	 * @return Inx_Apiimpl_Filter_FilterManagerImpl	the filter manager
	 * @since API 1.1.0
	 */
	public function getFilterManager()
	{
		if( $this->_oFilterManager == null )
			$this->_oFilterManager = new Inx_Apiimpl_Filter_FilterManagerImpl( $this );
		return $this->_oFilterManager;
	}
	
	
	/**
	 * Returns the <code>TextmoduleManager</code> object that will used to manage textmodules.
	 * 
	 * @return	the textmodule manager
	 * @since API 1.4.0
	 */
	public function getTextmoduleManager()
	{
	    return new Inx_Apiimpl_TextModule_TextModuleManagerImpl($this);
	}

	/**
	 * Returns the <code>Inx_Apiimpl_MailingTemplate_MailingTemplateManager</code> object that will used to manage mailing templates.
	 * 
	 * @return Inx_Apiimpl_MailingTemplate_MailingTemplateManagerImpl the template manager
	 * @since API 1.4.0
	 */
	public function getMailingTemplateManager()
	{
		return new Inx_Apiimpl_MailingTemplate_MailingTemplateManagerImpl( $this );
	}
	
	/**
	 * Returns the <code>Inx_Apiimpl_DesignTemplate_DesignCollectionManagerImpl</code> object that will used to manage design collections.
	 * 
	 * @return	the design collection manager
	 * @since API 1.4.0
	 */
	public function getDesignCollectionManager()
	{
	    return new Inx_Apiimpl_DesignTemplate_DesignCollectionManagerImpl($this);
	}
	
	/**
	 * Returns the <code>getTemporaryMailSender</code> object that will used to send temporary mails.
	 * 
	 * @return 	the mail sender
	 * @since API 1.0
	 */
	public function getTemporaryMailSender()
	{
	    if ($this->_oMailingManager === null)  {
	        $this->_oMailingManager = new Inx_Apiimpl_Mailing_MailingManagerImpl($this);
	    }
	    return $this->_oMailingManager;
	}

	
	/**
	 * Returns the <code>Inx_Api_Util_Utilities</code> object that can be used for special activities.
	 * 
	 * @return Inx_Api_Util_Utilities the utilities 
	 * @since API 1.1.0
	 */
	public function getUtilities()
	{
		return new Inx_Apiimpl_Util_UtilitiesImpl( $this );
	}
	
	
	/**
	 * Returns the <i>Inx_Api_Webpage_WebpageManager</i> used to access data of web pages (HTML files and JSPs) 
	 * like type and URL.
	 *
	 * @return Inx_Api_Webpage_WebpageManager the web page manager.
	 * @since API 1.9.0
	 */
	public function getWebpageManager()
	{
		return new Inx_Apiimpl_Webpage_WebpageManagerImpl( $this );
	}
	
	/**
	 * Returns the <code>UserContext</code> object associated with this <code>Session</code> object.
	 * 
	 * @return	the user context
	 * @since API 1.0
	 */
	public function getUserContext()
	{
	    if ($this->_oUserContext === null) {
	        $this->_oUserContext = new Inx_Apiimpl_Core_UserContextImpl($this);
	    }
	    return $this->_oUserContext;
	}
	
	
   /**
	* Returns the <i>InboxManager</i> object that will be used to retrieve inbox messages.
	*
	* @return Inx_Api_Inbox_InboxManager the inbox manager
	* @since API 1.9.0
	*/
	public function getInboxManager()
	{
		if( $this->_oInboxManager == null )
		$this->_oInboxManager = new Inx_Apiimpl_Inbox_InboxManagerImpl( $this );
		return $this->_oInboxManager;
	}
	
	
	/**
	 * Returns the <code>DataAccess</code> object that will used to get click and link data.
	 * 
	 * @return	the user context
	 * @since API 1.4
	 */
	public function getDataAccess()
	{
	    return new Inx_Apiimpl_DataAccess_DataAccessImpl($this);
	}
	
	public function getApprovalManager()
	{
	    return new Inx_Apiimpl_Approval_ApproverManagerImpl($this);
	}
	
	
	public function createTestRecipientContext()
	{

		try
		{
			$oRs = $this->getService( Inx_Apiimpl_SessionContext::TESTRECIPIENT_SERVICE );
			$rc = new Inx_Apiimpl_Recipient_RecipientContextImpl( $this, $oRs->fetchRecipientContext( $this->_sSessionId) );
			return new Inx_Apiimpl_Testprofiles_TestRecipientContextImpl( $this, $rc );
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->notify( $e );
			return null;
		}

	}
	
	public function getPluginStore()
	{
		return new Inx_Apiimpl_Plugin_PluginStoreImpl( $this );
	}
	
	    /**
     * Closes this session and releases any resources associated with
     * the session. A <code>Session</code> object
     * is also automatically closed when it is garbage collected.
     *
     * @since API 1.0
	 */
	public function close()
	{
		if( $this->_blSessionClosed ) {
			return;
		}
			
		$this->_blSessionClosed = true;
		
		try
		{
			$oService = $this->getService(self::CORE_SERVICE);
			$oService->logout( $this->_sSessionId );
		}
		catch( Exception $e )
		{
		    
		}
	}
	
	public function getServerTime()
	{
		try
		{
			$oService = $this->getService(self::CORE_SERVICE);
			$st = $oService->getServerTime($this->_sSessionId);
			return new Inx_Apiimpl_ServerTimeImpl(Inx_Apiimpl_TConvert::convert( $st->dateTime ),
									$st->gmtOffset,$st->dstOffset,$st->timeZone);
		}
		catch( Inx_Api_RemoteException $e )
		{
			$this->notify( $e );
			return null;
		}
	}
	
	
	public function sessionClosed() 
	{
	    return $this->_blSessionClosed;
	}
    
	public function fetchReleasedRemoteRefs()
	{
		$aRefIds = null;
		

		if( count($this->_aReleasedRemoteRefs) > 0 ) {
			
			$aRefIds = $this->_aReleasedRemoteRefs;
			$this->_aReleasedRemoteRefs = array();
		}
		
		return $aRefIds;
	}
	
	public function releaseRemoteRef( $sRemoteRefId, $blImmediate )
	{
	    $blRunDgc = false;

		$this->_aReleasedRemoteRefs[] = $sRemoteRefId ;
		if( $blImmediate )
			$blRunDgc = true;
		else
			$blRunDgc = count($this->_aReleasedRemoteRefs) >  $this->_maxReleasedRefs;
		
		if( $blRunDgc )
			$this->_heartbeat();
	}
	
	
	public function _heartbeat()
	{
		try
		{
			try
			{
				$aRefIds = $this->fetchReleasedRemoteRefs();
				
				$oCoreService = $this->getService( Inx_Apiimpl_SessionContext::CORE_SERVICE );
				$oCoreService->releaseRef( $this->sessionId(), $aRefIds );
			}
			catch( Inx_Api_RemoteException $x )
			{
				$this->notify( $x );
			}
		}
		catch( Exception $x )
		{
			// session already closed
		}
	}
		
	/**
	 * Returns the <code>Inx_Api_Resource_ResourceManager</code> object that will used to manage resources.
	 *
	 * @return Inx_Api_Resource_ResourceManager	the resource manager
	 * @since API 1.0
	 */
	public function getResourceManager()
	{
		if( $this->_oResourceManager == null )
			$this->_oResourceManager = new Inx_Apiimpl_Resource_ResourceManagerImpl( $this );
		return $this->_oResourceManager;
	}
/*
	
	protected abstract void scheduleHeartbeat( long period );
	protected abstract void cancelHeartbeat();



*/
 	
}
?>
