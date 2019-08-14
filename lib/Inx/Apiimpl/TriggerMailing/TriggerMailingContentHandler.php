<?php
/**
 * TriggerMailingContentHandler
 * 
 * @author chge, 31.05.2012
 */
abstract class Inx_Apiimpl_TriggerMailing_TriggerMailingContentHandler 
        implements Inx_Api_Mailing_ContentHandler
{
    protected $mailing;

    public function __construct( Inx_Apiimpl_TriggerMailing_TriggerMailingImpl $mailing )
    {
            $this->mailing = $mailing;
    }


    public function destroy()
    {
            $this->mailing = null;
    }


    public abstract function getMailingContentType();


    protected function check()
    {
            if( null === $this->mailing )
                    throw new Inx_Api_IllegalStateException( "orphaned content handler" );

            $this->mailing->checkLazyData();
            $this->mailing->checkWriteAccess();
    }


    public static function createContentHandler( Inx_Apiimpl_TriggerMailing_TriggerMailingImpl $mailing, 
            $sContentHandlerClazz = null )
    {                                                              
        if( empty($sContentHandlerClazz) )
        {
            $type = Inx_Api_TriggerMail_TriggerMailingContentType::byId($mailing->data->contentMailType);
            
            switch( $type )
            {
                    case Inx_Api_TriggerMail_TriggerMailingContentType::PLAIN_TEXT():
                        return new Inx_Apiimpl_TriggerMailing_TriggerMailingContentHandler_PlainTextImpl( $mailing );
                    case Inx_Api_TriggerMail_TriggerMailingContentType::HTML_TEXT():
                        return new Inx_Apiimpl_TriggerMailing_TriggerMailingContentHandler_HtmlTextImpl( $mailing ); 
                    case Inx_Api_TriggerMail_TriggerMailingContentType::MULTIPART():
                        return new Inx_Apiimpl_TriggerMailing_TriggerMailingContentHandler_MultiPartImpl( $mailing ); 
                    case Inx_Api_TriggerMail_TriggerMailingContentType::XML_XSLT_MULTIPART():
                        return new Inx_Apiimpl_TriggerMailing_TriggerMailingContentHandler_XsltMultiPartImpl( $mailing ); 
                    case Inx_Api_TriggerMail_TriggerMailingContentType::XML_XSLT_PLAIN_TEXT():
                        return new Inx_Apiimpl_TriggerMailing_TriggerMailingContentHandler_XsltPlainTextImpl( $mailing ); 
                    case Inx_Api_TriggerMail_TriggerMailingContentType::XML_XSLT_HTML_TEXT():
                        return new Inx_Apiimpl_TriggerMailing_TriggerMailingContentHandler_XsltHtmlTextImpl( $mailing ); 
                    default:
                            throw new Inx_Api_IllegalArgumentException( "Illegal ContentMailType: " . 
                                    $this->mailing->data->contentMailType );
            }
        }
        else 
        {
            switch($sContentHandlerClazz)
            {
                case 'Inx_Api_Mailing_PlainTextContentHandler':
                    return new Inx_Apiimpl_TriggerMailing_TriggerMailingContentHandler_PlainTextImpl( $mailing ); 
                case 'Inx_Api_Mailing_HtmlTextContentHandler':
                    return new Inx_Apiimpl_TriggerMailing_TriggerMailingContentHandler_HtmlTextImpl( $mailing ); 
                case 'Inx_Api_Mailing_MultiPartContentHandler':
                    return new Inx_Apiimpl_TriggerMailing_TriggerMailingContentHandler_MultiPartImpl( $mailing ); 
                case 'Inx_Api_Mailing_XsltMultiPartContentHandler':
                    return new Inx_Apiimpl_TriggerMailing_TriggerMailingContentHandler_XsltMultiPartImpl( $mailing ); 
                case 'Inx_Api_Mailing_XsltPlainTextContentHandler':
                    return new Inx_Apiimpl_TriggerMailing_TriggerMailingContentHandler_XsltPlainTextImpl( $mailing ); 
                case 'Inx_Api_Mailing_XsltHtmlTextContentHandler':
                    return new Inx_Apiimpl_TriggerMailing_TriggerMailingContentHandler_XsltHtmlTextImpl( $mailing ); 
                default:
                     throw new Inx_Api_IllegalArgumentException( "Illegal ContentMailType: "
                             . $sContentHandlerClazz );
            }   
        }
    }
}

class Inx_Apiimpl_TriggerMailing_TriggerMailingContentHandler_PlainTextImpl 
    extends Inx_Apiimpl_TriggerMailing_TriggerMailingContentHandler 
    implements Inx_Api_Mailing_PlainTextContentHandler
{
        public function __construct( Inx_Apiimpl_TriggerMailing_TriggerMailingImpl $mailing )
        {
                parent::__construct( $mailing );
        }


        public function getContent()
        {
                $this->check();
                return Inx_Apiimpl_TConvert::convert( $this->mailing->data->lazyData->plainText );
        }


        public function updateContent( $sContent )
        {
                $this->check();
                $this->mailing->data->lazyData->plainText = Inx_Apiimpl_TConvert::TConvert( $sContent );
                $this->mailing->changedAttrs[Inx_Api_TriggerMailing_TriggerMailingAttribute::PLAIN_TEXT()->getId()] = true;
        }


        public function getMailingContentType()
        {
                return Inx_Api_TriggerMail_TriggerMailingContentType::PLAIN_TEXT();
        }
}


class Inx_Apiimpl_TriggerMailing_TriggerMailingContentHandler_HtmlTextImpl 
        extends Inx_Apiimpl_TriggerMailing_TriggerMailingContentHandler 
        implements Inx_Api_Mailing_HtmlTextContentHandler
{
        public function __construct( Inx_Apiimpl_TriggerMailing_TriggerMailingImpl $mailing )
        {
                parent::__construct( $mailing );
        }


        public function getContent()
        {
                $this->check();
                return Inx_Apiimpl_TConvert::convert( $this->mailing->data->lazyData->htmlText );
        }


        public function updateContent( $sContent )
        {
                $this->check();
                $this->mailing->data->lazyData->htmlText = Inx_Apiimpl_TConvert::TConvert( $sContent );
                $this->mailing->changedAttrs[Inx_Api_TriggerMailing_TriggerMailingAttribute::HTML_TEXT()->getId()] = true;
        }


        public function getMailingContentType()
        {
                return Inx_Api_TriggerMail_TriggerMailingContentType::HTML_TEXT();
        }
}


class Inx_Apiimpl_TriggerMailing_TriggerMailingContentHandler_MultiPartImpl 
        extends Inx_Apiimpl_TriggerMailing_TriggerMailingContentHandler 
        implements Inx_Api_Mailing_MultiPartContentHandler
{
        public function __construct( Inx_Apiimpl_TriggerMailing_TriggerMailingImpl $mailing )
        {
                parent::__construct( $mailing );
        }


        public function getPlainTextContent()
        {
                $this->check();
                return Inx_Apiimpl_TConvert::convert( $this->mailing->data->lazyData->plainText );
        }


        public function updatePlainTextContent( $sPlainTextContent )
        {
                $this->check();
                $this->mailing->data->lazyData->plainText = Inx_Apiimpl_TConvert::TConvert( $sPlainTextContent );
                $this->mailing->changedAttrs[Inx_Api_TriggerMailing_TriggerMailingAttribute::PLAIN_TEXT()->getId()] = true;
        }


        public function getHtmlTextContent()
        {
                $this->check();
                return Inx_Apiimpl_TConvert::convert( $this->mailing->data->lazyData->htmlText );
        }


        public function updateHtmlTextContent( $sHtmlTextContent )
        {
                $this->check();
                $this->mailing->data->lazyData->htmlText = Inx_Apiimpl_TConvert::TConvert( $sHtmlTextContent );
                $this->mailing->changedAttrs[Inx_Api_TriggerMailing_TriggerMailingAttribute::HTML_TEXT()->getId()] = true;
        }


        public function getMailingContentType()
        {
                return Inx_Api_TriggerMail_TriggerMailingContentType::MULTIPART();
        }
}


abstract class Inx_Apiimpl_TriggerMailing_TriggerMailingContentHandler_XsltImpl 
        extends Inx_Apiimpl_TriggerMailing_TriggerMailingContentHandler
{
        public function __construct( Inx_Apiimpl_TriggerMailing_TriggerMailingImpl $mailing )
        {
                parent::__construct( $mailing );
        }


        public function getXmlContent()
        {
                $this->check();
                return Inx_Apiimpl_TConvert::convert( $this->mailing->data->lazyData->xmlContent );
        }


        public function updateXmlContent( $sContent )
        {
                $this->check();
                $this->mailing->data->lazyData->xmlContent = Inx_Apiimpl_TConvert::TConvert( $sContent );
                $this->mailing->changedAttrs[Inx_Api_TriggerMailing_TriggerMailingAttribute::XML_CONTENT()->getId()] = true;
        }


        public function getPlainTextXslt()
        {
                $this->check();
                return Inx_Apiimpl_TConvert::convert( $this->mailing->data->lazyData->plainTextXsl );
        }


        public function updatePlainTextXslt( $sPlainTextXslt )
        {
                $this->check();
                $this->mailing->data->lazyData->plainTextXsl = Inx_Apiimpl_TConvert::TConvert( $sPlainTextXslt );
                $this->mailing->changedAttrs[Inx_Api_TriggerMailing_TriggerMailingAttribute::PLAIN_TEXT_XSL()->getId()] = true;
        }


        public function getHtmlTextXslt()
        {
                $this->check();
                return Inx_Apiimpl_TConvert::convert( $this->mailing->data->lazyData->htmlTextXsl );
        }


        public function updateHtmlTextXslt( $sHtmlTextXslt )
        {
                $this->check();
                $this->mailing->data->lazyData->htmlTextXsl = Inx_Apiimpl_TConvert::TConvert( $sHtmlTextXslt );
                $this->mailing->changedAttrs[Inx_Api_TriggerMailing_TriggerMailingAttribute::HTML_TEXT_XSL()->getId()] = true;
        }


        public function getStyle()
        {
                $this->check();
                $tStyle = $this->mailing->data->lazyData->templateStyle;
                
                if( $tStyle === null )
                {
                    return null;
                }
                
                return new Inx_Apiimpl_DesignTemplate_StyleImpl( $tStyle->templateId, $tStyle->style );
        }


        public function updateStyle( Inx_Api_DesignTemplate_Style $style )
        {
                $this->check();
		/**
		 * @var TemplateStyle
		 */
		$newStyle = new stdClass();
		$newStyle->templateId = $style->getTemplateId();
		$newStyle->style = $style->getStyleName();
		$this->mailing->data->lazyData->templateStyle = $newStyle;
		$this->mailing->changedAttrs[Inx_Api_TriggerMailing_TriggerMailingAttribute::STYLE()->getId()] = true;
        }
}


class Inx_Apiimpl_TriggerMailing_TriggerMailingContentHandler_XsltMultiPartImpl 
        extends Inx_Apiimpl_TriggerMailing_TriggerMailingContentHandler_XsltImpl 
        implements Inx_Api_Mailing_XsltMultiPartContentHandler
{
        public function __construct( Inx_Apiimpl_TriggerMailing_TriggerMailingImpl $mailing )
        {
                parent::__construct( $mailing );
        }


        public function getMailingContentType()
        {
                return Inx_Api_TriggerMail_TriggerMailingContentType::XML_XSLT_MULTIPART();
        }
}


class Inx_Apiimpl_TriggerMailing_TriggerMailingContentHandler_XsltHtmlTextImpl 
        extends Inx_Apiimpl_TriggerMailing_TriggerMailingContentHandler_XsltImpl 
        implements Inx_Api_Mailing_XsltHtmlTextContentHandler
{
        public function __construct( Inx_Apiimpl_TriggerMailing_TriggerMailingImpl $mailing )
        {
                parent::__construct( $mailing );
        }


        public function getMailingContentType()
        {
                return Inx_Api_TriggerMail_TriggerMailingContentType::XML_XSLT_HTML_TEXT();
        }
}


class Inx_Apiimpl_TriggerMailing_TriggerMailingContentHandler_XsltPlainTextImpl 
        extends Inx_Apiimpl_TriggerMailing_TriggerMailingContentHandler_XsltImpl 
        implements Inx_Api_Mailing_XsltPlainTextContentHandler
{
        public function __construct( Inx_Apiimpl_TriggerMailing_TriggerMailingImpl $mailing )
        {
                parent::__construct( $mailing );
        }


        public function getMailingContentType()
        {
                return Inx_Api_TriggerMail_TriggerMailingContentType::XML_XSLT_PLAIN_TEXT();
        }
}