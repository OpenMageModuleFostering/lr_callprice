<?php
$installer = $this;

$installer->startSetup();

$installer->getConnection()->dropTable($installer->getTable('lr_callprice/request'));

$table = $installer->getConnection()
    ->newTable($installer->getTable('lr_callprice/request'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true
    ), 'ID')
    ->addColumn('customer_name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => false
    ), 'Name')
    ->addColumn('customer_email', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => false
    ), 'Email')
    ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false
    ), 'Customer ID')
    ->addColumn('customer_telephone', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false
    ), 'Customer Telephone')
    ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false
    ), 'Product ID')
    ->addColumn('product_name', Varien_Db_Ddl_Table::TYPE_TEXT,null, array(
        'nullable'  => false
    ), 'Product Name')
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => false
    ), 'Status');

$installer->getConnection()->createTable($table);

$installer->endSetup();