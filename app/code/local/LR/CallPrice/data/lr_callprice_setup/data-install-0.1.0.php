<?php
$installer = $this;

$installer->startSetup();

$installer->addAttribute('catalog_product', 'call_for_price_active', array(
    'group'              => 'Prices',
    'type'               => 'int',
    'backend'            => '',
    'frontend'           => '',
    'label'              => 'Call For Price',
    'input'              => 'select',
    'class'              => '',
    'source'             => 'eav/entity_attribute_source_boolean',
    'global'             => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible'            => true,
    'required'           => false,
    'user_defined'       => false,
    'default'            => 'No',
    'searchable'         => false,
    'filterable'         => false,
    'comparable'         => false,
    'visible_on_front'   => false,
    'unique'             => false,
    'apply_to'           => '',
    'is_configurable'    => false	
));

$installer->endSetup();