<?php

class Lewis_Lockdown_Block_Adminhtml_Lockdown_Edit_Tab_Main extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface {
	protected function _prepareForm() {
		$l = Mage::registry('current_lockdown');
		$disabled = ! $this->helper('lockdown/adminhtml')->isAllowedAction('save');

		$form = new Varien_Data_Form;
		$form->setHtmlIdPrefix('lockdown_');
		$form->setFieldNameSuffix('lockdown');

		$h = $this->helper('lockdown');

		$fieldset = $form->addFieldset('general', array(
			'legend' => $h->__('General')
		));

		if ($l->getId()) {
			$fieldset->addField('lockdown_id', 'hidden', array(
				'name' => 'lockdown_id'
			));
		}

		$fieldset->addField('cms_pages_update', 'hidden', array(
			'name' => 'cms_pages_update',
			'value' => 0
		));

		$fieldset->addField('identifier', 'text', array(
			'name' => 'identifier',
			'label' => $h->__('Identifier'),
			'disabled' => $disabled
		));

		$fieldset->addField('active', 'select', array(
			'name' => 'active',
			'label' => $h->__('Active'),
			'options' => Mage::getModel('adminhtml/system_config_source_yesno')->toArray(),
			'disabled' => $disabled
		));

		$form->setValues($l->getData());
		$this->setForm($form);

		return parent::_prepareForm();
	}

	public function getTabLabel() {
		return $this->helper('lockdown')->__('Settings');
	}

	public function getTabTitle() {
		return $this->getTabLabel();
	}

	public function canShowTab() {
		return true;
	}

	public function isHidden() {
		return ! $this->canShowTab();
	}
}
