<?php

class Lewis_Lockdown_Model_Lockdown extends Mage_Core_Model_Abstract {
	protected $_eventPrefix = 'lockdown';
	protected $_eventObject = 'lockdown';

	protected function _construct() {
		$this->_init('lockdown/lockdown');
	}

	protected function _beforeSave() {
		parent::_beforeSave();

		// reset hash, invalidate existing sessions
		$hash = md5(microtime().$this->getIdentifier());
		$this->setHash($hash);

		// if not using basic auth, delete username + password
		$m = Mage::getModel('lockdown/system_config_source_auth_type');
		if ($this->getAuthType() != $m::AUTH_TYPE_BASIC) {
			$this->setAuthUsername(null)->setAuthPassword(null);
		}

		return $this;
	}

	public function getCmsPageRelations() {
		return Mage::getSingleton('lockdown/relation_page')->getRelations($this);
	}
}
