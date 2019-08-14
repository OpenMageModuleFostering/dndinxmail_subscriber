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
class DndInxmail_Subscriber_Model_Adminhtml_System_Config_Source_Inxmail_Lists
{

    /**
     * @var
     */
    protected $_options;

    /**
     * Get all Inxmail lists
     *
     * @return array Inxmail lists
     */
    public function toOptionArray()
    {
        if (!$this->_options) {

            Mage::helper('dndinxmail_subscriber/error')->setIsSilentError(true);
            try {
                $lists = Mage::helper('dndinxmail_subscriber/synchronize')->getInxmailLists();
            }
            catch (Exception $e) {
                Mage::helper('dndinxmail_subscriber/log')->logExceptionData($e->getMessage(), __FUNCTION__);

                return array(
                    array(
                        'value' => '',
                        'label' => ''
                    )
                );
            }
            Mage::helper('dndinxmail_subscriber/error')->setIsSilentError(false);

            foreach ($lists as $list):
                $this->_options[] = array(
                    'value' => $list['id'],
                    'label' => $list['name']
                );
            endforeach;

        }

        return $this->_options;
    }

}