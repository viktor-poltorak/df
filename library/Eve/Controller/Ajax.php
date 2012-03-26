<?php
/**
 *	Controller for ajax requests
 *
 * @author Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @version 0.2
 * @copyright  Copyright (c) 2009 Alex Oleshkevich
 * @package Eve
 * @license  GPLv3
 */
class Eve_Controller_Ajax extends Eve_Controller_Action  {
	public function init() {
		parent::init();

		if (!$this->isAjax())
			$this->_redirect('/404/');
	}

	/**
	 *	displays a plain html
	 * @param string $template
	 */
	protected function _display($template) {
		echo $this->_fetch($template);
	}

	/**
	 *	returns a json string
	 * @param string $template
	 * @param int $status
	 * @param string $message
	 */
	protected function _show($template, $status = 200, $message = 'Done') {
		$template = $this->_fetch($template);

		echo json_encode(array(
			'data' => $template,
			'status' => $status,
			'message' => $message
		));
	}

	/**
	 *	 simply display json-encoded string
	 * @param array $bind
	 */
	protected function _respond($bind) {
		echo json_encode($bind);
	}

	/**
	 *	display error
	 * @param string $text
	 */
	protected function _respondError($text) {
		echo json_encode(array(
			'error' => true,
			'message' => $text
		));
	}

}