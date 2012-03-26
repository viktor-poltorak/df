<?php
	class Eve_Forum_Adapter_Phpbb implements Eve_Forum_Interface_Adapter {

		private $_prefix = 'phpbb_';

		protected $_table_users = 'users';

		protected $_table_topics = 'topics';

		protected $_table_posts = 'posts';

		protected $_table_sessions = 'sessions';

		protected $_table_user_group = 'user_group';

		/**
		 * @var Zend_Db
		 */
		protected $_db;

		
		public function setPrefix($prefix) {
			$this->_prefix = $prefix;
		}

		private function getTableName($name) {
			return $this->_prefix.$name;
		}

		public function setDbAdapter($adapter) {
			$this->_db = $adapter;
		}

		public function register($bind) {

			$this->_db->insert($this->getTableName($this->_table_users), $bind);

			return $this->_db->lastInsertId($this->_table_users);
		}

		public function unregister($userId) {

		}

		/**
		 * log in an EXISTING user
		 *
		 * @global array $config
		 * @global mysql $db
		 * @global user $user
		 * @global string $phpbb_root_path
		 * @global string $phpEx
		 * @global cache $cache
		 * @global string $SID
		 * @global string $_SID
		 * @param <string $email
		 * @param string $password
		 * @return hz
		 */
		public function login($email, $password) {

			global $phpEx, $method, $phpbb_root_path, $hacked_user, $config;

			define('IN_PHPBB', true);
			$phpbb_root_path = $_SERVER['DOCUMENT_ROOT'].'/forum/';

			$phpEx = 'php';
			$method = 'db';

			$phpEx = 'php';
			include($phpbb_root_path . 'common.' . $phpEx);

			// Start session management
			$user->session_begin();
			
			//var_dump($user);exit;
			$auth->acl($user->data);
			$user->setup();

			$user->lang_name = 'ru';

			$hacked_user = $user;


			if($user->data['is_registered'])
			{
				//User is already logged in
			}
			else
			{

				$result = $auth->login($email, $password, true);

				if ($result['status'] == LOGIN_SUCCESS)
				{
					//User was successfully logged into phpBB
					$redirect = request_var('redirect', "{$phpbb_root_path}index.$phpEx");

					// append/replace SID
					$redirect = reapply_sid($redirect);

					$sid = explode('=', $redirect);
					$sid = $sid[1];

					$_SESSION['forum_sid'] = $sid;
				}
				else
				{
					//User's login failed
				}
			}
			
		}

		public function logout($userId) {

			global $phpEx, $method, $phpbb_root_path, $user, $hacked_user, $config;

			define('IN_PHPBB', true);
			$phpbb_root_path = $_SERVER['DOCUMENT_ROOT'].'/forum/';

			$phpEx = 'php';
			$method = 'db';

			$phpEx = 'php';
			include($phpbb_root_path . 'common.' . $phpEx);

			$user->session_begin();

			$_GET['sid'] = $_SESSION['forum_sid'];

			if ($user->data['user_id'] != ANONYMOUS && isset($_GET['sid']) && !is_array($_GET['sid']) && $_GET['sid'] === $user->session_id)
			{
				$user->session_kill();
				$user->session_begin();
			}
			else
			{
				//$message = ($user->data['user_id'] == ANONYMOUS) ? $user->lang['LOGOUT_REDIRECT'] : $user->lang['LOGOUT_FAILED'];
			}

			unset($_SESSION['forum_sid']);

		}

		public function getLatestTopics($limit = false) {
			$select= $this->_db->select();
			$select->from($this->getTableName($this->_table_topics).' AS t', array (
				'*', '(SELECT COUNT(*) FROM '.$this->getTableName($this->_table_posts).' AS p WHERE p.topic_id = t.topic_id) AS posts'
			));

			if ($limit)
				$select->limit($limit);

			$select->order('topic_last_post_time  DESC');

			return $this->_db->query($select)->fetchAll(Zend_Db::FETCH_OBJ);
		}

		public function getPopularTopics($limit = false) {
			$select= $this->_db->select();
			$select->from($this->getTableName($this->_table_topics).' AS t', array (
				'*', '(SELECT COUNT(*) FROM '.$this->getTableName($this->_table_posts).' AS p WHERE p.topic_id = t.topic_id) AS posts'
			));

			if ($limit)
				$select->limit($limit);

			$select->order('posts DESC');

		//	var_dump($select->__toString());exit;

			return $this->_db->query($select)->fetchAll(Zend_Db::FETCH_OBJ);
		}

		public function phpbb_hash($password) {

			include ROOT.'forum/includes/functions.php';

			$itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

			$random_state = unique_id();
			$random = '';
			$count = 6;

			if (($fh = @fopen('/dev/urandom', 'rb')))
			{
				$random = fread($fh, $count);
				fclose($fh);
			}

			if (strlen($random) < $count)
			{
				$random = '';

				for ($i = 0; $i < $count; $i += 16)
				{
					$random_state = md5(unique_id() . $random_state);
					$random .= pack('H*', md5($random_state));
				}
				$random = substr($random, 0, $count);
			}

			$hash = _hash_crypt_private($password, _hash_gensalt_private($random, $itoa64), $itoa64);

			if (strlen($hash) == 34)
			{
				return $hash;
			}

			return md5($password);
		}

		public function getUser($email) {
			$select = $this->_db->select();

			$select->from($this->getTableName($this->_table_users));
			$select->where('username_clean = ?', $email);

			return $select->query()->fetchObject();
			
		}

		public function update($userId, $bind) {
			if (!$userId)
				return false;
   
			return $this->_db->update($this->getTableName($this->_table_users), $bind, $this->_db->quoteInto('user_id = ?', $userId));
		}

		public function addToGroup($userId, $groupId) {
			if (!$userId || !$groupId)
				return false;
   
			return $this->_db->insert($this->getTableName($this->_table_user_group), array (
				'user_id' => $userId,
				'group_id' => $groupId,
				'group_leader' => 0,
				'user_pending' => 0
			));
		}

		public function getLatestPosts($limit = false) {
			$adapter = $this->_getDb();
			
			$select = $adapter->select();
			$select->from($this->getTableName($this->_table_posts).' AS p');
			$select->joinLeft($this->getTableName($this->_table_users).' AS u',
				'p.poster_id = u.user_id'
			);
			$select->order('post_time DESC');
			if ($limit)
				$select->limit($limit);

			return $select->query()->fetchAll();
		}

		protected function _getDb() {
			if (file_exists('_server'))
				$postfix = trim(file_get_contents('_server'));

			$config = new Zend_Config_Xml('configs/database.xml', 'database'.$postfix);

			$adapter = Zend_Db::factory($config);
			$adapter->setFetchMode(Zend_Db::FETCH_OBJ);
			$adapter->query('SET NAMES `utf8`');

			return $adapter;
		}

	}