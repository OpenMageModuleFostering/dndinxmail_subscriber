<?php
/**
 * MailContentImpl
 * 
 * @version $Revision: 19494 $ $Date: 2010-12-14 10:11:12 +0100 (Di, 14 Dez 2010) $ $Author: sbn $
 */
class Inx_Apiimpl_TriggerMailing_TriggerMailContentImpl implements Inx_Api_TriggerMail_TriggerMailContent
{
	protected $rendererRef;

	protected $result;

	protected $attachments;

	protected $embeddedImages;

	protected $header;

	protected $headerList;


	public function __construct( Inx_Apiimpl_RemoteRef $rendererRef, stdClass $result )
	{
		$this->rendererRef = $rendererRef;
		$this->result = $result;

		$this->attachments = self::create( $this->rendererRef, $this->result->attachments );
		$this->embeddedImages = self::create( $this->rendererRef, $this->result->embeddedImages );

		$this->header = array();
		$this->headerList = array();

		if( !empty($this->_oResult->headers) && is_array($this->_oResult->headers) )
		{
                        foreach ($this->_oResult->headers as $val) 
                        {
                		$this->header[$val->name] = $val->value;
                		$this->headerList[] = new Inx_Api_Mail_HeaderField($val->name, $val->value);
                	}
		}
	}


	protected static function create( Inx_Apiimpl_RemoteRef $rendererRef, $as )
	{
                if(empty($as))
                {
                    return array();
                }
                else
                {
                    $aAttachments = array(); // new Attachment[as.length];
                    
                    foreach ($as as $i=>$val) 
                    {
                        $aAttachments[$i] =  new Inx_Apiimpl_TriggerMailing_AttachmentImpl( $rendererRef, $val );
                    }

                    return $aAttachments;
                }
	}


	public function getContentType()
	{
                return Inx_Api_TriggerMail_TriggerMailingContentType::byId($this->result->mailType);
	}


	public function getHtmlText()
	{
                return Inx_Apiimpl_TConvert::convert( $this->result->mailPartHtmlText );
	}


	public function getPlainText()
	{
		return Inx_Apiimpl_TConvert::convert( $this->result->mailPartPlainText );
	}


	public function getSubject()
	{
		return Inx_Apiimpl_TConvert::convert( $this->result->mailPartSubject );
	}


	public function getSenderAddress()
	{
		return Inx_Apiimpl_TConvert::convert( $this->result->mailPartSender );
	}


	public function getReplyToAddress()
	{
		return Inx_Apiimpl_TConvert::convert( $this->result->mailPartReplyTo );
	}


	public function getBounceAddress()
	{
		return Inx_Apiimpl_TConvert::convert( $this->result->mailPartBounce );
	}


	public function getRecipientAddress()
	{
		return Inx_Apiimpl_TConvert::convert( $this->result->mailPartRecipient );
	}


	public function getAttachments()
	{
		return $this->attachments;
	}


	public function getEmbeddedImages()
	{
		return $this->embeddedImages;
	}


	public function getHeader()
	{
		return $this->header;
	}


	public function getMultipleHeaders()
	{
		return $this->headerList;
	}
}