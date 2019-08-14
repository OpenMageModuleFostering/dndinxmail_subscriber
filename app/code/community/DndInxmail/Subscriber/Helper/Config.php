<?php

class DndInxmail_Subscriber_Helper_Config extends DndInxmail_Subscriber_Helper_Abstract
{
    const CONFIG_IS_SYNCHRONIZED = 'dndinxmail_subscriber/synchronize_subscribers/is_synchronized';

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
                default:
                    $scopeId = Mage::app()->getStore()->getId();
            }
        }
        $config = Mage::app()->getConfig();
        $config->saveConfig(self::CONFIG_IS_SYNCHRONIZED, $value, $scope, $scopeId);
        $config->cleanCache();
    }
}
 