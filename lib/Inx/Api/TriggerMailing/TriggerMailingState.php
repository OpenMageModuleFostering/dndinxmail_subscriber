<?php
/**
 * @package Inxmail
 * @subpackage TriggerMailing
 */

/**
 * The <i>Inx_Api_TriggerMailing_TriggerMailingState</i> enumeration defines the states in which a trigger mailing may 
 * transit. Most operations on trigger mailings are only allowed while the mailing is in a specific state. For example, 
 * a trigger mailing may only be edited while it is in the DRAFT state, which is the initial state.
 * <p>
 * If an operation is performed while in an illegal state, normally a <i>TriggerMailingStateException</i> will be
 * raised. The only exception is the commitUpdate method, which cannot throw a state exception as it is inherited from
 * <i>Inx_Api_BusinessObject</i>. Instead, commitUpdate will throw an <i>Inx_Api_UpdateException</i> stating that it is 
 * illegal to perform the action in the current state.
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
 * @see Inx_Api_TriggerMailing_TriggerMailing
 * @since API 1.10.0
 * @author chge, 13.07.2012
 */
final class Inx_Api_TriggerMailing_TriggerMailingState
{
	private static $DRAFT = null;
	
	private static $APPROVAL_REQUESTED = null;
	
	private static $APPROVED = null;
	
	private static $USED = null;
	
	private static $UNKNOWN = null;
	
	/**
	 * State constant for the draft state. The draft state is the initial state of a trigger mailing. The state
	 * constants are also used by the <i>TriggerMailingStateException</i>.
	 *
         * @return Inx_Api_TriggerMailing_TriggerMailingState the draft state.
	 * @see Inx_Api_TriggerMailing_TriggerMailingStateException::getCurrentMailingState()
	 */
	public static final function DRAFT()
	{
		if(null === self::$DRAFT)
			self::$DRAFT = new Inx_Api_TriggerMailing_TriggerMailingState( 1 );
		
		return self::$DRAFT;
	}

	/**
	 * State constant for the approval requested state. This state indicates that the approval of a trigger mailing was
	 * requested but not yet granted or denied. The state constants are also used by the
	 * <i>TriggerMailingStateException</i>.
	 *
	 * @return Inx_Api_TriggerMailing_TriggerMailingState the approval requested state.
	 * @see Inx_Api_TriggerMailing_TriggerMailingStateException::getCurrentMailingState()
	 */
	public static final function APPROVAL_REQUESTED()
	{
		if(null === self::$APPROVAL_REQUESTED)
			self::$APPROVAL_REQUESTED = new Inx_Api_TriggerMailing_TriggerMailingState( 2 ); 
		
		return self::$APPROVAL_REQUESTED;
	}

	/**
	 * State constant for the approved state. This state indicates that a trigger mailing was approved and is ready to
	 * be sent. The state constants are also used by the <i>TriggerMailingStateException</i>.
	 *
	 * @return Inx_Api_TriggerMailing_TriggerMailingState the approved state.
	 * @see Inx_Api_TriggerMailing_TriggerMailingStateException::getCurrentMailingState()
	 */
	public static final function APPROVED()
	{
		if(null === self::$APPROVED)
			self::$APPROVED = new Inx_Api_TriggerMailing_TriggerMailingState( 4 );
		
		return self::$APPROVED;
	}

	/**
	 * State constant for the used state. This state indicates that a trigger mailing was activated (used) at least
	 * once. The state constants are also used by the <i>TriggerMailingStateException</i>.
	 *
	 * @return Inx_Api_TriggerMailing_TriggerMailingState the used state.
	 * @see Inx_Api_TriggerMailing_TriggerMailingStateException::getCurrentMailingState()
	 */
	public static final function USED()
	{
		if(null === self::$USED)
			self::$USED = new Inx_Api_TriggerMailing_TriggerMailingState( 8 ); 
		
		return self::$USED;
	}

	/**
	 * State constant for an unknown state. This state indicates a version mismatch between API and server. The state
	 * constants are also used by the <code>TriggerMailingStateException</code>.
	 *
	 * @return Inx_Api_TriggerMailing_TriggerMailingState the unknown state.
	 * @see Inx_Api_TriggerMailing_TriggerMailingStateException::getCurrentMailingState()
	 */
	public static final function UNKNOWN()
	{
		if(null === self::$UNKNOWN)
			self::$UNKNOWN = new Inx_Api_TriggerMailing_TriggerMailingState( -1 );
		
		return self::$UNKNOWN;
	}

	private $id;


	private function __construct( $iId )
	{
		$this->id = $iId;
	}


	/**
	 * Returns the ID of the <i>TriggerMailingState</i>. The ID is used for transmission purposes and should not
	 * be used inside client code.
	 *
	 * @return int the ID of the <i>TriggerMailingState</i>.
	 */
	public function getId()
	{
		return $this->id;
	}


	/**
	 * Returns the <i>TriggerMailingState</i> corresponding to the given id. If the id is unknown, the
	 * <i>UNKNOWN</i> state will be returned. The ID is used for transmission purposes and should not be used
	 * inside client code.
	 * 
	 * @param int $iId the ID of the <i>TriggerMailingState</i> to retrieve.
	 * @return Inx_Api_TriggerMailing_TriggerMailingState the <i>TriggerMailingState</i> corresponding to the given ID.
	 */
	public static function byId( $iId )
	{
		foreach( self::values() as $state )
		{
			if( $state->getId() == $iId )
			{
				return $state;
			}
		}

		return self::UNKNOWN();
	}


	/**
	 * Returns an array of <i>TriggerMailingState</i>s corresponding to the given bit pattern. Unknown
	 * bits will be ignored. The bit pattern is used for transmission purposes and should not be used in client code.
	 *
	 * @param int $iBitPattern the bit pattern corresponding to the <i>TriggerMailingState</i>s to retrieve.
	 * @return array an array of <i>TriggerMailingState</i>s corresponding to the given bit pattern.
	 */
	public static function fromBitPattern( $iBitPattern )
	{
		$result = array();

		foreach( self::values() as $state )
		{
			if( ( $state->getId() & $iBitPattern ) == $state->getId() )
			{
				$result[] = $state;
			}
		}

		return $result;
	}


	/**
	 * Returns the bit pattern corresponding to the given array of <i>TriggerMailingState</i>s. The bit
	 * pattern is used for transmission purposes and should not be used in client code.
	 *
	 * @param array $states the states to be converted into a bit pattern.
	 * @return int the bit pattern corresponding to the given array of <i>TriggerMailingState</i>s.
	 */
	public static function toBitPattern( array $states )
	{
		if( null === $states || empty($states) )
			return PHP_INT_MAX;

		$result = 0;

		foreach( $states as $state )
		{
			$result |= $state->getId();
		}

		return $result;
	}
	
        /**
         * Returns an array containing all available <i>TriggerMailingState</i>s including UNKNOWN.
         * 
         * @return array an array containing all available <i>TriggerMailingState</i>s including UNKNOWN.
         */
	public static function values()
	{
		return array(self::DRAFT(), self::APPROVAL_REQUESTED(), self::APPROVED(), self::USED(), self::UNKNOWN());
	}
}
