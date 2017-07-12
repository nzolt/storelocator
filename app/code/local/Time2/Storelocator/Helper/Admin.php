<?php
/**
 * @author      Time2 Digital
 */
class Time2_Storelocator_Helper_Admin extends Mage_Core_Helper_Abstract
{
    /**
     * ACL
     *
     * @param string $action
     * @return bool
     */
    public function isActionAllowed($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('time2_storelocator/time2_manage_storelocator/' . $action);
    }
}