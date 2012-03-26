<?php
class Search_IndexController extends Eve_Controller_Action {

	/**
	 *
	 * @var Products
	 */
	protected $_products;

	/**
	 *
	 * @var integer
	 */
	protected $_perPage = 6;

	
	public function init() {
		parent::init();
		$this->_products = new Products();	
	}

	public function indexAction() {
		$q = trim(strip_tags($this->_request->q));		

		$this->_assign('indexPage', 1);
		
		$products = $this->_products->search($q, $this->_perPage);
		$this->_assign('products', $products);

		if($this->_isAjax()){
			echo $this->_fetch('search/autocomplete.tpl');
		} else {
			$this->_display('search/index.tpl');
		}
	}
}