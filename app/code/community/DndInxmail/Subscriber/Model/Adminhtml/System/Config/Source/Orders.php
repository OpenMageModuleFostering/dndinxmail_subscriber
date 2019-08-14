<?php

/**
 * @category               Module Model
 * @package                DndInxmail_Subscriber
 * @dev                    Merlin
 * @last_modified          13/03/2013
 * @copyright              Copyright (c) 2012 Agence Dn'D
 * @author                 Agence Dn'D - Conseil en creation de site e-Commerce Magento : http://www.dnd.fr/
 * @license                http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class DndInxmail_Subscriber_Model_Adminhtml_System_Config_Source_Orders
{

    /**
     *
     */
    const DNDINXMAIL_MAPPING_CUSTOMER_GROUP_SPECIFIC_ORDERS_SINGLE_DATE = 'single_date';
    /**
     *
     */
    const DNDINXMAIL_MAPPING_CUSTOMER_GROUP_SPECIFIC_ORDERS_RANGE_DATE = 'range_date';

    /**
     * Get specific group to synchronize
     *
     * @return array Specific groups
     */
    public function toOptionArray()
    {
        return array(
            array(
                'label' => Mage::helper('dndinxmail_subscriber')->__('Last X Days'),
                'value' => self::DNDINXMAIL_MAPPING_CUSTOMER_GROUP_SPECIFIC_ORDERS_SINGLE_DATE
            ),
            array(
                'label' => Mage::helper('dndinxmail_subscriber')->__('Date Range'),
                'value' => self::DNDINXMAIL_MAPPING_CUSTOMER_GROUP_SPECIFIC_ORDERS_RANGE_DATE
            )
        );
    }

}