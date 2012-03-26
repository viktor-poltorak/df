<?php

class Images extends Eve_Model_Abstract
{

    /**
     * news table
     *
     * @var string
     */
    public $_name = 'images';
    protected $_id_field = 'id';

    public function getAll($where = null)
    {
        $select = $this->select();
        if ($where)
            $select->where($where);

        return $select->query()->fetchAll();
    }
    
    public function getByObjectId($objectId) 
    {
        $select = $this->select();        
        $select->where('object_id = ?', $objectId);        
        return $select->query()->fetchAll();
    }

}