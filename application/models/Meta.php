<?php

class Meta extends Eve_Model_Abstract
{

    protected $_name = 'meta';
    protected $_id_field = 'id';

    public $_categories_table = 'product_categories';

    /**
    *  author	Defines the author of the document
    *  copyright	Defines copyright information of the document
    *  description	Defines a description of the document
    *  distribution	Defines the distribution level of the document (like "Global")
    *  generator	Defines the program used to generate the document
    *  keywords	Defines keywords to describe the document
    *  progid	Defines the id of a program used to generate the document
    *  rating	Defines webpage rating
    *  resource-type	Defines the type of the web resource
    *  revisit-after	Defines the expected update rate of the web resource
    *  robots	Defines rules for robots (web crawlers for search engines)
    *  others
    */
    public function getMetaNames(){
        return array(
            'author',
            'copyright',
            'description',
            'generator',
            'keywords',
            'rating',
            'resource-type',
            'robots',
            'others'
        );
    }


    /**
     * Return unique links from table
     *
     * @return array
     */
    public function getUniqueLinks(){        
        $sql = "SELECT * FROM {$this->_name} GROUP BY link";
        return $this->getAdapter()->query($sql)->fetchAll();
    }

    /**
     * Return meta by link
     *
     * @param string $link
     * @return array
     */
    public function getMetaByLink($link){
        $select = $this->select();
        $select->where('link=?', $link);
        $select->where("name IS NOT NULL");
        return $select->query()->fetchAll();
    }

    public function isExists($link){
        $select = $this->select();
        $select->where('link=?', $link);
        return ($select->query()->fetchObject()) ? true : false;
    }

    public function getCategoriesWithoutMeta(){
        $catLink = '/catalog/category/id/';

        $sql = "
        select * from product_categories as pc
        where
            pc.catalog_id = 0 and pc.parent_id = 0
        and (select count(*) from meta where link = CONCAT('{$catLink}',`pc`.`category_id`)) = 0
        ";
        
        return $this->getAdapter()->query($sql)->fetchAll();
    }
    
    public function getProducersWithoutMeta(){
        $prodLink = '/catalog/manufacturer/id/';

        $sql = "
            select * from product_categories as pc
            where
                pc.producer_id = 0 and pc.catalog_id = 1 and pc.parent_id = 0
            and (select count(*) from meta where link = CONCAT('{$prodLink}',`pc`.`category_id`)) = 0
            ";

        return $this->getAdapter()->query($sql)->fetchAll();
    }

    public function getPagesWithoutMeta(){
        $link = '/pages/';
        $sql = "
            select * from pages as p
            where
             (select count(*) from meta where link = CONCAT('{$link}',`p`.`link`)) = 0
            ";
        return $this->getAdapter()->query($sql)->fetchAll();
    }

    public function getProductsWithoutMeta(){
        $link = '/catalog/product/id/';
        $sql = "
            select * from products as p
            where
             (select count(*) from meta where link = CONCAT('{$link}',`p`.`product_id`)) = 0
            ";
        return $this->getAdapter()->query($sql)->fetchAll();
    }
}