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
			'required' => true,
			'disabled' => $disabled
		));

		$fieldset->addField('active', 'select', array(
			'name' => 'active',
			'label' => $h->__('Active'),
			'options' => Mage::getModel('adminhtml/system_config_source_yesno')->toArray(),
			'disabled' => $disabled
		));

		$fieldset = $form->addFieldset('auth', array(
			'legend' => $h->__('Authentication')
		));

		$authTypes = Mage::getModel('lockdown/system_config_source_auth_type');
		$typeField = $fieldset->addField('auth_type', 'select', array(
			'name' => 'auth_type',
			'label' => $h->__('Type'),
			'options' => $authTypes->toArray(),
			'disabled' => $disabled
		));

		$userField = $fieldset->addField('auth_username', 'text', array(
			'name' => 'auth_username',
			'label' => $h->__('Username'),
			'disabled' => $disabled
		));

		$passField = $fieldset->addField('auth_password', 'text', array(
			'name' => 'auth_password',
			'label' => $h->__('Password'),
			'disabled' => $disabled
		));

		// display dependency
		$dep = $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence');
		foreach (array($typeField, $userField, $passField) as $f) {
			$dep->addFieldMap($f->getHtmlId(), $f->getName());
		}
		$dep->addFieldDependence($userField->getName(), $typeField->getName(), $authTypes::AUTH_TYPE_BASIC);
		$dep->addFieldDependence($passField->getName(), $typeField->getName(), $authTypes::AUTH_TYPE_BASIC);
		$this->setChild('form_after', $dep);

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
