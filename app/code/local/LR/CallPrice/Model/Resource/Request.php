<?php

class LR_CallPrice_Model_Resource_Request extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init("lr_callprice/request", "id");
    }
}