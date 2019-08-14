<?php

/**
 * @category               Module Controller
 * @package                DndInxmail_Subscriber
 * @dev                    Alexander Velykzhanin
 * @last_modified          26/08/2015
 * @copyright              Copyright (c) 2015 Flagbit GmbH & Co. KG
 * @author                 Flagbit GmbH & Co. KG : https://www.flagbit.de/
 * @license                http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class DndInxmail_Subscriber_Adminhtml_InxmailNotificationController extends Mage_Adminhtml_Controller_Action
{


    protected $_publicActions = array('removeNotification');


    protected function _isAllowed()
    {
        return true;
    }


    /**
     * Remove admin notification
     */
    public function removeNotificationAction()
    {
        $emptyJson = Mage::helper('core')->jsonEncode(array());
        Mage::helper('dndinxmail_subscriber/flag')->saveAdminNotifications($emptyJson);

        $this->_redirectReferer();
    }
}
 