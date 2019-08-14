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
class DndInxmail_Subscriber_Helper_Error extends DndInxmail_Subscriber_Helper_Abstract
{

    /**
     *
     */
    const DNDINXMAIL_IS_SILENT_ERROR_KEY = 'isSilentError'; // Register key for silent errors

    /**
     * Set if is silent error or not
     *
     * @param string $error True if silent error false if not
     *
     * @return void
     */
    public function setIsSilentError($error = false)
    {
        $value = ($error == true) ? true : false;
        Mage::register(self::DNDINXMAIL_IS_SILENT_ERROR_KEY, $value, true);
    }

    /**
     * Blocks the error message in the backoffice when trying to connect the Inxmail API
     *
     * @return boolean
     */
    public function getIsSilentError()
    {
        return (Mage::registry(self::DNDINXMAIL_IS_SILENT_ERROR_KEY) != null && Mage::registry(self::DNDINXMAIL_IS_SILENT_ERROR_KEY) == true) ? true : false;
    }

}