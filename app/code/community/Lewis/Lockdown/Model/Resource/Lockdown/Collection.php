<?php

class Lewis_Lockdown_Model_Resource_Lockdown_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract {
	protected function _construct() {
		$this->_init('lockdown/lockdown');
	}
}
