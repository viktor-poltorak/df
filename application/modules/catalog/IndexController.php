<?php
class Catalog_IndexController extends Eve_Controller_Action {

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

	protected $_dir_images = 'images/products/';
    
	public function init() {
		parent::init();
		$this->_products = new Products();
		$this->_categories = new Categories();		
		$this->_producers = new Producers();
		$this->_assign('tab', 'catalog');
	}

	public function indexAction() {
		//$this->_assign('indexPage', 1);
		//$products = $this->_products->getAll(9);
        $producer = $this->_categories->getProducersTopLevel();
        $producer = array_shift($producer);
        $this->_setParam('id', $producer->category_id);
        $this->_forward('producer');
	}

	public function productAction(){
		$id = $this->_request->id;

		if(!$id){
			$this->_redirect('/');
		}

		$product = $this->_products->load($id);

		if(!$product){
			$this->_redirect('404');
		}
      
		$this->_setPageTitle($product->title);
        $this->_assign('prodId', $product->producer_id);
        $this->_assign('curCategory', $product->prod_cat);
		$this->_assign('product', $product);
		$this->_display('catalog/view.tpl');
	}

	public function producerAction(){
		$id = $this->_request->id;

		if(!$id){
			$this->_redirect('/');
		}
        
		$producer = $this->_categories->load($id);
		if(!$producer){
			$this->_redirect('404');
		}
		$this->_assign('producer', $producer);
		$this->_setPageTitle($producer->name);

		$products = $this->_products->getByProducerId($id);
		$categories = $this->_categories->getByProducerId($id);
        $this->_assign('prodId', $id);

		$items = array();
		foreach($categories as $k => $v){
			$items[$k]['category'] = $v;
			$items[$k]['items'] = $this->_products->getByCatForProducer($v->category_id, $id);
		}

		//Разделение списка на 3 части
		// Для горизонтального вывода
		$count = count($items);
		$colLength = floor($count/3);

		$col1 = array_slice($items, 0, $colLength);
		$col2 = array_slice($items, $colLength*1, $colLength);
		$col3 = array_slice($items, $colLength*2, $colLength);
		$diff = $count - $colLength*3;
		
		if($diff > 0) {
			$col1[] = $items[$colLength*3];
		}
		
		if($diff > 1) {
			$col2[] = $items[$colLength*3+1];
		}

		$this->_assign('col1', $col1);
		$this->_assign('col2', $col2);
		$this->_assign('col3', $col3);

		$this->_display('catalog/by-manufacturer.tpl');
	}

	public function categoryAction() {
		$id = $this->_request->id;

		if(!$id){
			$this->_redirect('/');
		}

		$cat = $this->_categories->load($id);
		if(!$cat){
			$this->_redirect('404');
		}
		$this->_assign('category', $cat);
       
        $subCategories = $this->_categories->getByParentId($cat->parent_id, true);
        $this->_assign('subCategories', $subCategories);        
        $this->_assign('curCategory', $cat->parent_id);
		$this->_setPageTitle($cat->name);

		$products = $this->_products->getByCatId($id, false);
        
		$this->_assign('products', $products);

        $this->_assign('curCategory', $id);
		$this->_display('catalog/by-category.tpl');
	}

    /**
     * Ajax 
     */
	public function subcategoryAction() {
		$id = $this->_request->id;

		if(!$id){
			$this->_redirect('/');
		}

		$cat = $this->_categories->getByParentId($id);

        if($cat){
            $out = '<ul>';
            foreach($cat as $v){
                $out .= "<li><a href=\"/catalog/category/id/{$v->category_id}\">{$v->name}</a></li>";
            }
			$out .= '</ul>';
            echo $out;
        }

        die;
	}

    /**
     * Ajax
     */
	public function prodcategoryAction() {
		$id = $this->_request->id;

		if(!$id){
			$this->_redirect('/');
		}

		$cat = $this->_categories->getByParentId($id);

        if($cat){
            $out = '<ul>';
            foreach($cat as $v){
                $out .= "<li><a href=\"/catalog/category/id/{$v->category_id}\">{$v->name}</a></li>";
            }
			$out .= '</ul>';
            echo $out;
        }

        die;
	}
}