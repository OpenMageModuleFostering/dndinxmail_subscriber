<?php

/**
 * @category               Module Model
 * @package                DndInxmail_Subscriber
 * @dev                    Merlin
 * @last_modified          18/03/2013
 * @copyright              Copyright (c) 2012 Agence Dn'D
 * @author                 Agence Dn'D - Conseil en creation de site e-Commerce Magento : http://www.dnd.fr/
 * @license                http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class DndInxmail_Subscriber_Model_Adminhtml_System_Config_Backend_Date extends Mage_Core_Model_Config_Data
{

    /**
     * Cron settings after save
     *
     * @return boolean
     */
    protected function _beforeSave()
    {
        if (!Mage::helper('dndinxmail_subscriber')->isDndInxmailEnabled()) return false;

        $value = $this->getValue();

        if ($value == '' || $value == null) {
            $format = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);
            $date   = Mage::app()->getLocale()->date(time(), Varien_Date::DATETIME_INTERNAL_FORMAT)->toString($format);
            $this->setValue($date);
        }

        return true;
    }

}