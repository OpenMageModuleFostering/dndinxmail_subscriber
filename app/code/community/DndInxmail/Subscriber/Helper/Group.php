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
class DndInxmail_Subscriber_Helper_Group extends DndInxmail_Subscriber_Helper_Abstract
{

    /**
     *
     */
    const DNDINXMAIL_INXMAIL_LIST_CUTOMER_GROUP_PREFIX = "Magento Customer Group "; // Inxamil list prefix
    /**
     *
     */
    const DNDINXMAIL_INXMAIL_LIST_CUTOMER_SEGMENT_PREFIX = "Magento Customer Segment "; // Inxamil list prefix  Magento EE Version Only
    /**
     *
     */
    const DNDINXMAIL_INXMAIL_LIST_CUTOMER_GROUP_SPECIFIC_LIIT = 10; // Default limit

    /**
     * Get customer group to synchronize
     *
     * @return string ID separated by commas
     */
    public function getCustomerGroupsConfig()
    {
        $groups = Mage::getStoreConfig('dndinxmail_subscriber_mapping/mapping_groups/customer_group');

        return $this->formatCustomerGroups($groups);
    }

    /**
     * Get array of groups
     *
     * @param string $groups
     *
     * @return array
     */
    public function formatCustomerGroups($groups)
    {
        return array_filter(explode(',', $groups));
    }

    /**
     * Get Magento customer group name
     *
     * @param int $groupId Magento group ID
     *
     * @return string
     */
    public function getGroupName($groupId)
    {
        $resource      = Mage::getSingleton('core/resource');
        $read          = $resource->getConnection('core_read');
        $customerGroup = $resource->getTableName('customer/customer_group');
        $query         = "SELECT `$customerGroup`.`customer_group_code` as `group_name` FROM `$customerGroup` WHERE `$customerGroup`.`customer_group_id` = $groupId";

        try {
            if (!$result = $read->query($query)) {
                return false;
            }
            if (!$groupName = $result->fetch()) {
                return false;
            }

            return (isset($groupName['group_name'])) ? $groupName['group_name'] : false;
        }
        catch (Exception $e) {
            return false;
        }
    }

    /**
     * Format Magento Group ID to Inxmail list name
     *
     * @param int $groupId Magento group ID
     *
     * @return string Inxmail list name
     */
    public function formatInxmailListName($groupId)
    {
        $name = $this->getGroupName($groupId);

        return ($name) ? self::DNDINXMAIL_INXMAIL_LIST_CUTOMER_GROUP_PREFIX . $name : self::DNDINXMAIL_INXMAIL_LIST_CUTOMER_GROUP_PREFIX . $groupId;
    }

    /**
     * Check if Date Of Birth is enabled in Magento configuration
     *
     * @return boolean
     */
    public function isDobEnabled()
    {
        return (bool)Mage::getSingleton('eav/config')->getAttribute('customer', 'dob')->getIsVisible();
    }

    /**
     * @param null $day
     *
     * @return array
     */
    public function getDayRangeFromToday($day = null)
    {
        $day  = ($day == null || $day <= 0 || $day == '') ? 30 : $day;
        $from = new Zend_Date();
        $to   = new Zend_Date();
        $to   = $to->add(1, Zend_Date::DAY)->get("YYYY-MM-dd");
        $from = $from->sub($day, Zend_Date::DAY)->get("YYYY-MM-dd");

        return array(
            'from' => $from,
            'to'   => $to
        );
    }

    /**
     * @param $from
     * @param $to
     *
     * @return array
     */
    public function getDayRange($from, $to)
    {
        $format = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);
        $locale = Mage::app()->getLocale()->getLocale();
        $from   = new Zend_Date($from, $format, $locale);
        $to     = new Zend_Date($to, $format, $locale);
        $to     = $to->get("YYYY-MM-dd");
        $from   = $from->get("YYYY-MM-dd");

        return array(
            'from' => $from,
            'to'   => $to
        );
    }

    /**
     * Get customer from Magento group
     *
     * @param int $groupId Magento group ID
     *
     * @return array Array with customer email
     */
    public function getCustomersFromGroup($groupId)
    {
        $resource       = Mage::getSingleton('core/resource');
        $read           = $resource->getConnection('core_read');
        $configLimit    = Mage::getStoreConfig('dndinxmail_subscriber_mapping/mapping_groups/customer_limit_specific_groups');
        $limit          = ($configLimit != '' && $configLimit != null) ? $configLimit : self::DNDINXMAIL_INXMAIL_LIST_CUTOMER_GROUP_SPECIFIC_LIIT;
        $query          = false;
        $isDynamicQuery = false;
        $customers      = array();

        switch ($groupId) {

            case DndInxmail_Subscriber_Model_Adminhtml_System_Config_Source_Group_Specific::DNDINXMAIL_MAPPING_CUSTOMER_GROUP_SPECIFIC_LAST:
                $config = $this->getConfig('dndinxmail_subscriber_mapping/mapping_groups/customer_config_last_customers');
                $range  = $this->getDayRangeFromToday($config);
                if (!isset($range['from']) || !isset($range['to'])) {
                    return false;
                }
                $from          = $range['from'];
                $to            = $range['to'];
                $customerTable = $resource->getTableName('customer/entity');
                $query         = "SELECT `$customerTable`.`email` FROM `$customerTable` WHERE (created_at >= '$from' AND created_at <= '$to') ORDER BY `$customerTable`.`created_at`";
                break;

            case DndInxmail_Subscriber_Model_Adminhtml_System_Config_Source_Group_Specific::DNDINXMAIL_MAPPING_CUSTOMER_GROUP_SPECIFIC_BEST:
                $config        = $this->getConfig('dndinxmail_subscriber_mapping/mapping_groups/customer_config_best_customers');
                $limitAmount   = ($config == null || $config <= 0 || $config == '') ? 1000 : $config;
                $orderTable    = $resource->getTableName('sales/order');
                $customerTable = $resource->getTableName('customer/entity');
                $query         = "SELECT `customer_table`.`email`, SUM((main_table.base_subtotal -
IFNULL(main_table.base_subtotal_refunded, 0) - IFNULL(main_table.base_subtotal_canceled, 0) - ABS(main_table.base_discount_amount) -
IFNULL(main_table.base_discount_canceled, 0)) * main_table.base_to_global_rate) AS `orders_sum_amount` FROM `$orderTable` AS `main_table`
LEFT JOIN `$customerTable` AS `customer_table` ON main_table.customer_id = customer_table.entity_id
WHERE (main_table.customer_id IS NOT NULL) AND (state != 'canceled')
GROUP BY `main_table`.`customer_id`
HAVING `orders_sum_amount` >= $limitAmount
ORDER BY `orders_sum_amount` DESC";
                break;

            case DndInxmail_Subscriber_Model_Adminhtml_System_Config_Source_Group_Specific::DNDINXMAIL_MAPPING_CUSTOMER_GROUP_SPECIFIC_BIRTHDAY:
                $isDynamicQuery = true;
                $customers      = Mage::getModel('customer/customer')->getCollection()->addAttributeToFilter('dob', array('like' => '%-' . date('m-d') . ' %'))->load();
                break;

            case DndInxmail_Subscriber_Model_Adminhtml_System_Config_Source_Group_Specific::DNDINXMAIL_MAPPING_CUSTOMER_GROUP_SPECIFIC_ABANDONNED_CARTS:
                $config = $this->getConfig('dndinxmail_subscriber_mapping/mapping_groups/customer_config_abandonned_carts');
                $range  = $this->getDayRangeFromToday($config);
                if (!isset($range['from']) || !isset($range['to'])) {
                    return false;
                }
                $from           = $range['from'];
                $to             = $range['to'];
                $isDynamicQuery = true;
                $customers      = Mage::getResourceModel('reports/quote_collection')->addFieldToFilter('items_count', array('neq' => '0'))->addFieldToFilter('main_table.is_active', '1')->addFieldToFilter('main_table.created_at', array(
                    'from' => $from,
                    'to'   => $to
                ))->addCustomerData()->setOrder('updated_at');
                break;

            case DndInxmail_Subscriber_Model_Adminhtml_System_Config_Source_Group_Specific::DNDINXMAIL_MAPPING_CUSTOMER_GROUP_SPECIFIC_ORDERS:

                $type = $this->getConfig('dndinxmail_subscriber_mapping/mapping_groups/customer_config_orders_options');

                if ($type == DndInxmail_Subscriber_Model_Adminhtml_System_Config_Source_Orders::DNDINXMAIL_MAPPING_CUSTOMER_GROUP_SPECIFIC_ORDERS_SINGLE_DATE) {
                    $config = $this->getConfig('dndinxmail_subscriber_mapping/mapping_groups/customer_config_orders_options_single_date');
                    $range  = $this->getDayRangeFromToday($config);
                    if (!isset($range['from']) || !isset($range['to'])) {
                        return false;
                    }
                    $from = $range['from'];
                    $to   = $range['to'];
                }
                else {
                    $configFrom = $this->getConfig('dndinxmail_subscriber_mapping/mapping_groups/customer_config_orders_options_date_range_from');
                    $configTo   = $this->getConfig('dndinxmail_subscriber_mapping/mapping_groups/customer_config_orders_options_date_range_to');
                    $range      = $this->getDayRange($configFrom, $configTo);
                    if (!isset($range['from']) || !isset($range['to'])) return false;
                    $from = $range['from'];
                    $to   = $range['to'];
                }

                $orderTable = $resource->getTableName('sales/order');
                $query      = "SELECT `main_table`.`customer_email` as `email` FROM `$orderTable` AS `main_table` WHERE (created_at >= '$from' AND created_at <= '$to')";
                break;

            default:
                $customerTable = $resource->getTableName('customer/entity');
                $query         = "SELECT `$customerTable`.`email` FROM `$customerTable` WHERE `group_id` = $groupId";
                break;

        }

        if (!$isDynamicQuery) {
            if (!$query) {
                return false;
            }
            if (!$result = $read->query($query)) {
                return false;
            }
            if (!$customers = $result->fetchAll()) {
                return false;
            }
        }
        else {
            if (count($customers) <= 0) {
                return false;
            }
        }

        $emails = array();

        foreach ($customers as $customer) {
            $email = (isset($customer['email'])) ? $customer['email'] : false;
            if (!$email) {
                continue;
            }
            $emails[] = $email;
        }

        return (count($emails) > 0) ? $emails : false;
    }

}