<?php
	class Users extends Eve_Model_Abstract {

		protected $_id_field = 'user_id';

		public $_name = Eve_Enum_Tables::USERS;

		protected $_max_idle_mins = 5;

		protected $_table_roles = Eve_Enum_Tables::ROLES;

		public function init() {
			parent::init();
		}

		public function get($identity, $value) {
			$select = $this->getAdapter()->select();
			$select->from($this->_name);
			$select->where($this->getAdapter()->quoteInto($identity.' = ?', $value));

			return $this->getAdapter()->query($select)->fetchObject();
		}

		/**
		 * get all records
		 *
		 * @param int $limit
		 * @param int $page
		 * @param string $where
		 * @return array
		 */
		public function getAll($limit = false, $page = false, $where = false, $order = false) {
			$select = $this->getAdapter()->select();
			$select->from($this->_name.' AS u', array ('*',
				'(SELECT COUNT(*)
					FROM `'.$this->_table_users.'` AS u2
					WHERE u2.last_seen >
						(NOW() - INTERVAL 5 MINUTE) AND u2.user_id = u.user_id)
					AS is_online'
			));

			if($limit)
				$select->limitPage($page,$limit);

			if ($order) {
				$select->order($order);
			}

			if($where)
				$select->where($where);

			return $this->getAdapter()->query($select)->fetchAll(Zend_Db::FETCH_OBJ);
		}
		
		public function getLatest($limit = false) {
			$select = $this->getAdapter()->select();
			$select->from($this->_name.' AS u');
			$select->order('registered_date DESC');

			if ($limit) {
				$select->limit($limit);
			}

			return $this->getAdapter()->query($select)->fetchAll(Zend_Db::FETCH_OBJ);
		}

		public function blockUser($userId) {
			return $this->getAdapter()->update($this->_name, array(
				'enabled' => 0
				), $this->getAdapter()->quoteInto('user_id = ?', $userId));
		}

		public function unblockUser($userId) {
			return $this->getAdapter()->update($this->_name, array(
				'enabled' => 1
				), $this->getAdapter()->quoteInto('user_id = ?', $userId));
		}

		public function search($userInfo = array()) {
			$select = $this->getAdapter()->select();
			$select->from($this->_name);

			foreach ($userInfo as $key => $info) {
				$select->where($key.' LIKE "%'.$info.'%"');
			}

			return $this->getAdapter()->query($select)->fetchAll(Zend_Db::FETCH_OBJ);

		}

		public function parseBirthdate($timestamp) {
			$birthdate = explode(' ', $timestamp);
			$birthdate = explode('-', $birthdate[0]);

			$date = new stdClass();
			$date->day = $birthdate[2];
			$date->month = $birthdate[1];
			$date->year = $birthdate[0];

			return $date;
		}

		public function dropUserEmailRequests($userId) {
			$this->getAdapter()->delete($this->_table_email_change_requests, $this->getAdapter()->quoteInto('user_id = ?', $userId));
		}

		/**
		 *	get users who are online
		 * @param int $interval
		 * @param int $limit
		 * @param int $page
		 */
		public function getOnlineUsers($interval = 5, $limit = false, $page = 1) {
			$select = $this->getAdapter()->select();
			$select->from($this->_name);
			$select->where('last_seen > (NOW() - INTERVAL '.$interval.' MINUTE)');

			if ($limit)
				$select->limitPage($page, $limit);

			return $select->query()->fetchAll(Zend_Db::FETCH_OBJ);
		}

		/**
		 *	get count of all online users basing on number of session files
		 * @return int
		 */
		public function getAllOnlineUsers() {
			if ( $directory_handle = opendir( session_save_path() ) ) {
				$count = 0;
				
				while ( false !== ( $file = readdir( $directory_handle ) ) ) {
					if($file != '.' && $file != '..') {
						if(time() - fileatime(session_save_path() . '/' . $file) < $this->_max_idle_mins * 60) {
							$count++;
						}
					}
				}
				closedir($directory_handle);
				return $count;
			} else {
				return false;
			}
		}

		/**
		 *	get count of users who are online
		 * @param int $interval
		 */
		public function getOnlineCount($interval = 5) {
			$select = $this->getAdapter()->select();
			$select->from($this->_name, 'COUNT(*) AS count');
			$select->where('last_seen > (NOW() - INTERVAL '.$interval.' MINUTE)');

			return $select->query()->fetchObject()->count;
		}

		/**
		 * make a email change request
		 *
		 * @param int $userId
		 * @param string $email
		 * @return string hash
		 */
		public function requestEmailChange($userId, $email) {

			$hash = md5(time().$userId.$email);

			$this->getAdapter()->insert($this->_table_email_change_requests, array (
				'user_id' => $userId,
				'email' => $email,
				'hash' => $hash,
				'date_added' => new Zend_Db_Expr('NOW()')
			));

			return $hash;
		}

		public function getEmailRequest($userId, $hash) {
			$select = $this->getAdapter()->select();
			$select->from($this->_table_email_change_requests);
			$select->where($this->getAdapter()->quoteInto('user_id = ?', $userId));
			$select->where($this->getAdapter()->quoteInto('hash = ?', $hash));

			return $select->query()->fetchObject();
		}

		public function changePassword($userId, $pass) {
			return $this->update(array(
				'password' => md5($pass)
			) , 'user_id='.$userId);
		}

		public function isRated($userId) {
			$select = $this->getAdapter()->select();
			$select->from($this->_table_user_rates);
			$select->where('from_user_id = ?', Auth::getAuthInfo()->user_id);
			$select->where('to_user_id = ?', $userId);
			$select->where(new Zend_Db_Expr('date <= (NOW() + INTERVAL 1 MONTH)'));

			return (bool) $select->query()->fetchObject();
		}

		public function addRate($userId) {
			return $this->getAdapter()->insert($this->_table_user_rates, array(
				'from_user_id' => Auth::getAuthInfo()->user_id,
				'to_user_id' => $userId,
				'date' => new Zend_Db_Expr('NOW()')
			));
		}

		public function deleteRates($userId) {
			$this->getAdapter()->delete($this->_table_user_rates, 'from_user_id = '.Auth::getAuthInfo()->user_id.' AND to_user_id = '.$userId);
		}

		public function isEmailRegistered($email) {
			$select = $this->select();
			$select->where('email = ?', $email);

			return (bool) $select->query()->fetchObject();
		}

		public function isRegistered($username) {
			$select = $this->select();
			$select->where('username = ?', $username);

			return (bool) $select->query()->fetchObject();
		}

	}