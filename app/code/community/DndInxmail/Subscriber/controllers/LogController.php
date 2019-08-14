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
class DndInxmail_Subscriber_LogController extends Mage_Core_Controller_Front_Action
{

    /**
     *
     */
    const SYNCHRONISATION_LOG_FILE_PATTERN = '{name}_synchronisation';

    /**
     * @var string
     */
    protected $_logFile = '';

    /**
     * @param $name
     */
    private function _initLog($name)
    {
        $this->_logFile = str_replace('{name}', $name, self::SYNCHRONISATION_LOG_FILE_PATTERN);
    }

    /**
     *
     */
    public function startAction()
    {
        $type = $this->getRequest()->getParam('type');
        $this->_initLog($type);
        $this->_log()->logData('## START ' . ucfirst($type) . ' synchronisation > ' . $this->_getNow() . ' ##', $this->_logFile);
    }

    /**
     *
     */
    public function tryToCloseAction()
    {
        $type = $this->getRequest()->getParam('type');
        $this->_initLog($type);
        $this->_log()->logData('## Try to close ' . ucfirst($type) . ' synchronisation > ' . $this->_getNow(), $this->_logFile);
    }

    /**
     *
     */
    public function endAction()
    {
        $type = $this->getRequest()->getParam('type');
        $this->_initLog($type);
        $this->_log()->logData('## END ' . ucfirst($type) . ' synchronisation > ' . $this->_getNow() . ' ##', $this->_logFile);
    }

    /**
     * @return DndInxmail_Subscriber_Helper_Log
     */
    private function _log()
    {
        return Mage::helper('dndinxmail_subscriber/log');
    }

    /**
     * @return string|Zend_Date
     */
    private function _getNow()
    {
        return $this->_formatLocaleTime(date('Y-m-d H:i:s'));
    }

    /**
     * @param $date
     *
     * @return string|Zend_Date
     */
    private function _formatLocaleTime($date)
    {
        $format = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
        $date   = Mage::app()->getLocale()->date($date, Varien_Date::DATETIME_INTERNAL_FORMAT)->toString($format);
        $date   = new Zend_Date($date);
        $date   = $date->get("YYYY-MM-dd HH:mm:ss");

        return $date;
    }

}