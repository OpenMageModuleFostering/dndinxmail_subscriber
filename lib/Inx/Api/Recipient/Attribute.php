<?php
/**
 * @package Inxmail
 * @subpackage Recipient
 */
/**
 * An <i>Inx_Api_Recipient_Attribute</i> contains meta data of recipients. 
 * It is the API equivalent of a column in the Inxmail recipient list view. 
 * There are mainly two categories of attributes:
 * <ol>
 * <li>Predefined attributes are created by Inxmail and may not be removed or renamed. 
 * The most important attributes of this type are:
 * <ul>
 * <li><i>The id attribute</i>: Contains the id of the recipient</li>
 * <li><i>The email attribute</i>: Contains the email address of the recipient</li>
 * <li><i>The key attribute</i>: In general the same as the email attribute</li>
 * <li><i>The subscription attribute</i>: Contains the subscription date of the recipient - Individual for every list</li>
 * <li><i>The last modification attribute</i>: Contains the date of the last modification of the recipient</li>
 * <li><i>The hard bounce attribute</i>: Contains the number of hard bounces received for the recipient</li>
 * </ul>
 * </li>
 * <li>User attributes are created by Inxmail users and may be freely removed or renamed. 
 * User attributes give you the ability to treat a recipient according to certain properties. 
 * For example you could create an user attribute called 'format' which contains the users preferred mail format. 
 * You could then set the mailing format according to this attribute. 
 * You could also define an user attribute to store certain interests of the recipient and generate filters 
 * (target groups) to send a mailing only to recipients who are interested in the topic covered by the mailing.</li>
 * </ol>
 * All attributes share a common set of properties, which define them. These properties are:
 * <p/>
 * <ul>
 * <li><i>The id</i>: Each attribute has a unique id.</li>
 * <li><i>The name</i>: Each attribute has an unique name. This name is only retrievable for user attributes, though.</li>
 * <li><i>The type</i>: The different attribute types are:
 * <ul>
 * <li><i>EMAIL_ATTRIBUTE_TYPE</i>: The email attribute</li>
 * <li><i>ID_ATTRIBUTE_TYPE</i>: The id attribute</li>
 * <li><i>SUBSCRIPTION_ATTRIBUTE_TYPE</i>: An attribute that indicates the subscription state for a specific list</li>
 * <li><i>LAST_MODIFICATION_ATTRIBUTE_TYPE</i>: The last modification date attribute</li>
 * <li><i>HARDBOUNCE_ATTRIBUTE_TYPE</i>: Contains the number of hard bounces received for a recipient</li>
 * <li><i>FEATURE_ATTRIBUTE_TYPE</i>: An attribute associated with a feature (agent)</li>
 * <li><i>USER_ATTRIBUTE_TYPE</i>: An user defined attribute</li>
 * </ul>
 * </li>
 * <li><i>The data type</i>: The different data types are:
 * <ul>
 * <li><i>DATA_TYPE_STRING</i></li>
 * <li><i>DATA_TYPE_DATETIME</i></li>
 * <li><i>DATA_TYPE_DATE</i></li>
 * <li><i>DATA_TYPE_TIME</i></li>
 * <li><i>DATA_TYPE_BOOLEAN</i></li>
 * <li><i>DATA_TYPE_INTEGER</i></li>
 * <li><i>DATA_TYPE_DOUBLE</i></li>
 * </ul>
 * </li>
 * <li><i>The maximum String length</i>: If the data type is <i>DATA_TYPE_STRING</i>, the attribute can not be longer
 * than the maximum length defined in this property.</li>
 * <li><i>The list context id</i>: Mainly used by attributes of type <i>SUBSCRIPTION_ATTRIBUTE_TYPE</i> to indicate
 * the list they are responsible for.</li>
 * <li><i>The feature (agent) id</i>: Some attributes are used by specific features.</li>
 * <li><i>The accessibility</i>: Only relevant for plug-ins.</li>
 * </ul>
 * <p/>
 * Predefined attributes can easily be retrieved using the various get methods of the <i>Inx_Api_Recipient_RecipientMetaData</i> class.
 * User attributes are retrieved using the <i>Inx_Api_Recipient_RecipientMetaData::getUserAttribute($sName)</i> method 
 * and are identified by their unique name. 
 * See the <i>Inx_Api_Recipient_RecipientMetaData</i> documentation for more information.
 * <p/>
 * User attributes may be created, removed and renamed using the <i>Inx_Api_Recipient_AttributeManager</i>. 
 * For more information on this topic, see the <i>AttributeManager</i> documentation.
 * 
 * @see Inx_Api_Recipient_AttributeManager
 * @see Inx_Api_Recipient_RecipientMetaData
 * @since   API 1.0
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 * @subpackage Recipient
 */
interface Inx_Api_Recipient_Attribute
{
	/**
	 * Constant for the data type String.
	 * 
	 * @var int
	 */
	const DATA_TYPE_STRING = 1;
	
	/**
	* Constant for the data type Integer.
	*
	* @var int
	*/
	const DATA_TYPE_INTEGER = 2;
	
	/**
	* Constant for the data type Double.
	*
	* @var int
	*/
	const DATA_TYPE_DOUBLE = 3;
	
	/**
	* Constant for the data type Boolean.
	*
	* @var int
	*/
	const DATA_TYPE_BOOLEAN = 4;
	
	/**
	* Constant for the data type Datetime (Date + Time).
	*
	* @var int
	*/
	const DATA_TYPE_DATETIME = 10;
	
	/**
	* Constant for the data type Date (without Time).
	*
	* @var int
	*/
	const DATA_TYPE_DATE = 11;
	
	/**
	* Constant for the data type Time (without Date).
	*
	* @var int
	*/
	const DATA_TYPE_TIME = 12;

	
	/**
	* Constant for attributes used by features.
	*
	* @var int
	*/
	const FEATURE_ATTRIBUTE_TYPE = 1;

	/**
	* Constant for attributes containing list subscription information.
	*
	* @var int
	*/
	const SUBSCRIPTION_ATTRIBUTE_TYPE = 2;

	/**
	* Constant for the email attribute.
	*
	* @var int
	*/
	const EMAIL_ATTRIBUTE_TYPE = 3;

	/**
	* Constant for the id attribute.
	*
	* @var int
	*/
	const ID_ATTRIBUTE_TYPE = 4;

	/**
	* Constant for user defined attributes.
	*
	* @var int
	*/
	const USER_ATTRIBUTE_TYPE = 5;

	/**
	* Constant for the last modification attribute.
	*
	* @var int
	*/
	const LAST_MODIFICATION_ATTRIBUTE_TYPE = 7;
	
	/**
	* Constant for the hard bounce attribute (counter).
	*
	* @var int
	* @since API 1.6.0
	*/
	const HARDBOUNCE_ATTRIBUTE_TYPE = 8;

	
	/**
	 * Returns the unique id of this attribute.
	 * 
	 * @return int the unique id of this attribute.
	 */
	public function getId();


	/**
	 * Returns the unique name of this attribute.
	 * 
	 * @return string the unique name of this attribute.
	 */
	public function getName();


	/**
	 * Returns the attribute type of this attribute.
	 * May be one of: 
	 * <ul>
	 * <li><i>ID_ATTRIBUTE_TYPE</i> 
	 * <li><i>EMAIL_ATTRIBUTE_TYPE</i>
	 * <li><i>USER_ATTRIBUTE_TYPE</i> 
	 * <li><i>SUBSCRIPTION_ATTRIBUTE_TYPE</i>
	 * <li><i>LAST_MODIFIED_ATTRIBUTE_TYPE</i>
	 * <li><i>FEATURE_ATTRIBUTE_TYPE</i>
	 * </ul>
	 * 
	 * @return int the attribute type of this attribute.
	 */
	public function getType();


	/**
	 * Returns the data type of this attribute.
	 * May be one of: 
	 * <ul>
	 * <li><i>DATA_TYPE_STRING</i> 
	 * <li><i>DATA_TYPE_INTEGER</i>
	 * <li><i>DATA_TYPE_DOUBLE</i> 
	 * <li><i>DATA_TYPE_BOOLEAN</i>
	 * <li><i>DATA_TYPE_DATETIME</i> 
	 * <li><i>DATA_TYPE_DATE</i>
	 * <li><i>DATA_TYPE_TIME</i>
	 * </ul>
	 * 
	 * @return int the data type of this attribute.
	 */
	public function getDataType();
	

	/**
	 * Returns the maximum length of the string value of this attribute. 
	 * Only relevant if the data type is <i>DATA_TYPE_STRING</i>.
	 * 
	 * @return int the maximum length of the string value of this attribute.
	 */
	public function getMaxStringLength();

	
	/**
	 * Returns the list context id of this attribute. 
	 * Only relevant if the attribute type is <i>SUBSCRIPTION_ATTRIBUTE_TYPE</i> or <i>FEATURE_ATTRIBUTE_TYPE</i>.
	 * 
	 * @return int the list context id of this attribute.
	 */
	public function getListContextId();

	
	/**
	 * Returns the feature id of this attribute. 
	 * Only relevant if the attribute type is <i>FEATURE_ATTRIBUTE_TYPE</i>.
	 * 
	 * @return int the feature id of this attribute.
	 */
	public function getFeatureId();
	
	/**
	 * Only relevant in a plug-in api session.
	 * 
	 * @return bool the accessibility of this attribute.
	 */
	public function isAccessible();

}
