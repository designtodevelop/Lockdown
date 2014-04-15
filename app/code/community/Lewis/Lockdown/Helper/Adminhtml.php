<?php

class Lewis_Lockdown_Helper_Adminhtml extends Mage_Core_Helper_Abstract {
	public function isAllowedAction($action) {
		return Mage::getSingleton('admin/session')->isAllowed('lockdown/manage/'.$action);
	}
}
