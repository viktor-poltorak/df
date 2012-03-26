<?php
class Eve_Helper_Email extends Zend_Controller_Action_Helper_Abstract {

	/**
	 * @var Zend_Mail
	 */
	protected $_email;

	/**
	 * @var Zend_Config
	 */
	protected $_config;

	protected $_type = Eve_Helper_Email::HTML;

	protected $_to;

	const HTML = 1;
	const PLAIN = 2;

	public function  __construct() {
		$this->_config = Eve_Helper_ConfigLoader::get('email.xml', 'email');

		Zend_Mail::setDefaultTransport(new Zend_Mail_Transport_Smtp($this->_config->transport->host, $this->_config->transport->toArray()));

		$this->_email = new Zend_Mail($this->_config->encoding);
	}

	public function getConfig() {
		return (object) $this->_config->toArray();
	}

	public function getInstanse() {
		return $this->_email;
	}

	public function send($to, $subject, $body) {
		$this->_email->setFrom($this->_config->from->email, $this->_config->from->first_name.' '.$this->_config->from->last_name);
		
		if (is_array($to))
			$this->_email->addTo($to['email'], $to['first_name'].' '.$to['last_name']);
		else
			$this->_email->addTo($to);

		$this->_email->setSubject($subject);

		if ($this->_type == Eve_Helper_Email::HTML)
			$this->_email->setBodyHtml($body);
		else
			$this->_email->setBodyText($body);

		//var_dump($this->_email);exit;

		$this->_email->send();
	}

	public function setType($type) {
		$this->_type = $type;
	}

}