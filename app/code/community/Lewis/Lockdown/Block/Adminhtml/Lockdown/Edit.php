<?php

class Lewis_Lockdown_Block_Adminhtml_Lockdown_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {
	public function __construct() {
		$this->_blockGroup = 'lockdown_adminhtml';
		$this->_controller = 'lockdown';
		$this->_objectId = 'lockdown_id';

		parent::__construct();

		$h = $this->helper('lockdown');
		$ha = $this->helper('lockdown/adminhtml');
		if ($ha->isAllowedAction('save')) {
			$this->_updateButton('save', 'label', $h->__('Save Lockdown'));
		}
		else {
			$this->_removeButton('save');
		}
		if ($ha->isAllowedAction('delete')) {
			$this->_updateButton('delete', 'label', $h->__('Delete Lockdown'));
		}
		else {
			$this->_removeButton('delete');
		}
	}

	public function getHeaderText() {
		$l = Mage::registry('current_lockdown');
		if ($l->getId()) {
			return $this->helper('lockdown')->__('Edit Lockdown \'%s\'', $this->htmlEscape($l->getIdentifier()));
		}
		else {
			return $this->helper('lockdown')->__('New Lockdown');
		}
	}
}
