<?php
	class Prefs extends Eve_Model_Abstract {

		protected $_id_field = 'pref_id';

		/**
		 * @var string
		 */
		public $_name = Eve_Enum_Tables::USER_PREFS;

		public function init() {
			parent::init();
		}

		/**
		 *  load user preference
		 */
		public function get($userId, $key) {
			$select = $this->select();
			$select->from($this->_name);
			$select->where('user_id = ?', $userId);
			$select->where('`key` = ?', $key);

			return $select->query()->fetchObject();
		}

		/**
		 * set the pref
		 */
		public function set($userId, $key, $val) {
			return $this->insert(array(
				'user_id' => $userId,
				'`key`' => $key,
				'value' => $val
			));
		}

		/**
		 * update pref
		 * @param int $userId
		 * @param string $key
		 * @param string $val
		 * @return bool | int
		 */
		public function update($userId, $key, $val) {
			return $this->getAdapter()->update($this->_name, array(
				'value' => $val
			), 'user_id = '.$userId.' AND `key` = "'.$key.'"');
		}

		/**
		 *	delete pref
		 * @param int $userId
		 * @param string $key
		 * @return bool | int
		 */
		public function delete($userId, $key) {
			return $this->getAdapter()->delete($this->_name, 'user_id = '.$userId.' AND `key` = '.$key);
		}

		/**
		 *	check if the pref is set
		 * @param int $userId
		 * @param string $key
		 * @return bool
		 */
		public function has($userId, $key) {
			$select = $this->select();
			$select->from($this->_name, 'COUNT(*) AS count');
			$select->where('user_id = ?', $userId);
			$select->where('`key` = ?', $key);

			return (bool)$select->query()->fetchObject()->count;
		}

	}