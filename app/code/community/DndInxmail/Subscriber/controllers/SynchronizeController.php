<?php

/**
 * @category               Module Controller
 * @package                DndInxmail_Subscriber
 * @dev                    Merlin
 * @last_modified          13/03/2013
 * @copyright              Copyright (c) 2012 Agence Dn'D
 * @author                 Agence Dn'D - Conseil en creation de site e-Commerce Magento : http://www.dnd.fr/
 * @license                http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class DndInxmail_Subscriber_SynchronizeController extends Mage_Core_Controller_Front_Action
{

    /**
     * Launch ajax Subscribers synchronization
     *
     * @return void
     */
    public function subscribersAction()
    {
        $hashKey           = $this->getRequest()->getParam('hash');
        $isAllowed         = Mage::helper('dndinxmail_subscriber')->isHashKeyAllowed($hashKey);
        $synchronize       = Mage::helper('dndinxmail_subscriber/synchronize');
        $subscribersHelper = Mage::helper('dndinxmail_subscriber/synchronize_subscribers');

        if (!$isAllowed) {
            $message = Mage::helper('dndinxmail_subscriber')->__('You are not allowed on this page.');
            Mage::getSingleton('core/session')->addError($message);
            $this->_redirect('dndinxmail_subscriber_front/messages/error/');
        }

        $store = Mage::getModel('core/store')->load($this->getRequest()->getParam('store'));
        if (!($store instanceof Varien_Object) || !$store->getStoreId()) {
            $message = Mage::helper('dndinxmail_subscriber')->__('No store set');
            Mage::getSingleton('core/session')->addError($message);
            $this->_redirect('dndinxmail_subscriber_front/messages/error/');
        }

        try {
            $unsubscribedStore = $synchronize->getUnsubscribedCustomers($store->getStoreId());

            // Emulate store that is synchronized to get correct email subscription by store
            $appEmulation = Mage::getSingleton('core/app_emulation');
            $initialEnvironmentInfo = $appEmulation->startEnvironmentEmulation($store->getStoreId());
            $synchronize->unsubscribeCustomersFromMagentoByEmails($unsubscribedStore);
            $synchronize->unsubscribeCustomersFromGroups();
            $appEmulation->stopEnvironmentEmulation($initialEnvironmentInfo);
        } catch (Exception $e) {
            $message = Mage::helper('dndinxmail_subscriber')->__('Error synchronizing unsubscribed customers from Inxmail');
            Mage::getSingleton('core/session')->addError($message);
            $this->_redirect('dndinxmail_subscriber_front/messages/error/');
        }

        $pass = $subscribersHelper->initSynchronization($store->getStoreId());

        if (!isset($pass['total']) || (isset($pass['total']) && $pass['total'] == 0)) {
            $message = Mage::helper('dndinxmail_subscriber')->__('No subscriber to synchronize.');
            Mage::getSingleton('core/session')->addError($message);
            $this->_redirect('dndinxmail_subscriber_front/messages/error/');
        }

        $pass = Zend_Json::encode($pass);

        $this->loadLayout('synchronize');

        $block = $this->getLayout()->createBlock('dndinxmail_subscriber/synchronization_subscribers')->setStoreSynchronize($store->getStoreId())->setPass($pass);

        $this->getLayout()->getBlock('content')->append($block);
        $this->renderLayout();
    }

    /**
     *
     */
    public function passSubscribersAction()
    {
        $synchronize = Mage::helper('dndinxmail_subscriber/synchronize');

        $data           = array();
        $data['failed'] = 'false';
        $data['msg']    = 'Success';

        $store = Mage::getModel('core/store')->load($this->getRequest()->getParam('store'));
        if (!($store instanceof Varien_Object) || !$store->getStoreId()) {
            $data['failed'] = 'true';
            $data['msg']    = "No store set";
        }
        $session = new Varien_Object();
        try {
            $session = $synchronize->openInxmailSession(false);
        } catch (Exception $e) {
            $data['failed'] = 'true';
            $data['msg']    = $e->getMessage();
        }

        if (!$listid = (int)$synchronize->getSynchronizeListId($store->getStoreId())) {
            $data['failed'] = 'true';
            $data['msg']    = "No list defined in configuration";
        }

        $pass = $this->getRequest()->getParam('pass');
        $pass = Zend_Json::decode($pass);

        if ($data['failed'] == 'false') {
            $listContextManager = $session->getListContextManager();
            $inxmailList        = $listContextManager->get($listid);

            $synchronize->doMappingCheck();
            try {
                Mage::getModel('dndinxmail_subscriber/synchronization')
                    ->synchronizeCustomers($pass, $inxmailList, $store);
            } catch (Exception $e) {
                Mage::helper('dndinxmail_subscriber/log')->logExceptionMessage($e);
                $data['failed'] = 'true';
                $data['msg']    = $e->getMessage();
            }
        }

        $synchronize->closeInxmailSession();

        $this->getResponse()->setBody(Zend_Json::encode($data));
    }

    /**
     * Launch ajax groups synchronization
     *
     * @return void
     */
    public function groupsAction()
    {
        // Emulate store that is synchronized to get correct email subscription by store
        $appEmulation = Mage::getSingleton('core/app_emulation');
        $initialEnvironmentInfo = $appEmulation->startEnvironmentEmulation(Mage_Core_Model_App::ADMIN_STORE_ID);

        $hashKey      = $this->getRequest()->getParam('hash');
        $isAllowed    = Mage::helper('dndinxmail_subscriber')->isHashKeyAllowed($hashKey);
        $groupsHelper = Mage::helper('dndinxmail_subscriber/synchronize_groups');

        if (!$isAllowed) {
            $message = Mage::helper('dndinxmail_subscriber')->__('You are not allowed on this page.');
            Mage::getSingleton('core/session')->addError($message);
            $this->_redirect('dndinxmail_subscriber_front/messages/error/');
        }

        try {
            $synchronize  = Mage::helper('dndinxmail_subscriber/synchronize');
            $unsubscribed = array();

            foreach (Mage::app()->getWebsites() as $website) {
                foreach ($website->getGroups() as $group) {
                    $stores = $group->getStores();
                    foreach ($stores as $store) {
                        $unsubscribedStore = $synchronize->getUnsubscribedCustomers($store->getStoreId());
                        $unsubscribed      = array_merge($unsubscribedStore, $unsubscribed);
                    }
                }
            }

            $synchronize->unsubscribeCustomersFromMagentoByEmails($unsubscribed);
            $synchronize->unsubscribeCustomersFromGroups();

        }
        catch (Exception $e) {
            $message = Mage::helper('dndinxmail_subscriber')->__('Error synchronizing unsubscribed customers from Inxmail');
            Mage::getSingleton('core/session')->addError($message);
            $this->_redirect('dndinxmail_subscriber_front/messages/error/');
        }

        $pass = $groupsHelper->initSynchronization();

        if (!isset($pass['total']) || (isset($pass['total']) && $pass['total'] == 0)) {
            $message = Mage::helper('dndinxmail_subscriber')->__('No customer to synchronize.');
            Mage::getSingleton('core/session')->addError($message);
            $this->_redirect('dndinxmail_subscriber_front/messages/error/');
        }

        $pass = Zend_Json::encode($pass);
        $appEmulation->stopEnvironmentEmulation($initialEnvironmentInfo);
        $this->loadLayout('synchronize');

        $block = $this->getLayout()->createBlock('dndinxmail_subscriber/synchronization_groups')->setPass($pass);

        $this->getLayout()->getBlock('content')->append($block);
        $this->renderLayout();
    }

    /**
     *
     */
    public function passGroupsAction()
    {
        // Emulate store that is synchronized to get correct email subscription by store
        $appEmulation = Mage::getSingleton('core/app_emulation');
        $initialEnvironmentInfo = $appEmulation->startEnvironmentEmulation(Mage_Core_Model_App::ADMIN_STORE_ID);

        $synchronize    = Mage::helper('dndinxmail_subscriber/synchronize');
        $data           = array();
        $data['failed'] = 'false';
        $data['msg']    = 'Success';

        try {
            $session = $synchronize->openInxmailSession(false);
        } catch (Exception $e) {
            $data['failed'] = 'true';
            $data['msg']    = $e->getMessage();
        }

        $firstPass = $this->getRequest()->getParam('first');
        $pass      = $this->getRequest()->getParam('pass');
        $pass      = Zend_Json::decode($pass);

        if ($data['failed'] == 'false') {

            try {

                $contextListManager = $session->getListContextManager();
                $listName           = $this->getRequest()->getParam('list');
                if (!$list = $contextListManager->findByName($listName)) {
                    $list = $contextListManager->createStandardList();
                    $list->updateName($listName);
                    $list->commitUpdate();
                }
                else {
                    if ($firstPass == 'true') $synchronize->truncateSpecificInxmailList($list);
                }

                $synchronize->subscribeByEmails($pass, false, $list);
            }
            catch (Exception $e) {
                $data['failed'] = 'true';
                $data['msg']    = $e->getMessage();
            }

        }

        $synchronize->closeInxmailSession();
        $appEmulation->stopEnvironmentEmulation($initialEnvironmentInfo);
        $this->getResponse()->setBody(Zend_Json::encode($data));
    }

}