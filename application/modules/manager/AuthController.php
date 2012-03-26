<?php
	class Manager_AuthController extends Eve_Controller_Action {

		/**
		 * @var Auth
		 */
		protected $_auth;

		public function init() {
			parent::init();
			$this->_auth = new Auth();
			$this->_setSkin('manager');

			if ($this->_isLogged() && $this->_request->action != 'logout')
				$this->_redirect('/manager/');
		}

		public function indexAction() {
			$this->_assign('mode', 'login');
			$this->_display('auth/login.tpl');
		}
	
		public function loginAction() {
			$username = trim($this->_request->username);
			$password = trim($this->_request->password);

			if (!$username || !$password)
				$this->_redirect('/manager/auth/');

			try {
				if (!$this->_auth->login($username, $password)) {
					$this->_assign('errors', (array) $this->errors->login_failed);
					$this->_assign('mode', 'login');
					$this->_display('auth/login.tpl');
				} else {
					$this->_redirect('/manager/');
				}
				
			} catch (Exception $e) {
				$this->_assign('errors', (array) $this->errors->login_failed);
				$this->_assign('mode', 'login');
				$this->_display('auth/login.tpl');
			}
		}
		
		public function logoutAction() {
			$this->_auth->logout();
			$this->_redirect('/manager/auth/');
		}

		public function resetPasswordAction() {
			$registration = new Registration();

			if(!$registration->isRegistered($this->_request->username)) {
				$this->_assign('errors', (array) $this->errors->user_not_found);
				$this->_assign('username', $this->_request->username);
				$this->_assign('mode', 'restore');
				$this->_show('auth/login.tpl');
			} else {
				//make new password
				$newPassword = $this->_auth->makePassword($this->_request->email);

				$users = new Users();

				// load user by email
				$user = $users->get('username', $this->_request->username);

				$a = $users->update(array(
					'password' => md5($newPassword)
				), 'email = "'.$this->_request->email.'"');

				//assign vars to smarty
				$this->_assign('newPassword', $newPassword);
				$this->_assign('username', $this->_request->username);
				
				// send email with new password
				try {
					$mail = new Eve_Email();
					$mail->mail((object) array(
						'email' => $user->email
					),
					$this->_fetch('mail/subjects/reset-password.tpl'),
					$this->_fetch('mail/reset-password.tpl'));
				} catch (Exception $e) {
				}

				$this->_redirect('/password-sent/');
			}

		}

		public function passwordSentAction() {
			$this->_assign('mode', 'login');
			$this->_assign('message', 'Пароль был отправлен вам на почту.');
			$this->_show('auth/login.tpl');
		}

	}