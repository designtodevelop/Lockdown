<?php

class Lewis_Lockdown_Block_Adminhtml_Lockdown_Edit_Tab_Page_Grid extends Mage_Adminhtml_Block_Cms_Page_Grid {
	public function __construct() {
		parent::__construct();
		$this->setId('cmsPagesGrid');
		$this->setDefaultSort('page_id');
		$this->setDefaultSort('identifier');
		$this->setDefaultDir('ASC');
		$this->setUseAjax(true);
	}

	protected function _prepareCollection() {
		$c = Mage::getResourceModel('cms/page_collection');
		$this->setCollection($c);
		return parent::_prepareCollection();
	}

	protected function getPreselectedPages() {
		return array();
	}

	// selections via ajax
	protected function getPostedPages() {
		$r = Mage::app()->getRequest();
		$post = $this->getRequest()->getPost('lockdown');
		if (is_array($post) && isset($post['cms_pages'])) {
			return $post['cms_pages'];
		}
	}

	public function getSelectedPages() {
		if ($this->hasData('selected_pages')) {
			return $this->getData('selected_pages');
		}
		else if ($p = $this->getPostedPages()) {
			$this->setSelectedPages($p);
			return $p;
		}
		return $this->getPreselectedPages();
	}

	public function getGridUrl() {
		return $this->getUrl('*/*/pagesgrid', array('_current' => true));
	}

	protected function _prepareColumns() {
		$this->addColumn('cms_page_apply', array(
			'type' => 'checkbox',
			'name' => 'cms_page_apply',
			'values' => $this->getSelectedPages(),
			'index' => 'page_id',
			'header_css_class' => 'a-center',
			'align' => 'center'
		));

		$r = parent::_prepareColumns();

		$this->removeColumn('creation_time');
		$this->removeColumn('update_time');
		$this->removeColumn('page_actions');

		return $r;
	}

	public function getRowUrl($item) {
		return '#';
	}
}
