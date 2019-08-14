<?php
/**
 * @package Inxmail
 * @subpackage TriggerMailing
 */

/**
 * The <i>Inx_Api_TriggerMailing_FilterConcatenationType</i> enumeration defines the different ways in 
 * which filters (target groups) can be combined.
 * <p>
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
 * @see Inx_Api_TriggerMailing_TriggerMailing::getFilterConcatinationType()
 * @since API 1.10.0
 * @author chge, 16.07.2012
 */
final class Inx_Api_TriggerMailing_FilterConcatenationType
{
	private static $FILTER_AND = null;
	
	private static $FILTER_OR = null;
	
	private static $FILTER_NOT_IN = null;
        
        private static $UNKNOWN = null;
	
	/**
	 * Filter constant for the AND operator. The AND operator requires a recipient to be a member of all filters (target
	 * groups) defined by <i>TriggerMailing::getFilderIds()</i>.
	 *
	 * @see Inx_Api_TriggerMailing_TriggerMailing::getFilderIds()
	 * @see Inx_Api_TriggerMailing_TriggerMailing::getFilterConcatinationType()
	 */
	public static final function FILTER_AND()
	{
		if(null === self::$FILTER_AND)
			self::$FILTER_AND = new Inx_Api_TriggerMailing_FilterConcatenationType( 1 );
		
		return self::$FILTER_AND;
	}

	/**
	 * Filter constant for the OR operator. The OR operator requires a recipient to be a member of a least one filter
	 * (target group) defined by <i>TriggerMailing::getFilderIds()</i>.
	 *
	 * @see Inx_Api_TriggerMailing_TriggerMailing::getFilderIds()
	 * @see Inx_Api_TriggerMailing_TriggerMailing::getFilterConcatinationType()
	 */
	public static final function FILTER_OR()
	{
		if(null === self::$FILTER_OR)
			self::$FILTER_OR = new Inx_Api_TriggerMailing_FilterConcatenationType( 2 );
		
		return self::$FILTER_OR;
	}

	/**
	 * Filter constant for the NOT IN operator. The NOT IN operator requires a recipient to not be a member of all
	 * filters (target groups) defined by <i>TriggerMailing::getFilderIds()</i>.
	 *
	 * @see Inx_Api_TriggerMailing_TriggerMailing::getFilderIds()
	 * @see Inx_Api_TriggerMailing_TriggerMailing::getFilterConcatinationType()
         */
	public static final function FILTER_NOT_IN()
	{
		if(null === self::$FILTER_NOT_IN)
			self::$FILTER_NOT_IN = new Inx_Api_TriggerMailing_FilterConcatenationType( 3 );
		
		return self::$FILTER_NOT_IN;
	}
        
        /**
	 * Filter constant for an unknown filter concatenation type. This type indicates a version mismatch between API and
	 * server.
	 * 
	 * @see Inx_Api_TriggerMailing_TriggerMailing::getFilderIds()
	 * @see Inx_Api_TriggerMailing_TriggerMailing::getFilterConcatinationType()
	 */
        public static final function UNKNOWN()
        {
                if(null === self::$UNKNOWN)
                        self::$UNKNOWN = new Inx_Api_TriggerMailing_FilterConcatenationType( -1 );
                
                return self::$UNKNOWN;
        }

	private $id;


	private function __construct( $iId )
	{
		$this->id = $iId;
	}


	/**
	 * Returns the ID of the <i>FilterConcatenationTypeicode>. The ID is used for transmission purposes and should
	 * not be used inside client code.
	 *
	 * @return int the ID of the <i>FilterConcatenationType</i>.
	 */
	public function getId()
	{
		return $this->id;
	}


	/**
	 * Returns the <i>FilterConcatenationType</i> corresponding to the given id. If the id is unknown, the
	 * <i>UNKNOWN</i> type will be returned. The ID is used for transmission purposes and should not be used
	 * inside client code.
	 * 
	 * @param int $iId the ID of the <i>FilterConcatenationType</i> to retrieve.
	 * @return Inx_Api_TriggerMailing_FilterConcatenationType the <i>FilterConcatenationType</i> corresponding 
         *      to the given ID.
	 */
	public static function byId( $iId )
	{
		foreach( self::values() as $type )
		{
			if( $type->getId() == $iId )
			{
				return $type;
			}
		}

		return self::UNKNOWN();
	}
	
        /**
         * Returns an array containing all available <i>FilterConcatenationType</i>s including UNKNOWN.
         * 
         * @return array an array containing all available <i>FilterConcatenationType</i>s including UNKNOWN.
         */
	public static function values()
	{
		return array(self::FILTER_AND(), self::FILTER_OR(), self::FILTER_NOT_IN(), self::UNKNOWN());
	}
}
