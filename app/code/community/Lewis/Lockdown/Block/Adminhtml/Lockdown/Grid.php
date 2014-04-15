<?php

class Lewis_Lockdown_Block_Adminhtml_Lockdown_Grid extends Mage_Adminhtml_Block_Widget_Grid {
	public function __construct() {
		parent::__construct();
		$this->setId('lockdownGrid');
		$this->setDefaultSort('identifier');
		$this->setDefaultDir('ASC');
	}

	protected function _prepareCollection() {
		$collection = Mage::getResourceModel('lockdown/lockdown_collection');
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	protected function _prepareColumns() {
		$h = $this->helper('lockdown');

		$this->addColumn('identifier', array(
			'header' => $h->__('Identifier'),
			'align' => 'left',
			'index' => 'identifier'
		));

		$this->addColumn('active', array(
			'header' => $h->__('Active'),
			'align' => 'left',
			'index' => 'active',
			'type' => 'options',
			'options' => Mage::getModel('adminhtml/system_config_source_yesno')->toArray()
		));

		return parent::_prepareColumns();
	}

	public function getRowUrl($item) {
		return $this->getUrl('*/*/edit', array('lockdown_id' => $item->getId()));
	}
}
