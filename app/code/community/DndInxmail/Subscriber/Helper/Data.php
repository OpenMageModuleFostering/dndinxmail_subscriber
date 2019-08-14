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
class DndInxmail_Subscriber_Helper_Data extends DndInxmail_Subscriber_Helper_Abstract
{

    /**
     * Check if DndInxmail_Subscriber is enabled
     *
     * @return boolean
     */
    public function isDndInxmailEnabled()
    {
        if ($this->getConfig('dndinxmail_subscriber_general/general/active') == 0) {
            return false;
        }

        $valid = true;

        if ($this->getConfig(DndInxmail_Subscriber_Helper_Synchronize::DNDINXMAIL_API_URL) == '') {
            Mage::getSingleton('adminhtml/session')->addError('Inxmail Configuration Error: URL field is empty');
            $valid = false;
        }

        if ($this->getConfig(DndInxmail_Subscriber_Helper_Synchronize::DNDINXMAIL_API_USER) == '') {
            Mage::getSingleton('adminhtml/session')->addError('Inxmail Configuration Error: API User field is empty');
            $valid = false;
        }

        if ($this->getConfig(DndInxmail_Subscriber_Helper_Synchronize::DNDINXMAIL_API_PASSWORD) == '') {
            Mage::getSingleton('adminhtml/session')->addError('Inxmail Configuration Error: API Password field is empty');
            $valid = false;
        }

        return $valid;
    }

    /**
     * Get Magento encryption key
     *
     * @return string
     */
    public function getHashKey()
    {
        return (string)Mage::getConfig()->getNode('global/crypt/key');
    }

    /**
     * Check if data is Magento encryption key
     *
     * @param string $hashKey Data to check
     *
     * @return boolean
     */
    public function isHashKeyAllowed($hashKey)
    {
        return ($hashKey == $this->getHashKey()) ? true : false;
    }

}