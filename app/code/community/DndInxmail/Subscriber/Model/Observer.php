<?php

/**
 * @category               Module Observer
 * @package                DndInxmail_Subscriber
 * @dev                    Merlin
 * @last_modified          13/03/2013
 * @copyright              Copyright (c) 2012 Agence Dn'D
 * @author                 Agence Dn'D - Conseil en creation de site e-Commerce Magento : http://www.dnd.fr/
 * @license                http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class DndInxmail_Subscriber_Model_Observer
{

    /**
     * Observe action when a new subscriber is created and subscribe/unsubscribe his address
     *
     * @param object $observer
     *
     * @return boolean
     */
    public function observeSubscriber($observer)
    {
        try {
            if (!Mage::helper('dndinxmail_subscriber')->isDndInxmailEnabled()) {
                return false;
            }

            $synchronize = Mage::helper('dndinxmail_subscriber/synchronize');

            $event      = $observer->getEvent();
            $subscriber = $event->getDataObject();
            if ($subscriber->getNotSyncInxmail()) {
                return false;
            }
            $email      = $subscriber->getSubscriberEmail();
            $status     = $subscriber->getStatus();
            $storeId    = $subscriber->getStoreId();

            if (!$session = $synchronize->openInxmailSession()) {
                return false;
            }

            if (!$listid = (int)$synchronize->getSynchronizeListId($storeId)) {
                return false;
            }

            $listContextManager = $session->getListContextManager();
            $inxmailList        = $listContextManager->get($listid);

            Mage::helper('dndinxmail_subscriber/synchronize')->switchActionToSubscriberStatus($status, $email, true, $inxmailList);

            $synchronize->closeInxmailSession();

            return true;
        }
        catch (Exception $e) {
            Mage::helper('dndinxmail_subscriber/log')->logExceptionData($e->getMessage(), __FUNCTION__);

            return false;
        }
    }

    /**
     * Observe when a subscriber is deleted
     *
     * @param object $observer
     *
     * @return boolean
     */
    public function deleteSubscriber($observer)
    {
        try {
            if (!Mage::helper('dndinxmail_subscriber')->isDndInxmailEnabled()) {
                return false;
            }

            $synchronize = Mage::helper('dndinxmail_subscriber/synchronize');

            $event      = $observer->getEvent();
            $subscriber = $event->getDataObject();
            $email      = $subscriber->getSubscriberEmail();
            $storeId    = $subscriber->getStoreId();

            if (!$session = $synchronize->openInxmailSession()) {
                return false;
            }

            if (!$listid = (int)$synchronize->getSynchronizeListId($storeId)) {
                return false;
            }

            $listContextManager = $session->getListContextManager();
            $inxmailList        = $listContextManager->get($listid);

            Mage::helper('dndinxmail_subscriber/synchronize')->removeCustomer($email, $inxmailList);

            $synchronize->closeInxmailSession();

            return true;
        }
        catch (Exception $e) {
            Mage::helper('dndinxmail_subscriber/log')->logExceptionData($e->getMessage(), __FUNCTION__);

            return false;
        }
    }

    /**
     * Synchronize unsubscribed from Inxmail to Magento
     *
     * @return boolean
     */
    public function synchronizeUnsubscribed()
    {
        try {
            if (!Mage::helper('dndinxmail_subscriber')->isDndInxmailEnabled()) {
                return false;
            }

            $synchronize = Mage::helper('dndinxmail_subscriber/synchronize');
            $currentDate = time();
            $lastUnsubscribedTime = Mage::helper('dndinxmail_subscriber/flag')->getLastUnsubscribedTime();
            foreach (Mage::app()->getWebsites() as $website) {
                foreach ($website->getGroups() as $group) {
                    $stores = $group->getStores();
                    foreach ($stores as $store) {
                        if (is_null($lastUnsubscribedTime)) {
                            $unsubscribedCustomers = $synchronize->getUnsubscribedCustomers($store->getStoreId());
                        } else {
                            $lastUnsubscribedDate = date('c', $lastUnsubscribedTime - 60);
                            $unsubscribedCustomers = $synchronize->getUnsubscribedAfterDate(
                                $store->getStoreId(),
                                $lastUnsubscribedDate
                            );
                        }

                        // Emulate store that is synchronized to get correct email subscription by store
                        $appEmulation = Mage::getSingleton('core/app_emulation');
                        $initialEnvironmentInfo = $appEmulation->startEnvironmentEmulation($store->getStoreId());
                        $synchronize->unsubscribeCustomersFromMagentoByEmails($unsubscribedCustomers, $store->getStoreId());
                        $appEmulation->stopEnvironmentEmulation($initialEnvironmentInfo);
                    }
                }
            }
            Mage::helper('dndinxmail_subscriber/flag')->saveLastUnsubscribedTimeFlag($currentDate);

            $synchronize->unsubscribeCustomersFromGroups();

            return true;
        }
        catch (Exception $e) {
            Mage::helper('dndinxmail_subscriber/log')->logExceptionData($e->getMessage(), __FUNCTION__);

            return false;
        }
    }

    /**
     * Synchronize customer group to Inxmail
     *
     * @return boolean
     */
    public function synchronizeCustomerGroup()
    {
        try {
            if (!Mage::helper('dndinxmail_subscriber')->isDndInxmailEnabled()) {
                return false;
            }

            Mage::helper('dndinxmail_subscriber/synchronize')->synchronizeCustomerGroupToInxmail();

            return true;
        }
        catch (Exception $e) {
            Mage::helper('dndinxmail_subscriber/log')->logExceptionData($e->getMessage(), __FUNCTION__);

            return false;
        }
    }

}