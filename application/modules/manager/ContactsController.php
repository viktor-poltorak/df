<?php
	class Manager_ContactsController extends Eve_Controller_AdminAction {

		protected $_settings;

		public function init() {
			parent::init();
			$this->_contacts = new Contacts();
		}
	
		public function indexAction() {
			$phones = $this->_contacts->getByType(Contacts::CONTACT_PHONE);
			$skype = $this->_contacts->getByType(Contacts::CONTACT_SKYPE);
			$skype = $skype[0];

			$icq = $this->_contacts->getByType(Contacts::CONTACT_ICQ);
			$icq = $icq[0];
			
			$address = $this->_contacts->getByType(Contacts::CONTACT_ADDRESS);
			$address = $address[0];

			$email = $this->_contacts->getByType(Contacts::CONTACT_EMAIL);
			$email = $email[0];
			
			$this->_assign('phones', $phones);
			$this->_assign('skype', $skype);
			$this->_assign('icq', $icq);
			$this->_assign('address', $address);
			$this->_assign('email', $email);
			
			$this->_display('contacts/index.tpl');
		}

		public function saveAction() {
			$this->_contacts->truncate();
			
			$this->_contacts->insert(array(
				'value' => strip_tags($this->_request->skype),
				'type' => Contacts::CONTACT_SKYPE
			));
			$this->_contacts->insert(array(
				'value' => strip_tags($this->_request->icq),
				'type' => Contacts::CONTACT_ICQ
			));

			foreach ($this->_request->phones as $phone) {
				$this->_contacts->insert(array(
					'value' => preg_replace('/^\d^\-$\s^\+^\./', '', $phone),
					'type' => Contacts::CONTACT_PHONE
				));
			}

			$this->_contacts->insert(array(
				'value' => strip_tags($this->_request->address),
				'type' => Contacts::CONTACT_ADDRESS
			));

			$this->_contacts->insert(array(
				'value' => strip_tags($this->_request->email),
				'type' => Contacts::CONTACT_EMAIL
			));
			
			$this->_redirect('/manager/contacts/');
		}

	}