<?php
	class Skins extends Eve_Model_Abstract {

		protected $_id_field = 'skin_id';

		/**
		 * @var string
		 */
		public $_name = Eve_Enum_Tables::SKINS;

		public function init() {
			parent::init();
		}

		public function getDefault() {
			return $this->get('default', 1);
		}

	}