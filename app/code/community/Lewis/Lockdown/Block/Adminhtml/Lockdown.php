<?php

class Lewis_Lockdown_Block_Adminhtml_Lockdown extends Mage_Adminhtml_Block_Widget_Grid_Container {
	public function __construct() {
		$this->_blockGroup = 'lockdown_admin';
		$this->_controller = 'lockdown';

		$h = Mage::helper('lockdown');
		$this->_headerText = $h->__('Manage Lockdowns');

		parent::__construct();

		if ($this->_isAllowedAction('save')) {
			$this->_updateButton('add', 'label', $h->__('Add New Lockdown'));
		} else {
			$this->_removeButton('add');
		}
	}

	protected function _isAllowedAction($action) {
		return Mage::getSingleton('admin/session')->isAllowed('lockdown/manage/'.$action);
	}
}
