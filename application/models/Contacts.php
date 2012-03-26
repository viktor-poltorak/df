<?php
	class Contacts extends Eve_Model_Abstract {
		
		protected $_name = 'contacts';
		
		const CONTACT_PHONE = 1;
		const CONTACT_SKYPE = 2;
		const CONTACT_ICQ = 3;
		const CONTACT_ADDRESS = 4;
		const CONTACT_EMAIL = 5;
		const CONTACT_FAX = 6;

		protected $_id_field = 'contact_id';

		public function getAll() {
			$select = $this->select();
			return $select->query()->fetchAll();
		}
		
		public function getByType($type) {
			$select = $this->select();
			$select->where('type = ?', $type);
			
			return $select->query()->fetchAll();
		}

		public function getPhone() {
			return $this->_getRowByType(self::CONTACT_PHONE);
		}

		public function getSkype() {
			return $this->_getRowByType(self::CONTACT_SKYPE);
		}

		public function getIcq() {
			return $this->_getRowByType(self::CONTACT_ICQ);
		}

		public function getAddress() {
			return $this->_getRowByType(self::CONTACT_ADDRESS);
		}

		public function getEmail() {
			return $this->_getRowByType(self::CONTACT_EMAIL);
		}

		public function getFax() {
			return $this->_getRowByType(self::CONTACT_FAX);
		}

		public function truncate() {
			$this->getAdapter()->query('truncate table contacts');
		}

		protected function _getRowByType($type) {
			$select = $this->select();
			$select->where('type = ?', $type);

			return $select->query()->fetchObject();
		}
		
	}