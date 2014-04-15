<?php

class Lewis_Lockdown_Model_Lockdown extends Mage_Core_Model_Abstract {
	protected $_eventPrefix = 'lockdown_lockdown';

	protected function _construct() {
		$this->_init('lockdown/lockdown');
	}
}
