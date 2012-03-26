<?php
/**
 * @author Viktor Poltorak
 */

class Banners extends Eve_Model_Abstract {
    /**
     * banners table
     *
     * @var string
     */
    public $_name = 'banners';

    protected $_id_field = 'id';

    public function getAll() {
        $select = $this->select();
        $select->where('file NOT LIKE "%.swf"');
        return $select->query()->fetchAll();
    }
    
    public function getFlashBanner() {
        $select = $this->select();
        $select->where('file LIKE "%.swf"');
        $select->limit(1);
        return $select->query()->fetchObject();
    }
}