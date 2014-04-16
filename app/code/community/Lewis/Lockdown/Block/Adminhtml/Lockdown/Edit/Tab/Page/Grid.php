<?php

class Lewis_Lockdown_Block_Adminhtml_Lockdown_Edit_Tab_Page_Grid extends Mage_Adminhtml_Block_Widget_Grid {
	public function __construct() {
		parent::__construct();
		$this->setId('cmsPagesGrid');
		$this->setDefaultSort('page_id');
		$this->setDefaultSort('identifier');
		$this->setDefaultDir('ASC');
		$this->setUseAjax(true);
	}

	protected function _addColumnFilterToCollection($column) {
		if ($column->getId() == 'cms_page') {
			$ids = $this->getSelectedPages();
			if ($column->getFilter()->getValue()) {
				$this->getCollection()->addFieldToFilter('page_id', array('in' => $ids));
			}
			else if (count($ids)) {
				$this->getCollection()->addFieldToFilter('page_id', array('nin' => $ids));
			}

			return $this;
		}

		return parent::_addColumnFilterToCollection($column);
	}

	protected function _prepareCollection() {
		$c = Mage::getResourceModel('cms/page_collection');
		$c->setFirstStoreFlag(true);
		$l = Mage::registry('current_lockdown');
		Mage::getSingleton('lockdown/relation_page')->removeUnavailableWithJoin($l, $c);
		$this->setCollection($c);
		return parent::_prepareCollection();
	}

	protected function _afterLoadCollection() {
		$this->getCollection()->walk('afterLoad');
		parent::_afterLoadCollection();
	}

	protected function _filterStoreCondition($collection, $column) {
		if (! $value = $column->getFilter()->getValue()) {
			return;
		}

		$this->getCollection()->addStoreFilter($value);
	}

	protected $_preselectDisabled = false;
	public function disablePreselect() {
		$this->_preselectDisabled = true;
	}

	protected function getPreselectedPages() {
		return Mage::registry('current_lockdown')->getCmsPageRelations();
	}

	// selections via ajax
	protected function getPostedPages() {
		$r = Mage::app()->getRequest();
		$post = $this->getRequest()->getPost('lockdown');
		if (is_array($post) && isset($post['cms_pages'])) {
			return $post['cms_pages'];
		}
		return null;
	}

	public function getSelectedPages() {
		if ($this->hasData('selected_pages')) {
			return $this->getData('selected_pages');
		}
		else if ($p = $this->getPostedPages()) {
			$this->setSelectedPages($p);
			return $p;
		}
		else if (! $this->_preselectDisabled) {
			return $this->getPreselectedPages();
		}
		return array();
	}

	public function getGridUrl() {
		return $this->getUrl('*/*/pagesgrid', array('_current' => true));
	}

	protected function _prepareColumns() {
		$this->addColumn('cms_page', array(
			'type' => 'checkbox',
			'name' => 'cms_page',
			'values' => $this->getSelectedPages(),
			'index' => 'page_id',
			'header_css_class' => 'a-center',
			'align' => 'center'
		));

		$this->addColumn('title', array(
			'header' => Mage::helper('cms')->__('Title'),
			'align' => 'left',
			'index' => 'title'
		));

		$this->addColumn('identifier', array(
			'header' => Mage::helper('cms')->__('URL Key'),
			'align' => 'left',
			'index' => 'identifier'
		));

		$this->addColumn('root_template', array(
			'header' => Mage::helper('cms')->__('Layout'),
			'index' => 'root_template',
			'type' => 'options',
			'options' => Mage::getSingleton('page/source_layout')->getOptions()
		));

		if (! Mage::app()->isSingleStoreMode()) {
			$this->addColumn('store_id', array(
				'header' => Mage::helper('cms')->__('Store View'),
				'index' => 'store_id',
				'type' => 'store',
				'store_all' => true,
				'store_view' => true,
				'sortable' => false,
				'filter_condition_callback' => array($this, '_filterStoreCondition')
			));
		}

		$this->addColumn('is_active', array(
			'header' => Mage::helper('cms')->__('Status'),
			'index' => 'is_active',
			'type' => 'options',
			'options' => Mage::getSingleton('cms/page')->getAvailableStatuses()
		));

		return parent::_prepareColumns();
	}

	public function getRowUrl($item) {
		return '#';
	}
}
