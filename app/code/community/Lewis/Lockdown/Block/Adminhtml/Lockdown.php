<?php

class Lewis_Lockdown_Block_Adminhtml_Lockdown extends Mage_Adminhtml_Block_Widget_Grid_Container {
	public function __construct() {
		$this->_blockGroup = 'lockdown_adminhtml';
		$this->_controller = 'lockdown';

		$this->_headerText = $this->helper('lockdown')->__('Manage Lockdowns');

		parent::__construct();

		if ($this->helper('lockdown/adminhtml')->isAllowedAction('save')) {
			$this->_updateButton('add', 'label', $this->helper('lockdown')->__('Add New Lockdown'));
		} else {
			$this->_removeButton('add');
		}
	}
}
