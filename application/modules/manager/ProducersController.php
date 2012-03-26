<?php

class Manager_ProducersController extends Eve_Controller_AdminAction
{

    /**
     *
     * @var Producers
     */
    protected $_producers;

    /**
     *
     * @var Categories
     */
    protected $_categories;
    protected $allowedRoles = array(
        'admins'
    );

    public function init()
    {
        parent::init();
        $this->_producers = new Producers();
        $this->_categories = new Categories();
    }

    public function indexAction()
    {
        $this->_assign('producers', $this->_categories->getProducersTopLevel());
        $this->_assign('tab', 'index');
        $this->_display('producers/index.tpl');
    }

    public function addAction()
    {
        $this->_assign('js', array(
            'libs/tiny_mce/tiny_mce',
            'tiny_mce_init'
        ));

        $prodCategories = $this->_categories->producerSubCat();
        $this->_assign('prodCategories', $prodCategories);

        $this->_assign('request', $this->_request->request);
        $this->_assign('errors', $this->_request->errors);
        $this->_display('producers/edit.tpl');
    }

    public function createItemAction()
    {
        if ($this->_request->name == '') {
            $errors[] = $this->errors->name_must_be_set;
            $this->_request->setParam('errors', $errors);
            $this->_request->setParam('request', $this->_request);
            $this->_forward('add');
        } else {
            $bind = array('name' => $this->_request->name, 'description' => $this->_request->description,  'catalog_id' => '1');
            $id = $this->_categories->insert($bind);
            $this->assignCategories($id);
            $this->_redirect('/manager/producers');
        }
    }

    public function editAction()
    {
        $this->_assign('js', array(
            'libs/tiny_mce/tiny_mce',
            'tiny_mce_init'
        ));

        $id = (int) $this->_request->id;
        if ((!$id))
            $this->_redirect('/manager/producers/');
        $item = $this->_categories->load($id);
        $prodCategories = $this->_categories->producerSubCat();

        $this->_assign('prodCategories', $prodCategories);
        $this->_assign('request', $item);
        $this->_display('producers/edit.tpl');
    }

    public function saveAction()
    {
        $id = (int) $this->_request->id;
        if ($id) {
            $bind = array('name' => $this->_request->name,
                'description' => $this->_request->description);
            $this->_categories->update($bind, $id);

            $this->assignCategories($id);
        }
        $this->_redirect('/manager/producers');
    }

    public function deleteAction()
    {
        $id = (int) $this->_request->id;
        if ($id) {
            $this->_categories->delete($id);
        }
        $this->_redirect('/manager/producers');
    }

    protected function assignCategories($id)
    {
        $categories = $this->_request->categories;

        if ($categories) {
            $this->_categories->clearProducer($id);
            foreach ($categories as $v) {
                $this->_categories->update(array('producer_id' => $id), (int) $v);
            }
        }
    }

    public function addCategoryAction()
    {
        $catName = trim($this->_request->name);
        if ($catName) {
            $id = $this->_categories->insert(array('name' => $catName, 'catalog_id' => 1, 'parent_id' => '1'));
            echo json_encode(array('name' => $catName, 'id' => $id));
        }

        die;
    }

    public function delCategoryAction()
    {
        $id = (int) $this->_request->id;
        $this->_categories->delete($id);
        die;
    }

}