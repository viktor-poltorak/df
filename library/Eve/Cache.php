<?php
/**
 * Generic Cache
 * Caching any data whith Zend_Cache
 * Work with this similar for Zend_Session_Namespace
 *
 * @author Viktor Poltorak
 * @version 0.1, Apr 17, 2010
 *
 */

class Eve_Cache extends Zend_Cache {
	
	/**
	 *
	 * @var Zend_Cache_Core
	 */
	protected $_cache;

	/**
	 *
	 * @var string
	 */
	protected $_namespace;

	/**
	 * Default constructor
	 *
	 * @param string $namespace Name namespace
	 */
	public function  __construct($namespace) {
		$this->_namespace = $namespace;

		if(!Zend_Registry::isRegistered('cache_config')) {
			$config = new Zend_Config_Xml('configs/cache.xml');
			Zend_Registry::set('cache_config', $config);
		} else {
			$config = Zend_Registry::get('cache_config');
		}

		$this->_cache = Zend_Cache::factory(
				$config->options->frontend_name,
				$config->options->backend_name,
				$config->options->frontend->toArray(),
				$config->options->backend->toArray()
		);

		if(!$data = $this->_cache->load($this->_namespace)) {
			$this->_cache->save(array(), $this->_namespace, array($this->_namespace));
		}
	}

	/**
	 * Get variable from cache
	 *
	 * @param string $name
	 * @return mixed
	 */
	public function __get($name) {
		$data = $this->_cache->load($this->_namespace);
		if(isset($data[$name])) {
			return $data[$name];
		} else {
			return false;
		}
	}

	/**
	 * Save variable in cache
	 *
	 * @param string $name variable name
	 * @param mixed $value variable
	 * @return bool
	 */
	public function  __set($name,  $value) {
		$data = $this->_cache->load($this->_namespace);
		$data[$name] = $value;
		return $this->_cache->save($data, $this->_namespace, array($this->_namespace));
	}

	/**
	 * Remove variable from cache
	 *
	 * @param string $name variable name
	 * @return bool
	 */
	public function remove($name) {
		$data = $this->_cache->load($this->_namespace);
		unset ($data[$name]);
		return $this->_cache->save($data, $this->_namespace, array($this->_namespace));
	}

	/**
	 * Clear namespace cache
	 */
	public function clear() {
		$this->_cache->save(array(), $this->_namespace, array($this->_namespace));
	}
}