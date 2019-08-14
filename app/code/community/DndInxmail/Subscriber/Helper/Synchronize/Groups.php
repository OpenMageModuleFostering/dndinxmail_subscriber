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
class DndInxmail_Subscriber_Helper_Synchronize_Groups extends DndInxmail_Subscriber_Helper_Abstract
{

    /**
     *
     */
    const CUSTOMERS_PER_PASS = 'dndinxmail_subscriber_crons/crons_synchronize_groups/customers_per_pass';

    /**
     * Format emails for synchronization
     *
     * @return array
     */
    public function initSynchronization()
    {
        $pass             = array();
        $customersPerPass = $this->getCustomersPerPass();
        $groupHelper      = Mage::helper('dndinxmail_subscriber/group');
        $groupsConfig     = $groupHelper->getCustomerGroupsConfig();
        if (count($groupsConfig) <= 0) {
            return array();
        }
        $group = 0;

        $isSession = (!$session = Mage::helper('dndinxmail_subscriber/synchronize')->openInxmailSession()) ? false : true;

        foreach ($groupsConfig as $groupId) {

            $listName = $groupHelper->formatInxmailListName($groupId);
            $emails   = $groupHelper->getCustomersFromGroup($groupId);

            if ($isSession) {
                try {
                    if ($list = $session->getListContextManager()->findByName($listName)) {
                        Mage::helper('dndinxmail_subscriber/synchronize')->truncateSpecificInxmailList($list);
                    }
                }
                catch (Exception $e) {

                }
            }

            if (!$emails) {
                continue;
            }

            $currentPass = 0;
            $i           = 0;
            foreach ($emails as $email) {

                $subscriber = Mage::getModel('newsletter/subscriber')->loadByEmail($email);
                if (!$subscriber instanceof Varien_Object || !$subscriber->getSubscriberId()) {
                    continue;
                }
                if (!$subscriber->isSubscribed()) {
                    continue;
                }

                $pass[$group][$currentPass][] = $email;

                if ($i % $customersPerPass == $customersPerPass - 1) {
                    $currentPass++;
                }

                $i++;
            }

            if ($i == 0) {
                continue;
            }

            $pass[$group]['total'] = count($pass[$group]);
            $pass[$group]['name']  = $listName;

            $group++;
        }

        $pass['total'] = count($pass);

        Mage::helper('dndinxmail_subscriber/synchronize')->closeInxmailSession();

        return $pass;
    }

    /**
     * Get customer per pass
     *
     * @return int
     */
    public function getCustomersPerPass()
    {
        $config = Mage::getStoreConfig(self::CUSTOMERS_PER_PASS);

        return ($config != '' && $config != null) ? $config : 50;
    }

}