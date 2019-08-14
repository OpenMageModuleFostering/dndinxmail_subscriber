<?php

/**
 * @category               Module Helper
 * @package                DndInxmail_Subscriber
 * @dev                    Alexander Velykzhanin
 * @last_modified          12/10/2015
 * @copyright              Copyright (c) 2015 Flagbit GmbH & Co. KG
 * @author                 Flagbit GmbH & Co. KG : https://www.flagbit.de/
 * @license                http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class DndInxmail_Subscriber_Helper_Version extends Mage_Core_Helper_Abstract
{
    /**
     * @return string
     */
    public function getSourceIdentifierString()
    {
        return sprintf('Magento %s - Inx %s', Mage::getVersion(), $this->getInxmailVersion());
    }

    /**
     * @return string
     */
    public function getInxmailVersion()
    {
        return Mage::getConfig()->getModuleConfig('DndInxmail_Subscriber')->version;
    }
}