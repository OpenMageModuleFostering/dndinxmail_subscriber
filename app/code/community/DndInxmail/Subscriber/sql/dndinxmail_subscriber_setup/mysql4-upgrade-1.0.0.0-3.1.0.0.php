<?php

/**
 * @category               Module SQL setup
 * @package                DndInxmail_Subscriber
 * @dev                    Merlin
 * @last_modified          13/03/2013
 * @copyright              Copyright (c) 2012 Agence Dn'D
 * @author                 Agence Dn'D - Conseil en creation de site e-Commerce Magento : http://www.dnd.fr/
 * @license                http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

$installer = $this;

$installer->startSetup();

$installer->getConnection()->addColumn($installer->getTable('newsletter/subscriber'), "email_bounced", "SMALLINT( 5 ) UNSIGNED NOT NULL DEFAULT '0'");

$installer->endSetup();
