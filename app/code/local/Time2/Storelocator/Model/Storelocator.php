<?php
/**
 * @author      Time2 Digital
 * 
 */
class Time2_Storelocator_Model_Storelocator extends Mage_Core_Model_Abstract
{
    /**
     * Resource model constructor
     */
    protected function _construct()
    {
        $this->_init('time2_storelocator/storelocator');
    }
    
    /**
     * Check if store name already exists
     *
     * @param $storeName store name
     * @param $storelocatorId storelocator id
     * @return boolean
     */
    public function storeExists($storeName, $storelocatorId = null)
    {
        $result = $this->_getResource()->storeExists($storeName, $storelocatorId);
        return (is_array($result) && count($result) > 0) ? true : false;
    }
    
}