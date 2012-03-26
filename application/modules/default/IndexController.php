<?php
class IndexController extends Eve_Controller_Action {

	/**
	 *
	 * @var Products
	 */
	protected $_products;

	/**
	 *
	 * @var Categories
	 */
	protected $_categories;

	/**
	 *
	 * @var Producers
	 */
	protected $_producers;

	/**
	 *
	 * @var integer
	 */
	protected $_perPage = 6;

    protected $_dir_images = 'images/products/';

	
	public function init() {
		parent::init();
		$this->_products = new Products();
		$this->_categories = new Categories();	
		$this->_producers = new Producers();
	}

	public function indexAction() {
		$this->_assign('indexPage', 1);
		$products = $this->_products->getAll(9);
		$this->_assign('products', $products);

      	$this->_assign('categoriesScroll', $this->_categories->getHomeCategories());

		$this->_assign('tab', 'index');

        $products = $this->_products->getFeatured($this->_perPage);         
		$this->_assign('featured', $products);

        $products = $this->_products->getStock($this->_perPage);
		$this->_assign('stock', $products);

        $products = $this->_products->getLatest($this->_perPage);
		$this->_assign('latest', $products);

        $settings =  new Eve_Settings();
        $this->_assign('globalTitle', $settings->siteName);
        
		$this->_display('default/index.tpl');
	}

}