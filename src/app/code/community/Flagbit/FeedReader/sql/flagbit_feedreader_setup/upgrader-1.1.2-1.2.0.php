<?php
/**
 * Magento
 *
 * @category   Flagbit
 * @package    Flagbit_FeedReader
 * @copyright  Copyright (c) 2013 Flagbit GmbH & Co. KG (http://www.flagbit.de)
 */

$installer = $this;

$installer->startSetup();

$installer->addAttribute('catalog_category', 'feedreader_url', array(
    'type'                       => 'varchar',
    'label'                      => 'FeedReader URL',
    'input'                      => 'text',
    'required'                   => false,
    'sort_order'                 => 100,
    'global'                     => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'group'                      => 'Display Settings'
));

$installer->addAttribute('catalog_product', 'feedreader_url', array(
    'type'                       => 'varchar',
    'label'                      => 'FeedReader URL',
    'input'                      => 'text',
    'sort_order'                 => 100,
    'global'                     => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'group'                      => 'General Information',
    'required'                   => false,
));

$installer->endSetup();
