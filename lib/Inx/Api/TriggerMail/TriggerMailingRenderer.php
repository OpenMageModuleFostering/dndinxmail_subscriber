<?php
/**
 * @package Inxmail
 * @subpackage TriggerMail
 */

/**
 * The <code>TriggerMailingRenderer</code> is used to generate mail content using the API. The main use of the class
 * will be to generate personalized previews of trigger mailings. The class can also be used to generate and send single
 * trigger mails using a different mail sender. Be aware that in this case the mail sending rate would decrease
 * enormously.
 * <p>
 * To preview a trigger mailing, take a <code>TriggerMailingRenderer</code> from the
 * {@link com.inxmail.xpro.api.triggermailing.TriggerMailingManager TriggerMailingManager}. Each mailing needs to be
 * parsed before building it. The following snippet shows how to build a trigger mail for a given recipient:
 * 
 * <pre>
 * TriggerMailingRenderer renderer = session.getTriggerMailingManager().createRenderer();
 * 
 * renderer.parse( mailing.getId(), BuildMode.ALTERNATIVEVIEW_ACTIVE );
 * 
 * TriggerMailContent content = renderer.build( recipientId );
 * </pre>
 * <p>
 * <code>TriggerMailingRenderer</code> can handle the following different build modes:
 * <ol>
 * <li>{@link BuildMode#PREVIEW} - Trackable links will not trigger any events, unsubscription links will redirect but
 * not unsubscribe anybody. Embedded images are replaced with http references to image resources on the Inxmail server.
 * <li>{@link BuildMode#ALTERNATIVEVIEW_ACTIVE} - All links are fully functional. Embedded images are replaced with http
 * references to image resources on the Inxmail server.
 * <li>{@link BuildMode#ALTERNATIVEVIEW_INACTIVE} - All links are not functional. Embedded images are replaced with http
 * references to image resources on the Inxmail server.
 * <li>{@link BuildMode#NORMAL} - The mail is rendered, ready to be sent.
 * <li>{@link BuildMode#ARCHIVE} - Trackable links will not trigger any events, unsubscription links will redirect but
 * not unsubscribe anybody. Embedded images are replaced with http references to image resources on the Inxmail server.
 * <li>{@link BuildMode#ALTERNATIVEVIEW_ACTIVE_SIMPLE_LINKS} - All links are fully functional but converted to simple
 * links. Embedded images are replaced with http references to image resources on the Inxmail server.
 * <li>{@link BuildMode#NEWSLETTER_SIMPLE_LINKS} - The same as above, but the function InInboxView returns true.
 * </ol>
 * <p>
 * <strong>Note:</strong> A <code>TriggerMailingRenderer</code> object <strong>must</strong> be closed once it is not
 * needed anymore to prevent memory leaks and other potentially harmful side effects.
 * 
 * @see com.inxmail.xpro.api.triggermail.TriggerMailContent
 * @since API 1.10.0
 * @author chge, 09.07.2012
 */
interface Inx_Api_TriggerMail_TriggerMailingRenderer
{
	/**
	 * Prepares the trigger mailing for a preview. It checks the mail quality (syntax errors, references to orphaned
	 * elements, ... ).<br>
	 * Errors will be listed in the <code>ParseException</code><br>
	 * The mailingId is supposed to be valid (existing trigger mailing).<br>
	 * 
	 * @param mailingId the id of the trigger mailing to be parsed.
	 * @param sendingId the id of the sending of the trigger mailing.
	 * @param buildMode the mode of the build. The mode <code>UNKNOWN</code> is illegal.
	 * @throws ParseException if any syntax error is present in the trigger mail.
	 * @throws APIException if the trigger mailing id is no longer valid.
	 * @throws IllegalArgumentException if the build mode is <code>UNKNOWN</code>.
	 */
	public function parse($iMailingId, Inx_Api_TriggerMail_BuildMode $buildMode, $iSendingId = null);
        

	/**
	 * Generates the personalized trigger mail content (recipient address, subject, HTML and/or plain text, ...) for the
	 * specified recipient with a specified mail type restriction.
	 * 
	 * @param recipientId the id of the recipient for which the trigger mail shall be personalized.
	 * @param preferredMailType the mail type. <code>UNKNOWN</code> is not allowed.
	 * @return the personalized content of the trigger mail.
	 * @throws BuildException if the recipient could not be found, or the building failed.
	 * @throws IllegalArgumentException if the preferred mail type is <code>UNKNOWN</code>.
	 */
	public function build( $iRecipientId, Inx_Api_TriggerMail_TriggerMailingContentType $preferredMailType = null );


	/**
	 * Closes this <code>TriggerMailingRenderer</code> and releases any server resources associated with this object. A
	 * <code>TriggerMailingRenderer</code> object <strong>must</strong> be closed once it is not needed anymore to
	 * prevent memory leaks and other potentially harmful side effects.
	 */
	public function close();
}

/**
 * The <code>ParseResultCode</code> defines the result of the server side parsing process.
 * 
 * @author chge, 02.08.2012
 */
 final class Inx_Api_TriggerMail_ParseResultCode
 {
        private static $PARSE_SUCCESSFUL = null;
        
        private static $PARSE_EXCEPTION = null;
        
        private static $MAILING_NOT_FOUND = null;
        
        private static $UNKNOWN = null;
     
        /**
         * The mailing was successfully parsed.
         */
        public static final function PARSE_SUCCESSFUL()
        {
            if(null === self::$PARSE_SUCCESSFUL)
                self::$PARSE_SUCCESSFUL = new Inx_Api_TriggerMail_ParseResultCode( 1 );
            
            return self::$PARSE_SUCCESSFUL;
        }

        /**
         * An exception occurred during the parsing process.
         */
        public static final function PARSE_EXCEPTION()
        {
            if(null === self::$PARSE_EXCEPTION)
                self::$PARSE_EXCEPTION = new Inx_Api_TriggerMail_ParseResultCode( 2 );
            
            return self::$PARSE_EXCEPTION;
        }

        /**
         * The mailing could not be found (i.e. was deleted).
         */
        public static final function MAILING_NOT_FOUND()
        {
            if(null === self::$MAILING_NOT_FOUND)
                self::$MAILING_NOT_FOUND = new Inx_Api_TriggerMail_ParseResultCode( 3 );
            
            return self::$MAILING_NOT_FOUND;
        }

        /**
         * The result is unknown. This indicates an unknown error.
         */
        public static final function UNKNOWN()
        {
            if(null == self::$UNKNOWN)
                self::$UNKNOWN = new Inx_Api_TriggerMail_ParseResultCode( -1 );
            
            return self::$UNKNOWN;
        }

        private $id;


        private function __construct( $iId )
        {
                $this->id = $iId;
        }


        /**
         * Returns the ID of the <code>ParseResultCode</code>. The ID is used for transmission purposes and should not
         * be used inside client code.
         * 
         * @return the ID of the <code>ParseResultCode</code>.
         */
        public function getId()
        {
                return $this->id;
        }


        /**
         * Returns the <code>ParseResultCode</code> corresponding to the given ID. If the ID is unknown, the UNKNOWN
         * code will be used. The ID is used for transmission purposes and should not be used inside client code.
         * 
         * @param id the ID of the <code>ParseResultCode</code> to retrieve.
         * @return the <code>ParseResultCode</code> corresponding to the given ID.
         */
        public static function byId( $iId )
        {
                foreach( self::values() as $result )
                {
                        if( $result->getId() == $iId )
                        {
                                return $result;
                        }
                } 

                return self::UNKNOWN();
        }
        
        public static function values()
        {
            return array(self::PARSE_SUCCESSFUL(), self::PARSE_EXCEPTION(), self::MAILING_NOT_FOUND(), self::UNKNOWN());
        }
 }


/**
 * The <code>BuildResultCode</code> defines the result of the server side building process.
 * 
 * @author chge, 02.08.2012
 */
 final class Inx_Api_TriggerMail_BuildResultCode
 {
        private static $BUILD_SUCCESSFUL = null;
        
        private static $BUILD_EXCEPTION = null;
        
        private static $UNKNOWN = null;
     
        /**
         * The mailing was successfully built.
         */
        public static final function BUILD_SUCCESSFUL()
        {
            if(null === self::$BUILD_SUCCESSFUL)
                self::$BUILD_SUCCESSFUL = new Inx_Api_TriggerMail_BuildResultCode( 1 );
            
            return self::$BUILD_SUCCESSFUL;
        }

        /**
         * An exception occurred during the build of the mailing.
         */
        public static final function BUILD_EXCEPTION()
        {
            if(null === self::$BUILD_EXCEPTION)
                self::$BUILD_EXCEPTION = new Inx_Api_TriggerMail_BuildResultCode( 2 );
            
            return self::$BUILD_EXCEPTION;
        }

        /**
         * The result is unknown. This indicates an unknown error.
         */
        public static final function UNKNOWN()
        {
            if(null === self::$UNKNOWN)
                self::$UNKNOWN = new Inx_Api_TriggerMail_BuildResultCode( -1 );
            
            return self::$UNKNOWN;
        }

        private $id;


        private function __construct( $iId )
        {
                $this->id = $iId;
        }


       /**
        * Returns the ID of the <code>BuildResultCode</code>. The ID is used for transmission purposes and should not
        * be used inside client code.
        * 
        * @return the ID of the <code>BuildResultCode</code>.
        */
        public function getId()
        {
                return $this->id;
        }


       /**
        * Returns the <code>BuildResultCode</code> corresponding to the given ID. If the ID is unknown, the UNKNOWN
        * code will be used. The ID is used for transmission purposes and should not be used inside client code.
        * 
        * @param id the ID of the <code>BuildResultCode</code> to retrieve.
        * @return the <code>BuildResultCode</code> corresponding to the given ID.
        */
        public static function byId( $iId )
        {
                foreach( self::values() as $result )
                {
                        if( $result->getId() == $iId )
                        {
                                return $result;
                        }
                }

                return self::UNKNOWN();
        }
        
        public static function values()
        {
            return array(self::BUILD_SUCCESSFUL(), self::BUILD_EXCEPTION(), self::UNKNOWN());
        }
 }