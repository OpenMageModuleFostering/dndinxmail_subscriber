<?php

/**
 * @category               Module Block
 * @package                DndInxmail_Subscriber
 * @dev                    Merlin
 * @last_modified          18/02/2013
 * @copyright              Copyright (c) 2012 Agence Dn'D
 * @author                 Agence Dn'D - Conseil en creation de site e-Commerce Magento : http://www.dnd.fr/
 * @license                http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class DndInxmail_Subscriber_Block_Adminhtml_System_Config_Form_Button_Subscribers extends Mage_Adminhtml_Block_System_Config_Form_Field
{

    /**
     * Set template
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('dndinxmail/subscriber/system/config/form/button/subscribers.phtml');
    }

    /**
     * Return element html
     *
     * @param  Varien_Data_Form_Element_Abstract $element
     *
     * @return string
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        return $this->_toHtml();
    }

    /**
     * Return ajax url for button
     *
     * @return string
     */
    public function getCheckUrl()
    {
        $store = Mage::app()->getRequest()->getParam('store');

        return Mage::helper('adminhtml')->getUrl('adminhtml/synchronize/subscribers', array('store' => $store));
    }

    /**
     * Generate button html
     *
     * @return string
     */
    public function getButtonHtml()
    {
        $button = $this->getLayout()->createBlock('adminhtml/widget_button')->setData(array(
            'id'      => 'dndinxmail_subscriber_button',
            'label'   => $this->helper('adminhtml')->__('Synchronize now'),
            'onclick' => 'javascript:DndInxmailSynchronizeSubscribers(); return false;'
        ));

        return $button->toHtml();
    }

}