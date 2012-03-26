<?php

class Objects extends Eve_Model_Abstract
{

    /**
     * news table
     *
     * @var string
     */
    public $_name = 'objects';
    protected $_id_field = 'id';

    public function getAll($where = null)
    {
        $select = $this->select();
        if ($where)
            $select->where($where);

        return $select->query()->fetchAll();
    }

}