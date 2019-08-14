<?php
/**
 * @package Inxmail
 * @subpackage TriggerMail
 */

/**
 * The <code>Attachment</code> object represents a regular attachment or an embedded image of a trigger mailing and is
 * part of the <code>TriggerMailContent</code> object.
 * 
 * @see com.inxmail.xpro.api.triggermail.TriggerMailContent#getAttachments()
 * @see com.inxmail.xpro.api.triggermail.TriggerMailContent#getEmbeddedImages()
 * @since API 1.10.0
 * @author chge, 09.07.2012
 */
interface Inx_Api_TriggerMail_Attachment
{

	/**
	 * Returns the file name of a regular attachment or the image identifier of an embedded image. An embedded image is
	 * referenced in a message body using an &lt;img&gt; tag, as follows:
	 * 
	 * <pre>
	 * 	&lt;img src="cid:Image-Identifier"&gt;
	 * </pre>
	 * 
	 * @return the file name of a regular attachment or the image identifier of an embedded image.
	 */
	public function getName();


	/**
	 * Returns the MIME type of this attachment, e.g. <code>application/pdf</code> or <code>image/gif</code>.
	 * 
	 * @return the MIME type of this attachment.
	 */
	public function getContentType();


	/**
	 * Return the size of the content of this attachment in bytes.
	 * 
	 * @return the size of the content of this attachment in bytes.
	 */
	public function getSize();


	/**
	 * Returns an input stream of the content of this attachment. This method is used to download the content of this
	 * attachment.
	 * 
	 * @return an input stream of the content of this attachment.
	 */
	public function getContent();
}