<?php


/**
 * MailingContentHandler
 * 
 * @version $Revision: 5483 $ $Date: 2007-01-30 09:11:15 +0000 (Di, 30 Jan 2007) $ $Author: bgn $
 */
abstract class Inx_Apiimpl_Mailing_MailingContentHandler implements Inx_Api_Mailing_ContentHandler
{
	/**
	 * Enter description here...
	 *
	 * @var Inx_Apiimpl_Mailing_MailingImpl
	 */
    protected $_oMailing;

		



    public function __construct( Inx_Apiimpl_Mailing_MailingImpl $oMailing )
    {
        $this->_oMailing = $oMailing;
    }

    
    public function destroy()
    {
        $this->_oMailing = null;
    }
    
    /**
     * @return int
     */
    public abstract function getMailingContentType();
    
    /**
     * @throws Inx_Api_IllegalStateException
     */
    protected function check()
    {
        if( $this->_oMailing == null )
            throw new Inx_Api_IllegalStateException( "orphaned content handler" );
        
        $this->_oMailing->checkLazyData();
        $this->_oMailing->checkWriteAccess();
    }
    
    /**
     * Enter description here...
     *
     * @param Inx_Apiimpl_Mailing_MailingImpl $oMailing
     * @param string $sContentHandlerClazz
     * @return Inx_Apiimpl_Mailing_MailingContentHandler
     */
    public static function createContentHandler( Inx_Apiimpl_Mailing_MailingImpl $oMailing, $sContentHandlerClazz = null )
    {
    	if ( empty($sContentHandlerClazz) ) {
	        switch( $oMailing->oData->contentMailType )
		    {
		    	case Inx_Api_Mailing_MailingConstants::MAIL_CONTENT_TYPE_PLAIN_TEXT:
		    	    return new Inx_Apiimpl_Mailing_MailingContentHandler_PlainTextImpl( $oMailing ); 
		    	case Inx_Api_Mailing_MailingConstants::MAIL_CONTENT_TYPE_HTML_TEXT:
		    	    return new Inx_Apiimpl_Mailing_MailingContentHandler_HtmlTextImpl( $oMailing ); 
		    	case Inx_Api_Mailing_MailingConstants::MAIL_CONTENT_TYPE_MULTI_PART:
		    	    return new Inx_Apiimpl_Mailing_MailingContentHandler_MultiPartImpl( $oMailing ); 
		    	case Inx_Api_Mailing_MailingConstants::MAIL_CONTENT_TYPE_XML_XSLT_MULTI_PART:
		    	    return new Inx_Apiimpl_Mailing_MailingContentHandler_XsltMultiPartImpl( $oMailing ); 
		    	case Inx_Api_Mailing_MailingConstants::MAIL_CONTENT_TYPE_XML_XSLT_PLAIN_TEXT:
		    	    return new Inx_Apiimpl_Mailing_MailingContentHandler_XsltPlainTextImpl( $oMailing ); 
		    	case Inx_Api_Mailing_MailingConstants::MAIL_CONTENT_TYPE_XML_XSLT_HTML_TEXT:
		    	    return new Inx_Apiimpl_Mailing_MailingContentHandler_XsltHtmlTextImpl( $oMailing ); 
		    	default:
		    	     throw new Inx_Api_IllegalArgumentException( "Illegal ContentMailType: "
		    	             . $this->_oMailing->oData->contentMailType );
		    }
    	} else {
    		switch( $sContentHandlerClazz )
		    {
		    	case 'Inx_Api_Mailing_PlainTextContentHandler':
		    	    return new Inx_Apiimpl_Mailing_MailingContentHandler_PlainTextImpl( $oMailing ); 
		    	case 'Inx_Api_Mailing_HtmlTextContentHandler':
		    	    return new Inx_Apiimpl_Mailing_MailingContentHandler_HtmlTextImpl( $oMailing ); 
		    	case 'Inx_Api_Mailing_MultiPartContentHandler':
		    	    return new Inx_Apiimpl_Mailing_MailingContentHandler_MultiPartImpl( $oMailing ); 
		    	case 'Inx_Api_Mailing_XsltMultiPartContentHandler':
		    	    return new Inx_Apiimpl_Mailing_MailingContentHandler_XsltMultiPartImpl( $oMailing ); 
		    	case 'Inx_Api_Mailing_XsltPlainTextContentHandler':
		    	    return new Inx_Apiimpl_Mailing_MailingContentHandler_XsltPlainTextImpl( $oMailing ); 
		    	case 'Inx_Api_Mailing_XsltHtmlTextContentHandler':
		    	    return new Inx_Apiimpl_Mailing_MailingContentHandler_XsltHtmlTextImpl( $oMailing ); 
		    	default:
		    	     throw new Inx_Api_IllegalArgumentException( "Illegal ContentMailType: "
		    	             . $sContentHandlerClazz );
		    }
    	}
    }
}
