<?php

/**
 * @category               Module Model
 * @package                DndInxmail_Subscriber
 * @dev                    Alexander Velykzhanin
 * @last_modified          29/07/2015
 * @copyright              Copyright (c) 2015 Flagbit GmbH & Co. KG
 * @author                 Flagbit GmbH & Co. KG : https://www.flagbit.de/
 * @license                http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class DndInxmail_Subscriber_Model_Adminhtml_System_Config_Source_Inxmail_GroupedColumns
    extends DndInxmail_Subscriber_Model_Adminhtml_System_Config_Source_Inxmail_Columns
{


    /**
     * Get all Inxmail Columns
     *
     * @return array Inxmail lists
     */
    public function toOptionArray()
    {
        if (!$this->_options) {
            $options = parent::toOptionArray();

            $helper = Mage::helper('dndinxmail_subscriber');

            $groupedOptions  = array(
                array(
                    'label' => $helper->__('Please select column'),
                    'value' => '',
                ),
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

            foreach ($options as $option) {
                if (!array_key_exists($option['type'], $groupedOptions)) {
                    continue;
                }
                $groupedOptions[$option['type']]['value'][] = array(
                    'value' => $option['value'],
                    'label' => $option['label'],
                    'params' => array(
                        'data-type' => $option['type'],
                    ),
                );
            }

            foreach ($groupedOptions as $type => $groupedOption) {
                if (is_array($groupedOption['value']) && !count($groupedOption['value'])) {
                    unset($groupedOptions[$type]);
                }
            }

            $this->_options = $groupedOptions;
        }

        return $this->_options;
    }

}