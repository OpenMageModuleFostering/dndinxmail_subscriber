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
class DndInxmail_Subscriber_Model_Adminhtml_System_Config_Source_Inxmail_Columns_Type_Int extends DndInxmail_Subscriber_Model_Adminhtml_System_Config_Source_Inxmail_Columns
{

    /**
     * @var
     */
    protected $_options;

    /**
     * Get all Inxmail Columns
     *
     * @return array Inxmail lists
     */
    public function toOptionArray()
    {
        if (!$this->_options) {
            $options = parent::toOptionArray();
            foreach ($options as $i => $option) {
                if ($option['type'] != Inx_Api_Recipient_Attribute::DATA_TYPE_INTEGER && $option['value'] != '') {
                    if (isset($options[$i])) unset($options[$i]);
                }
            }
            if (count($options) == 1 && isset($options[0])) {
                $options[0]['label'] = Mage::helper('dndinxmail_subscriber')->__('No column available');
            }
            $this->_options = $options;
        }

        return $this->_options;
    }

}