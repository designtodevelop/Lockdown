<?php

class Lewis_Lockdown_Model_Resource_Lockdown extends Mage_Core_Model_Resource_Db_Abstract {
	protected function _construct() {
		$this->_init('lockdown/lockdown', 'lockdown_id');
	}
}
