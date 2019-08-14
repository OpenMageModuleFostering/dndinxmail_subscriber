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
class DndInxmail_Subscriber_Model_Adminhtml_System_Config_Source_Group
{

    /**
     * @var
     */
    protected $_options;

    /**
     * Get Magento customer groups
     *
     * @return array Magento customer groups
     */
    public function toOptionArray()
    {

        $groups = Mage::getResourceModel('customer/group_collection')->load();

        if (!$this->_options) {
            $this->_options[] = array(
                'value' => '',
                'label' => ''
            );
            foreach ($groups as $group) {
                $this->_options[] = array(
                    'value' => $group->getId(),
                    'label' => $group->getCode() . ' (' . $group->getId() . ')'
                );
            }
            $specificGroups = Mage::getModel('dndinxmail_subscriber/adminhtml_system_config_source_group_specific')->getSpecificGroups();
            $this->_options = array_merge($this->_options, $specificGroups);
        }

        return $this->_options;
    }

}
