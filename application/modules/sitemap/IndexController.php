<?php
class Sitemap_IndexController extends Eve_Controller_Action {
	/**
	 *
	 * @var Categories
	 */
	protected $_categories;

    /**
     *
     * @var Pages
     */
    protected $_pages;

    public function init() {
		parent::init();
		$this->_categories = new Categories();
        $this->_pages = new Pages();
	}

    public function indexAction(){
        $this->_setPageTitle('Карта сайта');
        $this->_assign('pages', $this->_pages->getAll());
        $this->_assign('producers', $this->_categories->getProducersTopLevel());
        $this->_assign('categories', $this->_categories->getByParentId('0'));

        $this->_display('sitemap/sitemap.tpl');
    }

}