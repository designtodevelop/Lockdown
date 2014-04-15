<?php

class Lewis_Lockdown_Block_Adminhtml_Lockdown_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {
	public function __construct() {
		parent::__construct();
		$this->setId('lockdown_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle($this->helper('lockdown')->__('Lockdown Information'));
	}
}
