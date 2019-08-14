<?php
/**
 * @package Inxmail
 * @subpackage TriggerMail
 */

/**
 * The <code>TriggerMailingExceptionType</code> defines the type or category of an exception that occurred while
 * processing a request.
 * 
 * @author chge, 02.08.2012
 */
final class Inx_Api_TriggerMail_TriggerMailingExceptionType
{
        private static $STATE = null;
        
        private static $RECIPIENT_NOT_FOUND = null;
        
        private static $MAILBUILD = null;
        
        private static $MAILING_FEATURE_DISABLED = null;
        
        private static $APPROVAL = null;
        
        private static $UNKNOWN = null;


        /**
	 * Type for {@link MailingStateException}.
	 */
	public static final function STATE()
        {
            if(null === self::$STATE)
                self::$STATE = new Inx_Api_TriggerMail_TriggerMailingExceptionType( 1000 );
            
            return self::$STATE;
        }

	/**
	 * Type for {@link UnknownRecipientException} or an otherwise unknown recipient.
	 */
	public static final function RECIPIENT_NOT_FOUND()
        {
            if(null === self::$RECIPIENT_NOT_FOUND)
                self::$RECIPIENT_NOT_FOUND = new Inx_Api_TriggerMail_TriggerMailingExceptionType( 1001 );
            
            return self::$RECIPIENT_NOT_FOUND;
        }

	/**
	 * Type for an error which occurred during the building process of a mailing.
	 */
	public static final function MAILBUILD()
        {
            if(null === self::$MAILBUILD)
                self::$MAILBUILD = new Inx_Api_TriggerMail_TriggerMailingExceptionType( 1002 );
            
            return self::$MAILBUILD;
        }

	/**
	 * Type for missing mailing feature error.
	 */
	public static final function MAILING_FEATURE_DISABLED()
        {
            if(null === self::$MAILING_FEATURE_DISABLED)
                self::$MAILING_FEATURE_DISABLED = new Inx_Api_TriggerMail_TriggerMailingExceptionType( 1003 );
            
            return self::$MAILING_FEATURE_DISABLED;
        }

	/**
	 * Type for an error which occurred during the approval process of a mailing.
	 */
	public static final function APPROVAL()
        {
            if(null === self::$APPROVAL)
                self::$APPROVAL = new Inx_Api_TriggerMail_TriggerMailingExceptionType( 1004 );
            
            return self::$APPROVAL;
        }

	/**
	 * Type for an unknown error.
	 */
	public static final function UNKNOWN()
        {
            if(null === self::$UNKNOWN)
                self::$UNKNOWN = new Inx_Api_TriggerMail_TriggerMailingExceptionType( -1 );
            
            return self::$UNKNOWN;
        }

	private $id;


	private function __construct( $iId )
	{
		$this->id = $iId;
	}


	/**
	 * Returns the ID of the <code>TriggerMailingExceptionType</code>. The ID is used for transmission purposes and
	 * should not be used inside client code.
	 * 
	 * @return the ID of the <code>TriggerMailingExceptionType</code>.
	 */
	public function getId()
	{
		return $this->id;
	}


	/**
	 * Returns the <code>TriggerMailingExceptionType</code> corresponding to the given ID. If the ID is unknown, the
	 * UNKNOWN type will be used. The ID is used for transmission purposes and should not be used inside client code.
	 * 
	 * @param id the ID of the <code>TriggerMailingExceptionType</code> to retrieve.
	 * @return the <code>TriggerState</code> TriggerMailingExceptionType to the given ID.
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
        
        public static function values()
        {
            return array(self::STATE(), self::RECIPIENT_NOT_FOUND(), self::MAILBUILD(), self::MAILING_FEATURE_DISABLED(), 
                self::APPROVAL(), self::UNKNOWN());
        }
}