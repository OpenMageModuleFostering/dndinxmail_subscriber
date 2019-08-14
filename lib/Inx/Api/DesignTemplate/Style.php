<?php
/**
 * @package Inxmail
 * @subpackage DesignTemplate
 */

/**
 * An <i>Inx_Api_DesignTemplate_Style</i> defines the visual representation of a particular template or mailing. 
 * The style will be used to render the mailing.
 * <p>
 * For more information on templates, see the <i>Inx_Api_DesignTemplate_Template</i> documentation.
 * 
 * @see Inx_Api_DesignTemplate_Template 
 * @since API 1.4.0
 * @version $Revision: 9497 $Date: 2007-01-25 15:00:09 $ $Author: nds$
 * @package Inxmail
 * @subpackage DesignTemplate
 */
interface Inx_Api_DesignTemplate_Style
{
	/**
	 * Returns the id of the template, which contains this style.
	 * @return int the id of the template, which contains this style.
	 */
	public function getTemplateId();
	
	/**
	 * Returns the name of this style. 
	 * @return string the name of this style.
	 */
	public function getStyleName();
}
