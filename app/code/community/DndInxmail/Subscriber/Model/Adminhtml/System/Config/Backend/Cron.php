<?php

/**
 * @category               Module Model
 * @package                DndInxmail_Subscriber
 * @dev                    Merlin
 * @last_modified          18/03/2013
 * @copyright              Copyright (c) 2012 Agence Dn'D
 * @author                 Agence Dn'D - Conseil en creation de site e-Commerce Magento : http://www.dnd.fr/
 * @license                http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class DndInxmail_Subscriber_Model_Adminhtml_System_Config_Backend_Cron extends Mage_Core_Model_Config_Data
{

    /**
     * @var array
     */
    protected $_crons = array(
        array(
            'string_path' => 'crontab/jobs/dndinxmail_subscriber_synchronize_unsubscribed/schedule/cron_expr',
            'model_path'  => 'crontab/jobs/dndinxmail_subscriber_synchronize_unsubscribed/run/model',
            'enabled'     => 'groups/crons_synchronize_unsubscribed/fields/enabled/value',
            'time'        => 'groups/crons_synchronize_unsubscribed/fields/time/value',
            'frequency'   => 'groups/crons_synchronize_unsubscribed/fields/frequency/value',
        ),
        array(
            'string_path' => 'crontab/jobs/dndinxmail_subscriber_synchronize_customer_group/schedule/cron_expr',
            'model_path'  => 'crontab/jobs/dndinxmail_subscriber_synchronize_customer_group/run/model',
            'enabled'     => 'groups/crons_synchronize_groups/fields/enabled/value',
            'time'        => 'groups/crons_synchronize_groups/fields/time/value',
            'frequency'   => 'groups/crons_synchronize_groups/fields/frequency/value',
        )
    );

    /**
     * Cron settings after save
     *
     * @return boolean
     */
    protected function _afterSave()
    {
        if (!Mage::helper('dndinxmail_subscriber')->isDndInxmailEnabled()) return false;

        $frequencyHourly  = DndInxmail_Subscriber_Model_Adminhtml_System_Config_Source_Cron_Frequency::CRON_HOURLY;
        $frequencyDaily   = DndInxmail_Subscriber_Model_Adminhtml_System_Config_Source_Cron_Frequency::CRON_DAILY;
        $frequencyWeekly  = DndInxmail_Subscriber_Model_Adminhtml_System_Config_Source_Cron_Frequency::CRON_WEEKLY;
        $frequencyMonthly = DndInxmail_Subscriber_Model_Adminhtml_System_Config_Source_Cron_Frequency::CRON_MONTHLY;

        foreach ($this->_crons as $cronConfig) {

            $enabled   = $this->getData($cronConfig['enabled']);
            $time      = $this->getData($cronConfig['time']);
            $frequency = $this->getData($cronConfig['frequency']);

            if ($enabled) {
                $cronDayOfWeek = date('N');

                $cronExprArray = array(
                    intval($time[1]),
                    ($frequency == $frequencyHourly) ? '*' : intval($time[0]),
                    ($frequency == $frequencyMonthly) ? '1' : '*',
                    '*',
                    ($frequency == $frequencyWeekly) ? '1' : '*'
                );

                $cronExprString = join(' ', $cronExprArray);
            }
            else {
                $cronExprString = '';
            }

            try {
                Mage::getModel('core/config_data')->load($cronConfig['string_path'], 'path')->setValue($cronExprString)->setPath($cronConfig['string_path'])->save();

                Mage::getModel('core/config_data')->load($cronConfig['model_path'], 'path')->setValue((string)Mage::getConfig()->getNode($cronConfig['model_path']))->setPath($cronConfig['model_path'])->save();
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError('Unable to save the cron expression : ' . $e->getMessage());
            }

        }

        return true;
    }

}