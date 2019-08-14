<?php

class LR_CallPrice_Model_Resource_Request_Collection
    extends Mage_Core_Model_Resource_Db_Collection_Abstract {

    public function _construct() {
        $this->_init("lr_callprice/request");
    }
}