<?php
class Pages_IndexController extends Eve_Controller_Action {
	/**
	 * @var Pages
	 */
	protected $_pages;

	/**
	 * @var Eve_Model_Category
	 */
	protected $_category;

	protected $_page;

	/**
	 *
	 * @var Categories
	 */
	protected $_categories;

	public function init() {
		parent::init();
		$this->_pages = new Pages();
		$this->_page = $this->_request->getParam('page', 1);
		$this->_category = new Eve_Model_Category();
		$this->_assign('js', (array) 'pages');

		$this->_categories = new Categories();

		$this->_category->setTable(Eve_Enum_Tables::PAGES_CATEGORY);
	}

	public function indexAction() {
		$this->_redirect('/404/');
	}

	public function viewAction($id = false) {
        $alias = $this->_request->alias;

        $item = $this->_pages->getByLink($alias);

		if (!$item)
			$this->_forward('page-not-found', 'index', 'error');

		$this->_setPageTitle($item->title);
		$this->_assign('page', $item);
		$this->_assign('leftMenu', $this->_categories->getByParentId(0));
		$this->_assign('tab', str_replace('.htm', '', $item->link));

		$this->_display('pages/view.tpl');
	}

}