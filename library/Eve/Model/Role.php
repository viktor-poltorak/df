<?php
	class Eve_Model_Role extends Zend_Db_Table_Abstract {
		/**
		 * base table
		 *
		 * @var string
		 */
		public $_name = 'map_role_user';
		public $_table_roles = 'roles';
		public $_table_users = 'users';
		public $_table_manager_controllers = 'manager_controllers';
		public $_table_map_controller_role = 'map_manager_controller_role';
		
		public function addRole($userId, $roleId) {
			$this->getAdapter()->insert($this->_name, array(
				'user_id' => $userId,
				'role_id' => $roleId
			));
		}
		
		public function getRoles() {
			$select = $this->getAdapter()->select();
			$select->from($this->_table_roles);

			return $this->getAdapter()->query($select)->fetchAll(Zend_Db::FETCH_OBJ);
		}
		
		public function getUserRoles($userId) {
			$select = $this->getAdapter()->select();
			$select->from($this->_name);
			$select->joinLeft($this->_table_roles,
				$this->_name.'.role_id = '.$this->_table_roles.'.role_id'
			);
			$select->where($this->getAdapter()->quoteInto('user_id = ?', $userId));
			
			$roles = $this->getAdapter()->query($select)->fetchAll(Zend_Db::FETCH_OBJ);

			return $roles;
		}

		public function setAdmin($userId) {
			return $this->getAdapter()->update($this->_table_users, array(
				'role_id' => 1
				), $this->getAdapter()->quoteInto('user_id = ?', $userId));
		}

		public function dismissAdmin($userId) {
			return $this->getAdapter()->update($this->_table_users, array(
				'role_id' => 0
				), $this->getAdapter()->quoteInto('user_id = ?', $userId));
		}

		public function assignRole($userId, $roleId) {
			$this->getAdapter()->insert($this->_name, array(
				'role_id' => $roleId,
				'user_id' => $userId
			));

			return true;
		}

		public function unassignRole($userId, $roleId) {
			$where = $this->getAdapter()->quoteInto('user_id = ?', $userId);
			$where .= $this->getAdapter()->quoteInto('AND role_id = ?', $roleId);
			$this->getAdapter()->delete($this->_name, $where);
		}

		public function hasRole($userId, $roleId) {
			$select = $this->getAdapter()->select();
			$select->from($this->_name);
			$select->where('user_id = ?', $userId);
			$select->where('role_id = ?', $roleId);

			return $this->getAdapter()->fetchObject($select);
		}

		public function getControllerPermissions($controller) {
			$select = $this->getAdapter()->select();
			$select->from($this->_table_manager_controllers);
			$select->where('controller_name = ?', $controller);

			$controller = $this->getAdapter()->query($select)->fetchObject();
			unset($select);

			$select = $this->getAdapter()->select();
			$select->from($this->_table_map_controller_role);
			$select->joinLeft($this->_table_roles,
				$this->_table_map_controller_role.'.role_id = '.$this->_table_roles.'.role_id'
			);
			$select->where('controller_id = ?', $controller->controller_id);

			$roles = $this->getAdapter()->query($select)->fetchAll(Zend_Db::FETCH_OBJ);

			foreach($roles as &$role)
				$access[] = $role->role_name;

			return  $access;
		}

	}