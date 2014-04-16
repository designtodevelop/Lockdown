<?php

class Lewis_Lockdown_Model_Observer {
	const LAYOUT_HANDLE_LOGIN_CMS = 'lockdown_login_cms';

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

	public function initLayoutHandle($o) {
		switch ($this->getRequestPathStr()) {
			case 'cms_index_index':
			case 'cms_page_view':
				$h = Mage::helper('lockdown/cms');
				if (! $h->canViewPage()) {
					$u = $o->getEvent()->getLayout()->getUpdate();
					$u->addHandle(self::LAYOUT_HANDLE_LOGIN_CMS);
				}
			break;
		}
	}
}
