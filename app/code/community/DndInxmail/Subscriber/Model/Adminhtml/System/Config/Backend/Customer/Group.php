<?php

/**
 * @category               Module Model
 * @package                DndInxmail_Subscriber
 * @dev                    Merlin
 * @last_modified          13/03/2013
 * @copyright              Copyright (c) 2012 Agence Dn'D
 * @author                 Agence Dn'D - Conseil en creation de site e-Commerce Magento : http://www.dnd.fr/
 * @license                http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class DndInxmail_Subscriber_Model_Adminhtml_System_Config_Backend_Customer_Group extends Mage_Core_Model_Config_Data
{

    /**
     * Format attributes to synchronize in Inxmail after saving in admin
     *
     * @return boolean
     */
    protected function _afterSave()
    {
        if (!Mage::helper('dndinxmail_subscriber')->isDndInxmailEnabled()) return false;

        $value   = $this->getValue();
        $session = Mage::getSingleton('adminhtml/session');

        $synchronize = Mage::helper('dndinxmail_subscriber/synchronize');
        $groupHelper = Mage::helper('dndinxmail_subscriber/group');

        $newGroups = $groupHelper->formatCustomerGroups($value);
        $oldGroups = $groupHelper->getCustomerGroupsConfig();

        if (in_array(DndInxmail_Subscriber_Model_Adminhtml_System_Config_Source_Group_Specific::DNDINXMAIL_MAPPING_CUSTOMER_GROUP_SPECIFIC_BIRTHDAY, $newGroups) && !$groupHelper->isDobEnabled()) {
            $message = Mage::helper('dndinxmail_subscriber')->__('You have selected the Birthday group even though the date of birth is not enabled on your shop');
            $session->addNotice($message);
        }

        $created = array_filter(array_diff($newGroups, $oldGroups));

        $deleted = array_filter(array_diff($oldGroups, $newGroups));

        $groups = array(
            DndInxmail_Subscriber_Helper_Synchronize::DNDINXMAIL_CUSTOMER_MAPPING_STATUS_CREATED => $created,
        );

        if (count($created) == 0 && count($deleted) == 0) return false;

        try {
            $synchronize->synchronizeCustomerGroups($groups);
        }
        catch (Exception $e) {
            Mage::helper('dndinxmail_subscriber/log')->logExceptionData($e->getMessage(), __FUNCTION__);

            return false;
        }

        return true;
    }

}