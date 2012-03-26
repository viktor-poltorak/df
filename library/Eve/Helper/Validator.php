<?php
class Eve_Helper_Validator extends Zend_Controller_Action_Helper_Abstract {

	public function isEmpty($text) {
		$text = trim(strip_tags($text));
		if (empty($text))
			return true;
		else
			return false;
	}

	public function isValidEmail($email) {
		$validator = new Zend_Validate_EmailAddress();

		return $validator->isValid($email);
	}

	public function isValidStringLenght($str, $min, $max) {
		$validator = new Zend_Validate_StringLength($min, $max);

		return $validator->isValid($str);
	}

}