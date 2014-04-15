<?php

class Lewis_Lockdown_Adminhtml_LockdownController extends Mage_Adminhtml_Controller_Action {
	protected function _initAction() {
		$h = Mage::helper('lockdown');

		$this->loadLayout();
		$this->_setActiveMenu('lockdown/manage');

		$a = $h->__('Lockdown');
		$b = $h->__('Manage Lockdowns');
		$this->_addBreadcrumb($a, $a);
		$this->_addBreadcrumb($b, $b);
		$this->_title($a);
	}

	public function indexAction() {
		$this->_initAction();
		$this->_title(Mage::helper('lockdown')->__('Manage Lockdowns'));
		$this->renderLayout();
	}

	//wip placeholders

	public function newAction() {
		$this->_forward('edit');
	}

	public function editAction() {
	}

	public function saveAction() {
	}

	public function deleteAction() {
	}
}
