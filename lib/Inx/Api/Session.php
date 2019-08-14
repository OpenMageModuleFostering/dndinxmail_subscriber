<?php
/**
 * @package Inxmail
 */
/**
 * The <i>Inx_Api_Session</i> is the entry point to the API. 
 * 
 * The createRemoteSession method may be used in following way to create a remote session:
 * 
 * <PRE>
 * Inx_Api_Session::setProperty( &quot;http.proxyHost&quot;, &quot;192.168.1.142&quot; );
 * Inx_Api_Session::setProperty( &quot;http.proxyPort&quot;, &quot;8080&quot; );
 * Inx_Api_Session::setProperty( &quot;http.nonProxyHosts&quot;, &quot;localhost|127.0.0.1&quot; );
 * Inx_Api_Session::setProperty( &quot;http.proxyUser&quot;, &quot;test&quot; );
 * Inx_Api_Session::setProperty( &quot;http.proxyPassword&quot;, &quot;test&quot; );
 * 
 * $s = null;
 * 		
 * try
 * {
 * 	  $s = Inx_Api_Session::createRemoteSession( "http://localhost:80/inxmail", "apiuser", "password" );
 * 	  ...
 *    $s->close(); //close the session
 * }
 * catch( LoginException x )
 * {
 * 	  ...
 * }
 * </PRE>
 * 
 * <P/>
 * The createLocalSession method may be used in following way to create a local session:
 * 
 * <PRE>
 * $s = null;
 * 
 * try
 * {
 * 	  $s = Inx_Api_Session::createLocalSession( &quot;apiuser&quot;, &quot;password&quot; );
 * 	  ...
 *    $s->close(); //close the session
 * }
 * catch( LoginException x )
 * {
 * 	  ...
 * }
 * </PRE>
 * 
 * <p/>
 * <strong>Note:</strong> An <i>Inx_Api_Session</i> object <strong>must</strong> be closed once it is not needed anymore to
 * prevent memory leaks and other potentially harmful side effects.
 *
 * @since   API 1.0
 * @version $Revision: 9729 $ $Date: 2008-01-18 17:31:31 +0200 (Pn, 18 Sau 2008) $ $Author: aurimas $
 * @package Inxmail
 */
abstract class Inx_Api_Session
{
	protected static $_aProperties = array();
	/**
	 * Attempts to establish a session to the given inxmail application.
	 * 
	 * @param string $sApplicationUrl	an application url of the form http://[host]:[port]/[webapps].
	 * @param string $sUsername	the inxmail user on whose behalf the session is being created.
	 * @param string $sPassword	the user's password.
	 * @param bool $blPwdEncrypted	determines whether the password will be transfered in encrypted form, 
	 * 			may be omitted. 
	 * @return Inx_Api_Session a session to the given inxmail application.
	 * @throws Inx_Api_LoginException if the login failed.
	 * @throws Inx_Api_ConnectException if the connection could not be established.
	 * @since API 1.0
	 */
	public static function createRemoteSession( $sApplicationUrl, $sUsername,
			$sPassword, $blPwdEncrypted=false )
	{
		try
		{
			$sClassName='';
			if( strpos($sApplicationUrl, "rmi://")===0 )
			    throw new Exception('Not implemented!');
			elseif( strpos($sApplicationUrl, "hessian://")===0 )
				throw new Exception('Not implemented!');
			elseif( strpos($sApplicationUrl, "hessians://")===0 )
				throw new Exception('Not implemented!');
			else
			    $sClassName = "Inx_Apiimpl_SoapSession";
			return $class = new $sClassName($sApplicationUrl, $sUsername, $sPassword, $blPwdEncrypted);
		} catch( Inx_Api_LoginException $e ) {
			throw new Inx_Api_LoginException($e->getMessage(), $e->getCode());
		} catch( Inx_Api_APIException $e ) {
			throw new Inx_Api_APIException($e->getMessage(), $e);
		} catch( Inx_Api_ConnectException $e ) {
			throw new Inx_Api_ConnectException($e->getMessage(), $e->getCode());
		}
	}
	
	/**
	 * Attempts to establish a session used for plug-ins.
	 * 
	 * @param string $sApplicationUrl	an application url of the form http://[host]:[port]/[webapps].
	 * @param string $sLoginToken the token used to login the plug-in.
	 * @return Inx_Api_Session a session to the given inxmail application.
	 * @throws Inx_Api_LoginException if the login failed.
	 * @throws Inx_Api_ConnectException if the connection could not be established.
	 * @since API 1.4.5
	 */
	public static function createPluginSession( $sApplicationUrl, $sLoginToken)
	{
		try
		{
			$sClassName='';
			if( strpos($sApplicationUrl, "rmi://")===0 )
			    throw new Exception('Not implemented!');
			elseif( strpos($sApplicationUrl, "hessian://")===0 )
				throw new Exception('Not implemented!');
			elseif( strpos($sApplicationUrl, "hessians://")===0 )
				throw new Exception('Not implemented!');
			else
			    $sClassName = "Inx_Apiimpl_SoapSession";
			return $class = new $sClassName($sApplicationUrl, null, null, false, $sLoginToken);
		} catch( Inx_Api_LoginException $e ) {
			throw new Inx_Api_LoginException($e->getMessage(), $e->getCode());
		} catch( Inx_Api_APIException $e ) {
			throw new Inx_Api_APIException($e->getMessage(), $e);
		} catch( Inx_Api_ConnectException $e ) {
			throw new Inx_Api_ConnectException($e->getMessage(), $e->getCode());
		}
	}
	
	
	/**
	 * Attempts to establish a session used for plug-ins.
	 * 
	 * @param string $sApplicationUrl	an application url of the form http://[host]:[port]/[webapps].
	 * @param string $pluginSecretId the secret id of the Plugin.
	 * @param string $username the inxmail user on whose behalf the session is being created.
	 * @param string $password the user's password.
	 * @param bool $pwdEncrypted determines whether the password will be transfered in encrypted form.	
	 * @return Inx_Api_Session a session to the given inxmail application.
	 * @throws Inx_Api_LoginException if the login failed.
	 * @throws Inx_Api_ConnectException if the connection could not be established.
	 * @since API 1.4.5
	 */
	public static function createPluginSession2( $sApplicationUrl, $pluginSecretId,
			$username, $password, $pwdEncrypted )
	{
		try
		{
			$sClassName='';
			if( strpos($sApplicationUrl, "rmi://")===0 )
			    throw new Exception('Not implemented!');
			elseif( strpos($sApplicationUrl, "hessian://")===0 )
				throw new Exception('Not implemented!');
			elseif( strpos($sApplicationUrl, "hessians://")===0 )
				throw new Exception('Not implemented!');
			else
			    $sClassName = "Inx_Apiimpl_SoapSession";
			return $class = new $sClassName($sApplicationUrl, $username, $password, $password, null, $pluginSecretId);
		} catch( Inx_Api_LoginException $e ) {
			throw new Inx_Api_LoginException($e->getMessage(), $e->getCode());
		} catch( Inx_Api_APIException $e ) {
			throw new Inx_Api_APIException($e->getMessage(), $e);
		} catch( Inx_Api_ConnectException $e ) {
			throw new Inx_Api_ConnectException($e->getMessage(), $e->getCode());
		}
	}
	
	
	/**
	 * This feature is not available in the PHP API.
	 */
	public static function createLocalSession()
	{
		throw new Exception('Not implemented!');
	}

	
	/**
	 * Creates a new <i>Inx_Api_Recipient_RecipientContext</i> that can be used to access and manipulate 
	 * recipient data.
	 * 
	 * @return Inx_Api_Recipient_RecipientContext a new <i>Inx_Api_Recipient_RecipientContext</i>.
	 * @since API 1.0
	 */
	public abstract function createRecipientContext();
	
	
	/**
	 * Returns the <i>Inx_Api_List_ListContextManager</i> object that will be used to manage lists.
	 * 
	 * @return Inx_Api_List_ListContextManager	the list manager.
	 * @since API 1.0
	 */
	public abstract function getListContextManager();
	
	
	/**
	 * Returns the <i>Inx_Api_Recipient_AttributeManager</i> object that will be used to manage attributes 
	 * (recipient columns).
	 * 
	 * @return Inx_Api_Recipient_AttributeManager	the attribute manager.
	 * @since API 1.0
	 */
	public abstract function getAttributeManager();

	
	/**
	 * Returns the <i>Inx_Api_Mailing_MailingManager</i> object that will be used to manage mailings and 
	 * produce the mailing output (HTML and/or plain text) for a single recipient.
	 *
	 * @return Inx_Api_Mailing_MailingManager the mailing manager.
	 * @since API 1.0
	 */
	public abstract function getMailingManager();
        
        
        /**
	 * Returns the <i>Inx_Api_TriggerMailing_TriggerMailingManager</i> object that will be used to manage 
         * trigger mailings and produce the trigger mailing output (HTML and/or plain test) for a single recipient.
	 * 
	 * @return Inx_Api_TriggerMailing_TriggerMailingManager the trigger mailing manager.
	 * @since API 1.10.0
	 */
        public abstract function getTriggerMailingManager();

	
	/**
	 * Returns the <i>Inx_Api_Subscription_SubscriptionManager</i> object that will be used to subscribe 
	 * and unsubscribe recipients.
	 *
	 * @return Inx_Api_Subscription_SubscriptionManager the subscription manager.
	 * @since API 1.0
	 */
	public abstract function getSubscriptionManager();

	
	/**
	 * Returns the <i>Inx_Api_Resource_ResourceManager</i> object that will be used to manage resources like 
	 * attachments and embedded images stored on the server.
	 * 
	 * @return	Inx_Api_Resource_ResourceManager the resource manager.
	 * @since API 1.0
	 */
	public abstract function getResourceManager();


	/**
	 * Returns the <i>Inx_Api_Action_ActionManager</i> object that will be used to manage actions. 
	 * An <i>Inx_Api_Action_Action</i> can manipulate or send a mail to a recipient for whom an event has occurred.
	 * 
	 * @return Inx_Api_Action_ActionManager the action manager.
	 * @since API 1.2.0
	 */
	public abstract function getActionManager();

	
	/**
	 * Returns the <i>Inx_Api_Reporting_ReportEngine</i> object that will be used to generate reports.
	 * 
	 * @return Inx_Api_Reporting_ReportEngine the report engine.
	 * @since API 1.3.0
	 */
	public abstract function getReportEngine();

	
	/**
	 * Returns the <i>Inx_Api_Blacklist_BlacklistManager</i> object that will be used to manage blacklist entries.
	 * 
	 * @return Inx_Api_Blacklist_BlacklistManager the blacklist manager.
	 * @since API 1.1.0
	 */
	public abstract function getBlacklistManager();

	/**
	 * Returns the <i>Inx_Api_Bounce_BounceManager</i> object that will be used to retrieve bounce notifications. 
	 * A bounce notification is a mail received by a mail server that indicates that a mailing could not be sent to a 
	 * specific recipient (bounced). 
	 * This may be due due to an unknown recipient at the destination mail server.
	 * 
	 * @return Inx_Api_Bounce_BounceManager the bounce manager.
	 * @since API 1.4.3
	 */
	public abstract function getBounceManager();
	
	/**
	 * Returns the <i>Inx_Api_Filter_FilterManager</i> object that will be used to manage filters. 
	 * A <code>Filter</code> is used to define target groups of recipients that share a common property. 
	 * For example: All recipients born after 1970.
	 * 
	 * @return Inx_Api_Filter_FilterManager the filter manager.
	 * @since API 1.1.0
	 */
	public abstract function getFilterManager();
	
	/**
	 * Returns the <i>Inx_Api_TextModule_TextModuleManager</i> object that will be used to manage text modules. 
	 * Text modules are reusable text snippets that can be used inside mailings in the same list (or all lists 
	 * if the text module is defined in the system list). 
	 * A common text module is a custom salutation.
	 * 
	 * @return Inx_Api_TextModule_TextModuleManager	the textmodule manager.
	 * @since API 1.4.0
	 */
	public abstract function getTextmoduleManager();

	/**
	 * Returns the <i>Inx_Api_MailingTemplate_MailingTemplateManager</i> object that will be used to manage mailing templates. 
	 * Mailing templates are reusable mailing contents that can be used as a basis for new mailings. 
	 * These templates are far less powerful than the templates provided by design collections.
	 * 
	 * @return Inx_Api_MailingTemplate_MailingTemplateManager the template manager.
	 * @since API 1.4.0
	 */
	public abstract function getMailingTemplateManager();
	
	/**
	 * Returns the <i>Inx_Api_DesignTemplate_DesignCollectionManager</i> object that will be used to import design collections. 
	 * Design collections may contain multiple design templates which can be used to create complex multipart mailings.
	 * 
	 * @return Inx_Api_DesignTemplate_DesignCollectionManager the design collection manager.
	 * @since API 1.4.0
	 */
	public abstract function getDesignCollectionManager();
	
	/**
	 * Returns the <i>Inx_Api_Util_TemporaryMailSender</i> object that will be used to send temporary mails. 
	 * Temporary mails are not written to the database, thus not retrievable once they are sent.
	 * 
	 * @return Inx_Api_Util_TemporaryMailSender	the temporary mail sender.
	 * @since API 1.0
	 */
	public abstract function getTemporaryMailSender();

	
	/**
	 * Returns the <i>Inx_Api_Util_Utilities</i> object that can be used for special activities like the tell a friend feature.
	 * 
	 * @return Inx_Api_Util_Utilities the utilities.
	 * @since API 1.1.0
	 */
	public abstract function getUtilities();
	
   /**
	* Returns the <i>Inx_Api_Webpage_WebpageManager</i> used to access data of web pages (HTML files and JSPs) 
	* like type and URL.
	*
	* @return Inx_Api_Webpage_WebpageManager the web page manager.
	* @since API 1.9.0
	*/
	public abstract function getWebpageManager();
	
	
	/**
	 * Returns the <i>Inx_Api_UserContext</i> object associated with this <code>Session</code> object. 
	 * The <code>UserContext</code> may be used to check the rights of the session user.
	 * 
	 * @return Inx_Api_UserContext the user context.
	 * @since API 1.0
	 */
	public abstract function getUserContext();
	
	
	/**
	* Returns the <i>Inx_Api_Inbox_InboxManager</i> object that will be used to retrieve inbox messages.
	* 
	* @return Inx_Api_Inbox_InboxManager the inbox manager.
	* @since API 1.9.0
	*/
	public abstract function getInboxManager();
	
	
	/**
	 * Returns the <i>Inx_Api_DataAccess_DataAccess</i> object that will be used to get click and link data.
	 * 
	 * @return Inx_Api_DataAccess_DataAccess the data access object.
	 * @since API 1.4
	 */
	public abstract function getDataAccess();
	
	/**
	 * Returns the <i>Inx_Api_Approval_ApprovalManager</i> object that will be used to manage approvers. 
	 * An approver is responsible for approving mails before they can be sent.
	 * 
	 * @return Inx_Api_Approval_ApprovalManager the approval manager.
	 * @since API 1.6
	 */
	public abstract function getApprovalManager();
	
	
	/**
	 * Returns the unique id of this session.
	 * 
	 * @return string the id of this session.
	 * @since API 1.0
	 */
	public abstract function sessionId();
	
	
    /**
     * Closes this session and releases any resources associated with the session. 
     * An <i>Inx_Api_Session</i> object <strong>must</strong> be closed once it is not needed anymore to prevent 
     * memory leaks and other potentially harmful side effects.
     *
     * @since API 1.0
	 */
	public abstract function close();
		
	/**
	 * Returns the server time as <i>Inx_Api_ServerTime</i> object. 
	 * With this object, you are able to translate the date from your time zone to the time zone of the server.
	 * 
	 * @return Inx_Api_ServerTime the server time.
	 * @since API 1.4.4
	 */
	public abstract function getServerTime();
	
	/**
	 * Returns the <code>PluginStore</code> object that will be used to manage stored informations. 
	 * The <code>PluginStore</code> is used as isolated storage for plug-ins. 
	 * This is only useful for plug-in usage of the api.
	 * 
	 * @since API 1.7.0
	 */
	public abstract function getPluginStore();
	
	/**
	 * Creates a new <code>Inx_Api_Testprofiles_TestRecipientContext</code> that can be used to access and manipulate 
	 * test recipient data.
	 * Test recipients are used to create a preview of a mailing.
	 * 
	 * @return a new <code>TestRecipientContext</code>.
	 * @since API 1.6.0
	 */
	public abstract function createTestRecipientContext();
	
	/**
	 * Sets the session property specified by the given key to the given value. 
	 * This may be used to configure a proxy conenction.
	 *
	 * @param string $sKey the property name. Possible values are: 
	 * <ul>
	 * 	 	<li><i>http.proxyHost</i>
	 * 		<li><i>http.proxyPort</i>
	 * 		<li><i>http.proxyUser</i>
	 * 		<li><i>http.proxyPassword</i>
	 * 		<li><i>soap.connectionTimeout</i>
	 * </ul> 
	 * @param string|int $sValue the property value.
	 */
	public static function setProperty($sKey, $mxValue)
	{
		if (empty($sKey)) {
			throw new Inx_Api_IllegalArgumentException("Key can't be empty.");
		}
		
		if (! (is_string($mxValue) || is_int($mxValue))) {
			throw new Inx_Api_IllegalArgumentException("Value must be string or int.");
		}
		
		self::$_aProperties[$sKey] = $mxValue;
	}
	
	/**
	 * Returns the value of the session property specified by the given key.
	 *
	 * @param string $sKey the property name.
	 * @return string|int the property value.
	 */
	public static function getProperty($sKey)
	{
		if (empty($sKey)) {
			throw new Inx_Api_IllegalArgumentException("Key can't be empty.");
		}
		if (isset(self::$_aProperties[$sKey])) {
			return self::$_aProperties[$sKey];
		}
		
		return null;
	}
}