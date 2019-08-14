<?php
/**
 * @package Inxmail
 */
/**
 * UserRights
 * 
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 */
interface Inx_Api_UserRights
{
	/** The right to view (read only) recipient information. */
	const RECIPIENT_VIEW = "com.inxmail.xpro.MemberContainer.view";

	/** The right to add recipients. */
	const RECIPIENT_ADD = "com.inxmail.xpro.MemberContainer.add";

	/** The right to update recipient information. */
	const RECIPIENT_UPDATE = "com.inxmail.xpro.MemberContainer.update";

	/** The right to unsubscribe and resubscribe unsubscribed recipients. */
	const RECIPIENT_RESUBSCRIBE = "com.inxmail.xpro.MemberContainer.changeState";

	/** The right to remove recipients permanently. */
	const RECIPIENT_REMOVE = "com.inxmail.xpro.MemberContainer.remove";

	/** The right to access the system recipient list (global). */
	const RECIPIENT_USE_SYSTEM = "com.inxmail.xpro.MemberContainer.useSystemContainer";

	/** The right to add lists. */
	const LISTCONTEXT_ADD = "com.inxmail.xpro.ListContextContainer.add";

	/** The right to update list information. */
	const LISTCONTEXT_UPDATE = "com.inxmail.xpro.ListContextContainer.update";

	/** The right to remove lists. */
	const LISTCONTEXT_REMOVE = "com.inxmail.xpro.ListContextContainer.remove";

	/**
	 * @deprecated
	 */
	const PROPERTY_SYSTEM_UPDATE = "com.inxmail.xpro.PropertyContainer.System.update";

	/** The right to update administrative properties. */
	const PROPERTY_ADMIN_UPDATE = "com.inxmail.xpro.PropertyContainer.admin.update";

	/** The right to update advanced properties. */
	const PROPERTY_ADVANCED_UPDATE = "com.inxmail.xpro.PropertyContainer.advanced.update";

	/** The right to update editorial list properties. */
	const PROPERTY_LIST_UPDATE = "com.inxmail.xpro.PropertyContainer.list.update";

	/** The right to use list properties. */
	const PROPERTY_LIST_USE = "com.inxmail.xpro.PropertyContainer.list.use";

	/**
	 * @deprecated
	 */
	const PROPERTY_UPDATE = "com.inxmail.xpro.PropertyContainer.update";

	/** The right to add recipient attributes (columns). */
	const ATTRIBUTE_ADD = "com.inxmail.xpro.AttributeContainer.add";

	/** The right to update (rename) recipient attributes (columns). */
	const ATTRIBUTE_UPDATE = "com.inxmail.xpro.AttributeContainer.update";

	/** The right to remove recipient attributes (columns). */
	const ATTRIBUTE_REMOVE = "com.inxmail.xpro.AttributeContainer.remove";

	/** The right to update attribute (column) alignment, width and visibility. */
	const ATTRIBUTE_STORE = "com.inxmail.xpro.AttributeContainer.store";

	/** The right to use the 'mailing' feature. */
	const MAILING_FEATURE_USE = "com.inxmail.xpro.server.agent.SendmailAgentImpl.use";

	/** The right to send test mailings. */
	const MAILING_FEATURE_TEST_SEND = "com.inxmail.xpro.agent.SendmailAgent.sendTestEMail";

	/** The right to send mailings. */
	const MAILING_FEATURE_SEND = "com.inxmail.xpro.agent.SendmailAgent.sendEMail";

	/** The right to start the display test. */
	const MAILING_INBOX_PREVIEW_USE = "com.inxmail.xpro.agent.SendmailAgent.createInboxPreview";

	/** The right to edit test mailing lists. */
	const MAILING_MANAGE_TESTGROUPS = "com.inxmail.xpro.agent.SendmailAgent.manageTestmailGroups";

	/** The right to add target groups. */
	const FILTER_ADD = "com.inxmail.xpro.agent.FilterAgent.add";

	/** The right to remove target groups. */
	const FILTER_REMOVE = "com.inxmail.xpro.agent.FilterAgent.remove";

	/** The right to update target group information. */
	const FILTER_UPDATE = "com.inxmail.xpro.agent.FilterAgent.update";

	/** The right to use the 'target groups' feature. */
	const FILTER_FEATURE_USE = "com.inxmail.xpro.server.agent.FilterAgentImpl.use";

	/** The right to use the 'blacklist' feature. */
	const BLACKLIST_FEATURE_USE = "com.inxmail.xpro.server.agent.BlackListAgentImpl.use";

	/** The right to use the 'actions' feature. */
	const ACTION_FEATURE_USE = "com.inxmail.xpro.server.agent.ActionAgentImpl.use";

	/** The right to add text modules. */
	const TEXTMODULE_ADD = "com.inxmail.xpro.server.agent.TextModuleAgentImpl.add";

	/** The right to remove text modules. */
	const TEXTMODULE_REMOVE = "com.inxmail.xpro.server.agent.TextModuleAgentImpl.remove";

	/** The right to update text modules. */
	const TEXTMODULE_UPDATE = "com.inxmail.xpro.server.agent.TextModuleAgentImpl.update";

	/** The right to use the 'text modules' feature. */
	const TEXTMODULE_FEATURE_USE = "com.inxmail.xpro.server.agent.TextModuleAgentImpl.use";

	/** The right to add templates. */
	const TEMPLATE_ADD = "com.inxmail.xpro.server.agent.TextModuleAgentImpl.add";

	/** The right to remove templates. */
	const TEMPLATE_REMOVE = "com.inxmail.xpro.server.agent.TextModuleAgentImpl.remove";

	/** The right to update templates. */
	const TEMPLATE_UPDATE = "com.inxmail.xpro.server.agent.TextModuleAgentImpl.update";

	/** The right to use the templates management. */
	const TEMPLATE_ITC_USE = "com.inxmail.xpro.server.agent.TextModuleAgentImpl.itc_management";

	/** The right to use the 'templates' feature. */
	const TEMPLATE_FEATURE_USE = "com.inxmail.xpro.server.agent.TextModuleAgentImpl.use";

	/**
	 * @deprecated
	 */
	const EXTERNALDATA_ADD = "com.inxmail.xpro.agent.ExternalDataAgent.add";

	/** The right to manage content data sources. */
	const EXTERNALDATA_MANAGE = "com.inxmail.xpro.agent.ExternalDataAgent.manage";

	/**
	 * @deprecated
	 */
	const EXTERNALDATA_REMOVE = "com.inxmail.xpro.agent.ExternalDataAgent.remove";

	/**
	 * @deprecated
	 */
	const EXTERNALDATA_UPDATE = "com.inxmail.xpro.agent.ExternalDataAgent.update";

	/**
	 * @deprecated
	 */
	const REDIRECT_FEATURE_USE = "com.inxmail.xpro.agent.redirect.RedirectAgentImpl.use";

	/**
	 * @deprecated
	 */
	const REPORT_ADD = "com.inxmail.xpro.agent.report.ReportAgent.add";

	/**
	 * @deprecated
	 */
	const REPORT_REMOVE = "com.inxmail.xpro.agent.report.ReportAgent.remove";

	/**
	 * @deprecated
	 */
	const REPORT_UPDATE = "com.inxmail.xpro.agent.report.ReportAgent.update";

	/** The right to use the 'reports' feature. */
	const REPORT_FEATURE_USE = "com.inxmail.xpro.server.agent.ReportAgentImpl.use";

	/** The right to add web pages. */
	const RESOURCE_CREATE_PAGE = "com.inxmail.xpro.agent.ResourceAgent.createpage";

	/** The right to embed images in mailings. */
	const RESOURCE_EMBED_IMAGE = "com.inxmail.xpro.agent.ResourceAgent.embedimage";

	/** The right to attach files to mailings. */
	const RESOURCE_ATTACH_FILE = "com.inxmail.xpro.agent.ResourceAgent.attachfile";

	/** The right to publish web pages. */
	const RESOURCE_PUBLISH_PAGE = "com.inxmail.xpro.agent.ResourceAgent.publishpage";

	/** The right to delete web pages. */
	const RESOURCE_DELETE_PAGE = "com.inxmail.xpro.agent.ResourceAgent.deletepage";

	/** The right to delete files. */
	const RESOURCE_REMOVE = "com.inxmail.xpro.agent.ResourceAgent.deletefile";

	/** The right to upload files and release them for a list. */
	const RESOURCE_UPLOAD_LIST_SHARING = "com.inxmail.xpro.agent.ResourceAgent.uploadtolist";

	/** The right to upload files but not release them for a list. */
	const RESOURCE_UPLOAD_MAILING_SHARING = "com.inxmail.xpro.agent.ResourceAgent.uploadtotask";

	/** The right to upload files and release them for all lists. */
	const RESOURCE_UPLOAD_SYSTEM_SHARING = "com.inxmail.xpro.agent.ResourceAgent.uploadtoall";

	/** The right to use the 'files and web pages' feature. */
	const RESOURCE_FEATURE_USE = "com.inxmail.xpro.server.agent.ResourceAgentImpl.use";

	/** The right to add webspaces. */
	const RESOURCE_MANAGE_WEBSPACE = "com.inxmail.xpro.agent.ResourceAgent.webspaceManage";

	/** The right to use webspaces. */
	const RESOURCE_WEBSPACE_USE = "com.inxmail.xpro.agent.ResourceAgent.webspaceUse";

	/** The right to access all mailing lists. */
	const USER_ACCESS_ALL_LISTS = "com.inxmail.xpro.agent.UserAgent.all_list_access";

	/** The right to use the API. */
	const API_USE = "com.inxmail.xpro.ApiAgentImpl.use";

	/** The right to manage mail server settings. */
	const MAIL_TRANSPORT_MANAGEMENT_USE = "com.inxmail.xpro.MailTransportContainer.manage";

	/** The right to use the 'email sequence' feature. */
	const SEQUENCE_FEATURE_USE = "com.inxmail.xpro.server.agent.SequenceAgentImpl.use";

	/** The right to use the 'email connector' feature. */
	const DISCUSSION_FEATURE_USE = "com.inxmail.xpro.server.agent.DiscussionAgentImpl.use";

	/** The right to use the 'inbox and bounces' feature. */
	const ERRORMAIL_FEATURE_USE = "com.inxmail.xpro.server.agent.ErrormailAgentImpl.use";

	/** The right to use the 'subscriptions' feature. */
	const SUBSCRIPTION_FEATURE_USE = "com.inxmail.xpro.server.agent.SubscriptionAgentImpl.use";

	/** The right to use the 'synchronization' feature. */
	const SYNC_FEATURE_USE = "com.inxmail.xpro.server.agent.SyncAgentImpl.use";

	/** The right to use the 'test profiles' feature. */
	const TESTPROFILE_FEATURE_USE = "com.inxmail.xpro.server.agent.TestprofileAgentImpl.use";

	/** The right to use the 'access rights' feature. */
	const USER_FEATURE_USE = "com.inxmail.xpro.server.agent.UserAgentImpl.use";

	/** The right to use the 'content' feature. */
	const EXTERNAL_DATA_FEATURE_USE = "com.inxmail.xpro.server.agent.ExternalDataAgentImpl.use";

	/** The right to use the user administration. */
	const USER = "com.inxmail.xpro.UserContainer.manage";

	// NEW:
	/** The right to use the global agents 'properties' and 'properties (administration)'. */
	const PROPERTY_SYSTEM_USE = "com.inxmail.xpro.PropertyContainer.system.use";

	/** The right to reset a recipients bounce status. */
	const RECIPIENT_CHANGE_HARDBOUNCE_STATE = "com.inxmail.xpro.MemberContainer.resetHardbounceState";

	/** The right to send a mailing without approval. */
	const MAILING_FEATURE_SEND_UNAPPROVED = "com.inxmail.xpro.agent.SendmailAgent.sendWithoutApproval";

	/** The right to edit test profiles. */
	const TESTPROFILE_FEATURE_MANAGE = "com.inxmail.xpro.agent.TestprofileAgent.manage";

	/** The right to install, configure and uninstall plug-ins. */
	const PLUGIN_FEATURE_MANAGE = "com.inxmail.xpro.PluginContainer.manage";

	/** The right to add and delete plug-ins from lists. */
	const PLUGIN_FEATURE_LIST_ADD_DELETE = "com.inxmail.xpro.PluginContainer.listAddDelete";

	/** The right to install plug-ins that are not listed as trusted. */
	const PLUGIN_FEATURE_INSTALL_UNTRUSTED = "com.inxmail.xpro.PluginContainer.installUntrusted";
	
	/** The right to access the global settings. */
	const USER_ACCESS_GLOBAL_SETTINGS = "com.inxmail.xpro.agent.UserAgent.global_settings_access";
}
