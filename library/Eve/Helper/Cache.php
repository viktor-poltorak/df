<?php
class Eve_Helper_Cache extends Zend_Controller_Action_Helper_Abstract {

	/**
	 * @var Zend_Cache
	 */
	protected $_cache;

	/**
	 * @var Zend_Config
	 */
	protected $_config;

	protected $_server = '';

	public function  __construct() {
		$this->_config = Eve_Helper_ConfigLoader::get('project.xml', 'cache');

		$this->_cache = Zend_Cache::factory('Core', 'Memcached',
			$this->_config->frontend->toArray(),
			$this->_config->backend->toArray()
		);

		if (file_exists('_server'))
			$this->_server = trim(file_get_contents('_server'));
	}

	public function  __call($name, $arguments) {
		return call_user_func_array(array($this->_cache, $name), $arguments);
	}

	public function load($id) {
		return $this->_cache->load($id.$this->_server);
	}

	public function save($data, $id, $specificLifetime = false) {
		$this->_cache->save($data, $id.$this->_server, array(), $specificLifetime);
	}

}