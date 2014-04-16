<?php

class Lewis_Lockdown_Model_Lockdown extends Mage_Core_Model_Abstract {
	protected $_eventPrefix = 'lockdown';
	protected $_eventObject = 'lockdown';

	protected function _construct() {
		$this->_init('lockdown/lockdown');
	}

	public function getCmsPageRelations() {
		return Mage::getSingleton('lockdown/relation_page')->getRelations($this);
	}
}
