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
class DndInxmail_Subscriber_Model_Adminhtml_System_Config_Source_Group_Specific
{

    /**
     *
     */
    const DNDINXMAIL_MAPPING_CUSTOMER_GROUP_SPECIFIC_LAST = 'Last customers';
    /**
     *
     */
    const DNDINXMAIL_MAPPING_CUSTOMER_GROUP_SPECIFIC_BEST = 'Best customers';
    /**
     *
     */
    const DNDINXMAIL_MAPPING_CUSTOMER_GROUP_SPECIFIC_BIRTHDAY = 'Birthday';
    /**
     *
     */
    const DNDINXMAIL_MAPPING_CUSTOMER_GROUP_SPECIFIC_ABANDONNED_CARTS = 'Abandonned Carts';
    /**
     *
     */
    const DNDINXMAIL_MAPPING_CUSTOMER_GROUP_SPECIFIC_ORDERS = 'Orders';

    /**
     * @var
     */
    protected $_options;

    /**
     * Get specific group to synchronize
     *
     * @return array Specific groups
     */
    public function getSpecificGroups()
    {
        return array(
            array(
                'label' => Mage::helper('dndinxmail_subscriber')->__('Last customers (specific)'),
                'value' => 'Last customers'
            ),
            array(
                'label' => Mage::helper('dndinxmail_subscriber')->__('Best customers (specific)'),
                'value' => 'Best customers'
            ),
            array(
                'label' => Mage::helper('dndinxmail_subscriber')->__('Customers birthday (specific)'),
                'value' => 'Birthday'
            ),
            array(
                'label' => Mage::helper('dndinxmail_subscriber')->__('Abandonned carts (specific)'),
                'value' => 'Abandonned Carts'
            ),
            array(
                'label' => Mage::helper('dndinxmail_subscriber')->__('Orders (specific)'),
                'value' => 'Orders'
            )
        );
    }

}