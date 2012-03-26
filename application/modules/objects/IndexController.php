<?php

class Objects_IndexController extends Eve_Controller_Action
{

    /**
     *
     * @var Objects
     */
    protected $_objects;

    /**
     *
     * @var Images
     */
    protected $_images;

    public function init()
    {
        parent::init();

        $this->_objects = new Objects();
        $this->_images = new Images();
    }

    public function indexAction()
    {
        $objects = $this->_objects->getAll();
        foreach ($objects as &$object) {
            $images = $this->_images->getByObjectId($object->id);
            if (isset($images[0])) {
                $object->image = $images[0];
            }
        }
        $this->_setPageTitle('Наши объекты');
        $this->_assign('objects', $objects);
        $this->_display('objects/index.tpl');
    }

    public function viewAction()
    {
        $id = (int) $this->_request->id;
        $object = $this->_objects->load($id);
        if(!$object) {
            $this->_redirect('objects/');
        }
        
        $images = $this->_images->getByObjectId($id);
        $this->_assign('object', $object);
        $this->_assign('images', $images);
        $this->_setPageTitle('Наши объекты - ' . $object->name);
        $this->_display('objects/view.tpl');
    }

}