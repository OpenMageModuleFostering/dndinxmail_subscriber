<?php
/**
 * @package Inxmail
 * @subpackage DesignTemplate
 */
/**
 * An <i>Inx_Api_DesignTemplate_DesignCollection</i> represents a set of templates which are stored in an itc file. 
 * Templates can be used to create complex multipart mailings which are based on a common structure defined by the template. 
 * Templates simplify the creation of such mailings by using a specialized editor which aids in the structuring of the mailing.
 * <p>
 * The following design collection data can be retrieved:
 * <ul>
 * <li><i>Collection name</i>: the technical name of the design collection.
 * <li><i>Display name</i>: the display name of the design collection.
 * <li><i>Collection vendor</i>: the name of the design collection vendor.
 * <li><i>Vendor URL</i>: the uniform resource locator (URL) of the vendor (i.e. the vendors web site).
 * <li><i>Collection version</i>: the version of the design collection.
 * <li><i>Last modification date</i>: the date when the design collection was imported (the last time).
 * <li><i>Contained templates</i>: the templates contained by the design collection.
 * </ul>
 * <p>
 * Note: All data provided by <i>Inx_Api_DesignTemplate_DesignCollection</i> is read only!
 * <p>
 * For an example on how to import and use design collections, see the <i>Inx_Api_DesignTemplate_DesignCollectionManager</i> 
 * documentation.
 * 
 * @see Inx_Api_DesignTemplate_DesignCollectionManager
 * @see Inx_Api_DesignTemplate_Template
 * @since API 1.4.0
 * @version $Revision: 9553 $Date: 2007-01-25 15:00:09 $ $Author: nds$
 * @package Inxmail
 * @subpackage DesignTemplate
 */
interface Inx_Api_DesignTemplate_DesignCollection extends Inx_Api_BusinessObject
{
	/**
	 * Returns the technical name of the design collection.
	 * 
	 * @return string the technical name of the design collection.
	 */
	public function getName();

   /**
	* Returns the display name of the design collection.
	*
	* @return string the display name of the design collection.
	* @since API 1.9.0
	*/
	public function getDisplayName();
	
	/**
	 * Returns the name of the design collection vendor.
	 * 
	 * @return string the name of the design collection vendor.
	 */
	public function getVendor();

	/**
	 * Returns the uniform resource locator (URL) of the vendor (i.e. the vendors web site).
	 * 
	 * @return string the URL of the design collection vendor.
	 */
	public function getVendorURL();

	/**
	 * Returns the version of the design collection.
	 * 
	 * @return string the version of the design collection.
	 */
	public function getVersion();

	/**
	 * Returns the date when the design collection was imported (the last time).
	 * 
	 * @return string the date of the last modification of the design collection. 
	 * The date will be returned as ISO 8601 formatted datetime string.
	 */
	public function getLastModificationDate();

	/**
	 * Returns all templates contained by this design collection.
	 * 
	 * @return an array of all <i>Inx_Api_DesignTemplate_Template</i>s contained by this design collection.
	 */
	public function getTemplates();
}