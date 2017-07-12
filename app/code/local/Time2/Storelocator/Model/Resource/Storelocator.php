<?php
/**
 * @author Time2 Digital
 */
class Time2_Storelocator_Model_Resource_Storelocator extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Resource model constructor
     */
    protected function _construct()
    {
        $this->_init('time2_storelocator/storelocator', 'storelocator_id');
    }
    
    /**
     * Storelocator model before delete
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Time2_Storelocator_Model_Resource_Storelocator
     */
    protected function _beforeDelete(Mage_Core_Model_Abstract $object)
    {
        $condition = array(
            'storelocator_id = ?'     => (int) $object->getId(),
        );

        $this->_getWriteAdapter()->delete($this->getTable('time2_storelocator/storelocator_store'), $condition);

        return parent::_beforeDelete($object);
    }
    
    /**
     * Check if store already exists by name and/or id
     *
     * @param $storeName store name
     * @param $storelocatorId storelocaror id
     * @return array|false
     */
    public function storeExists($storeName, $storelocatorId = null)
    {
        $adapter = $this->_getReadAdapter();
        $select = $adapter->select();
        $binds = array();

        if(empty($storelocatorId)){
            $binds = array(
              'name' => $storeName,
            );
            
             $select->from($this->getMainTable())
             ->where('(name = :name)');
        } else {
            $binds = array(
              'name' => $storeName,
              'storelocator_id'  => (int) $storelocatorId,
            ); 
            
            $select->from($this->getMainTable())
            ->where('(name = :name)')
            ->where('storelocator_id <> :storelocator_id');
        }
        return $adapter->fetchRow($select, $binds);
    }
    
    /**
     * Storelocator model after save
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Time2_Storelocator_Model_Resource_Storelocator
     */
    protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
        $oldStores = $this->lookupStoreIds($object->getId());
        $newStores = (array)$object->getStores();
        if (empty($newStores)) {
            $newStores = (array)$object->getStoreId();
        }
        $table  = $this->getTable('time2_storelocator/storelocator_store');
        $insert = array_diff($newStores, $oldStores);
        $delete = array_diff($oldStores, $newStores);

        if ($delete) {
            $where = array(
                'storelocator_id = ?'     => (int) $object->getId(),
                'store_id IN (?)' => $delete
            );

            $this->_getWriteAdapter()->delete($table, $where);
        }

        if ($insert) {
            $data = array();

            foreach ($insert as $storeId) {
                $data[] = array(
                    'storelocator_id'  => (int) $object->getId(),
                    'store_id' => (int) $storeId
                );
            }

            $this->_getWriteAdapter()->insertMultiple($table, $data);
        }

        return parent::_afterSave($object);
    }
    
    /**
     * Get store ids for store
     *
     * @param int $storelocatorId
     * @return array
     */
    public function lookupStoreIds($storelocatorId)
    {
        $adapter = $this->_getReadAdapter();

        $select  = $adapter->select()
            ->from($this->getTable('time2_storelocator/storelocator_store'), 'store_id')
            ->where('storelocator_id = ?',(int)$storelocatorId);
        return $adapter->fetchCol($select);
    }
    
    /**
     * Operations after load
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Mage_Cms_Model_Resource_Page
     */
    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        if ($object->getId()) {
            $stores = $this->lookupStoreIds($object->getId());

            $object->setData('store_id', $stores);

        }
        return parent::_afterLoad($object);
    }
    
    /**
     * Get select object data
     *
     * @param string $field
     * @param mixed $value
     * @param Mage_Cms_Model_Page $object
     * @return Zend_Db_Select
     */
    protected function _getLoadSelect($field, $value, $object)
    {
        $select = parent::_getLoadSelect($field, $value, $object);

        if ($object->getStoreId()) {
            $storeIds = array(Mage_Core_Model_App::ADMIN_STORE_ID, (int)$object->getStoreId());
            $select->join(
                array('time2_storelocator_store' => $this->getTable('time2_storelocator/storelocator_store')),
                $this->getMainTable() . '.storelocator_id = time2_storelocator_store.storelocator_id',
                array())
                ->where('status = ?', 1)
                ->where('time2_storelocator_store.store_id IN (?)', $storeIds)
                ->order('time2_storelocator_store.store_id DESC')
                ->limit(1);
        }
        return $select;
    }
    
    /**
     * Country code from name
     * @param sting $countryName
     * @return string $countryId
     */
    protected function _getCountryCountryCode($countryName)
    {
        $countryId = '';
        $countryCollection = Mage::getModel('directory/country')->getCollection();
        foreach ($countryCollection as $country) {
            if ($countryName == $country->getName()) {
                $countryId = $country->getCountryId();
                break;
            }
        }
        
        if(empty($countryId)){
            return '';
        }else{
            return $countryId;
        }
    }
}