<?php
	class Manager_UsersController extends Eve_Controller_AdminAction {	
		
		/**
		 * @var Users
		 */
		protected $_users;
		
		/**
		 * @var Eve_Model_Role
		 */
		protected $_roles;
		
		public $allowedRoles = array(
			'admins'
		);
		
		public function init() {
			parent::init();
			$this->_assign('js', array('manage/users'));
			$this->_users = new Users();
			$this->_roles = new Eve_Model_Role();
		}
	
		public function indexAction() {

			$paginate = new Eve_Paginate($this->_perPage);

			$page = $this->_request->getParam('page', 1);

			$total = $this->_users->getTotal();

			$users = $this->_users->getAll($this->_perPage, $page, false, 'registered_date DESC');


			$this->_assign('tab', 'index');
			$this->_assign('users', $users);
			$this->_assign('paginate', $paginate->paginate($total, $page));
			$this->_display('users/index.tpl');
		}

		public function rolesAction() {
			$user = $this->_users->getUser($this->_request->getParam('user_id'));

			if(!$user)
				throw new Exception($this->errors->user_not_found);

			$userRoles = $this->_roles->getUserRoles($user->user_id);
			$availRoles = $this->_roles->getRoles();

			foreach ($userRoles as $role) {
				$userRole[] = $role->role_id;
			}

			foreach ($availRoles as $key => $role) {
				if(in_array($role->role_id, (array)$userRole))
					unset($availRoles[$key]);
			}

			$this->_assign('tab', 'index');
			$this->_assign('user', $user);
			$this->_assign('user_roles', $userRoles);
			$this->_assign('roles', $availRoles);
			$this->_display('users/roles.tpl');
		}
		
		public function setadminAction() {
			echo json_encode(
				$this->_roles->setAdmin($this->_request->getPost('user_id'))
			);
		}

		public function dismissadminAction() {
			echo json_encode(
				$this->_roles->dismissAdmin($this->_request->getPost('user_id'))
			);
		}

		public function blockAction() {
			echo json_encode(
				$this->_users->blockUser($this->_request->getPost('user_id'))
			);
		}

		public function unblockAction() {
			echo json_encode(
				$this->_users->unblockUser($this->_request->getPost('user_id'))
			);
		}

		public function searchAction() {
			$userInfo = explode(' ', $this->_request->getParam('search'));

			if(count($userInfo) > 1) {
				$users = $this->_users->search(array(
					'first_name' => $userInfo[0],
					'last_name' => $userInfo[1]
				));
			} else {
				$users = $this->_users->search(array(
					'last_name' => $userInfo[0]
				));
			}

			$this->_assign('users', $users);
			$this->_display('users/index.tpl');
		}

		public function addAction() {
			$this->_assign('request', $this->_request->request);
			$this->_assign('errors', $this->_request->errors);
			$this->_assign('tab', 'add');
			$this->_display('users/add.tpl');
		}

		public function createAction() {
			$email = trim(strip_tags($this->_request->email));
			$username = trim(strip_tags($this->_request->username));
			$password = trim(strip_tags($this->_request->pass));
			$password2 = trim(strip_tags($this->_request->pass2));
			$first_name = trim(strip_tags($this->_request->first_name));
			$last_name = trim(strip_tags($this->_request->last_name));
			$enabled = 1;
			$errors = false;

			$emailValidate = new Zend_Validate_EmailAddress();
			if (!$emailValidate->isValid($email))
				$errors[] = $this->errors->email_invalid;

			if ($this->_users->isEmailRegistered($email))
				$errors[] = $this->errors->email_is_registered;

			$str = new Zend_Validate_StringLength(6, 40);
			if (!$str->isValid($password))
				$errors[] = $this->errors->password_invalid;

			$alnum = new Zend_Validate_Alnum();
			if (!$alnum->isValid($username))
				$errors[] = $this->errors->username_invalid;

			if ($this->_users->isRegistered($username))
				$errors[] = $this->errors->username_is_registered;

			if ($password != $password2)
				$errors[] = $this->errors->passwords_mismatch;

			if ($errors) {
				$this->_request->setParam('request', (object) $this->_request->getParams());
				$this->_request->setParam('errors', $errors);
				$this->_forward('add');
			} else {
				$id = $this->_users->insert(array (
					'username' => $username,
					'password' => md5($password),
					'email' => $email,
					'first_name' => $first_name,
					'last_name' => $last_name,
					'enabled' => $enabled,
					'registered_date' => new Zend_Db_Expr('NOW()'),
					'role_id' => 1
				));

				$this->_redirect('/manager/users/');
			}

		}

		public function editAction() {
			$id = (int) $this->_request->id;
			$user = $this->_users->load($id);

			if (!$user)
				$this->_redirect('/manager/users/');


			$this->_assign('user', $user);
			$this->_assign('errors', $this->_request->errors);
			$this->_assign('tab', 'index');
			$this->_display('users/edit.tpl');
		}

		public function updateAction() {
			$id = (int) $this->_request->id;
			$user = $this->_users->load($id);

			if (!$user)
				$this->_redirect('/manager/users/');

			$email = trim(strip_tags($this->_request->email));
			$username = trim(strip_tags($this->_request->username));
			$password = trim(strip_tags($this->_request->password));
			$password2 = trim(strip_tags($this->_request->password2));
			$first_name = trim(strip_tags($this->_request->first_name));
			$last_name = trim(strip_tags($this->_request->last_name));
			$enabled = 1;
			$errors = false;
			$bind = array();

			if ($email != $user->email) {
				$emailValidate = new Zend_Validate_EmailAddress();
				if (!$emailValidate->isValid($email))
					$errors[] = $this->errors->email_invalid;

				if ($this->_users->isEmailRegistered($email))
					$errors[] = $this->errors->email_is_registered;
			}

			if ($username != $user->username) {
				if ($this->_users->isRegistered($username))
					$errors[] = $this->errors->username_is_registered;

				$alnum = new Zend_Validate_Alnum();
				if (!$alnum->isValid($username))
					$errors[] = $this->errors->username_invalid;
			}

			if ($pasword) {
				$str = new Zend_Validate_StringLength(6, 40);
				if (!$str->isValid($password))
					$errors[] = $this->errors->password_invalid;

				if ($password != $password2)
					$errors[] = $this->errors->passwords_mismatch;
			}

			if ($errors) {
				$this->_request->setParam('errors', $errors);
				$this->_forward('add');
			} else {
				$bind['username'] = $username;
				$bind['email'] = $email;
				$bind['first_name'] = $first_name;
				$bind['last_name'] = $last_name;

				if ($password)
					$bind['password'] = md5($password);

				$this->_users->update($bind, $id);

				$this->_redirect('/manager/users/');
			}
		}

		public function deleteAction() {
			$id = (int) $this->_request->id;

			if (!$id || $id == 1)
				$this->_redirect('/manager/users/');

			$this->_users->delete($id);
			$this->_redirect('/manager/users/');
		}

	}