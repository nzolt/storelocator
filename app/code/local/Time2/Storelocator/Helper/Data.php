<?php
/**
 * Store locator data helper
 * 
 * @category    Time2
 * @package     Time2_Storelocator
 * @author      Time2 Digital
 */
class Time2_Storelocator_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Frontend output config
     *
     * @var string
     */
    const XML_PATH_ENABLED = 'time2_storelocator_setting/time2_storelocator_status/enable';

    /**
     * Default stores per page
     *
     * @var string
     */
    const XML_PATH_STORES_PER_PAGE = 'time2_storelocator_setting/time2_storelocator_display_setting/stores_per_page';
    
    /**
     * Store view instance
     *
     * @var time2_storelocator_model_storelocator
     */
    protected $_storeViewInstance;
    
    /**
     * Checks if can be displayed in the frontend
     *
     * @param integer|string|Mage_Core_Model_Store $store
     * @return boolean
     */
    public function isEnabled($store = null)
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_ENABLED, $store);
    }
    
    /**
     * Get current store instance from the Registry
     *
     * @return time2_storelocator_model_storelocator
     */
    public function getStoreViewInstance()
    {
        if (!$this->_storeViewInstance) {
            $this->_storeViewInstance = Mage::registry('store_view');

            if (!$this->_storeViewInstance) {
                Mage::throwException($this->__('Store view instance does not exist'));
            }
        }

        return $this->_storeViewInstance;
    }
    
    /**
     * Get stores per page
     *
     * @param integer|string|Mage_Core_Model_Store $store
     * @return int
     */
    public function getStoresPerPage($store = null)
    {
        return abs((int)Mage::getStoreConfig(self::XML_PATH_STORES_PER_PAGE, $store));
    }
    
    /**
     * Get search form post url
     *
     * @return string
     */
    public function getSearchPostUrl()
    {
        return $this->_getUrl('storelocator/index/search');
    }
    
    /**
     * Get country name by county code
     *
     * @param string $countryCode country code
     * @return string
     */
    public function getCountryNameByCode($countryCode)
    {
        $countryModel = Mage::getModel('directory/country')->loadByCode($countryCode);
        return $countryModel->getName();
    }
}
