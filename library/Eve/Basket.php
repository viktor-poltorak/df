<?php
/**
 * Basket class
 *
 * @author Viktor Poltorak
 * @version 0.1, Apr 13, 2010
 *
 */

	class Eve_Basket{

		/**
		 *
		 * @var string
		 */
		protected $_storageName;

		/**
		 *
		 * @var Zend_Session_Namespace
		 */
		private $_storage;

		public function __construct($storageName = 'Eve_Basket') {
			if($storageName != '')
				$this->_storageName = $storageName;

			$this->_storage = new Zend_Session_Namespace($storageName);

			if(!$this->_storage->totalPrice){
				$this->_storage->totalPrice = 0;
			}
		}

		public function add($id, $name, $price){
			if(!isset($this->_storage->products[$id])){
				$product = new stdClass();
				$product->name = $name;
				$product->price = (float) str_replace('.', '', $price);
				$this->_storage->products[$id] = $product;			
				$this->_storage->totalPrice += $product->price;
			}
		}

		public function remove($id){
			if(isset($this->_storage->products[$id])){
				$product = $this->_storage->products[$id];
				$this->_storage->totalPrice -= $product->price;
				unset ($this->_storage->products[$id]);
			}
		}

		public function getTotalPrice(){
			return number_format($this->_storage->totalPrice, 0, ',', '.');
		}
		
		public function getCount(){
			return count($this->_storage->products);
		}

		public function get($id){
			if(isset($this->_storage->products[$id])){
				return $this->_storage->products[$id];
			}
		}

		public function getAll(){
			return $this->_storage->products;
		}

		public function emptyBasket(){
			$this->_storage->products = array();
			$this->_storage->totalPrice = 0;
		}

		public function inBasket($id){		
			if(isset($this->_storage->products[$id]))
				return true;
			else
				return false;

		}
	}