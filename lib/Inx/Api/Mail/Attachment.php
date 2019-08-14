<?php
/**
 * @package Inxmail
 * @subpackage Mail
 */
/**
 * The <i>Inx_Api_Mail_Attachment</i> object represents a regular attachment or an embedded image 
 * of a mailing and is part of the <i>Inx_Api_Mail_MailContent</i> object.
 *
 * @see  Inx_Api_Mail_MailContent::getAttachments()
 * @see  Inx_Api_Mail_MailContent::getEmbeddedImages()
 * @since API 1.0
 * @version $Revision: 9553 $ $Date: 2008-01-04 11:28:41 +0200 (Pn, 04 Sau 2008) $ $Author: vladas $
 * @package Inxmail
 * @subpackage Mail
 */
interface Inx_Api_Mail_Attachment
{
    
    /**
     * Returns the file name of a regular attachment or the image identifier of an embedded image. 
     * An embedded image is referenced in a message body using an &lt;img&gt; tag, as follows:
     * 
     * <pre>
     * 	<img src="cid:Image-Identifier">
     * </pre> 
     *  
     * @return	string the file name of a regular attachment or the image identifier of an embedded image.
     */
    public function getName();

    
    /**
     * Returns the MIME type of this attachment, e.g. <i>application/pdf</i> or <i>image/gif</i>.
     * 
     * @return	string the MIME type of this attachment.
     */
    public function getContentType();

    
    /**
     * Return the size of the content of this attachment in bytes.
     * 
     * @return	int the size of the content of this attachment in bytes.
     */
    public function getSize();

    
    /**
     * Returns an input stream of the content of this attachment. 
     * This method is used to download the content of this attachment.
     * 
     * @return	Inx_Api_InputStream an input stream of the content of this attachment.
     */
    public function getContent();
    
}
