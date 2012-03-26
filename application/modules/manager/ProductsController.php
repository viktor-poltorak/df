<?php

class Manager_ProductsController extends Eve_Controller_AdminAction
{

    /**
     *
     * @var Products
     */
    protected $_products;
    protected $allowedRoles = array(
        'admins'
    );
    /**
     *
     * @var Categories
     */
    protected $_categories;
    /**
     *
     * @var Producers
     */
    protected $_producers;
    protected $_dir_images = 'images/products/';

    /**
     *
     * @var array
     */
    protected $_uploads = array();


    public function init()
    {
        parent::init();
        $this->_products = new Products();
        $this->_categories = new Categories();
        $this->_producers = new Producers();
        $this->_assign('js', array(
            'libs/tiny_mce/tiny_mce',
            'tiny_mce_init'
        ));
    }

    public function indexAction()
    {
        $this->_assign('products', $this->_products->getAll());
        $this->_assign('tab', 'index');
        $this->_display('products/index.tpl');
    }

    public function addAction()
    {
        //$this->_assign('categories', $this->_categories->getAll());
        $this->_assign('producers', $this->_categories->getProducersTopLevel());
        $this->_assign('request', $this->_request->request);
        $this->_assign('categories', $this->_categories->getByParentId(0));
        $this->_assign('errors', $this->_request->errors);
        $this->_display('products/edit.tpl');
    }

    public function saveAction()
    {
        $title = trim(strip_tags($this->_request->title));

        $description = stripslashes(trim(strip_tags($this->_request->description)));
        $color = stripslashes(trim(strip_tags($this->_request->color)));
        $consumption = stripslashes(trim(strip_tags($this->_request->consumption)));
        $package = (int) $this->_request->package;
        $storage_time = stripslashes(trim(strip_tags($this->_request->storage_time)));
        $durability = stripslashes(trim(strip_tags($this->_request->durability)));
        $storage_terms = stripslashes(trim(strip_tags($this->_request->storage_terms)));
        $use_for = stripslashes(trim(strip_tags($this->_request->use_for)));
        $pre_packing = stripslashes(trim(strip_tags($this->_request->pre_packing)));

        $producer_id = (int) $this->_request->producer_id;
        $category_id = (int) $this->_request->category_id;
        $prod_cat = (int) $this->_request->prod_cat;

        $stock = $this->_request->stock ? 1 : 0;
        $featured = $this->_request->featured ? 1 : 0;

        $description = preg_replace('/width=\"\d+\"/i', "", $description);
        $description = preg_replace('/height=\"\d+\"/i', "", $description);

        $meta = trim(strip_tags($this->_request->meta));
        $keywords = trim(strip_tags($this->_request->keywords));

        if ($title == '') {
            $errors[] = $this->errors->products->no_title;
        }
        if ($description == '') {
            $errors[] = $this->errors->products->no_description;
        }

        if ($category_id == 0) {
            $errors[] = $this->errors->products->no_category;
        }
        if ($producer_id == 0) {
            $errors[] = $this->errors->products->no_category;
        }

        $bind = array(
            'title' => $title,
            'description' => $description,
            'color' => $color,
            'consumption' => $consumption,
            'package' => $package,
            'storage_time' => $storage_time,
            'durability' => $durability,
            'storage_terms' => $storage_terms,
            'use_for' => $use_for,
            'meta' => $meta,
            'keywords' => $keywords,
            'category_id' => $category_id,
            'producer_id' => $producer_id,
            'stock' => $stock,
            'featured' => $featured,
            'prod_cat' => $prod_cat,
            'pre_packing' => $pre_packing,
            'img_alt' => $title
        );

        $image = $this->_uploadSmallImage();
        if($image){
            $bind['image'] = $image;
        }

        $image = $this->_uploadBigImage();
        if($image){
            $bind['big_image'] = $image;
        }

        if ($errors) {
            $this->_request->setParam('errors', $errors);
            $this->_request->setParam('request', $this->_request);
            $this->_forward('add');
        } else {
            if ($this->_request->id) {
                $id = (int) $this->_request->id;
                if (!$id)
                    $this->_redirect('/manager/products');
                $this->_products->update($bind, $id);
            } else {
                $bind['date_posted'] = new Zend_Db_Expr('NOW()');
                $this->_products->insert($bind);
            }
            $this->_redirect('/manager/products');
        }
    }

    public function editAction()
    {
        $id = (int) $this->_request->id;
        if ((!$id))
            $this->_redirect('/manager/products/');
        $item = $this->_products->load($id);
        $this->_assign('producers', $this->_categories->getProducersTopLevel());
        $this->_assign('prodCat', $this->_categories->getByProducerId($item->producer_id));
        $this->_assign('categories', $this->_categories->getByParentId(0));
        $this->_assign('request', $item);
        $this->_display('products/edit.tpl');
    }

    public function deleteAction()
    {
        $id = (int) $this->_request->id;
        if ($id) {
            $product = $this->_products->load($id);
            $this->deleteImage($product->image);
            $this->_products->delete($id);
        }
        $this->_redirect('/manager/products');
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

    /**
     * Ajax function
     */
    public function categoriesAction()
    {
        $id = (int) $this->_request->id;
        if ((!$id))
            die;

        $categories = $this->_categories->getByProducerId($id);
        $result = '<option>Выберите категорию</option>';
        foreach ($categories as $cat) {
            $result .= '<option value="' . $cat->category_id . '">' . $cat->name . '</option>';
        }
        echo $result;
        die;
    }

    protected function _uploadSmallImage(){
        $this->_uploads = $_FILES;
        $_FILES = array();
        $result = false;

        if(isset($this->_uploads['image']['name'])){
            $_FILES['image'] = $this->_uploads['image'];
            
            $uploader = new Zend_File_Transfer_Adapter_Http();
            $uploader->setDestination($this->_dir_images);
            $fileName = $uploader->getFileName(null, false);
            $newImageName = Eve_File::makeName($fileName);

            //$type = explode('.', $fileName);
            //$type = strtolower(array_pop($type));

            $uploader->addFilter('Rename', array(
                'target' => $this->_dir_images . $newImageName,
                'overwrite' => true)
            );

            $image = $uploader->receive();

            if ($image) {
                $fileName = $uploader->getFileName(null, false);

                //Eve_Image::resize($this->_dir_images . $fileName, 135, 100, $this->_dir_images . $newImageName, true);

                if ($this->_request->id) {
                    $product = $this->_products->load($this->_request->id);
                    if ($fileName != $product->image) {
                        $this->deleteImage($product->image);
                    }
                }

                $result = $newImageName;
            }
        }

        //Clear current upload
        unset($this->_uploads['image']);
        $_FILES = $this->_uploads;
        
        return $result;
    }

    protected function _uploadBigImage(){
        $this->_uploads = $_FILES;
        $_FILES = array();
        $result = false;

        if(isset($this->_uploads['big_image']['name'])){
            $_FILES['big_image'] = $this->_uploads['big_image'];

            $uploader = new Zend_File_Transfer_Adapter_Http();
            $uploader->setDestination($this->_dir_images);
            $fileName = $uploader->getFileName(null, false);
            $newImageName = Eve_File::makeName($fileName);

            //$type = explode('.', $fileName);
            //$type = strtolower(array_pop($type));

            $uploader->addFilter('Rename', array(
                'target' => $this->_dir_images . $newImageName,
                'overwrite' => true)
            );

            $image = $uploader->receive();

            if ($image) {
                $fileName = $uploader->getFileName(null, false);

                // No resize for big image
                //Eve_Image::resize($this->_dir_images . $fileName, 135, 100, $this->_dir_images . $newImageName, true);

                if ($this->_request->id) {
                    $product = $this->_products->load($this->_request->id);
                    if ($fileName != $product->big_image) {
                        $this->deleteImage($product->big_image);
                    }
                }

                $result = $newImageName;
            }
        }

        //Clear current upload
        unset($this->_uploads['big_image']);
        $_FILES = $this->_uploads;

        return $result;
    }
}