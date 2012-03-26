<?php
	class Eve_Forum_Abstract {

		/**
		 * @var Eve_Forum_Interface_Adapter
		 */
		public $adapter;

		public function init() {
			parent::init();
		}
		
		public function  __construct($adapter, $db = false) {
			Zend_Loader::loadClass('Eve_Forum_Adapter_'.$adapter);

			$class = 'Eve_Forum_Adapter_'.$adapter;

			$this->adapter = new $class;

			if ($db)
				$this->adapter->setDbAdapter($db);

		}

		public function getAdapter() {
			return $this->adapter;
		}

	}