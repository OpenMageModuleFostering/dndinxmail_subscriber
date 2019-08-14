<?php


/**
 * MailContentImpl
 * 
 * @version $Revision: 5430 $ $Date: 2007-01-19 12:37:16 +0000 (Fr, 19 Jan 2007) $ $Author: bgn $
 */
class Inx_Apiimpl_Mailing_MailContentImpl implements Inx_Api_Mail_MailContent
{

	/**
	 * @var Inx_Apiimpl_RemoteRef
	 */
    protected $_oRendererRef;

    /**
     * Enter description here...
     *
     * @var stdClass BuildResult
     */
    protected $_oResult;

    /**
     * @var array Inx_Api_Mail_Attachment
     */
    protected $_aAttachments;

    /**
     * @var array Inx_Api_Mail_Attachment
     */
    protected $_aEmbeddedImages;
    
    /**
     * Enter description here...
     *
     * @var array Map
     */
    protected $_aHeader;
    
    /**
     * @var array List of <i>HeaderField</i>s
     */
    protected $_aHeaderList;
    
    
    public function __construct( Inx_Apiimpl_RemoteRef $oRendererRef, stdClass $oResult )
    {
        $this->_oRendererRef = $oRendererRef;
        $this->_oResult = $oResult;
        
        $this->_aAttachments = self::create( $this->_oRendererRef, $this->_oResult->attachments );
        $this->_aEmbeddedImages = self::create( $this->_oRendererRef, $this->_oResult->embeddedImages );
        
        $this->_aHeader = array();
        $this->_aHeaderList = array();
        
        if(! empty($this->_oResult->headers) && is_array($this->_oResult->headers))
        {
        	foreach ($this->_oResult->headers as $val) 
        	{
        		$this->_aHeader[$val->name] = $val->value;
        		$this->_aHeaderList[] = new Inx_Api_Mail_HeaderField($val->name, $val->value);
        	}
        }
    }
    
    
    /**
     * @return array Inx_Api_Mail_Attachment
     */
    /**
     * Enter description here...
     *
     * @param Inx_Apiimpl_RemoteRef $oRendererRef
     * @param array $as Inx_Api_Mail_Attachment
     * @return array Inx_Api_Mail_Attachment
     */
    protected static function create( Inx_Apiimpl_RemoteRef $oRendererRef, $as )
    {
        if(empty($as))
        {
            return array();
        }
        else
        {
            $aAttachments = array(); // new Attachment[as.length];
            foreach ($as as $i=>$val) {
            	$aAttachments[$i] =  new Inx_Apiimpl_Mailing_AttachmentImpl( $oRendererRef, $val );
            }
            
            return $aAttachments;
        }
    }
    
    /**
     * Enter description here...
     *
     * @return int
     */
    public function getMailType()
    {
        return $this->_oResult->mailType;
    }

    /**
     * Enter description here...
     *
     * @return string
     */
	public function getHtmlText()
	{
	    return Inx_Apiimpl_TConvert::convert( $this->_oResult->mailPartHtmlText );
	}
	
	/**
	 * Enter description here...
	 *
	 * @return String
	 */
	public function getPlainText()
	{
	    return Inx_Apiimpl_TConvert::convert( $this->_oResult->mailPartPlainText );
	}
	
	/**
	 * Enter description here...
	 *
	 * @return String
	 */
	public function getSubject()
	{
	    return Inx_Apiimpl_TConvert::convert( $this->_oResult->mailPartSubject );
	}
	
	/**
	 * Enter description here...
	 *
	 * @return String
	 */
	public function getSenderAddress()
	{
	    return Inx_Apiimpl_TConvert::convert( $this->_oResult->mailPartSender );
	}
	
	/**
	 * Enter description here...
	 *
	 * @return String
	 */	
	public function getReplyToAddress()
	{
	    return Inx_Apiimpl_TConvert::convert( $this->_oResult->mailPartReplyTo );
	}

	public function getBounceAddress()
	{
	    return Inx_Apiimpl_TConvert::convert( $this->_oResult->mailPartBounce );
	}
	
	/**
	 * Enter description here...
	 *
	 * @return String
	 */	
	public function getRecipientAddress()
	{
	    return Inx_Apiimpl_TConvert::convert( $this->_oResult->mailPartRecipient );
	}
	
	/**
	 * Enter description here...
	 *
	 * @return array Attachment
	 */	
	public function getAttachments()
	{
	    return $this->_aAttachments;
	}
	
	/**
	 * Enter description here...
	 *
	 * @return array Attachment
	 */	
	public function getEmbeddedImages()
	{
	    return $this->_aEmbeddedImages;
	}

    public function getHeader()
    {
        return $this->_aHeader;
    }
    
    public function getMultipleHeaders()
    {
    	return $this->_aHeaderList;
    }
}
