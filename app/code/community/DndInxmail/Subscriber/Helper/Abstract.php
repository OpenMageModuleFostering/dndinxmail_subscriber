<?php

/**
 * @category               Module Helper
 * @package                DndInxmail_Subscriber
 * @dev                    Merlin
 * @last_modified          13/03/2013
 * @copyright              Copyright (c) 2012 Agence Dn'D
 * @author                 Agence Dn'D - Conseil en creation de site e-Commerce Magento : http://www.dnd.fr/
 * @license                http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class DndInxmail_Subscriber_Helper_Abstract extends Mage_Core_Helper_Abstract
{

    /**
     * Get Magento store configuration
     *
     * @param string $path XML configuration path
     * @param string $store Store ID of configuration. If not set then current store ID
     *
     * @return string Magento configuration
     */
    public function getConfig($path, $store = null)
    {
        $store = ($store == null) ? Mage::app()->getStore()->getId() : $store;

        return Mage::getStoreConfig($path, $store);
    }

    /**
     * Create directory if not exist
     *
     * @param string $dir Directory path
     *
     * @return boolean
     */
    public function createDirIfNotExists($dir)
    {
        if (file_exists($dir)) {
            if (!is_dir($dir)) {
                return false;
            }
            if (!is_dir_writeable($dir)) {
                return false;
            }
        }
        else {
            $oldUmask = umask(0);
            if (!@mkdir($dir, 0777, true)) {
                return false;
            }
            umask($oldUmask);
        }

        return true;
    }

}