<?php

class Lewis_Lockdown_Helper_Adminhtml extends Mage_Core_Helper_Abstract {
	public function isAllowedAction($action) {
		return Mage::getSingleton('admin/session')->isAllowed('lockdown/manage/'.$action);
	}

	public function getPost($f=null) {
		$r = Mage::app()->getRequest();
		if (! $r->isPost()) {
			return null;
		}

		$p = $r->getPost('lockdown');
		if ($f) {
			return isset($p[$f]) ? $p[$f] : null;
		}
		return $p;
	}
}
