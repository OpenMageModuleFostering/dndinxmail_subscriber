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
class DndInxmail_Subscriber_Adminhtml_SynchronizeController extends Mage_Adminhtml_Controller_Action
{

    /**
     * Synchronize all customers to Inxmail
     *
     * @return void
     */
    public function subscribersAction()
    {
        $hash = Mage::helper('dndinxmail_subscriber')->getHashKey();

        $store = Mage::getModel('core/store')->load($this->getRequest()->getParam('store'), 'code');
        if (!($store instanceof Varien_Object) || !$store->getStoreId()) {
            $message = Mage::helper('dndinxmail_subscriber')->__('No store set');
            Mage::getSingleton('adminhtml/session')->addError($message);
            $this->_redirect('adminhtml/system_config/edit/', array('section' => 'dndinxmail_subscriber_general'));
        }

        if ($id = $this->_setDefaultStoreBeforeRedirect()) {
            Mage::app()->setCurrentStore($store->getStoreId());
            $this->_redirect('dndinxmail_subscriber_front/synchronize/subscribers/', array(
                'hash'  => $hash,
                'key'   => '',
                'store' => $store->getStoreId()
            ));
        }
        else {
            $message = Mage::helper('dndinxmail_subscriber')->__('No default store set');
            Mage::getSingleton('adminhtml/session')->addError($message);
            $this->_redirect('adminhtml/system_config/edit/', array('section' => 'dndinxmail_subscriber_general'));
        }
    }

    /**
     * Synchronize all groups to Inxmail
     *
     * @return void
     */
    public function groupsAction()
    {
        $hash = Mage::helper('dndinxmail_subscriber')->getHashKey();

        if ($id = $this->_setDefaultStoreBeforeRedirect()) {
            Mage::app()->setCurrentStore($id);
            $this->_redirect('dndinxmail_subscriber_front/synchronize/groups/', array(
                'hash' => $hash,
                'key'  => ''
            ));
        }
        else {
            $message = Mage::helper('dndinxmail_subscriber')->__('No default store set');
            Mage::getSingleton('adminhtml/session')->addError($message);
            $this->_redirect('adminhtml/system_config/edit/', array('section' => 'dndinxmail_subscriber_general'));
        }
    }

    /**
     * @return bool
     */
    private function _setDefaultStoreBeforeRedirect()
    {
        $websites = Mage::app()->getWebsites(true);
        foreach ($websites as $website) {
            if ($website->getIsDefault()) {
                return $website->getDefaultGroupId();
            }
        }

        return false;
    }

}