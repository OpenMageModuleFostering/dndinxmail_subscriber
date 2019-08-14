<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'abstract.php';

/**
 * @category               Module Shell Script
 * @package                DndInxmail_Subscriber
 * @dev                    Alexander Velykzhanin
 * @last_modified          19/10/2015
 * @copyright              Copyright (c) 2015 Flagbit GmbH & Co. KG
 * @author                 Flagbit GmbH & Co. KG : https://www.flagbit.de/
 * @license                http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class DndInxmail_SynchronizaCustomerGroup extends Mage_Shell_Abstract
{
    public function run()
    {
        try {
            Mage::getModel('dndinxmail_subscriber/observer')->synchronizeCustomerGroup();
        } catch (Exception $e) {
            Mage::helper('dndinxmail_subscriber/log')->logExceptionMessage($e, __CLASS__);
        }
    }
}

$shell = new DndInxmail_SynchronizaCustomerGroup();

$shell->run();