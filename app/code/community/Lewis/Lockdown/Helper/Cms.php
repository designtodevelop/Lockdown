<?php

class Lewis_Lockdown_Helper_Cms extends Lewis_Lockdown_Helper_Abstract {
	public function canViewPage() {
		$pageId = Mage::app()->getRequest()->getParam('page_id');
		if ($pageId) {
			$lockdownId = Mage::getSingleton('lockdown/relation_page')->getLockdown($pageId);
			if ($lockdownId) {
				return $this->canBypassLockdown($lockdownId);
			}
		}
		return true;
	}
}
