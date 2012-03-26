<?php
	class Eve_Helper_ConfigLoader extends Zend_Controller_Action_Helper_Abstract  {

		/**
		 * @var Zend_Config
		 */
		protected $_config;

		public static function get($name = false, $default = false) {
			$_tmp = explode('.', $name);
			$ext = ucfirst($_tmp[count($_tmp) - 1]);

			$class = 'Zend_Config_'.$ext;

			$config = new $class('configs/'.$name, $default);

			return $config;
		}
	}