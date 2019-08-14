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
class DndInxmail_Subscriber_Helper_Log extends DndInxmail_Subscriber_Helper_Abstract
{

    /**
     *
     */
    const DNDINXMAIL_LOG_FOLDER = 'dndinxmail'; // DndInxmail log folder name

    /**
     * @var string
     */
    protected $_logFilename = 'dndinxmail.log'; // DndInxmail log file name
    /**
     * @var string
     */
    protected $_logExceptionFilename = 'dndinxmail_exception.log'; // DndInxmail log file name

    /**
     * Log data from Inxmail
     *
     * @param string $message Message to log
     * @param string $methodName
     *
     * @return void
     */
    public function logData($message, $methodName = null)
    {
        $this->_checkLogDir();
        $file = ($methodName == null) ? $this->_logFilename : $methodName . '.log';
        Mage::log($message, null, self::DNDINXMAIL_LOG_FOLDER . DS . $file);
    }

    /**
     * Log exception data from Inxmail
     *
     * @param string $message Message to log
     * @param string $methodName
     *
     * @return void
     */
    public function logExceptionData($exception, $methodName = null)
    {
        $this->_checkLogDir();
        $exceptionNumber = $this->_getRandomExceptionNumber();

        $file          = ($methodName == null) ? $this->_logFilename : strtolower($methodName) . '.log';
        $fileException = ($methodName == null) ? $this->_logExceptionFilename : strtolower($methodName) . '_exception.log';

        Mage::log('## EXCEPTION ' . $exceptionNumber . ' ##', null, self::DNDINXMAIL_LOG_FOLDER . DS . $file);
        Mage::log('## EXCEPTION ' . $exceptionNumber . ' ##', null, self::DNDINXMAIL_LOG_FOLDER . DS . $fileException);
        Mage::log($exception, null, self::DNDINXMAIL_LOG_FOLDER . DS . $fileException);
        Mage::log('## / EXCEPTION ' . $exceptionNumber . ' ##', null, self::DNDINXMAIL_LOG_FOLDER . DS . $fileException);
    }

    /**
     * Get a random number for exception
     *
     * @return int Random number
     */
    private function _getRandomExceptionNumber()
    {
        return substr(number_format(time() * rand(), 0, '', ''), 0, 10);
    }

    /**
     * Check if the log folder exist then create it
     *
     * @return void
     */
    protected function _checkLogDir()
    {
        $path = $this->_getLogFolderPath();
        $this->createDirIfNotExists($path);
    }

    /**
     * Get the Inxmail log folder path
     *
     * @return string Return Inxmail log folder path
     */
    protected function _getLogFolderPath()
    {
        return Mage::getBaseDir('log') . DS . self::DNDINXMAIL_LOG_FOLDER . DS;
    }

}