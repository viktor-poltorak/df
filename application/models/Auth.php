<?php
	class Auth extends Zend_Db_Table_Abstract {
		protected $_name = Eve_Enum_Tables::USERS;
		
		public static $storage = 'auth';

		public static $params;

		public function  __get($name) {
			return self::getAuthInfo()->{$name};
		}

		public static function set($name, $value) {
			self::$params->name = $value;
		}

		public static function get($name) {
			return self::$params->name;
		}

		public function login($username, $password) {
			$auth = new Zend_Auth_Adapter_DbTable(Zend_Registry::get('db'), $this->_name, 'username', 'password');
			$auth->setIdentity($username)
				 ->setCredential($password)
				 ->setCredentialTreatment('MD5(?)');

			Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session(self::$storage));
			
			$result = Zend_Auth::getInstance()->authenticate($auth);

   			if($result->isValid()) {
				Zend_Auth::getInstance()->getStorage($this->storage)->write($auth->getResultRowObject(null, 'password'));
				
				return true;
			} else {
				return false;
			}
		}
		
		public static function logout() {
			Zend_Auth::getInstance()->clearIdentity();
			Zend_Session::stop();
		}
		
		public static function isLogged()	{
			$auth = Zend_Auth::getInstance();
			$auth -> setStorage(new Zend_Auth_Storage_Session(self::$storage));
			if($auth -> getIdentity())  
				return true;
			else
				return false;
		}

		/**
		 * get info about authorized user
		 * @return stdClass
		 */
		public static function getAuthInfo() {
			return Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session(self::$storage))->getIdentity();
		}

		/**
		 * reset password
		 *
		 * @param string $email
		 * @return string $newPassword
		 */
		public function makePassword($email) {
			return substr(md5(date('c').$user->email), 4, 8);
		}
		
	}