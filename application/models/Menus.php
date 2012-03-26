<?php
	class Menus extends Eve_Model_Abstract {

		protected $_name = Eve_Enum_Tables::MENUS;
		protected $_table_menu_items = Eve_Enum_Tables::MENU_ITEMS;
		protected $_id_field = 'menu_id';

		/**
		 *	load all menu item for selected menu
		 * @param int $menuId
		 */
		public function loadItemset($menuId) {
			$select = $this->getAdapter()->select();
			$select->from($this->_table_menu_items);
			$select->where('menu_id = ?', $menuId);
			$select->where('enabled = 1');
			$select->order('item_position');

			return $select->query()->fetchAll();
		}

		public function getItems($menuId) {
			$select = $this->getAdapter()->select();
			$select->from($this->_table_menu_items);
			$select->where('menu_id = ?', $menuId);
			$select->where('enabled = 1');
			$select->order('item_position');

			return $select->query()->fetchAll();
		}

		/**
		 *	drop all menu items for selected menu
		 * @param int $menuId
		 * @return int
		 */
		public function deleteItems($menuId) {
			return $this->getAdapter()->delete($this->_table_menu_items, $this->quoteInto('menu_id = ?', $menuId));
		}

		/**
		 * add item
		 * @param array $bind
		 */
		public function addItem($bind) {
			$this->getAdapter()->insert($this->_table_menu_items, $bind);
		}

		/**
		 *	load a menu item
		 * @param int $itemId
		 * @return stdClass
		 */
		public function loadItem($itemId) {
			$select = $this->getAdapter()->select();
			$select->from($this->_table_menu_items);
			$select->where('menu_item_id = ?', $itemId);

			return $select->query()->fetchObject();
		}

		/**
		 *	update a menu item
		 * @param array $bind
		 * @param int $itemId
		 */
		public function updateItem($bind, $itemId) {
			$this->getAdapter()->update($this->_table_menu_items, $bind, $this->quoteInto('menu_item_id = ?', $itemId));
		}

		/**
		 *	delete a menu item
		 * @param int $itemId
		 * @return int|bool
		 */
		public function deleteItem($itemId) {
			return $this->getAdapter()->delete($this->_table_menu_items, $this->quoteInto('menu_item_id = ?', $itemId));
		}

        /**
         * Return next item position
         *
         * @param int $menuId
         */
        public function getNextPosition($menuId){
           $sql = "SELECT (COUNT(*) + 1) as next FROM {$this->_table_menu_items} WHERE menu_id=?";
           return $this->getAdapter()->query($sql, array($menuId))->fetchObject()->next;
        }
	}