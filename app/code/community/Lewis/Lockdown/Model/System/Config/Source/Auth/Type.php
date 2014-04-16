<?php

class Lewis_Lockdown_Model_System_Config_Source_Auth_Type {
	const AUTH_TYPE_BASIC = 1;
	const AUTH_TYPE_CUSTOMER_GROUP = 2;

	public function toArray() {
		$h = Mage::helper('lockdown');
		return array(
			self::AUTH_TYPE_BASIC => $h->__('Single Username & Password'),
			self::AUTH_TYPE_CUSTOMER_GROUP => $h->__('Customer Groups')
		);
	}

	public function toOptionArray() {
		$dict = $this->toArray();
		$opt = array();
		foreach ($dict as $v=>$l) {
			$opt[] = array('value' => $v, 'label' => $l);
		}
		return $opt;
	}
}
