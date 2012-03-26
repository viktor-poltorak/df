<?php

class Eve_Model_Category extends Zend_Db_Table_Abstract {

	protected $_table;

	protected $_parents = array();

	public function init() {
		parent::init();
		$this->_name = $this->_table;
	}

	public function setTable($table) {
		$this->_name = $table;
	}

	public function getBy($identity, $value) {
		$select = $this->select();
		$select->where($identity.' = ?', $value);

		return $select->query()->fetchObject();
	}

	/**
	 * get a category
	 *
	 * @param int $id
	 * @return stdClass
	 */
	public function load($id) {
		$select = $this->select();
		$select->where('category_id = ?', $id);

		return $select->query()->fetchObject();
	}

	public function getAll() {
		$select = $this->select();
		$select->order('name');

		return $select->query()->fetchAll(Zend_Db::FETCH_OBJ);
	}

	public function getParents() {
		$select = $this->select();
		$select->where('parent_id = 0');

		return $select->query()->fetchAll(Zend_Db::FETCH_OBJ);
	}

	public function getChildren($parentId) {
		$select = $this->select();
		$select->where('parent_id = ?', $parentId);

		return $select->query()->fetchAll(Zend_Db::FETCH_OBJ);
	}

	public function getChildrenCount($parentId) {
		$select = $this->select();
		$select->from($this->_name, 'COUNT(*) AS count');
		$select->where('parent_id = ?', $parentId);

		return $select->query()->fetchObject()->count;
	}

	public function update($bind, $id) {
		return parent::update($bind, $this->getAdapter()->quoteInto('category_id = ?', $id));
	}

	public function delete($id) {
		return parent::delete($this->getAdapter()->quoteInto('category_id = ?', $id));
	}

	public function deleteChilds($parentId) {
		return parent::delete($this->getAdapter()->quoteInto('parent_id = ?', $parentId));
	}

	public function getTree($parentId = 0) {

		$select = $this->select();
		$select->where('parent_id = ?', $parentId);

		$categories = $select->query()->fetchAll(Zend_Db::FETCH_OBJ);

		foreach ($categories as &$category) {
			$category->sub_categories = $this->_getChilds($category->category_id);
		}

		return $categories;
	}

	private function _getChilds($parentId) {
		$select = $this->select();
		$select->where('parent_id = ?', $parentId);

		$categories = $select->query()->fetchAll(Zend_Db::FETCH_OBJ);

		foreach ($categories as &$category) {
			$subCategories = $this->_getChilds($category->category_id);
			if (!empty($subCategories)) {
				$category->sub_categories = $subCategories;
			}
		}

		return $categories;
	}

	public function getParentsTree($categoryId) {

		$this->_parents[] = $this->_getParent($categoryId);

		array_shift($this->_parents);

		return $this->_parents;
	}

	private function _getParent($categoryId) {
		$categories = array ();
		
		$category = $this->load($categoryId);

		if ($category)
			$this->_parents[] = $this->_getParent($category->parent_id);

		return $category;
	}

	public function getOmitted() {
		return $this->getTree(-1);
	}

	public function deleteIn($bind) {
		$sql = 'DELETE FROM '.$this->_name.' WHERE category_id IN ('.implode(',', $bind).')';

		return $this->getAdapter()->query($sql)->execute();
	}

	public function getLastInsertId() {
		return $this->getAdapter()->lastInsertId($this->_name);
	}

	public function getByAlias($alias) {
		$select = $this->select();
		$select->where('alias = ?', $alias);

		return $select->query()->fetchObject();
	}

	public function getChildIds($parentId) {
		$childsIds = array();

		$children = $this->getChildren($parentId);

		foreach ($children as $child) {
			$childsIds[] = $child->category_id;

			$childsIds2 = $this->getChildIds($child->category_id);

			if (is_array($childsIds2)) {
				$childsIds = array_merge($childsIds, $childsIds2);
			}

		}

		return $childsIds;
	}
}
