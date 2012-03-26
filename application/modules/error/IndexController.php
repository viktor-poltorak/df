<?php
class Error_IndexController extends Eve_Controller_Action {

	public function __call($method, $args) {
		$this->_forward('page-not-found');
	}
	
	public function init() {
		parent::init();
	}

	public function pageNotFoundAction() {
		header('HTTP/1.0 404 Not Found');
		$this->_assign('errors', array($this->errors->page_not_found));
		$this->_display('inc/404.tpl');
		exit;
	}
	
}