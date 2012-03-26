<?php
/**
 *	Controller for all pages protected from unauthorized access.
 *
 * @author Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @version 0.2
 * @copyright  Copyright (c) 2009 Alex Oleshkevich
 * @package Eve
 * @license  GPLv3
 */
class Eve_Controller_AuthAction extends Eve_Controller_Action {

	public function init() {
		parent::init();

		if(!Auth::isLogged())
			$this->_redirect('/login/');
	}
}