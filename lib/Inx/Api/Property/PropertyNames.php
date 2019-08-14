<?php
/**
 * @package Inxmail
 * @subpackage Property
 */
/**
 * The <i>Inx_Api_Property_PropertyNames</i> interface defines the properties which can be set by the API. 
 * Not all properties are available for all list types. 
 * See the documentation of a specific property for its list type availability.
 * 
 * @see Inx_Api_Property_Property
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 * @subpackage Property
 */
interface Inx_Api_Property_PropertyNames
{
	/**
	* Constant for the locale property. The locale property defines how numbers and dates are formatted. 
	* This property is available for the following list types:
	* <ul>
	* <li>Standard list
	* <li>Filter list
	* <li>System list
	* </ul>
	*/
    const FORMAT_LOCALE = "listFormatLocale";
    
    /**
    * Constant for the fraction digits property. 
    * The fraction digits property defines how many decimal fraction digits shall be viewed of a floating point 
    * (or floating comma) value. 
    * This property is available for the following list types:
    * <ul>
    * <li>Standard list
    * <li>Filter list
    * <li>System list
    * </ul>
    */
    const FORMAT_FRACTION_DIGITS = "floatDecimalPlacesProperty";

    /**
    * Constant for the decimal separator property. 
    * The decimal separator property defines which character is used to separate a decimal number from its fractions. 
    * This property is available for the following list types:
    * <ul>
    * <li>Standard list
    * <li>Filter list
    * <li>System list
    * </ul>
    */
    const FORMAT_SEPERATOR = "floatDecimalSeperatorProperty";

    /**
    * Constant for the line break property. 
    * The line break property defines after how many characters a text mailing line will break automatically. 
    * This property is available for the following list types:
    * <ul>
    * <li>Standard list
    * <li>Filter list
    * </ul>
    */
    const FORMAT_LINEBREAK = "editor-max-columns";

    /**
    * Constant for the character set property. 
    * The character set property defines how characters are encoded (e.g. UTF-8). 
    * This property is available for the following list types:
    * <ul>
    * <li>Standard list
    * <li>Filter list
    * <li>System list
    * </ul>
    */
    const MAIL_ENCODING = "charset";

    /**
    * Constant for the mail format property. 
    * The mail format property defines which formats (plain text, HTML text or multipart) may be used in a specific list. 
    * This special property can be set using the <i>Inx_Api_Property_FormatChoicePropertyFormatter</i>. 
    * This property is available for the following list types:
    * <ul>
    * <li>Standard list
    * <li>Filter list
    * </ul>
    *
    * @see Inx_Api_Property_FormatChoicePropertyFormatter
    */
    const MAIL_FORMAT_CHOICE = "email-format";

    /**
    * Constant for the sender address property. 
    * The sender address property defines which which address is used to send the mailings of a list. 
    * This property is available for the following list types:
    * <ul>
    * <li>Standard list
    * <li>Filter list
    * </ul>
    */
    const MAIL_SENDER_ADDRESS = "sender-address";

    /**
    * Constant for the reply address property. 
    * The reply address property defines which address the recipient may use for replies. 
    * This property is available for the following list types:
    * <ul>
    * <li>Standard list
    * <li>Filter list
    * </ul>
    */    
    const MAIL_REPLY_ADDRESS = "reply-address";

    /**
    * Constant for the system mail sender address property. 
    * The system mail sender address property defines which address is used to send system mails. 
    * This property is available for the following list types:
    * <ul>
    * <li>Administration list
    * </ul>
    */
    const SYSTEM_MAIL_SENDER_ADDRESS = "SystemSenderEmail";

    /**
    * @deprecated this property will be removed in further versions.
    */
    const SERVER_NAME = "RedirectServerHostName";

    /**
    * @deprecated this property will be removed in further versions.
    */
    const SERVER_PORT = "RedirectServerHostPort";

    /**
    * Constant for the sending performance property. 
    * The sending performance property defines how many mails may be sent per hour at a maximum. 
    * The value has to be set in steps of 3600, where 0 means no limit at all. 
    * This property is available for the following list types:
    * <ul>
    * <li>Standard list
    * <li>Filter list
    * <li>System list
    * </ul>
    */
    const SENDING_MAILS_PER_HOUR = "sendrate";

    /**
    * @deprecated this property will be removed in further versions.
    */
    const HTML_PREVIEW = "html-preview";
    
    /**
    * @deprecated this property will be removed in further versions.
    */
    const MAIL_TEST_ADDRESS = "test-recipient";
    
    /**
	 * Constant for the hard bounce threshold property. 
	 * The hard bounce threshold property defines how many hard bounces may be received before a recipient is 
	 * marked as unreachable. 
	 * A value of 0 means the recipient will never be marked as unreachable automatically. 
	 * This property is available for the following list types:
	 * <ul>
	 * <li>Administration list
	 * </ul>
	 * 
	 * @since API 1.6.0
	 */
	const HARDBOUNCE_THRESHOLD = "HardbounceThreshold";

	/**
	 * Constant for the hard bounce active property. 
	 * The hard bounce active property defines if recipients are automatically marked as unreachable if a 
	 * specific threshold (see <i>HARDBOUNCE_THRESHOLD</i>) is reached.
	 * This property is available for the following list types:
	 * <ul>
	 * <li>Administration list
	 * </ul>
	 * 
	 * @since API 1.6.0
	 */
	const HARDBOUNCE_ACTIVE = "HardbounceActive";

	/**
	 * Constant for the approval property. 
	 * The approval property defines if the approval of of mailings is activated and how it is done. 
	 * This special property may be set using the <i>Inx_Api_Property_PropertyFormatter</i> provided by
	 * <i>Inx_Api_Property_Property::getFormatter()</i>. 
	 * This property is available for the following list types:
	 * <ul>
	 * <li>Standard list
	 * <li>Filter list
	 * <li>System list
	 * </ul>
	 * 
	 * @see Inx_Api_Property_Property::getFormatter()
	 * @since API 1.6.0
	 */
	const APPROVAL_ACTIVE = "ApprovalActive";
	
	/**
	 * Constant for the server URL property. 
	 * The server URL property defines the address of the Inxmail customer. This value is important for JSPs. 
	 * This property is available for the following list types:
	 * <ul>
	 * <li>Standard list
	 * <li>Filter list
	 * <li>Administration list
	 * </ul>
	 * 
	 * @since API 1.6.1
	 */
	const SERVER_URL = "RedirectServerUrl";

	/**
	 * Constant for the link URL property. 
	 * The link URL property defines the address of the Inxmail customer. This value is used for link tracking. 
	 * This property is available for the following list types:
	 * <ul>
	 * <li>Standard list
	 * <li>Filter list
	 * <li>Administration list
	 * </ul>
	 * 
	 * @since API 1.6.1
	 */
	const LINK_URL = "RedirectLinkUrl";

	/**
	 * Constant for the tracking proxy property. 
	 * The tracking proxy property defines if a tracking proxy shall be used and which one to use. 
	 * This property is available for the following list types:
	 * <ul>
	 * <li>Administration list
	 * </ul>
	 * 
	 * @since API 1.6.1
	 */
	const TRACKING_PROXY = "TrackingProxy";
	
}
