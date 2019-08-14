<?php

/**
 * @category                Source Model
 * @package                 DndInxmail_Subscriber
 * @dev                     Barracuda
 * @last_modified           13/03/2012
 * @copyright               Copyright (c) 2012 Agence Dn'D
 * @author                  Agence Dn'D - Conseil en creation de site e-Commerce Magento : http://www.dnd.fr/
 * @license                 http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class DndInxmail_Subscriber_Model_Adminhtml_System_Config_Source_Attributes
{

    /**
     * @var
     */
    protected $_options;

    /**
     * Get product attributes
     *
     * @return array Product attributes
     */
    public function toOptionArray()
    {
        if (!$this->_options) {

            $attribute = Mage::getResourceModel('eav/entity_attribute_collection');

            foreach ($attribute as $option) {
                if ($option->getIsUserDefined() && $option->getFrontendLabel()) {
                    $this->_options[] = array(
                        'value' => $option->getAttributeCode(),
                        'label' => $option->getAttributeCode()
                    );
                }
            }
        }

        return $this->_options;
    }

}


