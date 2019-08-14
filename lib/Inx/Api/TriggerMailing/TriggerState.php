<?php
/**
 * @package Inxmail
 * @subpackage TriggerMailing
 */

/**
 * The <i>Inx_Api_TriggerMailing_TriggerState</i> enumeration defines the states in which a trigger may transit. For 
 * time trigger mailings, the trigger state is either <i>ACTIVE</i> or <i>INACTIVE</i>, which is the initial state. 
 * For action mailings it is <i>UNSPECIFIED</i>.
 *
 * @see Inx_Api_TriggerMailing_TriggerMailing
 * @since API 1.10.0
 * @author chge, 13.07.2012
 */
final class Inx_Api_TriggerMailing_TriggerState
{
	private static $ACTIVE = null;
	
	private static $INACTIVE = null;
	
	private static $UNKNOWN = null;
	
	private static $UNSPECIFIED = null;
	
	/**
	 * State constant for the active state. This state indicates that the trigger has been activated and the trigger
	 * mailing may be sent during the next dispatch interval.
         * 
         * @return Inx_Api_TriggerMailing_TriggerState the active state.
	 */
	public static final function ACTIVE()
	{
		if(null === self::$ACTIVE)
			self::$ACTIVE = new Inx_Api_TriggerMailing_TriggerState( 1 );
		
		return self::$ACTIVE;
	}

	/**
	 * State constant for the inactive state. This is the initial state of time trigger mailings and indicates that the
	 * trigger has not yet been activated or was deactivated. The trigger mailing will not be sent during the next
	 * dispatch interval.
         * 
         * @return Inx_Api_TriggerMailing_TriggerState the inactive state.
	 */
	public static final function INACTIVE()
	{
		if(null === self::$INACTIVE)
			self::$INACTIVE = new Inx_Api_TriggerMailing_TriggerState( 2 );
		
		return self::$INACTIVE;
	}

	/**
	 * State constant for an unknown state. This state indicates a version mismatch between API and server.
         * 
         * @return Inx_Api_TriggerMailing_TriggerState the unknown state.
	 */
	public static final function UNKNOWN()
	{
		if(null === self::$UNKNOWN)
			self::$UNKNOWN = new Inx_Api_TriggerMailing_TriggerState( 3 );
		
		return self::$UNKNOWN;
	}

	/**
	 * State constant for the unspecified state. This is the initial (and only) state of action mailings and indicates
	 * that the trigger (in this case an action) cannot be activated or deactivated. using the
	 * <i>Inx_Api_TriggerMailing_TriggerMailing::activateSending()</i> and 
         * <i>Inx_Api_TriggerMailing_TriggerMailing::deactivateSending(bool)</i> methods. This state can be used to retrieve 
         * all action mailings when used inside a <i>Inx_Api_TriggerMailing_StateFilter</i>.
         * 
         * @return Inx_Api_TriggerMailing_TriggerState the unspecified state.
	 */
	public static final function UNSPECIFIED()
	{
		if(null === self::$UNSPECIFIED)
			self::$UNSPECIFIED = new Inx_Api_TriggerMailing_TriggerState( 4 );
		
		return self::$UNSPECIFIED;
	}

	private $id;


	private function __construct( $iId )
	{
		$this->id = $iId;
	}


	/**
	 * Returns the ID of the <i>TriggerState</i>. The ID is used for transmission purposes and should not be used
	 * inside client code.
	 *
	 * @return int the ID of the <i>TriggerState</i>.
	 */
	public function getId()
	{
		return $this->id;
	}


	/**
	 * Returns the <i>TriggerState</i> corresponding to the given ID. If the ID is unknown, the UNKNOWN state will
	 * be used. The ID is used for transmission purposes and should not be used inside client code.
	 *
	 * @param int $iState the ID of the <i>TriggerState</i> to retrieve.
	 * @return Inx_Api_TriggerMailing_TriggerState the <i>TriggerState</i> corresponding to the given ID.
	 */
	public static function byId( $iState )
	{
		foreach( self::values() as $s )
		{
			if( $s->getId() == $iState )
			{
				return $s;
			}
		}

		return self::UNKNOWN();
	}
	
        /**
         * Returns an array containing all available <i>TriggerState</i>s including UNKNOWN.
         * 
         * @return array an array containing all available <i>TriggerState</i>s including UNKNOWN.
         */
	public static function values()
	{
		return array(self::ACTIVE(), self::INACTIVE(), self::UNKNOWN(), self::UNSPECIFIED());
	}
}
