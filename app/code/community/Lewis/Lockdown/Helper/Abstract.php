<?php

abstract class Lewis_Lockdown_Helper_Abstract extends Mage_Core_Helper_Abstract {
	protected function getLockdownModel($id) {
		return Mage::getModel('lockdown/lockdown')->load($id);
	}

	protected function canBypassLockdown($l) {
		if (! $l instanceof Lewis_Lockdown_Model_Lockdown) {
			$l = $this->getLockdownModel($l);
		}

		return false;
	}
}
