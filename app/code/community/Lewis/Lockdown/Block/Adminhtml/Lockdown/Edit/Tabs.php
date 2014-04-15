<?php

class Lewis_Lockdown_Block_Adminhtml_Lockdown_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {
	public function __construct() {
		parent::__construct();
		$this->setId('lockdown_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle($this->helper('lockdown')->__('Lockdown Information'));
	}

	protected function _beforeToHtml() {
		$this->addTab('cms_page', array(
			'label' => $this->helper('cms')->__('Pages'),
			'title' => $this->helper('cms')->__('Pages'),
			'url' => $this->getUrl('*/*/pagesInit', array('_current' => true)),
			'class' => 'ajax'
		));

		return parent::_beforeToHtml();
	}
}
