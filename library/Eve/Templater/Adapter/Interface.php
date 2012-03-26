<?php
/*
 *  Eve Platform
 * 
 *  LICENSE
 * 
 *  This source file is subject to the GPLv3 license that is bundled
 *  with this package in the file LICENSE.txt.
 */

/**
 * @author Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @version 0.2
 * @copyright  Copyright (c) 2009 Alex Oleshkevich
 * @category Eve
 * @package Template
 * @license  GPLv3
 */
interface Eve_Templater_Adapter_Interface {
	
    public function assign($key, $val);

	public function display($template);

	public function fetch($template);
}