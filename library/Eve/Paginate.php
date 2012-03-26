<?php
/**
 * Pagination class
 * 
 * @author Alex Oleshkevich
 * @version 0,1, Jan 4, 2009
 *
 */
	class Eve_Paginate {
		
		/**
		 * num of items per page
		 *
		 * @var int
		 */
		public $perPage;
		
		/**
		 * array if pages
		 *
		 * @var array
		 */
		public $pages = array();
		
		/**
		 * previous page
		 *
		 * @var int
		 */
		public $previous = false;
		
		/**
		 * next page
		 *
		 * @var int
		 */
		public $next = false;
		
		/**
		 * first page
		 *
		 * @var int
		 */
		public $first = 1;
		
		/**
		 * last page
		 *
		 * @var int
		 */
		public $last = false;
		
		/**
		 * total records
		 *
		 * @var int
		 */
		public $total;
		
		/**
		 * total avilable pages
		 *
		 * @var int
		 */
		public $totalPages;
		
		/**
		 * current page
		 *
		 * @var int
		 */
		public $current;
		
		/**
		 * current url
		 *
		 * @var string
		 */
		public $url;
		
		public function __construct($perPage = 25) {
			$this->perPage = $perPage;
		}
		
		/**
		 * process pagination and fill all vars of this
		 *
		 * @param string $table
		 * @param array | string $where
		 * @return Paginate
		 */
		public function paginate($totalItems, $currentPage = 1) {

			$this->total = ceil($totalItems / $this->perPage);

			for($i = 1; $i <= $this->total; $i++) {
				$this->pages[] = $i;
			}
			
			$this->last = $this->total;
			$this->current = !$currentPage ? 1 : $currentPage;
			$this->next = ($currentPage + 1) > $this->total ? false : ($currentPage + 1);
			$this->previous = ($currentPage - 1) < $this->first ? false : ($currentPage - 1);
			$this->totalPages = count($this->pages);
           
            $this->first = ($currentPage == $this->first) ? false : $this->first;

            $this->last = ($currentPage == $this->totalPages) ? false : $this->totalPages;

			if(!isset($this->url))
				$this->url = $_SERVER['REQUEST_URI'];
			
			if(count($this->pages) == 1) {
				return false;
			} else {
				return $this;
			}
		}
		
		public function getLastPage($totalItems = false, $currentPage = 1) {
			return ceil($totalItems / $this->perPage);
		}
	}