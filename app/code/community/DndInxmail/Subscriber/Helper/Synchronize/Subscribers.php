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
class DndInxmail_Subscriber_Helper_Synchronize_Subscribers extends DndInxmail_Subscriber_Helper_Abstract
{

    /**
     *
     */
    const SUBSCRIBER_PER_PASS = 'dndinxmail_subscriber_general/syncrhonize_subscribers/subscribers_per_pass';

    /**
     * Format emails for synchronization
     *
     * @return array
     */
    public function initSynchronization($storeId)
    {
        $pass               = array();
        $subscribersPerPass = $this->getSubscribersPerPass($storeId);
        $currentPass        = 0;
        $i                  = 0;

        $resource        = Mage::getSingleton('core/resource');
        $read            = $resource->getConnection('core_read');
        $subscriberTable = $resource->getTableName('newsletter/subscriber');
        $query           = "
            SELECT `$subscriberTable`.`subscriber_email` as `email`
            FROM `$subscriberTable`
            WHERE `$subscriberTable`.`store_id` = $storeId
        ";

        try {
            if (!$result = $read->query($query)) {
                return array();
            }
            if (!$subscribers = $result->fetchAll()) {
                return array();
            }

            foreach ($subscribers as $subscriber) {

                $pass[$currentPass][] = $subscriber['email'];

                if ($i % $subscribersPerPass == $subscribersPerPass - 1) {
                    $currentPass++;
                }

                $i++;
            }

            $pass['total'] = count($pass);

            return $pass;

        }
        catch (Exception $e) {
            return array();
        }
    }

    /**
     * Get subscriber per pass
     *
     * @return int
     */
    public function getSubscribersPerPass($storeId)
    {
        $config = Mage::getStoreConfig(self::SUBSCRIBER_PER_PASS, $storeId);

        return ($config != '' && $config != null) ? $config : 50;
    }

}