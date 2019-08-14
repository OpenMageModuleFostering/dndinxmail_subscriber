<?php

/**
 * @category               Module Helper
 * @package                DndInxmail_Subscriber
 * @dev                    Merlin
 * @last_modified          13/03/2013
 * @copyright              Copyright (c) 2012 Agence Dn'D
 * @author                 Agence Dn'D - Conseil en creation de site e-Commerce Magento : http://www.dnd.fr/
 * @license                http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class DndInxmail_Subscriber_Block_Synchronization_Subscribers extends Mage_Core_Block_Template
{

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('dndinxmail/synchronization/subscribers.phtml');
    }

    /**
     * @return Mage_Core_Block_Abstract
     */
    protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    /**
     * @return mixed
     */
    public function getAllPass()
    {
        return $this->getPass();
    }

    /**
     * @return mixed
     */
    public function getStoreToSynchronize()
    {
        return $this->getStoreSynchronize();
    }

}