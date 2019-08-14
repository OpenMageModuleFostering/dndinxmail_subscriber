<?php
/**
 * @package Inxmail
 * @subpackage DesignTemplate
 */
/**
 * The <i>Inx_Api_DesignTemplate_DesignCollectionMananger</i> can be used to access <i>Inx_Api_DesignTemplate_DesignCollection</i>s. 
 * You can import design collections from itc files into a specific list or all lists (by using the <i>SystemListContext</i>). 
 * You can also retrieve the collections available in a specific list or all lists (by ommitting the list parameter).
 * <p>
 * <i>Inx_Api_DesignTemplate_DesignCollection</i>s are returned in an <i>Inx_Api_BOResultSet</i> that may be used to access 
 * the individual collections. 
 * <i>Inx_Api_DesignTemplate_DesignCollection</i>s may contain multiple templates with possibly multiple text and HTML styles. 
 * These styles can be used to create new mailings based on the chosen template.
 * <p>
 * The following snippet shows how to generate a mailing based on a newly imported design collection:
 * 
 * <pre>
 * $oListContext = $oSession->getListContextManager()->findByName( &quot;Name of the desired List&quot; );
 * $oMailing = $oSession->getMailingManager()->createMailing( $oListContext );
 * $oMailing->setContentHandler( &quot;Inx_Api_Mailing_XsltMultiPartContentHandler&quot; );
 * 
 * $oDesignCollectionManager = $oSession->getDesignCollectionManager();
 * 
 * $stream = fopen( &quot;test.itc&quot;, &quot;rb&quot;);
 * 
 * $oDesignCollection = $oDesignCollectionManager->importDesignCollection( $stream, $oListContext );
 * fclose($stream);
 * $aTemplates = $oDesignCollection->getTemplates();
 * 
 * $oContentHandler = $oMailing->getContentHandler();
 * $aStyles = $aTemplates[0]->getHTMLStyles();
 * $oContentHandler->updateStyle( $aStyles[0] );
 * 
 * $oMailing->commitUpdate();
 * </pre>
 * 
 * </p>
 * <p>
 * The following snippet shows how to list all available HTML styles of all design collections in a certain list:
 * 
 * <pre>
 * $oDesignCollectionManager = $oSession->getDesignCollectionManager();
 * 
 * $oListContext = $oSession->getListContextManager()->findByName( &quot;Name of the desired List&quot; );
 * 
 * $oBOResultSet = $oDesignCollectionManager->select($oListContext);
 * 
 * for( $i = 0; $i&lt;$oBOResultSet->getSize(); $i++)
 * {
 *  $oDesignCollection = $oBOResultSet->get($i);
 *  echo $oDesignCollection->getVendor();
 *  echo $oDesignCollection->getVendorURL();
 *  ...
 *  $aTemplates = $oDesignCollection->getTemplates();
 *  for($j = 0; $j&lt;count($aTemplates); $j++)
 *  {
 *   $oTemplate = $aTemplates[j];
 *   echo $oTemplate->getName();
 *   echo $oTemplate->getId();
 *   $aHtmlStyles = $oTemplate->getHTMLStyles();
 *   for ($k = 0; $k&lt;count($aHtmlStyles); $k++)
 *   {
 *    echo $aHtmlStyles[k]->getTemplateID();
 *    echo $aHtmlStyles[k]->getStyleName();
 *   }
 *  }
 * }
 * 
 * $oBOResultSet->close();
 * </pre>
 * 
 * </p>
 * Note: The usage of <i>Inx_Api_DesignTemplate_DesignCollection</i>s requires the api user right: 
 * <i>Inx_Api_UserRights::TEMPLATE_FEATURE_USE</i>
 * <p>
 * For more information on design collections, see the <i>Inx_Api_DesignTemplate_DesignCollection</i> documentation.
 * 
 * @see Inx_Api_DesignTemplate_DesignCollection
 * @since API 1.4.0
 * @version $Revision: 9553 $ $Date: 2008-01-04 11:28:41 +0200 (Pn, 04 Sau 2008) $ $Author: vladas $
 * @package Inxmail
 * @subpackage DesignTemplate
 */

interface Inx_Api_DesignTemplate_DesignCollectionManager extends Inx_Api_BOManager
{
	/**
	 * Imports the desired itc file into the specified list to be used there. Importing an itc into the system list will
	 * make the design collection available in all lists. The following snippet retrieves the system list context:
	 * <PRE>
	 * $oListContextManager = $oSession->getListContextManager();
	 * $oListContextc = $oListContextManager->findByName( Inx_Api_SystemListContext::NAME );
	 * </PRE>
	 * 
	 * @param resource $rbItcFile the itc file handle from which the itc file will be read.
	 * @param Inx_Api_List_ListContext $oCxt the list to import the design collection into.
	 * @return Inx_Api_DesignTemplate_DesignCollection the generated <i>Inx_Api_DesignTemplate_DesignCollection</i>.
	 * @throws Inx_Api_IOException if the resource cannot be read.
	 * @throws Inx_Api_DesignTemplate_ImportException if an error occurred while importing the itc file.
	 * @throws Inx_Api_FeatureNotAvailableException if the design template feature is not available in the given list. 
 	 *			This exception is thrown since API 1.9.0.
	 */
	public function importDesignCollection( $rbItcFile, Inx_Api_List_ListContext $oCxt );

	/**
	 * Returns the <i>Inx_Api_DesignTemplate_DesignCollection</i>s available in the specified list. 
	 * To retrieve all design collections from all lists, pass on a <i>null</i> value.
	 * 
	 * @param Inx_Api_List_ListContext $oListContext all design collections available in this list will be returned.
	 * @return Inx_Api_BOResultSet an <i>Inx_Api_BOResultSet</i> containing the fetched 
	 * <i>Inx_Api_DesignTemplate_DesignCollection</i>s.
	 */
	public function select( Inx_Api_List_ListContext $oListContext );
	


	/**
	 * Returns the preview image, provided by the design collection. Can be null, if no image was provided.
	 * This method does not return an actual screenshot of a mailing generated with this 
	 * <i>Inx_Api_DesignTemplate_Style</i>, but an image provided and generated by the design collection author.
	 * 
	 * @return Inx_Api_InputStream an <i>Inx_Api_InputStream</i> containing the image data.
	 * @throws Inx_Api_NullPointerException when the passed style is <i>null</i>.
	 */
	public function createPreviewImageStream( Inx_Api_DesignTemplate_Style $oStyle );
}
