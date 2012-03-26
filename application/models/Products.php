<?php
	class Products extends Eve_Model_Abstract {
		/**
		 * news table
		 *
		 * @var string
		 */
		public $_name = 'products';

		protected $_id_field = 'product_id';
		
		public function getAll($limit = 'all') {
			$select = $this->select();

			if($limit != 'all'){
				$select->limit($limit);
			}
			return $select->query()->fetchAll();
		}

		public function getByCatId($cat, $limit = 15){
			$select = $this->select();
			$select->where('category_id=?', $cat);
            if($limit){
                $select->limit($limit);
            }
			return $select->query()->fetchAll();
		}

		public function getByProducerId($prod, $limit = 15){
			$select = $this->select();
			$select->where('producer_id=?', $prod);
			$select->limit($limit);
			return $select->query()->fetchAll();
		}

		public function getByCatForProducer($catId, $producerId, $limit = 15){
			$select = $this->select();
			$select->where('prod_cat = ?', $catId);
			$select->where('producer_id = ?', $producerId);
			$select->limit($limit);
			return $select->query()->fetchAll();
		}

		/**
		 *
		 * @param array $ids
		 */
		public function getByIdsList($ids){
			if(is_array($ids)){
				$where = $this->_id_field .' IN(';
				foreach($ids as $val){
					$where .= intval($val) .',';
				}

				$where = trim($where, ',');
				$where .= ')';

				$select = $this->select();
				$select->where($where);
				return $select->query()->fetchAll();
			} else {
				return false;
			}
		}

		public function getStock($count = 15){
			$select = $this->select();
			$select->where('stock = 1');
			$select->limit($count);
			return $select->query()->fetchAll();
		}

		public function getFeatured($count = 15){
			$select = $this->select();
			$select->where('featured = 1');
			$select->limit($count);
			return $select->query()->fetchAll();
		}

		public function search($keyword, $limit = 15, $page = 1){
			$select = $this->select();
			$select->where('title LIKE (?)', '%'.$keyword.'%');
			$select->limitPage($page, $limit);
			return $select->query()->fetchAll();
		}		
	}