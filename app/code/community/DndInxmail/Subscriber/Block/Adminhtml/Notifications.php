<?php

class DndInxmail_Subscriber_Block_Adminhtml_Notifications extends Mage_Core_Block_Template
{


    /**
     * @return array
     */
    public function getMessages()
    {
        $errorsJson = Mage::helper('dndinxmail_subscriber/flag')->getAdminNotifications();
        try {
            $errors = Mage::helper('core')->jsonDecode($errorsJson);
        } catch (Exception $e) {
            $errors = array();
        }

        if (!is_array($errors)) {
            $errors = array();
        }

        return $errors;
    }
}
 