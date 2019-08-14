<?php

/**
 * @package Inxmail
 * @subpackage Plugin
 */
/**
 * The <i>Inx_Api_Plugin_PluginStore</i> is used by plug-ins for storing small amounts of data on the Inxmail 
 * Professional system. 
 * Each plug-in may only use its isolated storage, identified by the plug-in secret. 
 * The data is allocated using unique keys.
 * <p>
 * <strong>Note:</strong> It is <strong>strongly recommended</strong> to upload a maximum of 1 MB of data. 
 * Uploading too much data may significantly reduce the performance of the server.
 * <p>
 * The following snippet shows how to upload an image to the plug-in store of a plug-in with the secret id
 * "plug-in secret":
 * 
 * <pre>
 * $oPluginStore = $oSession->getPluginStore();
 * $handle = fopen("test.png","r");
 * $oPluginStore->put("plug-in secret","test-image",$handle);
 * </pre>
 * <p>
 * The following snippet shows how to download the previously uploaded image for saving and displaying:
 * 
 * <pre>
 * $oPluginStore = $oSession->getPluginStore();
 * $oInputStream = $oPluginStore->get("plug-in secret", "test-image");
 *	
 * $validate = fopen("validate.png",'w') or die("can't open file");
 *	
 * while(($chunk = $oInputStream->read()) != -1)
 * {
 *	fwrite($validate,$chunk);
 * }
 *	
 * fclose($validate);
 *	
 * echo '&#60;img src="validate.png"&#62;';
 * </pre>
 * 
 * @since API 1.7.0
 * @version $Revision: 2934 $ $Date: 2005-07-04 17:00:09 +0200 (Mo, 04 Jul 2005) $ $Author: bgn $
 * @package Inxmail
 * @subpackage Plugin
 */
interface Inx_Api_Plugin_PluginStore
{

	/**
	 * Uploads data from a plug-in which needs to be stored in Inxmail Professional. 
	 * The data should be no bigger than 1 MB. 
	 * Uploading more data is <strong>strongly discouraged</strong> as it may significantly reduce the performance of the server.
	 * 
	 * @param string $secretId the secret id of the plug-in.
	 * @param string $key the key for the uploaded data.
	 * @param Inx_Api_InputStream $is the input stream to read the data from.
	 * @return bool <i>true</i> if the upload was successful, <i>false</i> otherwise.
	 */
	public function put( $secretId, $key, $is );


	/**
	 * Returns an <i>Inx_Api_InputStream</i> to download the data for the given key.
	 * 
	 * @param string $secretId the secret id of the plug-in.
	 * @param string $key the key of the data to download.
	 * @return Inx_Api_InputStream an <i>Inx_Api_InputStream</i> to download the data.
	 * @throws Inx_Api_DataException if the there is no data for that key (i.e. the key does not exist).
	 */
	public function get( $secretId, $key );


	/**
	 * Returns all keys which are stored for the given plug-in secret id.
	 * 
	 * @param string $secretId the secret id of the plug-in.
	 * @return array an array of string keys.
	 */
	public function getKeys( $secretId );


	/**
	 * Removes the given key and its value from the plug-in store. Removing an unknown key will have no effect.
	 * 
	 * @param string $secretId the secret id of the plug-in.
	 * @param string $key the key of the data which should be deleted.
	 */
	public function remove( $secretId, $key );


	/**
	 * Removes all keys from the plug-in store for the given plug-in secret id.
	 * 
	 * @param string $secretId the secret id of the plug-in.
	 */
	public function removeAll( $secretId );
}
