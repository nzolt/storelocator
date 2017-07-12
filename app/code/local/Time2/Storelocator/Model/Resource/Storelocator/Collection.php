<?php
/**
 * @author      Time2 Digital
 * 
 */
class Time2_Storelocator_Model_Resource_Storelocator_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Model collection constructor
     *
     */
    protected function _construct()
    {
       $this->_init('time2_storelocator/storelocator');
       $this->_map['fields']['storelocator_id'] = 'main_table.storelocator_id';
       $this->_map['fields']['store']   = 'store_table.store_id';
    }
    
    /**
     * Add status to filter
     * @return Time2_Storelocator_Model_Resource_Storelocator_Collection
     */
    public function addStatusFilter()
    {
        return $this->addFieldToFilter('status', 1);
    }
    
    /**
     * List stores on page
     * @param integer $page
     * @return Time2_Storelocator_Model_Resource_Storelocator_Collection
     */
    public function prepareForList($page)
    {
        $this->setPageSize(Mage::helper('time2_storelocator')->getStoresPerPage());
        $this->setCurPage($page);
        $this->setOrder('created_at', Varien_Data_Collection::SORT_ORDER_DESC);
        return $this;
    }
    
    /**
     * Add specific store to filter
     * @param int|Mage_Core_Model_Store $store
     * @param bool $withAdmin
     * @return Time2_Storelocator_Model_Resource_Storelocator_Collection
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        if (!$this->getFlag('store_filter_added')) {
            if ($store instanceof Mage_Core_Model_Store) {
                $store = array($store->getId());
            }

            if (!is_array($store)) {
                $store = array($store);
            }

            if ($withAdmin) {
                $store[] = Mage_Core_Model_App::ADMIN_STORE_ID;
            }

            $this->addFilter('store', array('in' => $store), 'public');
        }
        return $this;
    }
    
     /**
     * Join store tables
     */
    protected function _renderFiltersBefore()
    {
        if ($this->getFilter('store')) {
            $this->getSelect()->join(
                array('store_table' => $this->getTable('time2_storelocator/storelocator_store')),
                'main_table.storelocator_id = store_table.storelocator_id',
                array()
            );
        }
        return parent::_renderFiltersBefore();
    }
}