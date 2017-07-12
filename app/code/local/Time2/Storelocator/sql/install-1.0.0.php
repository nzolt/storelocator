<?php
/**
 * @author      Time2 Digital <nzolt@time2.digital>
 * 
 */

$installer = $this;

$installer->startSetup();

/**
 * table 'time2_storelocator/storelocator'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('time2_storelocator/storelocator'))
    ->addColumn('storelocator_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Storelocator Id')
        
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Store Name')
        
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_TINYINT, null, array(
        'nullable'  => false,
        'default'   => '1',
        ), 'Staus')
        
   ->addColumn('street', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        'default'   => null,
        ), 'Street Address')
        
   ->addColumn('country', Varien_Db_Ddl_Table::TYPE_TEXT, 64, array(
        'nullable'  => true,
        'default'   => null,
        ), 'Country')
   
    ->addColumn('city', Varien_Db_Ddl_Table::TYPE_TEXT, 64, array(
        'nullable'  => true,
        'default'   => null,
        ), 'City')
        
   ->addColumn('zipcode', Varien_Db_Ddl_Table::TYPE_TEXT, 64, array(
        'nullable'  => true,
        'default'   => null,
        ), 'Zipcode')
        
   ->addColumn('phone', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        'default'   => null,
        ), 'Phone')
        
   ->addColumn('description', Varien_Db_Ddl_Table::TYPE_TEXT, '64K', array(
        'nullable'  => true,
        'default'   => null,
        ), 'Description')
        
   ->addColumn('opening_hours', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        'default'   => null,
        ), 'Trading Hours')
        
  ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
       'nullable' => true,
       'default'  => null,
        ), 'Creation Time')
   
  ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
       'nullable' => true,
       'default'  => null,
        ), 'Store Updated Date')
 
  ->addIndex(
        $installer->getIdxName(
            'time2_storelocator/storelocator',
            array('name'), 
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
        ),
        array('name'), 
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
        
    ->setComment('Time2 Storelocator Table');

$installer->getConnection()->createTable($table);

/**
 * table 'time2_storelocator/storelocator_store'
 */

$table = $installer->getConnection()
    ->newTable($installer->getTable('time2_storelocator/storelocator_store'))
    ->addColumn('storelocator_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'primary'   => true,
        ), 'Storelocator ID')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Store ID')
    ->addIndex($installer->getIdxName('time2_storelocator/storelocator_store', array('store_id')),
        array('store_id'))
        
    ->addForeignKey($installer->getFkName('time2_storelocator/storelocator_store', 'storelocator_id', 'time2_storelocator/storelocator', 'storelocator_id'),
        'storelocator_id', $installer->getTable('time2_storelocator/storelocator'), 'storelocator_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        
    ->addForeignKey($installer->getFkName('time2_storelocator/storelocator_store', 'store_id', 'core/store', 'store_id'),
        'store_id', $installer->getTable('core/store'), 'store_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        
    ->setComment('Time2 Storelocator To Store Linkage Table');
$installer->getConnection()->createTable($table);

$installer->endSetup();