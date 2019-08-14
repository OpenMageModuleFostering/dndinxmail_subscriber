<?php

/**
 * @category               Module Helper
 * @package                DndInxmail_Subscriber
 * @dev                    Alexander Velykzhanin
 * @last_modified          29/02/2016
 * @copyright              Copyright (c) 2016 Flagbit GmbH & Co. KG
 * @author                 Flagbit GmbH & Co. KG : https://www.flagbit.de/
 * @license                http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class DndInxmail_Subscriber_Helper_Flag extends Mage_Core_Helper_Abstract
{
    const UNSUBSCRIBED_TIME = 'dndinxmail_subscriber_last_unsubscribed_time';

    /**
     * @return Mage_Core_Model_Flag
     */
    public function getLastUnsubscribedTimeFlag()
    {
        return Mage::getModel('core/flag', array('flag_code' => self::UNSUBSCRIBED_TIME))->loadSelf();
    }

    /**
     * @return int|null
     */
    public function getLastUnsubscribedTime()
    {
        $flag = $this->getLastUnsubscribedTimeFlag();
        if (!$flag->getId()) {
            return null;
        }

        return (int) $flag->getFlagData();
    }

    /**
     * @param null $time
     *
     * @throws Exception
     */
    public function saveLastUnsubscribedTimeFlag($time = null)
    {
        if (!$time) {
            $time = time();
        }

        $flag = $this->getLastUnsubscribedTimeFlag();
        $flag->setFlagData($time)->save();
    }
}