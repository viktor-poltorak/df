<?php
	class Manager_IndexController extends Eve_Controller_AdminAction {	

		/**
		 * @var Eve_Utils
		 */
		protected $_utils;
		
		public function init() {
			parent::init();

			$this->_utils = new Eve_Utils();
			$this->_utils->setDb(Zend_Registry::get('db'));
		}
	
		public function indexAction() {
            $this->_display('index.tpl');
		}
	}