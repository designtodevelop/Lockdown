<?php

class Lewis_Lockdown_Model_Observer {
	const LAYOUT_HANDLE_RESTRICT_CMS = 'lockdown_restrict_cms';

	const LAYOUT_HANDLE_AUTH_BASIC = 'lockdown_auth_basic';
	const LAYOUT_HANDLE_AUTH_CUSTOMER_GROUP = 'lockdown_auth_customer_group';

	protected function getRequestPath() {
		$r = Mage::app()->getRequest();
		$a = array(
			$r->getModuleName(),
			$r->getControllerName(),
			$r->getActionName()
		);
		return $a;
	}

	protected function getRequestPathStr() {
		return implode('_', $this->getRequestPath());
	}

	protected function addAuthTypeLayoutHandle($u) {
		$s = Mage::getSingleton('lockdown/session');
		switch(true) {
			case $s->requireBasicAuth():
				$u->addHandle(self::LAYOUT_HANDLE_AUTH_BASIC);
			break;
			case $s->requireCustomerGroup():
				$u->addHandle(self::LAYOUT_HANDLE_AUTH_CUSTOMER_GROUP);
			break;
		}
	}

	public function initLayoutHandle($o) {
		$s = Mage::getSingleton('lockdown/session');
		switch ($this->getRequestPathStr()) {
			case 'cms_page_view':
				$pageId = Mage::app()->getRequest()->getParam('page_id');
				if ($pageId) {
					$lockdownId = Mage::getSingleton('lockdown/relation_page')->getLockdown($pageId);
					$s->setLockdown($lockdownId);
					if (! $s->authenticate()) {
						$u = $o->getEvent()->getLayout()->getUpdate();
						$u->addHandle(self::LAYOUT_HANDLE_RESTRICT_CMS);
						$this->addAuthTypeLayoutHandle($u);
					}
				}
			break;
		}
	}
}
