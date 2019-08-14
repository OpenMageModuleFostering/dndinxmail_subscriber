<?php
/**
 * @package Inxmail
 * @subpackage TriggerMail
 */

/**
 * The <code>TriggerMailingContentType</code> defines the content type of a trigger mailing.
 * 
 * @author chge, 02.08.2012
 */
final class Inx_Api_TriggerMail_TriggerMailingContentType
{
        private static $HTML_TEXT = null;
                
        private static $PLAIN_TEXT = null;

        private static $MULTIPART = null;

        private static $XML_XSLT_HTML_TEXT = null;

        private static $XML_XSLT_PLAIN_TEXT = null;

        private static $XML_XSLT_MULTIPART = null;

        private static $SYSTEM = null;

        private static $UNKNOWN = null;
    
	/**
	 * Mail type indicating a HTML text mail. This trigger mail has only a HTML text part.
	 */
	public static final function HTML_TEXT()
        {
            if(self::$HTML_TEXT === null)
                self::$HTML_TEXT = new Inx_Api_TriggerMail_TriggerMailingContentType( 0 );
            
            return self::$HTML_TEXT;
        }

	/**
	 * Mail type indicating a plain text mail. This trigger mail has only a plain text part.
	 */
	public static final function PLAIN_TEXT()
        {
            if(self::$PLAIN_TEXT === null)
                self::$PLAIN_TEXT = new Inx_Api_TriggerMail_TriggerMailingContentType( 1 );
            
            return self::$PLAIN_TEXT;
        }

	/**
	 * Mail type indicating a multipart mail. This trigger mail has a HTML and a plain text part.
	 */
	public static final function MULTIPART()
        {
            if(self::$MULTIPART === null)
                self::$MULTIPART = new Inx_Api_TriggerMail_TriggerMailingContentType( 2 );
            
            return self::$MULTIPART;
        }

	/**
	 * Mail type indicating a HTML text mail which uses a template defined in XML/XSLT. This trigger mail has only a
	 * HTML text part.
	 */
	public static final function XML_XSLT_HTML_TEXT()
        {
            if(self::$XML_XSLT_HTML_TEXT === null)
                self::$XML_XSLT_HTML_TEXT = new Inx_Api_TriggerMail_TriggerMailingContentType( 3 );
            
            return self::$XML_XSLT_HTML_TEXT;
        }

	/**
	 * Mail type indicating a plain text mail which uses a template defined in XML/XSLT. This trigger mail has only a
	 * plain text part.
	 */
	public static final function XML_XSLT_PLAIN_TEXT()
        {
            if(self::$XML_XSLT_PLAIN_TEXT === null)
                self::$XML_XSLT_PLAIN_TEXT = new Inx_Api_TriggerMail_TriggerMailingContentType( 4 );
            
            return self::$XML_XSLT_PLAIN_TEXT;
        }

	/**
	 * Mail type indicating a multipart mail which uses a template defined in XML/XSLT. This trigger mail has a HTML and
	 * a plain text part.
	 */
	public static final function XML_XSLT_MULTIPART()
        {
            if(self::$XML_XSLT_MULTIPART === null)
                self::$XML_XSLT_MULTIPART = new Inx_Api_TriggerMail_TriggerMailingContentType( 5 );
            
            return self::$XML_XSLT_MULTIPART;
        }

	/**
	 * The default mail type used by the system.
	 */
	public static final function SYSTEM()
        {
            if(self::$SYSTEM === null)
                self::$SYSTEM = new Inx_Api_TriggerMail_TriggerMailingContentType( -1 );
            
            return self::$SYSTEM;
        }
        
        /**
	 * Constant for an unknown content type. This type indicates a version mismatch between API and server.
	 */
        public static final function UNKNOWN()
        {
            if(self::$UNKNOWN === null)
                self::$UNKNOWN = new Inx_Api_TriggerMail_TriggerMailingContentType( -2 );
            
            return self::$UNKNOWN;
        }

        private $id;


	private function __construct( $iId )
	{
		$this->id = $iId;
	}


	/**
	 * Returns the ID of the <code>TriggerMailingContentType</code>. The ID is used for transmission purposes and should
	 * not be used inside client code.
	 * 
	 * @return the ID of the <code>TriggerMailingContentType</code>.
	 */
	public function getId()
	{
		return $this->id;
	}


	/**
	 * Returns the <code>TriggerMailingContentType</code> corresponding to the given ID. If the ID is unknown, the
	 * <code>UNKNOWN</code> content type will be returned. The ID is used for transmission purposes and should not be
	 * used inside client code.
	 * 
	 * @param id the ID of the <code>TriggerMailingContentType</code> to retrieve.
	 * @return the <code>TriggerMailingContentType</code> corresponding to the given ID.
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
            return array(self::HTML_TEXT(), self::PLAIN_TEXT(), self::MULTIPART(), self::XML_XSLT_HTML_TEXT(), 
                self::XML_XSLT_PLAIN_TEXT(), self::XML_XSLT_MULTIPART(), self::SYSTEM(), self::UNKNOWN());
        }
}