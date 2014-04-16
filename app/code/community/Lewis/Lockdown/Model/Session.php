<?php

class Lewis_Lockdown_Model_Session extends Mage_Core_Model_Session_Abstract {
	const SESSION_NAMESPACE = 'lockdown';
	const VAR_HASH_ARRAY = 'user_hash';

	public function __construct() {
		$this->init(self::SESSION_NAMESPACE);
	}

	public function setLockdown($l) {
		if (! $l instanceof Lewis_Lockdown_Model_Lockdown) {
			$l = Mage::getModel('lockdown/lockdown')->load($l);
		}

		Mage::register('current_lockdown', $l);
	}

	public function getLockdown() {
		return Mage::registry('current_lockdown');
	}

	protected function getAuthTypeSource() {
		return Mage::getSingleton('lockdown/system_config_source_auth_type');
	}

	public function requireBasicAuth() {
		$s = $this->getAuthTypeSource();
		return $this->getLockdown()->getAuthType() == $s::AUTH_TYPE_BASIC;
	}

	public function requireCustomerGroup() {
		$s = $this->getAuthTypeSource();
		return $this->getLockdown()->getAuthType() == $s::AUTH_TYPE_CUSTOMER_GROUP;
	}

	public function getHashes() {
		return $this->getData(self::VAR_HASH_ARRAY);
	}

	public function setHash() {
		$hashes = $this->getHashes();
		if (! is_array($hashes)) {
			$hashes = array();
		}
		$hashes[$this->getLockdown()->getId()] = $this->getLockdown()->getHash();
		$this->setData(self::VAR_HASH_ARRAY, $hashes);
		return $this;
	}

	public function authenticate() {
		if ($this->requireBasicAuth()) {
			$currId = $this->getLockdown()->getId();
			$hashes = $this->getHashes();
			if (! in_array($currId, array_keys($hashes))) {
				return false;
			}
			$currHash = $this->getLockdown()->getHash();
			$valid = false;
			foreach ($this->getHashes() as $id => $hash) {
				if ($id != $currId) {
					continue;
				}
				if ($hash == $currHash) {
					return true;
				}
			}
		}
		else if ($this->requireCustomerGroup()) {
			#Mage::throwException(Mage::helper('lockdown')->__('Customer Group-based authentication not yet supported.'));
		}
		return false;
	}
}
