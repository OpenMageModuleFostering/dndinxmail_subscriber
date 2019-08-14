<?php

class DndInxmail_Subscriber_Helper_Config extends DndInxmail_Subscriber_Helper_Abstract
{
    const OPTIN_CONTROL_INXMAIL = 1;
    const OPTIN_CONTROL_MAGENTO = 2;

    const CONFIG_IS_SYNCHRONIZED = 'dndinxmail_subscriber/synchronize_subscribers/is_synchronized';
    const CONFIG_OPTIN = 'dndinxmail_subscriber_general/general/optin_control';
    const CONFIG_INXMAIL_IMAGES_FOLDER = 'dndinxmail_subscriber_datasource/general/images_folder';

    /**
     * @param $store
     *
     * @return bool
     */
    public function isSynchronized($store = null)
    {
        return $this->getConfig(self::CONFIG_IS_SYNCHRONIZED, $store);
    }

    /**
     * @return string
     */
    public function getOptinControl()
    {
        return $this->getConfig(self::CONFIG_OPTIN);
    }

    /**
     * @return bool
     */
    public function isInxmailUsedOptinControl()
    {
        return ((int)$this->getOptinControl() === self::OPTIN_CONTROL_INXMAIL);
    }

    /**
     * @return string
     */
    public function getInxmailImagesFolder()
    {
        return $this->getConfig(self::CONFIG_INXMAIL_IMAGES_FOLDER);
    }

    /**
     * @param $value
     * @param string $scope
     * @param null $scopeId
     */
    public function setIsSynchronized($value = true, $scope = 'stores', $scopeId = null)
    {
        if (is_null($scopeId)) {
            switch ($scope) {
                case 'stores':
                    $scopeId = Mage::app()->getStore()->getId();
                    break;
                case 'websites':
                    $scopeId = Mage::app()->getWebsite()->getId();
                    break;
                default:
                    $scopeId = Mage::app()->getStore()->getId();
            }
        }
        $config = Mage::app()->getConfig();
        $config->saveConfig(self::CONFIG_IS_SYNCHRONIZED, $value, $scope, $scopeId);
        $config->cleanCache();
    }
}
