<?php
	class Manager_PagesController extends Eve_Controller_AdminAction {
		/**
		 * @var Pages
		 */
		protected $_pages;

		protected $allowedRoles = array(
			'admins',
			'editors'
		);

		/**
		 * @var Eve_Model_Category
		 */
		protected $_category;

		protected $_dir_images = Eve_Enum_Paths::PAGES_CATEGORIES_ICONS;

		public function init() {
			parent::init();
			
			$this->_pages = new Pages();
			$this->_category = new Eve_Model_Category();
			$this->_category->setTable(Eve_Enum_Tables::PAGES_CATEGORY);

			$this->_dir_images = $this->_dir_images;

			$this->_assign('js', array (
				'manage/categories'
			));
		}
	
		public function indexAction() {
			$categoryId = (int) $this->_request->id;

			$paginate = new Eve_Paginate($this->_perPage);

			$page = $this->_request->getParam('page', 1);

			if ($categoryId) {
				$total = $this->_pages->getTotal('category_id = '.$categoryId);
				$pages = $this->_pages->getByCategory($this->_request->id, $this->_perPage, $page);
			} else {
				$total = $this->_pages->getTotal();
				$pages = $this->_pages->getAll($this->_perPage, $page, false, 'date_posted desc');
			}

			$this->_assign('categories', $this->_category->getAll());
			$this->_assign('category_id', $categoryId);
			$this->_assign('paginate', $paginate->paginate($total, $page));
			$this->_assign('tab', 'index');
			$this->_assign('pages',$pages);
			$this->_display('pages/index.tpl');
		}
		
		public function viewAction() {
			$id = (int) $this->_request->id;

			if ((!$id))
				$this->_redirect('/manager/pages/');

			$page = $this->_pages->load($id);

			$this->_assign('page', $page);
			$this->_display('pages/view.tpl');
		}

		public function addAction() {
			$this->_assign('js', array(
				'libs/tiny_mce/tiny_mce',
				'tiny_mce_init'
			));

			$this->_assign('tab', 'add');
			$this->_assign('request', $this->_request->request);
			$this->_assign('errors', $this->_request->errors);
			$this->_display('pages/add.tpl');
		}

		public function createAction() {
			$title = trim(strip_tags($this->_request->title));
			$body = trim($this->_request->body);

            $link = trim(strip_tags($this->_request->link));
			$description = trim(strip_tags($this->_request->description));
			$keywords = trim(strip_tags($this->_request->keywords));

			if (!$title)
				$errors[] = $this->errors->pages->no_title;

			if (!$body)
				$errors[] = $this->errors->pages->no_body;

            if (!$description)
				$errors[] = $this->errors->pages->no_description;
			if (!$keywords)
				$errors[] = $this->errors->pages->no_keywords;

			if (!$link)
				$errors[] = $this->errors->pages->no_link;

			if ($errors) {
				$this->_request->setParam('errors', $errors);
				$this->_request->setParam('request', $this->_request);
				$this->_forward('add');
			} else {
				$id = $this->_pages->insert(array (
					'user_id' => Auth::getAuthInfo()->user_id,
					'body' => $body,
					'title' => $title,
                    'description' => $description,
					'keywords' => $keywords,
					'link' => $link,
					'date_posted' => new Zend_Db_Expr('NOW()'),
				));
				$this->_redirect('manager/pages/view/id/'.$id);
			}
		}

		public function editAction() {

			$id = (int) $this->_request->id;

			if (!$id)
				$this->_redirect('/manager/pages/');

			$this->_assign('js', array(
				'libs/tiny_mce/tiny_mce',
				'tiny_mce_init'
			));

			$page = $this->_pages->load($id);
			
			$this->_assign('request', $this->_request->request);
			$this->_assign('errors', $this->_request->errors);
			$this->_assign('page', $page);
			$this->_display('pages/edit.tpl');
		}

		public function updateAction() {

			$id = (int) $this->_request->id;

			if (!$id)
				$this->_redirect('/manager/pages/');

			$title = trim(strip_tags($this->_request->title));
			$body = trim($this->_request->body);

			$link = trim(strip_tags($this->_request->link));
			$description = trim(strip_tags($this->_request->description));
			$keywords = trim(strip_tags($this->_request->keywords));

			if (!$title)
				$errors[] = $this->errors->pages->no_title;

			if (!$body)
				$errors[] = $this->errors->pages->no_body;

			if (!$description)
				$errors[] = $this->errors->pages->no_description;
			if (!$keywords)
				$errors[] = $this->errors->pages->no_keywords;

			if (!$link)
				$errors[] = $this->errors->pages->no_link;

			if ($errors) {
				$this->_request->setParam('errors', $errors);
				$this->_request->setParam('request', $this->_request);
				$this->_forward('edit');
			} else {
				$this->_pages->update(array (
					'updated_by' => Auth::getAuthInfo()->user_id,
					'body' => str_replace('../../..', '', $this->_request->body),
					'title' => $title,
					'description' => $description,
					'keywords' => $keywords,
					'link' => $link,
					'date_posted' => new Zend_Db_Expr('NOW()')
				), $id);

				$this->_redirect('/manager/pages/view/id/'.$id);
			}
		}

		public function deleteAction() {
            $id = (int) $this->_request->id;
			if (!$id)
				$this->_redirect('/manager/pages/');

			$this->_pages->delete($id);
			$this->_redirect('/manager/pages/');
		}

		public function categoriesAction() {
			$categories = $this->_category->getTree(0);

			$this->_assign('tab', 'category');
			$this->_assign('categories', $categories);
			$this->_display('pages/categories.tpl');
		}

		public function categoryEditAction() {
			$id = (int) $this->_request->id;

			if (!$id)
				$this->_redirect('/manager/pages/categories/');

			$category = $this->_category->load($id);
			$category->parent = $this->_category->load($category->parent_id);

			$categories = $this->_category->getParents();
			$allCategories = $this->_category->getAll();

			$this->_assign('tab', 'category');
			$this->_assign('category', $category);
			$this->_assign('all_categories', $allCategories);
			$this->_assign('categories', $categories);
			$this->_display('pages/edit-category.tpl');
		}

		public function categoryUpdateAction() {
			$id = (int) $this->_request->id;
			$name = trim($this->_request->name);
			$category = $this->_category->load($id);
			
			if (!$id || empty($name))
				$this->_redirect('/manager/pages/categories/');

			$bind = array (
				'name' => $name,
				'description' => $this->_request->description,
				'parent_id' => (int) $this->_request->parent_id
			);

			if ($_FILES['icon']) {
				$uploader = new Zend_File_Transfer_Adapter_Http();
				$uploader->setDestination($this->_dir_images);
				$uploader->addValidator('IsImage', true);
				$uploader->addFilter('Rename', array(
					'target' => $this->_dir_images.$this->_makeName($uploader->getFileName(null, false)),
					'overwrite'=>true
				));
				$icon = $uploader->receive();

				if ($icon) {
					$icon = $uploader->getFileName(null, false);
					Eve_Image::resample($this->_dir_images.$icon, $this->_dir_images.$icon, 64, 64);
					$bind['icon'] = $icon;

					if (file_exists($this->_dir_images.$category->icon))
						unlink($this->_dir_images.$category->icon);
				}
			}

			$this->_category->update($bind, $id);

			$this->_redirect('/manager/pages/categories/');
		}

		public function categoryAddAction() {
			$allCategories = $this->_category->getAll();

			$this->_assign('tab', 'category');
			$this->_assign('all_categories', $allCategories);
			$this->_display('pages/add-category.tpl');
		}

		public function categoryCreateAction() {
			$name = trim($this->_request->name);
			$alias = trim($this->_request->translit);

			if (empty($name))
				$this->_redirect('/manager/pages/categories/');

			$bind = array (
				'name' => $name,
				'parent_id' => (int) $this->_request->parent_id
			);

			if ($_FILES['icon']) {
				$uploader = new Zend_File_Transfer_Adapter_Http();
				$uploader->setDestination($this->_dir_images);
				$uploader->addValidator('IsImage', true);
				$uploader->addFilter('Rename', array(
					'target' => $this->_dir_images.$this->_makeName($uploader->getFileName(null, false)),
					'overwrite'=>true
				));
				$icon = $uploader->receive();

				if ($icon) {
					$icon = $uploader->getFileName(null, false);
					Eve_Image::resample($this->_dir_images.$icon, $this->_dir_images.$icon, 64, 64);
					$bind['icon'] = $icon;
				}
			}

			$this->_category->insert($bind);

			$this->_redirect('/manager/pages/categories/');
		}

		public function categoryDeleteAction() {
			$id = (int) $this->_request->id;

			if (!$id)
				$this->_redirect('/manager/pages/categories/');

			$children = $this->_category->getChildren($id);
			$category = $this->_category->load($id);

			$ids = array();
			$ids[] = $id;

			foreach ($children as $child) {
				$ids[] = $child->category_id;

				if (file_exists($this->_dir_images.$child->image))
					unlink($this->_dir_images.$child->image);

			}

			$pages = $this->_pages->fetchPagesByCategories($ids, array (
				'publication_id'
			));

			// get ids of pages that are in categories
			$pageIds = array();
			foreach ($pages as $page) {
				$pageIds[] = $page->publication_id;
			}

			// delete all child categories
			$this->_category->deleteChilds($id);

			// delete all related pages
			if (!empty ($pageIds))
				$this->_pages->deleteMatchedPages($pageIds);

			// delete requested category
			$this->_category->delete($id);
			
			if (file_exists($this->_dir_images.$category->image))
				unlink($this->_dir_images.$category->image);


			$this->_redirect('/manager/pages/categories/');
		}

		public function categoryRemoveIconAction() {

			$id = (int) $this->_request->id;

			if (!$id)
				$this->_redirect('/manager/pages/categories/');

			$category = $this->_category->load($this->_request->id);

			if (file_exists($this->_dir_images.$category->icon))
				unlink($this->_dir_images.$category->icon);

			$this->_category->update(array(
				'icon' => ''
			), $id);

			$this->_redirect('/manager/pages/category-edit/id/'.$id);

		}
	}