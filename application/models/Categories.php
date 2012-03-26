<?php

class Categories extends Eve_Model_Abstract {

    /**
     * news table
     *
     * @var string
     */
    public $_name = 'product_categories';
    protected $_id_field = 'category_id';

    public function getAll($where = null) {
        $select = $this->select();
        if ($where)
            $select->where($where);

        return $select->query()->fetchAll();
    }

    /**
     * Producers func
     * @return mixed
     */
    public function producerSubCat($notAssign = false){
        $select = $this->select();
        if($notAssign){
            $select->where('producer_id = 0');
        }
        $select->where('catalog_id = 1');
        $select->where('parent_id = 1');
        $select->order('name');
        return $select->query()->fetchAll();
    }

    public function byProducer($id){
        $select = $this->select();
        $select->where('producer_id=?', $producerId);
        $select->where('catalog_id = 1');
        $select->where('catalog_id = 1');
        return $select->query()->fetchAll();
    }

    public function getProducersTopLevel(){
        $select = $this->select();
        $select->where('producer_id= 0');
        $select->where('catalog_id = 1');
        $select->where('parent_id = 0');
        return $select->query()->fetchAll();
    }
   
    public function getByProducerId($producerId, $withoutTop = false) {
        $select = $this->select();
        $select->where('producer_id=?', $producerId);
        if ($withoutTop) {
            $select->where('parent_id!=0');
        }
        return $select->query()->fetchAll();
    }


    /**
     * Categories func
     * @param int $pid
     * @param bool $withoutOnHome
     * @return mixed
     */
    public function getByParentId($pid, $withoutOnHome = false) {
        $select = $this->select();
        $select->where('parent_id=?', $pid);
        $select->where('catalog_id = 0');
        if ($withoutOnHome) { // Ебать капать, в рот мне ноги
            $select->where('on_home = 0'); //Костыль бля Заказчик сука
        }
        return $select->query()->fetchAll();
    }

    public function getParent($id) {
        $select = $this->select();
        $select->where('parent_id = (select parent_id from product_categories where category_id = ?)', $id);
        return $select->query()->fetchAll();
    }

    public function clearProducer($producerId) {
        return $this->getAdapter()->update($this->_name, array('producer_id' => 0), $this->getAdapter()->quoteInto('producer_id = ?', $producerId));
    }

    public function getParentId($id) {
        $select = $this->select();
        $select->where('category_id = ?', $id);
        $result = $select->query()->fetchObject();
        if ($result) {
            return $result->parent_id;
        } else {
            return false;
        }
    }
    
    /**
     *
     * @param int $cat 0 - by categories 1 - by manufacturer
     * @param int $parentId
     * @return array
     */
    public function getCategoriesByCatalog($cat, $parentId = false){
        $select = $this->select();
        $select->where('catalog_id=?', $cat);
        if ($parentId !== false) {
            $select->where('parent_id=?', $parentId);
        }
        return $select->query()->fetchAll();
    }


    public function getHomeCategories($cat=0, $parentId = false){
        $select = $this->select();
        $select->where('catalog_id=?', $cat);
        if ($parentId !== false) {
            $select->where('parent_id=?', $parentId);
        }
        $select->where('on_home=1', $parentId);
        return $select->query()->fetchAll();
    }

}