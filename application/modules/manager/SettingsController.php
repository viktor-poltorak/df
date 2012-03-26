<?php
	class Manager_SettingsController extends Eve_Controller_AdminAction {

		protected $_settings;

		protected $allowedRoles = array(
			'admins'
		);
		
		public function init() {
			parent::init();
			
			$this->_settings = new Settings();
		}
	
		public function indexAction() {
			$this->_assign('settings', $this->_settings->getAll());
			$this->_assign('tab', 'index');
			$this->_display('settings/index.tpl');
		}

		public function addAction(){
			$this->_assign('request', $this->_request->request);
			$this->_assign('errors', $this->_request->errors);
			$this->_display('settings/edit.tpl');
		}

		public function createItemAction(){			
			if($this->_request->name == '' || $this->_request->value == ''){			
				$errors[] = "Не все поля заполнены";
				$this->_request->setParam('errors', $errors);
				$this->_request->setParam('request', $this->_request);
				$this->_forward('add');		
			} else {
				$bind = array(
					'name' => $this->_request->name,
					'value' => $this->_request->value,
					'lock' => $this->_request->lock
				);
				$this->_settings->insert($bind);
				$this->_redirect('/manager/settings');
			}
		}

		public function editAction(){
			$id = (int) $this->_request->id;
			if ((!$id))
				$this->_redirect('/manager/settings/');

			$item = $this->_settings->load($id);
			$this->_assign('request', $item);
			$this->_display('settings/edit.tpl');
		}

		public function saveAction(){
			$id = (int) $this->_request->id;
			
			if ($id){
				$bind = array(
					'name' => $this->_request->name,
					'value' => $this->_request->value,
					'lock' => $this->_request->lock
				);
				$this->_settings->update($bind, $id);
			}
			
			$this->_redirect('/manager/settings');
		}

		public function deleteAction(){
			$id = (int) $this->_request->id;

			if ($id){
				$this->_settings->delete($id);
			}

			$this->_redirect('/manager/settings');
		}
	}