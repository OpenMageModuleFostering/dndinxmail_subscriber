<?php
/**
 * @package Inxmail
 * @subpackage Property
 */
/**
 * The <i>Inx_Api_Property_FormatChoicePropertyFormatter</i> is used for converting the mail format property 
 * to and from the internal string representation. 
 * For this property, there is no dedicated value holder like the <i>Inx_Api_Property_ApprovalPropertyValue</i>. 
 * Instead, the formatter itself contains all relevant data:
 * <p>
 * <ul>
 * <li><i>The formatting (choice) strategy</i>: Defines how mailings shall be formatted.
 * <li><i>The default format</i>: Defines which format shall be used by default.
 * <li><i>The attribute id</i>: Defines the recipient attribute which shall be used to determine which format to use.
 * <li><i>The patterns</i>: Define which attribute value will trigger the use of a specific format.
 * </ul>
 * The formatting (choice) strategy may be one of the following constants:
 * <p>
 * <ul>
 * <li><i>MAILING_FORMAT_STRATEGY</i>: The editor may freely choose the mail format for each individual mailing. 
 * Used by <i>formatMailingChoice()</i>.
 * <li><i>FIXED_STRATEGY</i>: Only one specific mail format may be used. 
 * Used by <i>formatFixedChoice($sFormat)</i>.
 * <li><i>ATTRIBUTE_STRATEGY</i>: A recipient attribute is used to determine the mail format. 
 * Used by <i>formatAttributeChoice($iAttributeId, $sDefaultFormat, $sPlainTextPattern, $sHtmlTextPattern, $sMultipartPattern)</i>.
 * </ul>
 * The default format is used by the <i>FIXED_STRATEGY</i> and the <i>ATTRIBUTE_STRATEGY</i>. 
 * The possible formats are:
 * <p>
 * <ul>
 * <li><i>PLAIN_TEXT_FORMAT</i>: Mailings will contain plain text only.
 * <li><i>HTML_TEXT_FORMAT</i>: Mailings will contain HTML text only.
 * <li><i>MULTIPART_FORMAT</i>: Mailings will contain both, plain and HTML text parts.
 * </ul>
 * <p>
 * <strong>Note:</strong> When using the <i>ATTRIBUTE_STRATEGY</i> it is recommended to create multipart mailings only. 
 * However, it is still possible to create plain or HTML text mailings. 
 * Be aware that in such a case, all recipients will receive the mailing in the same format (which is plain or HTML text).
 * <p>
 * The attribute strategy requires an attribute id, a default mail format and attribute value patterns that determine
 * which mail format to use. 
 * If the value of an attribute matches the pattern, the format associated to this pattern will be chosen. 
 * If the value matches none of the specified patterns, the default format will be used. 
 * The pattern of the default format is automatically set to <i>null</i>.
 * <p>
 * The patterns are <strong>not</strong> patterns in the ordinary sense. 
 * No operators or wildcards are allowed and the value is case sensitive and without quotes. 
 * Let's say we use the following patterns:
 * <p>
 * <ul>
 * <li><i>Plain text pattern</i>: plain%
 * <li><i>HTML text pattern</i>: html
 * <li><i>Multipart pattern (default)</i>: multipart
 * </ul>
 * If the attribute value is equal to plain, the recipient will get a multipart mailing as the % wildcard is considered
 * an ordinary character. 
 * If it is equal to html, the recipient gets the HTML flavour. 
 * However, if the attribute value is equal to HTML, the recipient will also get a multipart mailing, as the patterns 
 * are case sensitive. 
 * The multipart pattern may also be set to <i>null</i> as multipart is the default format and therefore the pattern 
 * is set to <i>null</i> anyway.
 * <p>
 * The following snippet shows how to retrieve and parse the mail format property of the specified list:
 * 
 * <pre>
 * $oListContext = $oSession->getListContextManager()->findByName(&quot;Desired list&quot;);
 * $oProperty = $oListContext->findProperty(Inx_Api_Property_PropertyNames::MAIL_FORMAT_CHOICE);
 * 
 * $oFormatChoicePropertyFormatter = Inx_Api_Property_FormatChoicePropertyFormatter::parse($oProperty);
 * echo &quot;Format strategy: &quot;.$oFormatChoicePropertyFormatter->getChoiceStategy()."&#60;br&#62;";
 * echo &quot;Default format:  &quot;.$oFormatChoicePropertyFormatter->getDefaultFormat()."&#60;br&#62;";
 * echo &quot;Attribute id:    &quot;.$oFormatChoicePropertyFormatter->getAttributeId()."&#60;br&#62;";
 * echo &quot;HTML pattern:    &quot;.$oFormatChoicePropertyFormatter->getPattern(
 * 	Inx_Api_Property_FormatChoicePropertyFormatter::HTML_TEXT_FORMAT)."&#60;br&#62;";
 * </pre>
 * <p>
 * To give the editor free choice to use any mail format she or he considers appropriate, use the 
 * <i>formatMailingChoice()</i> method. 
 * The following snippet shows how this can be achieved:
 * 
 * <pre>
 * $oListContext = $oSession->getListContextManager()->findByName( &quot;Desired list&quot; );
 * $oProperty = $oListContext->findProperty( Inx_Api_Property_PropertyNames::MAIL_FORMAT_CHOICE );
 * 
 * $oProperty->updateInternalValue( Inx_Api_Property_FormatChoicePropertyFormatter::formatMailingChoice() );
 * $oProperty->commitUpdate();
 * </pre>
 * <p>
 * The opposite strategy is to restrict all mailings of a list to a certain mail format. 
 * The following snippet shows how to restrict the mailing format of the specified list to the multipart format:
 * 
 * <pre>
 * $oListContext = $oSession->getListContextManager()->findByName( &quot;Desired list&quot; );
 * $oProperty = $oListContext->findProperty( Inx_Api_Property_PropertyNames::MAIL_FORMAT_CHOICE );
 * 
 * $oProperty->updateInternalValue( Inx_Api_Property_FormatChoicePropertyFormatter::formatFixedChoice( 
 * 	Inx_Api_Property_FormatChoicePropertyFormatter::MULTIPART_FORMAT ) );
 * $oProperty->commitUpdate();
 * </pre>
 * <p>
 * The final strategy is to choose the mailing format based on the value of a recipient attribute. 
 * The following snippet shows how to send HTML mailings to recipients with the attribute value html, plain text 
 * mailings to recipients with the attribute value plain and multipart mailings to all other recipients:
 * 
 * <pre>
 * $oListContext = $oSession->getListContextManager()->findByName( &quot;Desired list&quot; );
 * $oRecipientMetaData = $oSession->createRecipientContext()->getMetaData();
 * $oProperty = $oListContext->findProperty( Inx_Api_Property_PropertyNames::MAIL_FORMAT_CHOICE );
 * 
 * $iAttributeId = $oRecipientMetaData->getUserAttribute( &quot;format&quot; )->getId();
 * $sPlainTextPattern = &quot;plain&quot;;
 * $sHtmlTextPattern = &quot;html&quot;;
 * 
 * $sStrategy = Inx_Api_Property_FormatChoicePropertyFormatter::formatAttributeChoice( $iAttributeId,
 * 		Inx_Api_Property_FormatChoicePropertyFormatter::MULTIPART_FORMAT, $sPlainTextPattern, $sHtmlTextPattern, null );
 * $oProperty->updateInternalValue( $sStrategy );
 * $oProperty->commitUpdate();
 * </pre>
 * <p>
 * For more information on properties in general, see the <i>Inx_Api_Property_Property</i> documentation.
 * 
 * @see Inx_Api_Property_Property
 * @version $Revision: 9497 $ $Date: 2007-12-19 17:03:25 +0200 (Tr, 19 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 * @subpackage Property
 */
class Inx_Api_Property_FormatChoicePropertyFormatter
{
    const PREFIX = "EmailFormat[";

    const SUFFIX = "]";
    
    
    /**
    * Strategy constant which lets the editor freely choose the appropriate mail format.
    * 
    * @var int
    */
    const MAILING_FORMAT_STRATEGY = 0;

    /**
    * Strategy constant which restricts the mail format to exactly one specified format.
    * 
    * @var int
    */
    const FIXED_STRATEGY = 1;

    /**
    * Strategy constant which is used to determine the mail format based on the value of a recipient attribute.
    * 
    * @var int
    */
    const ATTRIBUTE_STRATEGY = 2;


    /**
    * Constant for the plain text pattern.
    * 
    * @var string
    */
    const PLAIN_TEXT_FORMAT = "text/plain";

    /**
    * Constant for the HTML text pattern.
    * 
    * @var string
    */
    const HTML_TEXT_FORMAT = "text/html";

    /**
    * Constant for the multipart pattern.
    * 
    * @var string
    */
    const MULTIPART_FORMAT = "multipart";


    /**
    * The strategy used to choose the mailing format.
    * 
    * @var int
    */
    protected $iChoiceStategy;

    /**
    * The attribute that controls which format to choose.
    * 
    * @var int
    */
    protected $iAttributeId;

    /**
    * The plain text pattern.
    * 
    * @var string
    */
    protected $sPlainTextPattern;

    /**
    * The HTML text pattern.
    * 
    * @var string
    */
    protected $sHtmlTextPattern;

    /**
    * The multipart pattern.
    * 
    * @var string
    */
    protected $sMultipartPattern;

    /**
    * The default mailing format.
    * 
    * @var string
    */
    protected $sFormat;
    

    /**
    * Default constructor which may only be used by derived classes.
    */
    protected function __construct()
    {}
    
    
   /**
    * Parses the given property and extracts the format choice policy into a new
    * <i>Inx_Api_Property_FormatChoicePropertyFormatter</i> for easy retrieval. 
    * Only the <i>Inx_Api_Property_PropertyNames::MAIL_FORMAT_CHOICE</i> property is allowed. 
    * Using any other property will trigger an <i>Inx_Api_IllegalArgumentException</i>.
    *
    * @param property the property to parse.
    * @return Inx_Api_Property_FormatChoicePropertyFormatter an <i>Inx_Api_Property_FormatChoicePropertyFormatter</i> 
    * 	which can be used for easy retrieval of the	property values.
    * @throws Inx_Api_IllegalArgumentException if the given property is not an 
    * 	<i>Inx_Api_Property_PropertyNames::MAIL_FORMAT_CHOICE</i> property.
    */
    public static function parse( Inx_Api_Property_Property $oProperty )
    {
        $sValue = $oProperty->getInternalValue();
        $oFormat = new Inx_Api_Property_FormatChoicePropertyFormatter();
        
        if( $sValue === null || strlen($sValue) == 0 )
        {
            $oFormat->iChoiceStategy = self::MAILING_FORMAT_STRATEGY;
            return $oFormat;
        }
        
        if( strpos($sValue, self::PREFIX) === 0 && true ===(strrpos($sValue, self::SUFFIX) == strlen($sValue) - strlen(self::SUFFIX)) )
        {
            $s = substr($sValue, strlen(self::PREFIX), -1);
            
           
            if( strcmp('0', $s) === 0 ) // EmailFormat[0]
            {
                $oFormat->iChoiceStategy = self::MAILING_FORMAT_STRATEGY;
                return $oFormat;
            }
            if( strcmp('1|text/plain', $s ) === 0 ) // EmailFormat[1|text/plain]
            {
                $oFormat->iChoiceStategy = self::FIXED_STRATEGY;
                $oFormat->sFormat = self::PLAIN_TEXT_FORMAT;
                return $oFormat;
            }
            if( strcmp('1|text/html', $s ) === 0) // EmailFormat[1|text/html]
            {
                $oFormat->iChoiceStategy = self::FIXED_STRATEGY;
                $oFormat->sFormat = self::HTML_TEXT_FORMAT;
                return $oFormat;
            }
            if( strcmp('1|multipart', $s ) === 0 ) // EmailFormat[1|multipart]
            {
                $oFormat->iChoiceStategy = self::FIXED_STRATEGY;
                $oFormat->sFormat = self::MULTIPART_FORMAT;
                return $oFormat;
            }
            
            // EmailFormat[2|<attrId>|<htmltext-pattern>|<plaintext-pattern>|<multipart-pattern>|<defaultForamt>]
            $aTokens = explode('|', $s);
            if ((count($aTokens) === 6) && strcmp('2', $aTokens[0]) === 0 && ctype_digit($aTokens[1]))
            {
            	$oFormat->iChoiceStategy = self::ATTRIBUTE_STRATEGY;
                $oFormat->iAttributeId  = (int) $aTokens[1];
                $oFormat->sHtmlTextPattern = $aTokens[2];
                $oFormat->sPlainTextPattern = $aTokens[3];
                $oFormat->sMultipartPattern = $aTokens[4];
                $df = $aTokens[5];
                if(strcmp($df, self::PLAIN_TEXT_FORMAT) === 0) {
                	$oFormat->sFormat = self::PLAIN_TEXT_FORMAT;
                    return $oFormat;
                }
                
                if(strcmp($df, self::HTML_TEXT_FORMAT) === 0) {
                    $oFormat->sFormat = self::HTML_TEXT_FORMAT;
                    return $oFormat;
                }
                
                if(strcmp($df, self::MULTIPART_FORMAT) === 0) {
                    $oFormat->sFormat = self::MULTIPART_FORMAT;
                    return $oFormat;
                }
            }
        }
        throw new Inx_Api_IllegalArgumentException( "illegal mail choise format: " . value );
    }
        
    /**
    * Returns the formatting (choice) strategy. May be one of:
    * <ul>
    * <li><i>MAILING_FORMAT_STRATEGY</i>
    * <li><i>FIXED_STRATEGY</i>
    * <li><i>ATTRIBUTE_STRATEGY</i>
    * </ul>
    *
    * @return int the formatting (choice) strategy.
    */
    public function getChoiceStategy()
    {
        return $this->iChoiceStategy;
    }
    
    /**
    * Returns the id of the recipient attribute used to determine the mailing format. 
    * If the choice strategy is not <i>ATTRIBUTE_STRATEGY</i>, 0 will be returned.
    *
    * @return int the id of the recipient attribute used to determine the mailing format, or 0 if none is needed.
    */
    public function getAttributeId()
    {
        return $this->iAttributeId; 
    }
    
    /**
    * Returns the pattern for the given mailing format. 
    * Patterns are only used by the choice strategy <i>ATTRIBUTE_STRATEGY</i>.
    *
    * @param string $sFormat the mailing format for which the pattern shall be returned. May be one of:
    *            <ul>
    *            <li><i>PLAIN_TEXT_FORMAT</i>
    *            <li><i>HTML_TEXT_FORMAT</i>
    *            <li><i>MULTIPART_FORMAT</i>
    *            </ul>
    * @return string the pattern for the given format, if any, <i>null</i> otherwise.
    */
    public function getPattern( $sFormat )
    {
        if( strcmp($sFormat, self::PLAIN_TEXT_FORMAT) === 0 )
    	    return $this->sPlainTextPattern;
        if( strcmp($sFormat, self::HTML_TEXT_FORMAT) === 0 )
            return $this->sHtmlTextPattern;
	    if( strcmp($sFormat, self::MULTIPART_FORMAT) === 0 )
	    	return $this->sMultipartPattern;
	    
	    throw new Inx_Api_IllegalArgumentException( "unknown format: " . $sFormat );
    }
    
    /**
    * Returns the default mailing format. 
    * The default format is only used by the choice strategies <i>FIXED_STRATEGY</i> and <i>ATTRIBUTE_STRATEGY</i>.
    *
    * @return string the default mailing format, if any, <i>null</i> otherwise.
    */
    public function getDefaultFormat()
    {
        return $this->sFormat;
    }
    
    /**
    * Creates the internal string value for the <i>MAILING_FORMAT_STRATEGY</i>.
    *
    * @return string the internal string value for the <i>MAILING_FORMAT_STRATEGY</i>.
    */
    public static function formatMailingChoice()
    {
        return self::PREFIX . "0" . self::SUFFIX;
    }
    
    /**
    * Creates the internal string value for the <i>FIXED_STRATEGY</i> using the given default mailing format. 
    * The default format may be one of:
    * <ul>
    * <li><i>PLAIN_TEXT_FORMAT</i>
    * <li><i>HTML_TEXT_FORMAT</i>
    * <li><i>MULTIPART_FORMAT</i>
    * </ul>
    *
    * @param string $sFormat the default mailing format.
    * @return string the internal string value for the <i>FIXED_STRATEGY</i>.
    */
    public static function formatFixedChoice( $sFormat )
    {
        self::checkFormat( $sFormat );
        return self::PREFIX . "1|" . $sFormat . self::SUFFIX;
    }
    
    /**
    * Creates the internal string value for the <i>ATTRIBUTE_STRATEGY</i> using the given recipient attribute id,
    * default mailing format and patterns. 
    * For a description of the pattern syntax, see the documentation of this class. 
    * The default mailing attribute may be one of:
    * <ul>
    * <li><i>PLAIN_TEXT_FORMAT</i>
    * <li><i>HTML_TEXT_FORMAT</i>
    * <li><i>MULTIPART_FORMAT</i>
    * </ul>
    *
    * @param int $iAttributeId the id of the recipient attribute used to determine the mailing format.
    * @param string $sDefaultFormat the default mailing format.
    * @param string $sPlainTextPattern the plain text pattern. May be <i>null</i> if this is the default format.
    * @param string $sHtmlTextPattern the HTML text pattern. May be <i>null</i> if this is the default format.
    * @param string $sMultipartPattern the multipart text pattern. May be <i>null</i> if this is the default format.
    * @return string the internal string value for the <i>ATTRIBUTE_STRATEGY</i>.
    */
    public static function formatAttributeChoice( $iAttributeId, $sDefaultFormat,
            $sPlainTextPattern, $sHtmlTextPattern, $sMultipartPattern )
    {
        if( strcmp($sDefaultFormat, self::PLAIN_TEXT_FORMAT) === 0)
        {
        	//fixes XAPI35 (comment): use "null" instead of null
            $sPlainTextPattern = "null";
            if( $sHtmlTextPattern === null || strlen($sHtmlTextPattern) == 0 )
                throw new Inx_Api_IllegalArgumentException( "htmlTextPattern - illegal value: " . $sHtmlTextPattern );
            if( $sMultipartPattern === null || strlen($sMultipartPattern) == 0 )
                throw new Inx_Api_IllegalArgumentException( "multipartPattern - illegal value: " . $sMultipartPattern );
        }
        else if( strcmp($sDefaultFormat, self::HTML_TEXT_FORMAT) === 0)
        {
        	//fixes XAPI35 (comment): use "null" instead of null
            $sHtmlTextPattern = "null";
            if( $sPlainTextPattern === null || strlen($sPlainTextPattern) == 0 )
                throw new Inx_Api_IllegalArgumentException( "plainTextPattern - illegal value: " . $sPlainTextPattern );
            if( $sMultipartPattern === null || strlen($sMultipartPattern) == 0 )
                throw new Inx_Api_IllegalArgumentException( "multipartPattern - illegal value: " . $sMultipartPattern );    
        }
	    else if( strcmp($sDefaultFormat, self::MULTIPART_FORMAT) === 0 )
	    {
	    	//fixes XAPI35 (comment): use "null" instead of null 
	        $sMultipartPattern = "null";
	        //fixes XAPI-35: strlen() instead of length()
	        if( $sPlainTextPattern === null || strlen($sPlainTextPattern) == 0 )
                throw new Inx_Api_IllegalArgumentException( "plainTextPattern - illegal value: " . $sPlainTextPattern );
            if( $sHtmlTextPattern === null || strlen($sHtmlTextPattern) == 0 )
                throw new Inx_Api_IllegalArgumentException( "htmlTextPattern - illegal value: " . $sHtmlTextPattern );
	    }
	    else
	        throw new Inx_Api_IllegalArgumentException( "unknown defaultFormat: " . $sDefaultFormat );
        
        return self::PREFIX . "2|" . $iAttributeId . "|" . $sHtmlTextPattern . "|" . $sPlainTextPattern 
        	. "|" . $sMultipartPattern . "|" . $sDefaultFormat . self::SUFFIX;
    }
    
    
    private static function checkFormat( $sFormat )
    {
        if( strcmp(self::PLAIN_TEXT_FORMAT, $sFormat ) === 0)
    	    return;
        if( strcmp(self::HTML_TEXT_FORMAT, $sFormat ) === 0)
            return;
	    if( strcmp(self::MULTIPART_FORMAT, $sFormat ) === 0)
	    	return;
	    
	    throw new Inx_Api_IllegalArgumentException( "unknown format: " . $sFormat );
    }
}
