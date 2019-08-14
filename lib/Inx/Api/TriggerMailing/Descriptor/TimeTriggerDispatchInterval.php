<?php
/**
 * @package Inxmail
 * @subpackage TriggerMailing_Descriptor
 */

/**
 * The <i>Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval</i> enumeration defines the possible 
 * interval types of interval trigger mailings.
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
 * @see Inx_Api_TriggerMailing_Descriptor_TriggerInterval::getDispatchIntervals()
 * @since API 1.10.0
 * @author chge, 16.07.2012
 */
final class Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval
{
        private static $LAST_DAY_OF_MONTH = null;
        
        private static $SPECIFIC_DAY_OF_MONTH = null;
        
        private static $SPECIFIC_DAY_BEFORE_END_OF_MONTH = null;
        
        private static $MONDAY = null;
        
        private static $TUESDAY = null;
        
        private static $WEDNESDAY = null;
        
        private static $THURSDAY = null;
        
        private static $FRIDAY = null;
        
        private static $SATURDAY = null;
        
        private static $SUNDAY = null;
        
        private static $DAILY = null;
        
        private static $HOURLY = null;
        
        private static $UNKNOWN = null;
    
	/**
	 * Dispatch interval for time triggers which fire on the last day of each month.
         * 
         * @return Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval the last day of month 
         *      <i>TimeTriggerDispatchInterval</i>.
	 */
	public static final function LAST_DAY_OF_MONTH()
        {
            if(null === self::$LAST_DAY_OF_MONTH)
                self::$LAST_DAY_OF_MONTH = 
                    new Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval( 1 );
            
            return self::$LAST_DAY_OF_MONTH;
        }

	/**
	 * Dispatch interval for time triggers which fire on a specific day of each month.
         * 
         * @return Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval the specific day of month 
         *      <i>TimeTriggerDispatchInterval</i>.
	 */
	public static final function SPECIFIC_DAY_OF_MONTH()
        {
            if(null === self::$SPECIFIC_DAY_OF_MONTH)
                self::$SPECIFIC_DAY_OF_MONTH= 
                    new Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval( 2 );
            
            return self::$SPECIFIC_DAY_OF_MONTH;
        }

	/**
	 * Dispatch interval for time triggers which fire on a specific day before the end of each month.
         * 
         * @return Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval the specific day before end of month 
         *      <i>TimeTriggerDispatchInterval</i>.
	 */
	public static final function SPECIFIC_DAY_BEFORE_END_OF_MONTH()
        {
            if(null === self::$SPECIFIC_DAY_BEFORE_END_OF_MONTH)
                self::$SPECIFIC_DAY_BEFORE_END_OF_MONTH = 
                    new Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval( 3 );
            
            return self::$SPECIFIC_DAY_BEFORE_END_OF_MONTH;
        }

	/**
	 * Dispatch interval for time triggers which fire on every Monday.
         * 
         * @return Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval the monday <i>TimeTriggerDispatchInterval</i>.
	 */
	public static final function MONDAY()
        {
            if(null === self::$MONDAY)
                self::$MONDAY = new Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval( 4 );
            
            return self::$MONDAY;
        }

	/**
	 * Dispatch interval for time triggers which fire on every Tuesday.
         * 
         * @return Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval the tuesday <i>TimeTriggerDispatchInterval</i>.
	 */
	public static final function TUESDAY()
        {
            if(null === self::$TUESDAY)
                self::$TUESDAY = new Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval( 5 );
            
            return self::$TUESDAY;
        }

	/**
	 * Dispatch interval for time triggers which fire on every Wednesday.
         * 
         * @return Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval the wednesday <i>TimeTriggerDispatchInterval</i>.
	 */
	public static final function WEDNESDAY()
        {
            if(null === self::$WEDNESDAY)
                self::$WEDNESDAY = new Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval( 6 );
            
            return self::$WEDNESDAY;
        }

	/**
	 * Dispatch interval for time triggers which fire on every Thursday.
         * 
         * @return Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval the thursday <i>TimeTriggerDispatchInterval</i>.
	 */
	public static final function THURSDAY()
        {
            if(null === self::$THURSDAY)
                self::$THURSDAY = new Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval( 7 );
            
            return self::$THURSDAY;
        }

	/**
	 * Dispatch interval for time triggers which fire on every Friday.
         * 
         * @return Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval the friday <i>TimeTriggerDispatchInterval</i>.
	 */
	public static final function FRIDAY()
        {
            if(null === self::$FRIDAY)
                self::$FRIDAY = new Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval( 8 );
            
            return self::$FRIDAY;
        }

	/**
	 * Dispatch interval for time triggers which fire on every Saturday.
         * 
         * @return Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval the saturday <i>TimeTriggerDispatchInterval</i>.
	 */
	public static final function SATURDAY()
        {
            if(null === self::$SATURDAY)
                self::$SATURDAY = new Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval( 9 );
            
            return self::$SATURDAY;
        }

	/**
	 * Dispatch interval for time triggers which fire on every Sunday.
         * 
         * @return Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval the sunday <i>TimeTriggerDispatchInterval</i>.
	 */
	public static final function SUNDAY()
        {
            if(null === self::$SUNDAY)
                self::$SUNDAY = new Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval( 10 );
            
            return self::$SUNDAY;
        }

	/**
	 * Dispatch interval for time triggers which fire on a daily basis.
         * 
         * @return Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval the daily <i>TimeTriggerDispatchInterval</i>.
	 */
	public static final function DAILY()
        {
            if(null === self::$DAILY)
                self::$DAILY = new Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval( 11 );
            
            return self::$DAILY;
        }

	/**
	 * Dispatch interval for time triggers which fire on a hourly basis.
         * 
         * @return Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval the hourly <i>TimeTriggerDispatchInterval</i>.
	 */
	public static final function HOURLY()
        {
            if(null === self::$HOURLY)
                self::$HOURLY = new Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval( 12 );
            
            return self::$HOURLY;
        }

	/**
	 * Unknown dispatch interval. Indicates a version mismatch between API and server.
         * 
         * @return Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval the unknown <i>TimeTriggerDispatchInterval</i>.
	 */
	public static final function UNKNOWN()
        {
            if(null === self::$UNKNOWN)
                self::$UNKNOWN = new Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval( -1 );
            
            return self::$UNKNOWN;
        }

	private $id;


	private function __construct( $iId )
	{
		$this->id = $iId;
	}


	/**
	 * Returns the ID of the <i>TimeTriggerDispatchInterval</i>. The ID is used for transmission purposes and
	 * should not be used inside client code.
	 * 
	 * @return int the ID of the <i>TimeTriggerDispatchInterval</i>.
	 */
	public function getId()
	{
		return $this->id;
	}


	/**
	 * Returns the <i>TimeTriggerDispatchInterval</i> corresponding to the given ID. If the ID is unknown, the
	 * UNKNOWN interval will be used. The ID is used for transmission purposes and should not be used inside client
	 * code.
	 * 
	 * @param int $iId the ID of the <i>TimeTriggerDispatchInterval</i> to retrieve.
	 * @return Inx_Api_TriggerMailing_Descriptor_TimeTriggerDispatchInterval the <i>TimeTriggerDispatchInterval</i> 
         *      corresponding to the given ID.
	 */
	public static function byId( $iId )
	{
		foreach( self::values() as $interval )
		{
			if( $interval->getId() == $iId )
			{
				return $interval;
			}
		}

		return self::UNKNOWN();
	}
        
        /**
         * Returns an array containing all available <i>TimeTriggerDispatchInterval</i>s including UNKNOWN.
         * 
         * @return array an array containing all available <i>TimeTriggerDispatchInterval</i>s including UNKNOWN.
         */
        public static function values()
        {
            return array(self::LAST_DAY_OF_MONTH(), self::SPECIFIC_DAY_OF_MONTH(), self::SPECIFIC_DAY_BEFORE_END_OF_MONTH(),
                self::MONDAY(), self::TUESDAY(), self::WEDNESDAY(), self::THURSDAY(), self::FRIDAY(), self::SATURDAY(),
                self::SUNDAY(), self::DAILY(), self::HOURLY(), self::UNKNOWN());
        }
}

