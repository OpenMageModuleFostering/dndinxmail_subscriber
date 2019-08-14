<?php
/**
 * @package Inxmail
 * @subpackage DesignTemplate
 */
/**
 * An <i>Inx_Api_DesignTemplate_Template</i> provides a common structure for complex multipart mailings. 
 * A template may contain multiple (but at least one) text and HTML style which is used to render the mailing. 
 * Multiple <i>Inx_Api_DesignTemplate_Template</i>s can be stored in an <i>Inx_Api_DesignTemplate_DesignCollection</i>.
 * 
 * @see Inx_Api_DesignTemplate_Style
 * @see Inx_Api_DesignTemplate_DesignCollection
 * @since API 1.4.0
 * @version $Revision: 9497 $Date: 2007-01-25 15:00:09 $ $Author: nds$
 * @package Inxmail
 * @subpackage DesignTemplate
 */
interface Inx_Api_DesignTemplate_Template
{
	/**
	 * Returns the name of the template.
	 * 
	 * @return string the name of the template.
	 */
	public function getName();

	/**
	 * Returns the id of the template.
	 * 
	 * @return int the id of the template.
	 */
	public function getId();

	/**
	 * Returns all text <code>Style</code>s in this template. The default text style, which should be used for a
	 * multipart mailing, if there is no appropriate text style for the chosen HTML style, is the first in the array.
	 * 
	 * @return array all text <i>Inx_Api_DesignTemplate_Style</i>s of this template. 
	 * The default text style is the first in the array.
	 */
	public function getTextStyles();

	/**
	 * Returns all HTML <i>Inx_Api_DesignTemplate_Style</i>s in this template. 
	 * Note, that to generate a multipart mailing, the HTML style should be passed on to the <i>Inx_Api_Mailing_XsltContentHandler</i>.
	 * 
	 * @return array all HTML styles of this template.
	 */
	public function getHTMLStyles();
}
