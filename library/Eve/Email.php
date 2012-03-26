<?php
	class Eve_Email extends Zend_Mail {
		/**
		 * @var Zend_Config_Xml
		 */
		protected $_config;


		public function __construct() {
			$this->_config = new Zend_Config_Xml('configs/email.xml', 'config');
		}
		
		public function send($user, $subject, $body) {
			$_user = new stdClass();
			$_user->email = $user['email'];
			$_user->first_name = $user['first_name'];
			$_user->last_name = $user['last_name'];

			$this->mail($_user, $subject, $body);
		}

		public function mail($user, $subject, $body) {
			$mail = new Zend_Mail($this->_config->encoding);
			$mail->setFrom($this->_config->from->email, $this->_config->from->first_name.' '. $this->_config->from->last_name);
			$mail->addTo($user->email, $user->first_name.' '.$user->last_name);
			$mail->setSubject($subject);
			$mail->setBodyHtml($body);

			$mail->send();

		}
	}