<?php
/**
 * @author      Time2 Digital
 * 
 */


class Time2_Storelocator_Model_Enabledisable extends Mage_Adminhtml_Model_System_Config_Source_Enabledisable
{
    /**
     * @return array
     */
    public function toArray()
    {
        return array(
            1 => Mage::helper('adminhtml')->__('Enable'),
            0 => Mage::helper('adminhtml')->__('Disable'),
        );
    }
}
