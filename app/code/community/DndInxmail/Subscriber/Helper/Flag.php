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
    const UNSUBSCRIBED_TIME_BY_STORE = 'dndinxmail_subscriber_last_unsubscribed_time_by_store';
    const GROUP_UNSUBSCRIBED_TIME = 'dndinxmail_subscriber_group_unsubscribed_time';
    const ADMIN_NOTIFICATIONS = 'dndinxmail_subscriber_notifications';

    /**
     * @return Mage_Core_Model_Flag
     */
    public function getUnsubscribedTimeFlag()
    {
        return Mage::getModel('core/flag', array('flag_code' => self::UNSUBSCRIBED_TIME))->loadSelf();
    }

    public function getAdminNotificationsFlag()
    {
        return Mage::getModel('core/flag', array('flag_code' => self::ADMIN_NOTIFICATIONS))->loadSelf();
    }

    public function getAdminNotifications()
    {
        $flag = $this->getAdminNotificationsFlag();

        $data = $flag->getFlagData();
        if (!isset($data['admin_notifications'])) {
            return null;
        }

        return $data['admin_notifications'];
    }

    /**
     * @return $this
     * @throws Exception
     */
    public function saveAdminNotifications($notifications)
    {
        $flag = $this->getAdminNotificationsFlag();
        $data = array('admin_notifications' => $notifications);
        $flag->setFlagData($data)->save();

        return $this;
    }

    /**
     * @return Mage_Core_Model_Flag
     */
    public function getUnsubscribedTimeFlagByStore()
    {
        return Mage::getModel('core/flag', array('flag_code' => self::UNSUBSCRIBED_TIME_BY_STORE))->loadSelf();
    }

    /**
     * @return Mage_Core_Model_Flag
     */
    public function getGroupUnsubscribedTimeFlag()
    {
        return Mage::getModel('core/flag', array('flag_code' => self::GROUP_UNSUBSCRIBED_TIME))->loadSelf();
    }

    /**
     * @return int|null
     */
    public function getGroupUnsubscribedTime()
    {
        $flag = $this->getGroupUnsubscribedTimeFlag();
        if (!$flag->getId()) {
            return null;
        }
        $data = $flag->getFlagData();
        if (!isset($data['all_groups'])) {
            return null;
        }

        return (int) $data['all_groups'];
    }

    /**
     * @param null $time
     *
     * @throws Exception
     * @return $this
     */
    public function saveGroupUnsubscribedTimeFlag($time = null)
    {
        if (!$time) {
            $time = time();
        }

        $flag = $this->getGroupUnsubscribedTimeFlag();
        $data = $flag->getFlagData();
        if (!is_array($data)) {
            $data = array();
        }
        $data['all_groups'] = $time;

        $flag->setFlagData($data)->save();

        return $this;
    }

    /**
     * @param $storeId
     * @return int|null
     */
    public function getUnsubscribedTime($storeId = null)
    {
        $timeByStore = $this->getUnsubscribedTimeByStore($storeId);
        if ($timeByStore) {
            return $timeByStore;
        }
        $flag = $this->getUnsubscribedTimeFlag();
        if (!$flag->getId()) {
            return null;
        }

        return (int) $flag->getFlagData();
    }

    /**
     * @param $storeId
     *
     * @return int|null
     */
    public function getUnsubscribedTimeByStore($storeId)
    {
        $flag = $this->getUnsubscribedTimeFlagByStore();
        if (!$flag->getId()) {
            return null;
        }

        $data = $flag->getFlagData();
        if (!is_array($data) || !isset($data[$storeId])) {
            return null;
        }

        return (int) $data[$storeId];
    }

    /**
     * @param null|int $time
     * @param null|int $storeId
     *
     * @throws Exception
     * @return $this
     */
    public function saveUnsubscribedTimeFlag($time = null, $storeId = null)
    {
        if (!$time) {
            $time = time();
        }

        $flag = $this->getUnsubscribedTimeFlagByStore($storeId);
        $data = $flag->getFlagData();
        if (!is_array($data)) {
            $data = array();
        }
        $data[$storeId] = $time;
        $flag->setFlagData($data)->save();

        return $this;
    }
}