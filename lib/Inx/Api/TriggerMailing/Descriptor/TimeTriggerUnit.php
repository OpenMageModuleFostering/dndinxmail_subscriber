<?php
/**
 * @package Inxmail
 * @subpackage TriggerMailing_Descriptor
 */

/**
 * The <i>Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit</i> enumeration defines the time units which can be used 
 * with time triggers, including the minimum and maximum values. The <i>TimeTriggerUnit</i> is used in various aspects 
 * of time triggers, for example in offsets and intervals.
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
 * @since API 1.10.0
 * @author chge, 16.07.2012
 */
final class Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit
{
        private static $DAY = null;
        
        private static $MONTH = null;
        
        private static $YEAR = null;
        
        private static $WEEK = null;
        
        private static $HOUR = null;
        
        private static $UNKNOWN = null;
    
	/**
	 * Time unit for daily fired time triggers and offsets. The values may range from 1 to 364 inclusively.
         * 
         * @return Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit the day <i>TimeTriggerUnit</i>.
	 */
	public static final function DAY()
        {
            if(null === self::$DAY)
                self::$DAY = new Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit( 1, 1, 364 );
            
            return self::$DAY;
        }

	/**
	 * Time unit for monthly fired time triggers and offsets. The values may range from 1 to 12 inclusively.
         * 
         * @return Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit the month <i>TimeTriggerUnit</i>.
	 */
	public static final function MONTH()
        {
            if(null === self::$MONTH)
                self::$MONTH = new Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit( 2, 1, 12 );
            
            return self::$MONTH;
        }

	/**
	 * Time unit for yearly fired time triggers and offsets. The values may range from 1 to 100 inclusively.
         * 
         * @return Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit the year <i>TimeTriggerUnit</i>.
	 */
	public static final function YEAR()
        {
            if(null === self::$YEAR)
                self::$YEAR = new Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit( 3, 1, 100 );
            
            return self::$YEAR;
        }

	/**
	 * Time unit for weekly fired time triggers and offsets. The values may range from 1 to 51 inclusively.
         * 
         * @return Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit the week <i>TimeTriggerUnit</i>.
	 */
	public static final function WEEK()
        {
            if(null === self::$WEEK)
                self::$WEEK = new Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit( 4, 1, 51 );
            
            return self::$WEEK;
        }

	/**
	 * Time unit for hourly fired time triggers and offsets. The values may range from 1 to 23 inclusively.
         * 
         * @return Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit the hour <i>TimeTriggerUnit</i>.
	 */
	public static final function HOUR()
        {
            if(null === self::$HOUR)
                self::$HOUR = new Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit( 5, 1, 23 );
            
            return self::$HOUR;
        }
                

	/**
	 * Unknown time unit. Indicates a version mismatch between API and server.
         * 
         * @return Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit the unknown <i>TimeTriggerUnit</i>.
	 */
	public static final function UNKNOWN()
        {
            if(null === self::$UNKNOWN)
                self::$UNKNOWN = new Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit( -1, 0, 10000 );
            
            return self::$UNKNOWN;
        }

	private $id;

	private $minValue;

	private $maxValue;


	private function __construct( $iId, $iMinValue, $iMaxValue )
	{
		$this->id = $iId;
		$this->minValue = $iMinValue;
		$this->maxValue = $iMaxValue;
	}


	/**
	 * Returns the ID of the <i>TimeTriggerUnit</i>. The ID is used for transmission purposes and should not be
	 * used inside client code.
	 * 
	 * @return int the ID of the <i>TimeTriggerUnit</i>.
	 */
	public function getId()
	{
		return $this->id;
	}


	/**
	 * Returns the minimum value for this <i>TimeTriggerUnit</i> inclusively.
	 * 
	 * @return int the minimum value.
	 */
	public function getMinValue()
	{
		return $this->minValue;
	}


	/**
	 * Returns the maximum value for this <i>TimeTriggerUnit</i> inclusively.
	 * 
	 * @return int the maximum value.
	 */
	public function getMaxValue()
	{
		return $this->maxValue;
	}


	/**
	 * Returns the <i>TimeTriggerUnit</i> corresponding to the given ID. If the ID is unknown, the UNKNOWN unit
	 * will be used. The ID is used for transmission purposes and should not be used inside client code.
	 * 
	 * @param int $iId the ID of the <i>TimeTriggerUniticode> to retrieve.
	 * @return Inx_Api_TriggerMailing_Descriptor_TimeTriggerUnit the <i>TimeTriggerUnit</i> corresponding to the 
         *      given ID.
	 */
	public static function byId( $iId )
	{
		foreach( self::values() as $unit )
		{
			if( $unit->getId() == $iId )
			{
				return $unit;
			}
		}

		return self::UNKNOWN();
	}
        
        /**
         * Returns an array containing all available <i>TimeTriggerUnit</i>s including UNKNOWN.
         * 
         * @return array an array containing all available <i>TimeTriggerUnit</i>s including UNKNOWN.
         */
        public static function values()
        {
            return array(self::DAY(), self::MONTH(), self::YEAR(), self::WEEK(), self::HOUR(), self::UNKNOWN());
        }
}

