<?php

/**
 * @category               Module Model
 * @package                DndInxmail_Subscriber
 * @dev                    Alexander Velykzhanin
 * @last_modified          18/04/2015
 * @copyright              Copyright (c) 2015 Flagbit GmbH & Co. KG
 * @author                 Flagbit GmbH & Co. KG : https://www.flagbit.de/
 * @license                http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class DndInxmail_Subscriber_Model_Adminhtml_System_Config_Source_Inxmail_OptinControl
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array(
                'value' => DndInxmail_Subscriber_Helper_Config::OPTIN_CONTROL_INXMAIL,
                'label' => Mage::helper('adminhtml')->__('Inxmail Professional')
            ),
            array(
                'value' => DndInxmail_Subscriber_Helper_Config::OPTIN_CONTROL_MAGENTO,
                'label' => Mage::helper('adminhtml')->__('Magento')
            ),
        );
    }

}