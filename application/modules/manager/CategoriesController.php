<?php

class Manager_CategoriesController extends Eve_Controller_AdminAction
{

    /**
     *
     * @var Categories
     */
    protected $_categories;

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
    protected $_dir_images = 'images/categories/';

    public function init()
    {
        parent::init();
        $this->_categories = new Categories();
    }

    public function indexAction()
    {
        $this->_assign('categories', $this->_categories->getByParentId(0));
        $this->_assign('tab', 'index');
        $this->_display('categories/index.tpl');
    }

    public function addAction()
    {
        $this->_assign('request', $this->_request->request);
        $this->_assign('errors', $this->_request->errors);
        $this->_display('categories/edit.tpl');
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
                'on_home' => (int) $this->_request->on_home
            );
            $this->_categories->insert($bind);
            $this->_redirect('/manager/categories');
        }
    }

    public function subcatAction()
    {
        $id = (int) $this->_request->id;
        if ((!$id))
            $this->_redirect('/manager/categories/');

        $categories = $this->_categories->getByParentId($id);

        $this->_assign('categories', $categories);
        $this->_display('categories/index.tpl');
    }

    public function editAction()
    {
        $id = (int) $this->_request->id;
        if ((!$id))
            $this->_redirect('/manager/categories/');
        $item = $this->_categories->load($id);
        $this->_assign('request', $item);

        $this->_assign('categories', $this->_categories->getByParentId(0));

        $this->_display('categories/edit.tpl');
    }

    public function saveAction()
    {
        $id = (int) $this->_request->id;
        if ($id) {
            $bind = array(
                'name' => $this->_request->name,
                'on_home' => (int) $this->_request->on_home,
                'catalog_id' => 0
            );
            //Upload image
            if ($_FILES['image']) {
                $uploader = new Zend_File_Transfer_Adapter_Http();
                $uploader->setDestination($this->_dir_images);
                $fileName = $uploader->getFileName(null, false);
                $newImageName = md5($fileName);

                $type = explode('.', $fileName);
                $type = strtolower(array_pop($type));

                $uploader->addFilter('Rename', array(
                    'target' => $this->_dir_images . $newImageName . '.' . $type,
                    'overwrite' => true)
                );

                $image = $uploader->receive();

                if ($image) {
                    $fileName = $uploader->getFileName(null, false);
                    //$nFileName = Eve_File::makeName($this->_dir_images . $fileName);
                    //Eve_Image::resize($this->_dir_images . $fileName, 100, 100, $this->_dir_images.$nFileName , true);
                    //if(file_exists($this->_dir_images . $fileName)){
                    //     unlink($this->_dir_images . $fileName);
                    // }

                    if ($this->_request->id) {
                        $product = $this->_categories->load($this->_request->id);
                        if ($fileName != $product->image) {
                            $this->deleteImage($product->image);
                        }
                    }

                    $bind['image'] = $fileName;
                }
            }
            $this->_categories->update($bind, $id);
        }
        $this->_redirect('/manager/categories');
    }

    protected function deleteImage($image)
    {
        if ($image == '')
            return;
        $image1 = $this->_dir_images . $image;

        if (file_exists($image1)) {
            unlink($image1);
        }
    }

    public function deleteAction()
    {
        $id = (int) $this->_request->id;
        if ($id) {
            $this->_categories->delete($id);
        }
        $this->_redirect('/manager/categories');
    }

}