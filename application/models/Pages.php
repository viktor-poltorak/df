<?php
	class Pages extends Eve_Model_Abstract {
		protected $_name = Eve_Enum_Tables::PAGES;
		
		protected $_table_categories = Eve_Enum_Tables::PAGES_CATEGORY;
		
		protected $_table_users = Eve_Enum_Tables::USERS;
		
		protected $_id_field = 'page_id';

		public function get($id) {
			$select = $this->getAdapter()->select();
			$select->from($this->_name.' AS p');
			$select->joinLeft($this->_table_users.' AS u',
				'p.user_id = u.user_id', array ('first_name', 'last_name', 'user_id', 'gender')
			);
			$select->where($this->_id_field.' = ?', $id);
			return $select->query()->fetchObject();
		}

        public function getByLink($link){
            $select = $this->getAdapter()->select();
			$select->from($this->_name.' AS p');		
			$select->where('link = ?', $link);

			return $select->query()->fetchObject();
        }

		public function getMore($limit, $category_id = false) {
			$select = $this->getAdapter()->select();
			$select->from($this->_name, array (
				'page_id'
			));

			if ($category_id)
				$select->where($this->getAdapter()->quoteInto('category_id = ?', $category_id));
				
			$select->limit(4);
			$select->order('date_posted DESC');

			$result = $select->query()->fetchAll(Zend_Db::FETCH_OBJ);

			$ids = array();

			foreach ($result as $item) {
				$ids[] = $item->page_id;
			}


			$select = $this->getAdapter()->select();
			$select->from($this->_name);
			$select->where('page_id NOT IN ('.implode(',', $ids).')');

			if ($category_id)
				$select->where($this->getAdapter()->quoteInto('category_id = ?', $category_id));

			$select->limit(4);
			$select->order('date_posted DESC');

			return $this->getAdapter()->query($select)->fetchAll(Zend_Db::FETCH_OBJ);
		}

		public function getByCategory($categoryId, $limit = false, $page = 1) {

			$select = $this->getAdapter()->select();
			$select->from($this->_name.' AS p');
			$select->joinLeft($this->_table_users.' AS u',
				'p.user_id = u.user_id', array ('first_name', 'last_name', 'user_id', 'gender')
			);
			$select->joinLeft($this->_table_categories.' AS c',
				'p.category_id = c.category_id'
			);
			$select->order('p.date_posted desc');
			$select->where('p.category_id = ?', $categoryId);

			if ($limit)
				$select->limitPage($page, $limit);

			$articles = $select->query()->fetchAll(Zend_Db::FETCH_OBJ);

			foreach ($articles as $key => $article) {
				$articles[$key]->annotation = str_replace('../../..', '', $article->annotation);
				$articles[$key]->body = str_replace('../../..', '', $article->body);
			}

			return $articles;
		}

		public function getByAlias($alias) {
			$select = $this->getAdapter()->select();
			$select->from($this->_table_categories.' AS c', array (
				'*', '(SELECT COUNT(*) FROM '.$this->_table_categories.' AS c2 WHERE c2.parent_id = c.category_id) AS sub_category_count'
			));
			$select->where('c.alias = ?', $alias);

			return $this->getAdapter()->query($select)->fetchObject();
		}

		public function deleteMatchedPages($ids) {
			$sql = 'DELETE FROM '.$this->_name.' WHERE publication_id IN ('.implode(',', $ids).')';

			return $this->getAdapter()->query($sql)->execute();
		}
		
		public function fetchPagesByCategories($ids, $fields = array ('*'), $limit = false, $order = false) {

			$select = $this->getAdapter()->select();
			$select->from($this->_name, implode(',', $fields));
			$select->where('category_id IN ('.implode(',', $ids).')');

			if ($limit)
				$select->limit($limit);

			if ($order)
				$select->order($order);

			return $select->query()->fetchAll(Zend_Db::FETCH_OBJ);
		}

		public function fetchByCategories($ids, $limit) {

			$select = $this->getAdapter()->select();
			$select->from($this->_name);
			$select->where('category_id IN ('.implode(',', $ids).')');

			return $select->query()->fetchAll(Zend_Db::FETCH_OBJ);
		}

	}