<?php

class Manager_ObjectsController extends Eve_Controller_AdminAction
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

    /**
     *
     * @var array
     */
    protected $allowedRoles = array(
        'admins'
    );

    /**
     *
     * @var string
     */
    protected $_dir_images = 'upload/objects/';

    public function init()
    {
        parent::init();

        $this->_objects = new Objects();
        $this->_images = new Images();

        $this->_assign('js', array(
            'facebox',
            'libs/tiny_mce/tiny_mce',
            'tiny_mce_init'
        ));
        $this->_assign('css', array(
            'facebox'
        ));
    }

    public function indexAction()
    {
        $this->_assign('tab', 'index');
        $this->_assign('objects', $this->_objects->getAll());
        $this->_display('objects/index.tpl');
    }

    public function addAction()
    {
        $this->_assign('request', $this->_request->request);
        $this->_assign('errors', $this->_request->errors);
        $this->_display('objects/edit.tpl');
    }

    public function createItemAction()
    {
        if ($this->_request->name == '') {
            $errors[] = $this->errors->name_must_be_set;
            $this->_request->setParam('errors', $errors);
            $this->_request->setParam('request', $this->_request);
            $this->_forward('add');
        } else {
            $bind = array(
                'name' => $this->_request->name,
                'description' => $this->_request->description
            );
            $id = $this->_objects->insert($bind);

            $this->_uploadImage($id);

            $this->_redirect('/manager/objects');
        }
    }

    public function editAction()
    {
        $id = (int) $this->_request->id;
        if ((!$id))
            $this->_redirect('/manager/objects/');

        $this->_assign('request', $this->_objects->load($id));
        $this->_assign('images', $this->_images->getByObjectId($id));
        $this->_display('objects/edit.tpl');
    }

    public function saveAction()
    {
        $id = (int) $this->_request->id;
        if ($id) {
            $bind = array(
                'name' => $this->_request->name,
                'description' => $this->_request->description
            );
            $this->_uploadImage($id);
            $this->_objects->update($bind, $id);

            $this->_redirect('/manager/objects/edit/id/' . $id);
        }
        $this->_redirect('/manager/objects');
    }

    public function deleteimageAction()
    {
        $id = (int) $this->_request->id;
        $this->deleteImage($id);
        $this->_redirect('/manager/objects');
    }

    protected function _uploadImage($objectId)
    {
        //Upload image
        if ($_FILES['image'] && !empty($_FILES['image']['name'])) {
            $uploader = new Zend_File_Transfer_Adapter_Http();
            $uploader->setDestination($this->_dir_images);
            $fileName = $uploader->getFileName(null, false);

            $newImageName = md5($fileName . $objectId);

            $type = explode('.', $fileName);
            $type = strtolower(array_pop($type));

            $uploader->addFilter('Rename', array(
                'target' => $this->_dir_images . $newImageName . '.' . $type,
                'overwrite' => true)
            );

            $image = $uploader->receive();

            if ($image) {
                $fileName = $uploader->getFileName(null, false);

                $bind = array('object_id' => $objectId, 'path' => $fileName);
                $this->_images->insert($bind);

                return $fileName;
            }
        }

        return false;
    }

    protected function deleteImage($id)
    {
        $image = $this->_images->load($id);
        if (!$image) {
            return false;
        }

        $imagePath = $this->_dir_images . $image->path;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        $this->_images->delete($id);
    }

    public function deleteAction()
    {
        $id = (int) $this->_request->id;
        if ($id) {

            $images = $this->_images->getByObjectId($id);
            if ($images) {
                foreach ($images as $image) {
                    $this->deleteImage($image->id);
                }
            }
            $this->_objects->delete($id);
        }
        $this->_redirect('/manager/objects');
    }

}