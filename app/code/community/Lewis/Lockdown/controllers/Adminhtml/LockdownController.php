<?php

class Lewis_Lockdown_Adminhtml_LockdownController extends Mage_Adminhtml_Controller_Action {
	protected function helper($h) {
		return Mage::helper($h);
	}

	protected function getSession() {
		return Mage::getSingleton('adminhtml/session');
	}

	protected function _initAction() {
		$this->loadLayout();
		$this->_setActiveMenu('lockdown/manage');

		$h = $this->helper('lockdown');
		$a = $h->__('Lockdown');
		$b = $h->__('Manage Lockdowns');

		$this->_addBreadcrumb($a, $a);
		$this->_addBreadcrumb($b, $b);
		$this->_title($a);
	}

	public function indexAction() {
		$this->_initAction();
		$this->_title($this->helper('lockdown')->__('Manage Lockdowns'));
		$this->renderLayout();
	}

	protected function _initLockdown() {
		$l = Mage::getModel('lockdown/lockdown');
		if ($id = $this->getRequest()->getParam('lockdown_id')) {
			$l->load($id);
		}
		Mage::register('current_lockdown', $l);
		return $l;
	}

	public function newAction() {
		$this->_forward('edit');
	}

	public function editAction() {
		$this->_initLockdown();
		$this->_initAction();
		$this->_title($this->helper('lockdown')->__('Edit Lockdown'));
		$this->renderLayout();
	}

	public function saveAction() {
		$l = $this->_initLockdown();

		if (! $this->getRequest()->isPost()) {
			$this->_redirect('*/*/');
			return;
		}

		$post = $this->getRequest()->getPost();
		foreach ($post as $k=>$v) {
			if ($k == 'lockdown_id' || is_array($v)) {
				continue;
			}

			$l->setData($k, $v);
		}

		$h = $this->helper('lockdown');
		try {
			$l->save();
			$this->getSession()->addSuccess($h->__('Saved lockdown \'%s\'.', $l->getIdentifier()));
		}
		catch (Exception $e) {
			Mage::logException($e);
			$this->getSession()->addError($h->__('Error saving lockdown: %s', $e->getMessage()));
		}

		$this->_redirect('*/*/');
	}

	public function deleteAction() {
		$h = $this->helper('lockdown');
		$l = $this->_initLockdown();

		if (! $l->getId()) {
			$this->getSession()->addNotice($h->__('Cannot delete lockdown: it does not exist.'));
			$this->_redirect('*/*/');
			return;
		}

		try {
			$l->delete();
			$this->getSession()->addSuccess($h->__('Deleted lockdown.'));
		}
		catch (Exception $e) {
			Mage::logException($e);
			$this->getSession()->addError($h->__('Error deleting lockdown: %s', $e->getMessage()));
		}

		$this->_redirect('*/*/');
	}
}
