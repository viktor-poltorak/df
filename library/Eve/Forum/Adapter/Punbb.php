<?php
	class Eve_Forum_Adapter_Punbb implements Eve_Forum_Interface_Adapter {

		private $prefix = 'punbb_';

		protected $_table_users = 'users';

		protected $_table_topics = 'topics';

		protected $_table_posts = 'posts';

		/**
		 * @var Zend_Db
		 */
		protected $db;

		
		public function setTablePrefix($prefix) {
			$this->prefix = $prefix;
		}

		private function getTableName($name) {
			return $this->prefix.$name;
		}

		public function setDbAdapter($adapter) {
			$this->db = $adapter;
		}

		public function register($bind) {
			$this->db->insert($this->getTableName($this->_table_users), $bind);

			return $this->db->lastInsertId($this->_table_users);
		}

		public function unregister($userId) {

		}

		public function login($userId) {
			$_SESSION['logged_in_forum'] = true;
		}

		public function logout($userId) {
			$_SESSION['logged_in_forum'] = false;
		}

		public function getLatestTopics($limit = false) {
			$select= $this->db->select();
			$select->from($this->getTableName($this->_table_topics).' AS t', array (
				'*', '(SELECT COUNT(*) FROM '.$this->getTableName($this->_table_posts).' AS p WHERE p.topic_id = t.id) AS posts'
			));

			if ($limit)
				$select->limit($limit);

			$select->order('last_post DESC');

		//	var_dump($select->__toString());exit;

			return $this->db->query($select)->fetchAll(Zend_Db::FETCH_OBJ);
		}

		public function getPopularTopics($limit = false) {
			$select= $this->db->select();
			$select->from($this->getTableName($this->_table_topics).' AS t', array (
				'*', '(SELECT COUNT(*) FROM '.$this->getTableName($this->_table_posts).' AS p WHERE p.topic_id = t.id) AS posts'
			));

			if ($limit)
				$select->limit($limit);

			$select->order('posts DESC');

		//	var_dump($select->__toString());exit;

			return $this->db->query($select)->fetchAll(Zend_Db::FETCH_OBJ);
		}

	}