<?php

/**
 * @category               Module Model
 * @package                DndInxmail_Subscriber
 * @dev                    Alexander Velykzhanin
 * @last_modified          4/12/2015
 * @copyright              Copyright (c) 2015 Flagbit GmbH & Co. KG
 * @author                 Flagbit GmbH & Co. KG : https://www.flagbit.de/
 * @license                http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class DndInxmail_Subscriber_Model_Synchronization extends Mage_Core_Model_Abstract
{

    protected $_inxmailSession;

    protected $_customers = array();

    /**
     * @param array $emails
     * @param $inxmailList
     * @param $store
     */
    public function synchronizeCustomers(array $emails, $inxmailList, $store = null)
    {
        if (empty($emails)) {
            return;
        }
        $logHelper = Mage::helper('dndinxmail_subscriber/log');
        $synchronizeHelper = Mage::helper('dndinxmail_subscriber/synchronize');
        try {
            $synchronizeHelper->openInxmailSession();
        } catch (Exception $e) {
            $logHelper->logExceptionMessage($e, __FUNCTION__);

            return;
        }

        if (is_null($store)) {
            $store = Mage::app()->getStore();
        }
        $customers = $this->_getCustomersByEmails($emails);
        $subscriberCollection = Mage::getModel('newsletter/subscriber')->getCollection();
        $subscriberCollection->addFieldToFilter('subscriber_email', array('in' => $emails))
            ->addStoreFilter($store->getId());

        $recipientContext      = $synchronizeHelper->getRecipientContext();
        $recipientMetaData     = $recipientContext->getMetaData();
        $subscriptionAttribute = $recipientMetaData->getSubscriptionAttribute($inxmailList);
        $batchChannel          = $recipientContext->createBatchChannel();
        $filter = '';
        foreach ($subscriberCollection as $subscriber) {
            $subscriptionEmail = $subscriber->getEmail();
            $filter .= "email LIKE \"" . $subscriptionEmail . "\" OR ";
        }
        $filter = rtrim($filter, "OR ");
        /** @var Inx_Apiimpl_Recipient_RecipientRowSetImpl $recipientRowSet */
        $recipientRowSet = $recipientContext->select($inxmailList, null, $filter, null, Inx_Api_Order::ASC);
        $inxmailEmails = array();
        $emailAttribute = $recipientMetaData->getUserAttribute('email');
        while ($recipientRowSet->next()) {
            $inxmailEmails[] = $recipientRowSet->getString($emailAttribute);
        }
        foreach ($subscriberCollection as $subscriber) {
            $subscriptionEmail = $subscriber->getEmail();
            if ((array_search($subscriptionEmail, $inxmailEmails) !== false) && !$subscriber->isSubscribed()) {
                $subscriber->setStatus(Mage_Newsletter_Model_Subscriber::STATUS_SUBSCRIBED)
                    ->setNotSyncInxmail(true);
                $subscriber->save();
            } elseif ($subscriber->isSubscribed()) {
                $batchChannel->createRecipient($subscriptionEmail, true);
                $batchChannel->selectRecipient($subscriptionEmail, true);
                if (isset($customers[$subscriptionEmail])) {
                    $customer = $customers[$subscriptionEmail];
                    $vars = $synchronizeHelper->getCustomerAttributesForInxmail($customer);

                    foreach ($vars as $attributeName => $attributeValue) {
                        try {
                            $recipientMetaData->getUserAttribute($attributeName);
                            $batchChannel->write($recipientMetaData->getUserAttribute($attributeName), $attributeValue);
                        } catch (Inx_Api_Recipient_AttributeNotFoundException $e) {
                            continue;
                        }
                    }
                }
                $batchChannel->write($subscriptionAttribute, date("c"));
            }
        }
        $results = $batchChannel->executeBatch();
        $this->_logResultErrors($results);

        Mage::helper('dndinxmail_subscriber/config')->setIsSynchronized(true, 'stores', $store->getId());
    }

    protected function _logResultErrors($results)
    {
        if (!is_array($results)) {
            return;
        }
        $logHelper = Mage::helper('dndinxmail_subscriber/log');
        foreach ($results as $result) {
            $error = $this->getBatchResultError($result);
            if (!$error) {
                continue;
            }
            $logHelper->logExceptionData($error . " (Code {$result})", __FUNCTION__);
        }
    }

    /**
     * Transform result code into error message or bool false in case of success
     *
     * @param $result
     *
     * @return bool|string
     */
    public function getBatchResultError($result)
    {
        $error = false;
        $helper = Mage::helper('dndinxmail_subscriber');
        switch ($result) {
            case Inx_Api_Recipient_BatchChannel::RESULT_NOT_COMMITTED:
                $error = $helper->__('Data was not committed.');
                break;
            case Inx_Api_Recipient_BatchChannel::RESULT_FAILURE_ILLEGAL_VALUE:
                $error = $helper->__('Key value is illegal.');
                break;
            case Inx_Api_Recipient_BatchChannel::RESULT_FAILURE_BLOCKED_BY_BLACKLIST:
                $error = $helper->__('Email is blocked by blacklist entry.');
                break;
            case Inx_Api_Recipient_BatchChannel::RESULT_FAILURE_DUPLICATE_KEY:
                $error = $helper->__('Unique key already exists.');
                break;
            case Inx_Api_Recipient_BatchChannel::RESULT_FAILURE_KEY_NOT_FOUND:
                $error = $helper->__('Recipient doesn\'t exist.');
                break;
            case Inx_Api_Recipient_BatchChannel::RESULT_PERMISSION_DENIED:
                $error = $helper->__('Permission is denied to create, update or remove a recipient.');
                break;
        }

        return $error;
    }

    /**
     * @param $emails
     *
     * @return array|Mage_Customer_Model_Customer[]
     */
    protected function _getCustomersByEmails($emails)
    {
        /** @var Mage_Customer_Model_Resource_Customer_Collection $customerCollection */
        $customerCollection = Mage::getModel('customer/customer')->getCollection();
        $customerCollection->addNameToSelect()
            ->addFieldToFilter('email', array('in' => $emails))
            ->addAttributeToSelect('*');
        $customerCollection->getSelect()
            ->group('e.email');

        $customers = array();
        foreach ($customerCollection as $customer) {
            $customers[$customer->getEmail()] = $customer;
        }

        return $customers;
    }
}
 