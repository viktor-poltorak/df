<?php
/*
 *  Eve Platform
 * 
 *  LICENSE
 * 
 *  This source file is subject to the GPLv3 license that is bundled
 *  with this package in the file LICENSE.txt.
 * 
 * @author Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @version 0.2
 * @copyright  Copyright (c) 2009 Alex Oleshkevich
 * @category Eve
 * @package Templater
 * @subpackage Adapter
 * @license  GPLv3
 */

//require_once 'Eve/Templater/Adapter/Interface.php';

class Eve_Templater_Adapter_Smarty implements Eve_Templater_Adapter_Interface {

	/**
	 * @var Smarty
	 */
	protected $_smarty;

	public function  __construct($options = array()) {
		require_once 'Smarty/Smarty.class.php';

		$this->_smarty = new Smarty();

		foreach ($options as $key => $option) {
			$this->_smarty->$key = $option;
		}

	}

	public function setOption($key, $val) {
		$this->_smarty->$key = $val;
	}

    public function getTemplateVar($name){
        return $this->_smarty->get_template_vars($name);
    }

	public function assign($key, $val) {
		$this->_smarty->assign($key, $val);
	}

	public function display($template) {
		$this->_smarty->display($template);
	}

	public function fetch($template) {
		return $this->_smarty->fetch($template);
	}
}