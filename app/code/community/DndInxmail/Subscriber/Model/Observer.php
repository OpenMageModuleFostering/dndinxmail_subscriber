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
    const TRIGER_EMAIL_REGISTRY = 'dndinxmail_trigger_email';

    /**
     * Observe action when a new subscriber is created and subscribe/unsubscribe his address
     *
     * @param object $observer
     *
     * @return boolean
     */
    public function observeSubscriber(Varien_Event_Observer $observer)
    {
        try {
            if (!Mage::helper('dndinxmail_subscriber')->isDndInxmailEnabled()) {
                return false;
            }

            $synchronize = Mage::helper('dndinxmail_subscriber/synchronize');

            $subscriber = $observer->getDataObject();

            // Set import mode to not send any transactional emails related to newsletter subscription
            $this->disableEmails($observer);

            if ($subscriber->getNotSyncInxmail()) {
                return false;
            }
            $trigger = false;
            if (Mage::registry(self::TRIGER_EMAIL_REGISTRY)) {
                $trigger = true;
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
            $synchronize->doMappingCheck();
            
            $listContextManager = $session->getListContextManager();
            $inxmailList        = $listContextManager->get($listid);

            Mage::helper('dndinxmail_subscriber/synchronize')->switchActionToSubscriberStatus($status, $email, $trigger, $inxmailList);

            $synchronize->closeInxmailSession();

            return true;
        }
        catch (Exception $e) {
            Mage::helper('dndinxmail_subscriber/log')->logExceptionData($e->getMessage(), __FUNCTION__);

            return false;
        }
    }

    /**
     * Set import mode to not send any transactional emails related to newsletter subscription
     *
     * @param Varien_Event_Observer $observer
     */
    public function disableEmails(Varien_Event_Observer $observer)
    {
        // Set import mode to not send any transactional emails related to newsletter subscription
        if (Mage::helper('dndinxmail_subscriber')->isDndInxmailEnabled()
            && Mage::helper('dndinxmail_subscriber/config')->isInxmailUsedOptinControl()
        ) {
            $subscriber = $observer->getDataObject();
            $subscriber->setImportMode(true);
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
            foreach (Mage::app()->getWebsites() as $website) {
                foreach ($website->getGroups() as $group) {
                    $stores = $group->getStores();
                    foreach ($stores as $store) {
                        $storeId = $store->getStoreId();
                        $lastUnsubscribedTime = Mage::helper('dndinxmail_subscriber/flag')->getUnsubscribedTime($storeId);
                        if (is_null($lastUnsubscribedTime)) {
                            $unsubscribedCustomers = $synchronize->getUnsubscribedCustomers($storeId);
                        } else {
                            $lastUnsubscribedDate = date('c', $lastUnsubscribedTime - 60);
                            $unsubscribedCustomers = $synchronize->getUnsubscribedAfterDate(
                                $storeId,
                                $lastUnsubscribedDate
                            );
                        }

                        // Emulate store that is synchronized to get correct email subscription by store
                        $appEmulation = Mage::getSingleton('core/app_emulation');
                        $initialEnvironmentInfo = $appEmulation->startEnvironmentEmulation($storeId);
                        $synchronize->unsubscribeCustomersFromMagentoByEmails($unsubscribedCustomers, $storeId);
                        $appEmulation->stopEnvironmentEmulation($initialEnvironmentInfo);
                        Mage::helper('dndinxmail_subscriber/flag')->saveUnsubscribedTimeFlag($currentDate, $storeId);
                    }
                }
            }

            $currentDate = time();
            $groupUnsubscribedTime = Mage::helper('dndinxmail_subscriber/flag')->getGroupUnsubscribedTime();
            if (!is_null($groupUnsubscribedTime)) {
                $groupUnsubscribedTime -= 60;
            }
            $synchronize->unsubscribeCustomersFromGroups($groupUnsubscribedTime);
            Mage::helper('dndinxmail_subscriber/flag')->saveGroupUnsubscribedTimeFlag($currentDate);

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
            $currentDate = time();
            Mage::helper('dndinxmail_subscriber/synchronize')->synchronizeCustomerGroupToInxmail();
            Mage::helper('dndinxmail_subscriber/flag')->saveGroupUnsubscribedTimeFlag($currentDate);

            return true;
        }
        catch (Exception $e) {
            Mage::helper('dndinxmail_subscriber/log')->logExceptionData($e->getMessage(), __FUNCTION__);

            return false;
        }
    }

    public function setEmailTrigger()
    {
        $request        = Mage::app()->getRequest();
        $routeName      = $request->getRequestedRouteName();
        $controllerName = $request->getRequestedControllerName();
        $actionName     = $request->getRequestedActionName();
        $isLoggedIn = Mage::getSingleton('customer/session')->isLoggedIn();
        if ((!$isLoggedIn && $routeName == 'checkout')
            || ($routeName == 'customer' && $controllerName == 'account' && $actionName == 'createpost')
            || ($routeName == 'newsletter' && $controllerName == 'subscriber' && $actionName == 'new')
            || ($routeName == 'newsletter' && $controllerName == 'manage' && $actionName == 'save')
        ) {
            Mage::register(self::TRIGER_EMAIL_REGISTRY, true);
        }
    }
}