<?php
/**
 * Settings class
 *
 * @author Viktor Poltorak
 * @version 0.2, Apr 17, 2010
 *
 */

	class Eve_Settings extends Eve_Model_Abstract{
		/**
		 *
		 * @var string
		 */
		protected $_name = 'settings';

		/**
		 *
		 * @var string
		 */
		protected $_id_field = 'name';

		/**
		 *
		 * @var bool
		 */
		private $_caching = false;

		/**
		 *
		 * @var Eve_Cache_Abstract
		 */
		private $_cache;

		/**
		 * Default constructor
		 *
		 * @param array $config
		 */
		public function __construct($config = array()) {
			if(is_array($config)){
				if(isset ($config['caching'])){
					$this->_caching = (bool) $config['caching'];
				}
			}
	
			$this->_cache = new Eve_Cache('settings');

			parent::__construct();
		}

		/**
		 * Enable/Disable caching
		 *
		 * @param boot $value
		 */
		public function setCaching($value){
			$this->_caching = (bool) $value;
		}

		/**
		 * Get variable
		 *
		 * @param mixed $name
		 */
		public function  __get($name) {
			if($this->_caching){
				$var = $this->_cache->$name;
				if(!$var){
					$var = $this->load($name);
					$this->_cache->$name = $var;
				}
			} else  {			
				$var = $this->load($name);
			}

			if($var){
				return $var->value;
			} else {
				return false;
			}
		}


		/**
		 * Set variable
		 * This function available only for admin
		 * when implements acl
		 *
		 * @param string $name
		 * @param mixed $value
		 */
		 /**
		public function  __set($name,  $value) {
			if($this->_caching){
				$this->_cache->$name = $value;
			}
			$this->update(array('value'=>$value),$name);
		}
		  *
		  */
	}