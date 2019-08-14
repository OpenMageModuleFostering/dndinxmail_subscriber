<?php

/** @var Mage_Core_Model_Resource_Setup $installer */
$installer = $this;

$installer->startSetup();

$customerAttributes = array(
    'entity_id',
    'website_id',
    'group_id',
    'store_id',
    'created_at',
    'updated_at',
    'is_active',
    'prefix',
    'firstname',
    'lastname',
    'gender',
    'dob'
);

$config = new Mage_Core_Model_Config();

/** @var Mage_Core_Model_Resource_Config_Data_Collection $configCollection */
$configCollection = Mage::getModel('core/config_data')->getCollection();
$configCollection->addPathFilter('dndinxmail_subscriber_mapping/mapping_customer');

$mapping        = array();
$defaultMapping = array();
foreach ($configCollection as $configItem) {
    // If value is null or empty we do not set it
    if (!$configItem->getValue()) {
        continue;
    }

    $dividedConfigPath = explode('/', $configItem->getPath());
    // Get attribute code
    $path = end($dividedConfigPath);

    if ($configItem->getScope() == 'default') {
        $defaultMapping[$path] = $configItem->getValue();
    } elseif ($configItem->getScope() == 'websites') {
        $scopeId = $configItem->getScopeId();
        if (!array_key_exists($scopeId, $mapping)) {
            $mapping[$scopeId] = array();
        }
        $mapping[$scopeId][$path] = $configItem->getValue();
    }
}

// Set values from default configuration if they were not set for website
foreach ($mapping as $websiteId => $websiteMapping) {
    foreach ($defaultMapping as $attributeCode => $inxmailColumn) {
        if (!array_key_exists($attributeCode, $websiteMapping)) {
            $mapping[$websiteId][$attributeCode] = $defaultMapping[$attributeCode];
        }
    }
}

$newMappingConfigPath = 'dndinxmail_subscriber_mapping/mapping_customer/mapping';

// Save default mapping
$mappingToSave = array();
foreach ($defaultMapping as $attributeCode => $inxmailColumn) {
    $mappingToSave[] = array(
        'attribute_code' => 'customer:' . $attributeCode,
        'inxmail_column' => $inxmailColumn,
    );
}
if (!empty($mappingToSave)) {
    $config->saveConfig($newMappingConfigPath, serialize($mappingToSave));
}

// Save mappings per websites
foreach ($mapping as $websiteId => $websiteMapping) {
    $mappingToSave = array();
    foreach ($websiteMapping as $attributeCode => $inxmailColumn) {
        $mappingToSave[] = array(
            'attribute_code' => 'customer:' . $attributeCode,
            'inxmail_column' => $inxmailColumn,
        );
    }
    if (!empty($mappingToSave)) {
        $config->saveConfig($newMappingConfigPath, serialize($mappingToSave), 'websites', $websiteId);
    }
}

$installer->endSetup();