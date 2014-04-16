<?php

class Lewis_Lockdown_Model_Relation_Page {
	protected function getResource() {
		return Mage::getSingleton('core/resource');
	}

	protected function getTable() {
		return $this->getResource()->getTableName('lockdown/relation_page');
	}

	protected function query($sql) {
		return $this->getResource()->getConnection()->query($sql);
	}

	public function getRelations($l) {
		return $this->_get($l->getId());
	}

	public function getLockdown($pageId) {
		if ($pageId instanceof Mage_Cms_Model_Page) {
			$pageId = $pageId->getId();
		}

		return $this->_getp($pageId);
	}

	public function updateRelations($o) {
		$l = $o->getEvent()->getLockdown();
		if (! $l->hasData('cms_pages')) {
			return;
		}

		$new = $l->getData('cms_pages');
		if (! is_array($new)) {
			$new = explode('&', $new);
		}

		foreach ($new as $k=>$v) {
			if (! is_numeric($v)) {
				unset($new[$k]);
			}
		}

		return $this->_update($l->getId(), $new);
	}

	protected function _update($lockdownId, $pageIds) {
		$old = $this->_get($lockdownId);

		$del = array_diff($old, $pageIds);
		if (count($del)) {
			$this->_delete($lockdownId, $del);
		}

		$add = array_diff($pageIds, $old);
		if (count($add)) {
			$this->_add($lockdownId, $add);
		}
	}

	protected function _get($lockdownId) {
		$sql = sprintf('select `page_id` from `%s` where `lockdown_id`=%d;',
			$this->getTable(),
			$lockdownId
		);
		$a = $this->query($sql)->fetchAll();
		$flat = array();
		foreach ($a as $b) {
			$flat[] = (int)$b['page_id'];
		}
		return $flat;
	}

	protected function _getp($pageId) {
		$sql = sprintf('select `lockdown_id` from `%s` where `page_id`=%d;',
			$this->getTable(),
			$pageId
		);
		$a = $this->query($sql)->fetchAll();
		if (count($a)) {
			$a = array_shift($a);
			return $a['lockdown_id'];
		}
		return null;
	}

	protected function _add($lockdownId, $pageIds) {
		$v = array();
		foreach ($pageIds as $pageId) {
			$v[] = sprintf('(%d, %d)', $lockdownId, $pageId);
		}

		$sql = sprintf('insert into `%s` (`lockdown_id`, `page_id`) values %s;',
			$this->getTable(),
			implode(', ', $v)
		);
		return $this->query($sql);
	}

	protected function _delete($lockdownId, $pageIds) {
		$sql = sprintf('delete from `%s` where `lockdown_id`=%d and `page_id` in (%s);',
			$this->getTable(),
			$lockdownId,
			implode(', ', $pageIds)
		);
		return $this->query($sql);
	}
}
