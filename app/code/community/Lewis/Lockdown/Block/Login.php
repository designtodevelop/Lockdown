<?php

class Lewis_Lockdown_Block_Login extends Mage_Core_Block_Template {
	public function getLoginUrl() {
		return $this->getUrl('lockdown/session/login');
	}

	public function getLockdownId() {
		return Mage::getSingleton('lockdown/session')->getLockdown()->getId();
	}
}
