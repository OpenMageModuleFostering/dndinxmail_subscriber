<?php
interface Inx_Apiimpl_SessionContext
{
	
	const CORE_SERVICE = "CoreService";

	const RECIPIENT_SERVICE = "RecipientService";

	const LIST_SERVICE = "ListService";

	const MAILING6_SERVICE = "Mailing6Service";
        
        const TRIGGER_MAILING_SERVICE = "TriggerMailingService";

	const PROPERTY_SERVICE = "PropertyService";

	const RESOURCE_SERVICE = "ResourceService";

	const REPORTING_SERVICE = "ReportingService";

	const BLACKLIST_SERVICE = "BlacklistService";

	const FILTER_SERVICE = "FilterService";

	const ACTION_SERVICE = "ActionService";

	const TEXTMODULE_SERVICE = "TextmoduleService";
	
	const MAILING_TEMPLATE_SERVICE = "MailingTemplateService";

	const DATAACCESS_SERVICE = "DataAccessService";

	const DESIGN_COLLECTION2_SERVICE = "DesignTemplate2Service";
	
	const BOUNCE2_SERVICE = "Bounce2Service";
	
	const APPROVER_SERVICE = "ApproverService";
	
	const TESTRECIPIENT_SERVICE = "TestrecipientService";
	
	const UNSUBSCRIBER_SERVICE = "UnsubscriberService";
	
	const PLUGIN_SERVICE = "PluginService";
	
	const INBOX_SERVICE = "InboxService";
	
	const WEBPAGE_SERVICE = "WebpageService";
	
//	public function sessionId();

	
	public function createCxt();

	
	public function createRemoteRef( $sRemoteRefId );

	
	public function getService( $sKey );
	
	public function getIntProperty( $sKey );

	public function notify( Inx_Api_RemoteException $x );

}
