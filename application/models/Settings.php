<?php
	class Settings extends Eve_Model_Abstract {
		/**
		 * news table
		 *
		 * @var string
		 */
		public $_name = 'settings';

		protected $_id_field = 'setting_id';
		
		public function getAll($visible = false) {
			$select = $this->select();
            if(!$visible){
                $select->where('visible=1');
            }
			return $select->query()->fetchAll();
		}

		public function getByName($name, $object = false){
			$select = $this->select();
			$select->where('name=?', $name);
			$result = $select->query()->fetchObject();

			if($result){
                if($object){
                    return $result;
                } else {
                    return $result->value;
                }
			} else {
				return false;
			}
		}
        
        public function set($name, $bind){
            $option = $this->getByName($name, true);
            $bind['name'] = $name;
            if($option){
                return $this->update($bind, $option->setting_id);
            } else {
                return $this->insert($bind);
            }
        }
	}