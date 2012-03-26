<?php
	/**
	 *	Extender class for admin pages
	 *
	 * @author Alex Oleshkevich <alex.oleshkevich@gmail.com>
	 * @version 0.2
	 * @copyright  Copyright (c) 2009 Alex Oleshkevich
	 * @package Eve
	 * @license  GPLv3
	 */
	class Eve_Controller_AdminAction extends Eve_Controller_Action {
		
		public function init() {
			parent::init();

			$this->_templater->setOption('template_dir', 'application/views/manager/');

			if(!Auth::isLogged())
				$this->_redirect('/manager/auth/');
				
			if (!Auth::getAuthInfo()->role_id) {
				$this->_redirect('/404/');
				exit;
			}

			$this->_assign('tab', $this->_request->action);

		}

		/**
		 * is you has enough permissions to access this controller
		 * @param array $permissions conntrollers permissions
		 * @return bool
		 */
		public function isAllowed($permissions) {
			return true;
		}

	}