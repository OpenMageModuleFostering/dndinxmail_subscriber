<?php

/**
 * @category               Module Model
 * @package                DndInxmail_Subscriber
 * @dev                    Alexander Velykzhanin
 * @last_modified          05/08/2015
 * @copyright              Copyright (c) 2015 Flagbit GmbH & Co. KG
 * @author                 Flagbit GmbH & Co. KG : https://www.flagbit.de/
 * @license                http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class DndInxmail_Subscriber_Model_Adminhtml_System_Config_Source_Customer_Attributes
{

    /**
     * @var
     */
    protected $_options;


    /**
     * Attributes that we don't need to map(will not be used or are mapped automatically
     *
     * @var array
     */
    protected $_attributesToSkip = array(
        'customer' => array(
            'disable_auto_group_change',
            'email',
            'default_billing',
            'default_shipping',
            'password_hash',
            'reward_update_notification',
            'reward_warning_notification',
            'rp_token',
            'rp_token_created_at',
        ),
        'customer_address' => array(
            'firstname',
            'lastname',
            'middlename',
            'prefix',
            'suffix',
        ),
    );


    /**
     * @return array
     */
    protected function _getStaticAttributes()
    {
        $helper = Mage::helper('dndinxmail_subscriber');

        return array(
            array(
                'label' => $helper->__('Customer ID'),
                'value' => 'customer:entity_id',
                'params' => array(
                    'data-type' => Inx_Api_Recipient_Attribute::DATA_TYPE_INTEGER,
                ),
            ),
            array(
                'label' => $helper->__('Update Date'),
                'value' => 'customer:updated_at',
                'params' => array(
                    'data-type' => Inx_Api_Recipient_Attribute::DATA_TYPE_DATE,
                ),
            ),
            array(
                'label' => $helper->__('Customer is active'),
                'value' => 'customer:is_active',
                'params' => array(
                    'data-type' => Inx_Api_Recipient_Attribute::DATA_TYPE_BOOLEAN,
                ),
            ),
            array(
                'label' => $helper->__('Creation Date'),
                'value' => 'customer:created_at',
                'params' => array(
                    'data-type' => Inx_Api_Recipient_Attribute::DATA_TYPE_DATE,
                ),
            ),
            array(
                'label' => $helper->__('Group ID'),
                'value' => 'customer:group_id',
                'params' => array(
                    'data-type' => Inx_Api_Recipient_Attribute::DATA_TYPE_INTEGER,
                ),
            ),
            array(
                'label' => $helper->__('Store ID'),
                'value' => 'customer:store_id',
                'params' => array(
                    'data-type' => Inx_Api_Recipient_Attribute::DATA_TYPE_INTEGER,
                ),
            ),
            array(
                'label' => $helper->__('Website ID'),
                'value' => 'customer:website_id',
                'params' => array(
                    'data-type' => Inx_Api_Recipient_Attribute::DATA_TYPE_INTEGER,
                ),
            ),
        );
    }


    /**
     * Get product attributes
     *
     * @return array Product attributes
     */
    public function toOptionArray()
    {
        if (!$this->_options) {
            $customerAttributes = Mage::getResourceModel('customer/attribute_collection');
            // Static columns that are not attributes
            $results = $this->_getStaticAttributes();

            $customerAddressAttributes = Mage::getResourceModel('customer/address_attribute_collection');

            $customerOptions        = $this->_getAttributesOptions($customerAttributes, 'customer');
            $customerAddressOptions = $this->_getAttributesOptions($customerAddressAttributes, 'customer_address');

            $results = array_merge($results, $customerOptions, $customerAddressOptions);

            uasort($results, function($a, $b) {
                return $a['label'] > $b['label'];
            });

            $helper = Mage::helper('dndinxmail_subscriber');
            $groupedOptions  = array(
                Inx_Api_Recipient_Attribute::DATA_TYPE_DATE => array(
                    'label' => $helper->__('Type Date'),
                    'value' => array(),
                ),
                Inx_Api_Recipient_Attribute::DATA_TYPE_DOUBLE  => array(
                    'label' => $helper->__('Type Float'),
                    'value' => array(),
                ),
                Inx_Api_Recipient_Attribute::DATA_TYPE_INTEGER => array(
                    'label' => $helper->__('Type Integer'),
                    'value' => array(),
                ),
                Inx_Api_Recipient_Attribute::DATA_TYPE_STRING  => array(
                    'label' => $helper->__('Type Text'),
                    'value' => array(),
                ),
                Inx_Api_Recipient_Attribute::DATA_TYPE_BOOLEAN => array(
                    'label' => $helper->__('Type Yes/No'),
                    'value' => array(),
                ),
            );

            foreach ($results as $result) {
                $groupedOptions[$result['params']['data-type']]['value'][] = $result;
            }

            foreach ($groupedOptions as $type => $groupedOption) {
                if (!count($groupedOption['value'])) {
                    unset($groupedOptions[$type]);
                }
            }

            array_unshift(
                $groupedOptions,
                array(
                    'label' => $helper->__('Please select value'),
                    'value' => '',
                )
            );

            $this->_options = $groupedOptions;
        }

        return $this->_options;
    }


    /**
     * @param $attributes
     * @param $attributeType
     *
     * @return array
     */
    public function _getAttributesOptions($attributes, $attributeType)
    {
        $typeMapping = $this->getTypeMapping();
        $results = array();

        foreach ($attributes as $attribute) {
            $code = $attribute->getAttributeCode();
            if (in_array($code, $this->_attributesToSkip[$attributeType])) {
                continue;
            }
            // Region id should be excluded to have only one region in list. Later we will check both as exclusion
            // from general behavior
            if ($code == 'region_id') {
                continue;
            }
            $label       = $attribute->getFrontendLabel();
            $backendType = $attribute->getBackendType();
            if ($backendType == 'static') {
                continue;
            } elseif ($attribute->getFrontendInput() == 'boolean') {
                $type = Inx_Api_Recipient_Attribute::DATA_TYPE_BOOLEAN;
            } elseif ($attribute->getFrontendInput() == 'select' || $attribute->getFrontendInput() == 'multiselect') {
                $type = Inx_Api_Recipient_Attribute::DATA_TYPE_STRING;
            } else {
                $type = $typeMapping[$backendType];
            }
            if (!$label) {
                $label .= $code;
            }
            $results[] = array(
                'label' => $label,
                'value' => sprintf('%s:%s', $attributeType, $code),
                'params' => array(
                    'data-type'  => $type,
                ),
            );
        }

        return $results;
    }


    /**
     * @return array
     */
    static public function getTypeMapping()
    {
        return array(
            'varchar'  => Inx_Api_Recipient_Attribute::DATA_TYPE_STRING,
            'datetime' => Inx_Api_Recipient_Attribute::DATA_TYPE_DATE,
            'int'      => Inx_Api_Recipient_Attribute::DATA_TYPE_INTEGER,
            'text'     => Inx_Api_Recipient_Attribute::DATA_TYPE_STRING,
            'decimal'  => Inx_Api_Recipient_Attribute::DATA_TYPE_DOUBLE,
        );
    }
}


