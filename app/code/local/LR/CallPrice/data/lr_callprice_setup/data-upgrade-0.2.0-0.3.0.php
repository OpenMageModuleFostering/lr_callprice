<?php
$installer = $this;

$installer->startSetup();

$idAttributeOldSelect = $this->getAttribute('catalog_product', 'call_for_price_active', 'attribute_id');
$installer->updateAttribute('catalog_product', $idAttributeOldSelect, array(
    'is_visible_on_front'=> true,
	'used_in_product_listing' => true
	));

$installer->endSetup();