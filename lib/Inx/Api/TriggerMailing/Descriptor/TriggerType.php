<?php
/**
 * @package Inxmail
 * @subpackage TriggerMailing_Descriptor
 */

/**
 * The <i>Inx_Api_TriggerMailing_Descriptor_TriggerType</i> enumeration defines the different types of triggers. The 
 * trigger types can be divided into two categories:
 * <p>
 * <ol>
 * <li><b>Time triggers</b>: Used for time controlled dispatch of trigger mailings.
 * <li><b>Action triggers</b>: Used for action controlled dispatch of trigger mailings.
 * </ol>
 * Time trigger mailings are sent out on a regular basis. The following time triggers are available:
 * <p>
 * <ul>
 * <li><b>Birthday</b>: A mailing of this type is sent to recipients on the annual recurrence of a specific date. A
 * datetime attribute of the recipient acts as a baseline and the mailing is sent every year after this baseline. An
 * offset can be specified to send the mailing some time before or after the annual recurrence. The condition is checked
 * once a day. The birthday trigger is an attribute driven time trigger.
 * <li><b>Anniversary</b>: A mailing of this type is sent to recipients on the recurrence of a specific date. A datetime
 * attribute of the recipient acts as baseline and the mailing is sent after a user defined period of time (years,
 * months or days) after this baseline. An offset can be specified to send the mailing some time before or after the
 * recurrence. The condition is checked once a day. The anniversary trigger is an attribute driven time trigger.
 * <li><b>Reminder</b>: A mailing of this type is sent to recipients on a specific date. A datetime attribute of the
 * recipient defines that date. An offset can be specified to send the mailing some time before the date. The condition
 * is checked once a day. The reminder trigger is an attribute driven time trigger.
 * <li><b>Follow up</b>: A mailing of this type is sent to recipients on a specific date. A datetime attribute of the
 * recipient defines that date. An offset can be specified to send the mailing some time after the date. The condition
 * is checked once a day. The follow up trigger is an attribute driven time trigger.
 * <li><b>Interval</b>: A mailing of this type is sent to all recipients of the associated list at a freely definable
 * interval (i.e. hourly, daily, weekly,...). The interval is described by an 
 * <i>Inx_Api_TriggerMailing_Descriptor_TriggerInterval</i> object. The interval trigger is a time trigger which is not 
 * related to a specific attribute.
 * </ul>
 * <p>
 * Action trigger mailings, on the other hand, are only sent if the associated action is executed. Be aware that the
 * action cannot be defined by the trigger descriptor. Instead, the action contains a command (an 
 * <i>Inx_Api_Action_SendMailCommand</i>) which will send the mailing.
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
final class Inx_Api_TriggerMailing_Descriptor_TriggerType
{
	private static $ACTION_MAILING = null;
	
	private static $TIME_TRIGGER_INTERVAL_MAILING = null;
	
	private static $TIME_TRIGGER_BIRTHDAY_MAILING = null;
	
	private static $TIME_TRIGGER_ANNIVERSARY_MAILING = null;
	
	private static $TIME_TRIGGER_REMINDER_MAILING = null;
	
	private static $TIME_TRIGGER_FOLLOW_UP_MAILING = null;
	
	private static $UNKNOWN = null;
	
	/**
	 * Type constant for action mailings. An action mailing is sent by the associated action using an
	 * <i>Inx_Api_Action_SendMailCommand</i>.
	 *
         * @return Inx_Api_TriggerMailing_Descriptor_TriggerType the action <i>TriggerType</i>.
	 * @see Inx_Api_Action_SendMailCommand
	 */
	public static final function ACTION_MAILING()
	{
		if(null === self::$ACTION_MAILING)
			self::$ACTION_MAILING = new Inx_Api_TriggerMailing_Descriptor_TriggerType( 1 );
		 
		return self::$ACTION_MAILING;
	}

	/**
	 * Type constant for interval trigger mailings. An interval trigger mailing is sent to all recipients in the
	 * associated list at a freely definable interval (e.g. hourly, daily, weekly,...). The interval is described by a
	 * {@link TriggerInterval}. The interval trigger is a time trigger but no attribute driven trigger.
	 *
         * @return Inx_Api_TriggerMailing_Descriptor_TriggerType the interval <i>TriggerType</i>.
	 * @see com.inxmail.xpro.api.triggermailing.descriptor.TriggerInterval
	 */
	public static final function TIME_TRIGGER_INTERVAL_MAILING()
	{
		if(null === self::$TIME_TRIGGER_INTERVAL_MAILING)
			self::$TIME_TRIGGER_INTERVAL_MAILING = new Inx_Api_TriggerMailing_Descriptor_TriggerType( 2 );
		
		return self::$TIME_TRIGGER_INTERVAL_MAILING;
	}

	/**
	 * Type constant for birthday trigger mailings. A birthday trigger mailing is sent every day to recipients for which
	 * the day of the attribute matches the current day. The birthday trigger is an attribute driven time trigger.
         * 
         * @return Inx_Api_TriggerMailing_Descriptor_TriggerType the birthday <i>TriggerType</i>.
	 */
	public static final function TIME_TRIGGER_BIRTHDAY_MAILING()
	{
		if(null === self::$TIME_TRIGGER_BIRTHDAY_MAILING)
			self::$TIME_TRIGGER_BIRTHDAY_MAILING = new Inx_Api_TriggerMailing_Descriptor_TriggerType( 3 );
		
		return self::$TIME_TRIGGER_BIRTHDAY_MAILING;
	}

	/**
	 * Type constant for anniversary trigger mailings. An anniversary trigger mailing is sent every day to recipients
	 * for which the day of the attribute matches the current day and was a fixed number of years, months or days ago.
	 * The anniversary trigger is an attribute driven time trigger.
         * 
         * @return Inx_Api_TriggerMailing_Descriptor_TriggerType the anniversary <i>TriggerType</i>.
	 */
	public static final function TIME_TRIGGER_ANNIVERSARY_MAILING()
	{
		if(null === self::$TIME_TRIGGER_ANNIVERSARY_MAILING)
			self::$TIME_TRIGGER_ANNIVERSARY_MAILING = new Inx_Api_TriggerMailing_Descriptor_TriggerType( 4 );
		
		return self::$TIME_TRIGGER_ANNIVERSARY_MAILING;
	}

	/**
	 * Type constant for reminder trigger mailings. A reminder trigger mailing is sent every day to recipients for which
	 * the date in the attribute matches the current date (only positive offset). The reminder trigger is an attribute
	 * driven time trigger.
         * 
         * @return Inx_Api_TriggerMailing_Descriptor_TriggerType the reminder <i>TriggerType</i>.
	 */
	public static final function TIME_TRIGGER_REMINDER_MAILING()
	{
		if(null === self::$TIME_TRIGGER_REMINDER_MAILING)
			self::$TIME_TRIGGER_REMINDER_MAILING = new Inx_Api_TriggerMailing_Descriptor_TriggerType( 5 );
		
		return self::$TIME_TRIGGER_REMINDER_MAILING;
	}

	/**
	 * Type constant for follow up trigger mailing. A follow up trigger mailing is sent every day to recipients for
	 * which the date in the attribute matches the current date (only negative offset). the follow up trigger is an
	 * attribute driven time trigger.
         * 
         * @return Inx_Api_TriggerMailing_Descriptor_TriggerType the follow-up <i>TriggerType</i>.
	 */
	public static final function TIME_TRIGGER_FOLLOW_UP_MAILING()
	{
		if(null === self::$TIME_TRIGGER_FOLLOW_UP_MAILING)
			self::$TIME_TRIGGER_FOLLOW_UP_MAILING = new Inx_Api_TriggerMailing_Descriptor_TriggerType( 6 );;
		
		return self::$TIME_TRIGGER_FOLLOW_UP_MAILING;
	}

	/**
	 * Type constant for an unknown trigger type. Indicates a version mismatch between API and server.
         * 
         * @return Inx_Api_TriggerMailing_Descriptor_TriggerType the unknown <i>TriggerType</i>.
	 */
	public static final function UNKNOWN()
	{
		if(null === self::$UNKNOWN)
			self::$UNKNOWN = new Inx_Api_TriggerMailing_Descriptor_TriggerType( 7 );
		
		return self::$UNKNOWN;
	}

	private $id;


	private function __construct( $iId )
	{
		$this->id = $iId;
	}


	/**
	 * Returns the ID of the <i>TriggerType</i>. The ID is used for transmission purposes and should not be used
	 * inside client code.
	 *
	 * @return int the ID of the <i>TriggerType</i>.
	 */
	public function getTypeId()
	{
		return $this->id;
	}


	/**
	 * Returns a <i>bool</i> indicating whether the <i>TriggerType</i> is a time trigger type.
	 *
	 * @return <i>true</i> if the <i>TriggerType</i> is a time trigger type, <i>false</i> otherwise.
	 */
	public function isTimeTriggerType()
	{
		return $this === self::TIME_TRIGGER_ANNIVERSARY_MAILING() || $this === self::TIME_TRIGGER_BIRTHDAY_MAILING()
				|| $this === self::TIME_TRIGGER_FOLLOW_UP_MAILING() || $this === self::TIME_TRIGGER_INTERVAL_MAILING()
				|| $this === self::TIME_TRIGGER_REMINDER_MAILING();
	}


	/**
	 * Returns a <i>bool</i> indicating whether the <i>TriggerType</i> is an attribute driven trigger type.
	 *
	 * @return <i>true</i> if the <i>TriggerType</i> is an attribute driven trigger type, icode>false</i>
	 *         otherwise.
	 */
	public function isAttributeTriggerType()
	{
		return $this === self::TIME_TRIGGER_ANNIVERSARY_MAILING() || $this === self::TIME_TRIGGER_BIRTHDAY_MAILING()
				|| $this === self::TIME_TRIGGER_FOLLOW_UP_MAILING() || $this === self::TIME_TRIGGER_REMINDER_MAILING();
	}


	/**
	 * Returns the <i>TriggerType</i> corresponding to the given ID. If the ID is unknown, the UNKNOWN type will
	 * be used. The ID is used for transmission purposes and should not be used inside client code.
	 *
	 * @param int $iId the ID of the <i>TriggerType</i> to retrieve.
	 * @return Inx_Api_TriggerMailing_Descriptor_TriggerType the <i>TriggerType</i> corresponding to the given ID.
	 */
	public static function byTypeId( $iId )
	{
		foreach( self::values() as $type )
		{
			if( $type->getTypeId() == $iId )
			{
				return $type;
			}
		}

		return self::UNKNOWN();
	}
	
        /**
         * Returns an array containing all available <i>TriggerType</i>s including UNKNOWN.
         * 
         * @return array an array containing all available <i>TriggerType</i>s including UNKNOWN.
         */
	public static function values()
	{
		return array(self::ACTION_MAILING(), self::TIME_TRIGGER_INTERVAL_MAILING(), self::TIME_TRIGGER_BIRTHDAY_MAILING(), 
				self::TIME_TRIGGER_ANNIVERSARY_MAILING(), self::TIME_TRIGGER_REMINDER_MAILING(), 
				self::TIME_TRIGGER_FOLLOW_UP_MAILING(),	self::UNKNOWN());
	}
}
