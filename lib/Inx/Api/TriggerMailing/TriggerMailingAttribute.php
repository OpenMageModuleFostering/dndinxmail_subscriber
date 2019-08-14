<?php
/**
 * @package Inxmail
 * @subpackage TriggerMailing
 */

/**
 * The <i>TriggerMailingAttribute</i> enumeration defines the attributes of trigger mailings which are used for
 * the ordering of result sets and to identify the error source of an <i>Inx_Api_UpdateException</i>.
 * <p>
 * To find out if an attribute may be used for ordering, call the <i>isOrderAttribute()</i> method.
 *<p>
 * A note for programmers who are not familiar with the concept of enumerations: Enumerations or enumerated types are basically 
 * a fixed set of named values. They are usually used to define a couple of legitimate values in a specific context and serve a 
 * purpose similar to integer constants. 
 * The advantage of enumerations is, that you cannot specify any "weird" values because every value has to be an instance of 
 * the enumerated type. It is also possible to associate data or even behaviour (methods) with the values. 
 * PHP does not support such a language feature like Java and C# do. In most languages the named values are a sort of constant 
 * whose value is an instance of the enumerated type. In PHP a constant cannot contain a reference type. Therefore, we 
 * implemented enumerations as classes with private constructor and methods which return the named values.
 * Be aware that the objects returned by the static methods are always the same object. That way it is possible to use the 
 * identity operator (===) on these objects and use them comfortably in switch statements.
 * 
 * @see Inx_Api_TriggerMailing_TriggerMailingManager::selectByState( Inx_Api_List_ListContext $listContext, 
 *      Inx_Api_TriggerMailing_StateFilter $stateFilter, Inx_Api_TriggerMailing_TriggerMailingAttribute $orderAttribute = null, 
 *      $iOrderType = null, $sFilter = null )
 * @see Inx_Api_UpdateException::getErrorSource()
 * @since API 1.10.0
 * @author chge, 13.07.2012
 */
final class Inx_Api_TriggerMailing_TriggerMailingAttribute
{
	private static $INTERNAL_MAILING_LIST_ID = null;
	
	private static $INTERNAL_MAILING_FEATURE_ID = null;
	
	private static $INTERNAL_MAILING_CONTENT_MAIL_TYPE = null;
	
	private static $SUBJECT = null;
	
	private static $PLAIN_TEXT = null;
	
	private static $HTML_TEXT = null;
	
	private static $XML_CONTENT = null;
	
	private static $PLAIN_TEXT_XSL = null;
	
	private static $HTML_TEXT_XSL = null;
	
	private static $FILTER_ID = null;
	
	private static $SENDER_ADDRESS = null;
	
	private static $RECIPIENT_ADDRESS = null;
	
	private static $REPLY_TO_ADDRESS = null;
	
	private static $PRIORITY = null;
	
	private static $MODIFICATION_DATETIME = null;
	
	private static $STYLE = null;
	
	private static $ACTIVATION_DATETIME = null;
	
	private static $SINGLE_SEND_COUNT = null;
	
	private static $NAME = null;
	
	private static $DESCRIPTOR = null;
	
	private static $DEFAULT_ATTRIBUTE = null;
        
        private static $UNKNOWN = null;
	
	/**
	 * Constant for the mailing list id attribute. This constant is used internally only.
         * 
         * @return Inx_Api_TriggerMailing_TriggerMailingAttribute the mailing list id attribute.
	 */
	public static final function INTERNAL_MAILING_LIST_ID()
	{
		if(null === self::$INTERNAL_MAILING_LIST_ID)
			self::$INTERNAL_MAILING_LIST_ID = new Inx_Api_TriggerMailing_TriggerMailingAttribute( 0, false );
		
		return self::$INTERNAL_MAILING_LIST_ID;
	}

	/**
	 * Constant for the mailing content (MIME) type attribute. This constant is used internally only.
         * 
         * @return Inx_Api_TriggerMailing_TriggerMailingAttribute the mailing content type attribute.
	 */
	public static final function INTERNAL_MAILING_CONTENT_MAIL_TYPE()
	{
		if(null === self::$INTERNAL_MAILING_CONTENT_MAIL_TYPE)
			self::$INTERNAL_MAILING_CONTENT_MAIL_TYPE = new Inx_Api_TriggerMailing_TriggerMailingAttribute( 1, false );
		
		return self::$INTERNAL_MAILING_CONTENT_MAIL_TYPE;
	}

	/**
	 * Constant for the mailing feature id. This constant is used internally only.
         * 
         * @return Inx_Api_TriggerMailing_TriggerMailingAttribute the mailing feature id attribute.
	 */
	public static final function INTERNAL_MAILING_FEATURE_ID()
	{
		if(null === self::$INTERNAL_MAILING_FEATURE_ID)
			self::$INTERNAL_MAILING_FEATURE_ID = new Inx_Api_TriggerMailing_TriggerMailingAttribute( 2, false );
		
		return self::$INTERNAL_MAILING_FEATURE_ID;
	}

	/**
	 * Constant for the subject attribute. Used for ordering by the <i>TriggerMailingManager</i>.
	 *
         * @return Inx_Api_TriggerMailing_TriggerMailingAttribute the subject attribute.
	 * @see Inx_Api_TriggerMailing_TriggerMailingManager::selectByState( Inx_Api_List_ListContext $listContext, 
         *      Inx_Api_TriggerMailing_StateFilter $stateFilter, Inx_Api_TriggerMailing_TriggerMailingAttribute $orderAttribute = null, 
         *      $iOrderType = null, $sFilter = null )
   	 */
	public static final function SUBJECT()
	{
		if(null === self::$SUBJECT)
			self::$SUBJECT = new Inx_Api_TriggerMailing_TriggerMailingAttribute( 3, true );
		
		return self::$SUBJECT;
	}

	/**
	 * Constant for the plain text attribute.
         * 
         * @return Inx_Api_TriggerMailing_TriggerMailingAttribute the plain text attribute.
	 */
	public static final function PLAIN_TEXT()
	{
		if(null === self::$PLAIN_TEXT)
			self::$PLAIN_TEXT = new Inx_Api_TriggerMailing_TriggerMailingAttribute( 4, false );
		
		return self::$PLAIN_TEXT;
	}

	/**
	 * Constant for the HTML text attribute.
         * 
         * @return Inx_Api_TriggerMailing_TriggerMailingAttribute the HTML text attribute.
	 */
	public static final function HTML_TEXT()
	{
		if(null === self::$HTML_TEXT)
			self::$HTML_TEXT = new Inx_Api_TriggerMailing_TriggerMailingAttribute( 5, false );;
		
		return self::$HTML_TEXT;
	}

	/**
	 * Constant for the XML content attribute.
         * 
         * @return Inx_Api_TriggerMailing_TriggerMailingAttribute the XML content attribute.
	 */
	public static final function XML_CONTENT()
	{
		if(null === self::$XML_CONTENT)
			self::$XML_CONTENT = new Inx_Api_TriggerMailing_TriggerMailingAttribute( 6, false );
		
		return self::$XML_CONTENT;
	}

	/**
	 * Constant for the plain text style XML content attribute.
         * 
         * @return Inx_Api_TriggerMailing_TriggerMailingAttribute the plain text style XML content attribute.
	 */
	public static final function PLAIN_TEXT_XSL()
	{
		if(null === self::$PLAIN_TEXT_XSL)
			self::$PLAIN_TEXT_XSL = new Inx_Api_TriggerMailing_TriggerMailingAttribute( 7, false );
		
		return self::$PLAIN_TEXT_XSL;
	}

	/**
	 * Constant for the HTML text style XML content attribute.
         * 
         * @return Inx_Api_TriggerMailing_TriggerMailingAttribute the HTML text style XML content attribute.
	 */
	public static final function HTML_TEXT_XSL()
	{
		if(null === self::$HTML_TEXT_XSL)
			self::$HTML_TEXT_XSL = new Inx_Api_TriggerMailing_TriggerMailingAttribute( 8, false );
		
		return self::$HTML_TEXT_XSL;
	}

	/**
	 * Constant for the filter id attribute.
         * 
         * @return Inx_Api_TriggerMailing_TriggerMailingAttribute the filter id attribute.
	 */
	public static final function FILTER_ID()
	{
		if(null === self::$FILTER_ID)
			self::$FILTER_ID = new Inx_Api_TriggerMailing_TriggerMailingAttribute( 9, false );
		
		return self::$FILTER_ID;
	}

	/**
	 * Constant for the sender address attribute.
         * 
         * @return Inx_Api_TriggerMailing_TriggerMailingAttribute the sender address attribute.
	 */
	public static final function SENDER_ADDRESS()
	{
		if(null === self::$SENDER_ADDRESS)
			self::$SENDER_ADDRESS = new Inx_Api_TriggerMailing_TriggerMailingAttribute( 10, false );
		
		return self::$SENDER_ADDRESS;
	}

	/**
	 * Constant for the recipient address attribute.
         * 
         * @return Inx_Api_TriggerMailing_TriggerMailingAttribute the recipient address attribute.
	 */
	public static final function RECIPIENT_ADDRESS()
	{
		if(null === self::$RECIPIENT_ADDRESS)
			self::$RECIPIENT_ADDRESS = new Inx_Api_TriggerMailing_TriggerMailingAttribute( 11, false );
		
		return self::$RECIPIENT_ADDRESS;
	}

	/**
	 * Constant for the reply address attribute.
         * 
         * @return Inx_Api_TriggerMailing_TriggerMailingAttribute the reply address attribute.
	 */
	public static final function REPLY_TO_ADDRESS()
	{
		if(null === self::$REPLY_TO_ADDRESS)
			self::$REPLY_TO_ADDRESS = new Inx_Api_TriggerMailing_TriggerMailingAttribute( 12, false );
		
		return self::$REPLY_TO_ADDRESS;
	}

	/**
	 * Constant for the priority attribute.
         * 
         * @return Inx_Api_TriggerMailing_TriggerMailingAttribute the priority attribute.
	 */
	public static final function PRIORITY()
	{
		if(null === self::$PRIORITY)
			self::$PRIORITY = new Inx_Api_TriggerMailing_TriggerMailingAttribute( 13, false );
		
		return self::$PRIORITY;
	}

	/**
	 * Constant for the modification datetime attribute. Used for ordering by the <i>TriggerMailingManager</i>.
	 *
         * @return Inx_Api_TriggerMailing_TriggerMailingAttribute the modification datetime attribute.
	 * @see Inx_Api_TriggerMailing_TriggerMailingManager::selectByState( Inx_Api_List_ListContext $listContext, 
         *      Inx_Api_TriggerMailing_StateFilter $stateFilter, Inx_Api_TriggerMailing_TriggerMailingAttribute $orderAttribute = null, 
         *      $iOrderType = null, $sFilter = null )
	 */
	public static final function MODIFICATION_DATETIME()
	{
		if(null === self::$MODIFICATION_DATETIME)
			self::$MODIFICATION_DATETIME = new Inx_Api_TriggerMailing_TriggerMailingAttribute( 14, true );
		
		return self::$MODIFICATION_DATETIME;
	}

	/**
	 * Constant for the style attribute. Used by the <i>UpdateException</i> to identify the error source.
	 *
         * @return Inx_Api_TriggerMailing_TriggerMailingAttribute the style attribute.
	 * @see Inx_Api_UpdateException::getErrorSource()
	 */
	public static final function STYLE()
	{
		if(null === self::$STYLE)
			self::$STYLE = new Inx_Api_TriggerMailing_TriggerMailingAttribute( 15, false );
		
		return self::$STYLE;
	}

	/**
	 * Constant for the activation datetime attribute. Used for ordering by the <i>TriggerMailingManager</i>
	 *
         * @return Inx_Api_TriggerMailing_TriggerMailingAttribute the activation datetime attribute.
	 * @see Inx_Api_TriggerMailing_TriggerMailingManager::selectByState( Inx_Api_List_ListContext $listContext, 
         *      Inx_Api_TriggerMailing_StateFilter $stateFilter, Inx_Api_TriggerMailing_TriggerMailingAttribute $orderAttribute = null, 
         *      $iOrderType = null, $sFilter = null )
	 */
	public static final function ACTIVATION_DATETIME()
	{
		if(null === self::$ACTIVATION_DATETIME)
			self::$ACTIVATION_DATETIME = new Inx_Api_TriggerMailing_TriggerMailingAttribute( 16, true );
		
		return self::$ACTIVATION_DATETIME;
	}

	/**
	 * Constant for the single send count attribute. Used for ordering by the <i>TriggerMailingManager</i>
	 *
         * @return Inx_Api_TriggerMailing_TriggerMailingAttribute the single send count attribute.
	 * @see Inx_Api_TriggerMailing_TriggerMailingManager::selectByState( Inx_Api_List_ListContext $listContext, 
         *      Inx_Api_TriggerMailing_StateFilter $stateFilter, Inx_Api_TriggerMailing_TriggerMailingAttribute $orderAttribute = null, 
         *      $iOrderType = null, $sFilter = null )
	 */
	public static final function SINGLE_SEND_COUNT()
	{
		if(null === self::$SINGLE_SEND_COUNT)
			self::$SINGLE_SEND_COUNT = new Inx_Api_TriggerMailing_TriggerMailingAttribute( 17, true );
		
		return self::$SINGLE_SEND_COUNT;
	}

	/**
	 * Constant for the name attribute. Used for ordering by the <i>TriggerMailingManager</i>
	 *
         * @return Inx_Api_TriggerMailing_TriggerMailingAttribute the name attribute.
	 * @see Inx_Api_TriggerMailing_TriggerMailingManager::selectByState( Inx_Api_List_ListContext $listContext, 
         *      Inx_Api_TriggerMailing_StateFilter $stateFilter, Inx_Api_TriggerMailing_TriggerMailingAttribute $orderAttribute = null, 
         *      $iOrderType = null, $sFilter = null )
	 */
	public static final function NAME()
	{
		if(null === self::$NAME)
			self::$NAME = new Inx_Api_TriggerMailing_TriggerMailingAttribute( 18, true );
		
		return self::$NAME;
	}

	/**
	 * Constant for the trigger descriptor attribute. Used by the <i>UpdateException</i> to identify the error
	 * source.
	 *
         * @return Inx_Api_TriggerMailing_TriggerMailingAttribute the descriptor attribute.
	 * @see Inx_Api_UpdateException::getErrorSource()
	 */
	public static final function DESCRIPTOR()
	{
		if(null === self::$DESCRIPTOR)
			self::$DESCRIPTOR = new Inx_Api_TriggerMailing_TriggerMailingAttribute( 19, false );
		
		return self::$DESCRIPTOR;
	}

	/**
	 * The default attribute used for ordering and as error source if no specific attribute is known or given.
         * 
         * @return Inx_Api_TriggerMailing_TriggerMailingAttribute the default attribute.
	 */
	public static final function DEFAULT_ATTRIBUTE()
	{
		if(null === self::$DEFAULT_ATTRIBUTE)
			self::$DEFAULT_ATTRIBUTE = new Inx_Api_TriggerMailing_TriggerMailingAttribute( -1, true );
		
		return self::$DEFAULT_ATTRIBUTE;
	}
        
        /**
	 * Constant for an unknown attribute. This attribute indicates a version mismatch between API and server. It might
	 * be used by the <i>UpdateException</i> to identify the error source.
         * 
         * @return Inx_Api_TriggerMailing_TriggerMailingAttribute the unknown attribute.
         * @see Inx_Api_UpdateException::getErrorSource()
	 */
        public static final function UNKNOWN()
        {
                if(null === self::$UNKNOWN)
                        self::$UNKNOWN = new Inx_Api_TriggerMailing_TriggerMailingAttribute( -2, false );

                return self::$UNKNOWN;
        }

	private $id;

	private $isOrderAttribute;


	private function __construct( $iId, $blIsOrderAttribute )
	{
		$this->id = $iId;
		$this->isOrderAttribute = $blIsOrderAttribute;
	}


	/**
	 * Returns the ID of the <i>TriggerMailingAttribute</i>. The ID is used for transmission purposes and should
	 * not be used inside client code.
	 *
	 * @return int the ID of the <i>TriggerMailingAttribute</i>.
	 */
	public function getId()
	{
		return $this->id;
	}


	/**
	 * Returns a <i>bool</i> indicating if this <i>TriggerMailingAttribute</i> can be used for ordering
	 * of result sets.
	 *
	 * @return bool <i>true</i> if this attribute can be used for ordering, <i>false</i> otherwise.
	 */
	public function isOrderAttribute()
	{
		return $this->isOrderAttribute;
	}


	/**
	 * Returns the <i>TriggerMailingAttribute</i> corresponding to the given id. If the id is unknown, the
	 * <i>UNKNOWN</i> attribute will be returned. The ID is used for transmission purposes and should not be used
	 * inside client code.
	 * 
	 * @param int $iId the ID of the <i>TriggerMailingAttribute</i> to retrieve.
	 * @return Inx_Api_TriggerMailing_TriggerMailingAttribute the <i>TriggerMailingAttribute</i> corresponding to 
         *      the given ID.
	 */
	public static function byId( $iId )
	{
		foreach( self::values() as $attribute )
		{
			if( $attribute->getId() == $iId )
			{
				return $attribute;
			}
		}

		return self::UNKNOWN();
	}


	/**
	 * Returns an array of the <i>TriggerMailingAttribute</i>s which can be used for ordering.
	 *
	 * @return array an array of the <i>TriggerMailingAttribute</i>s which can be used for ordering.
	 */
	public static function getOrderAttributes()
	{
		$result = array();

		foreach( self::values() as $attribute )
		{
			if( $attribute->isOrderAttribute() )
			{
				$result[] = $attribute;
			}
		}

		return $result;
	}
	
        /**
         * Returns an array containing all available <i>TriggerMailingAttribute</i>s including UNKNOWN.
         * 
         * @return array an array containing all available <i>TriggerMailingAttribute</i>s including UNKNOWN.
         */
	public static function values()
	{
		return array(self::INTERNAL_MAILING_LIST_ID(), self::INTERNAL_MAILING_CONTENT_MAIL_TYPE(), 
				self::INTERNAL_MAILING_FEATURE_ID(), self:: SUBJECT(), self::PLAIN_TEXT(), self::HTML_TEXT(),
				self::XML_CONTENT(), self::PLAIN_TEXT_XSL(), self::HTML_TEXT_XSL(), self::FILTER_ID(),
				self::SENDER_ADDRESS(), self::RECIPIENT_ADDRESS(), self::REPLY_TO_ADDRESS(), self::PRIORITY(),
				self::MODIFICATION_DATETIME(), self::STYLE(), self::ACTIVATION_DATETIME(), self::SINGLE_SEND_COUNT(),
				self::NAME(), self::DESCRIPTOR(), self::DEFAULT_ATTRIBUTE(), self::UNKNOWN());
	}
}
