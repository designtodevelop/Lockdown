<?php

class Lewis_Lockdown_SessionController extends Mage_Core_Controller_Front_Action {
	protected function getSession() {
		return Mage::getSingleton('lockdown/session');
	}

	public function loginAction() {
		$h = Mage::helper('lockdown');
		$s = $this->getSession();

		$lockdownId = $this->getRequest()->getParam('lockdown_id');
		if (! $lockdownId) {
			$s->addError($h->__('No lockdown ID given.'));
		}
		else {
			$l = Mage::getModel('lockdown/lockdown')->load($lockdownId);
			if (! $l->getId()) {
				$s->addError($h->__('Invalid lockdown ID given.'));
			}
			else {
				$u = $this->getRequest()->getParam('auth_username');
				$p = $this->getRequest()->getParam('auth_password');
				if ($u == $l->getAuthUsername() && $p == $l->getAuthPassword()) {
					$s = Mage::getSingleton('lockdown/session');
					$s->setLockdown($l);
					$s->setHash();
				}
				else {
					$s->addError($h->__('Invalid login details given.'));
				}
			}
		}

		$this->_redirectReferer();
	}
}
