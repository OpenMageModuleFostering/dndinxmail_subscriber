<?php

class DndInxmail_Subscriber_Model_Resource_Newsletter_Subscriber extends Mage_Newsletter_Model_Resource_Subscriber
{


    /**
     * Load subscriber from DB by email
     *
     * @param string $subscriberEmail
     * @return array
     */
    public function loadByEmail($subscriberEmail)
    {
        $storeId = Mage::app()->getStore()->getId();

        $select = $this->_read->select()
            ->from($this->getMainTable())
            ->where('subscriber_email=:subscriber_email');

        $bind = array('subscriber_email' => $subscriberEmail);
        // Add store ID for newsletters
        if ($storeId != Mage_Core_Model_App::ADMIN_STORE_ID) {
            $select->where('store_id=:store_id');
            $bind['store_id'] = $storeId;
        }

        $result = $this->_read->fetchRow($select, $bind);

        if (!$result) {
            return array();
        }

        return $result;
    }

    /**
     * Load subscriber by customer
     *
     * @param Mage_Customer_Model_Customer $customer
     * @return array
     */
    public function loadByCustomer(Mage_Customer_Model_Customer $customer)
    {
        $select = $this->_read->select()
            ->from($this->getMainTable())
            ->where('customer_id=:customer_id')
            ->where('store_id=:store_id');

        $storeId = Mage::app()->getStore()->getId();
        if ($storeId == Mage_Core_Model_App::ADMIN_STORE_ID) {
            $storeId = $customer->getStoreId();
        }

        $result = $this->_read->fetchRow($select, array(
            'customer_id'   => $customer->getId(),
            'store_id'      => $storeId,
        ));

        if ($result) {
            return $result;
        }

        $select = $this->_read->select()
            ->from($this->getMainTable())
            ->where('subscriber_email=:subscriber_email')
            ->where('store_id=:store_id');

        $result = $this->_read->fetchRow($select, array(
            'subscriber_email'  => $customer->getEmail(),
            'store_id'          => $storeId
        ));

        if ($result) {
            return $result;
        }

        return array();
    }

}