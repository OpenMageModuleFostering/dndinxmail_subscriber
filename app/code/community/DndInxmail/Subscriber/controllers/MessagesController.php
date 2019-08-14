<?php

/**
 * @category               Module Controller
 * @package                DndInxmail_Subscriber
 * @dev                    Merlin
 * @last_modified          13/03/2013
 * @copyright              Copyright (c) 2012 Agence Dn'D
 * @author                 Agence Dn'D - Conseil en creation de site e-Commerce Magento : http://www.dnd.fr/
 * @license                http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class DndInxmail_Subscriber_MessagesController extends Mage_Core_Controller_Front_Action
{

    /**
     * Launch ajax Subscribers synchronization
     *
     * @return void
     */
    public function errorAction()
    {
        $this->loadLayout('messages');
        $this->renderLayout();
    }

}