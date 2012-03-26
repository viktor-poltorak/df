<?php

class Manager_MenusController extends Eve_Controller_AdminAction
{

    /**
     * @var Menus
     */
    protected $_menus;
    protected $_dir_icons = 'images/skins/?/icons/';
    /**
     * @var Pages
     */
    protected $_pages;

    public function init()
    {
        parent::init();
        $this->_menus = new Menus();
        $this->_pages = new Pages();
        $this->_dir_icons = str_replace('?', $this->_getSkin(), $this->_dir_icons);
    }

    public function indexAction()
    {
        $menus = $this->_menus->getAll();
        $this->_assign('menus', $menus);
        $this->_display('menus/index.tpl');
    }

    public function addAction()
    {
        $this->_assign('errors', $this->_request->errors);
        $this->_display('menus/add.tpl');
    }

    public function createAction()
    {
        $name = trim($this->_request->name);
        $description = strip_tags(trim($this->_request->description));

        if (!$name) {
            $this->_request->setParam('errors', $this->errors->name_must_be_set);
            $this->_forward('add');
        } else {
            $id = $this->_menus->insert(array(
                        'name' => $name,
                        'description' => $description,
                        'locked' => (int) $this->_request->locked
                    ));
            $this->_redirect('/manager/menus/items/id/' . $id);
        }
    }

    public function editAction()
    {
        $id = (int) $this->_request->id;

        if (!$id)
            $this->_redirect('/manager/menus/');

        $menu = $this->_menus->load($id);

        $this->_assign('errors', $this->_request->errors);
        $this->_assign('menu', $menu);
        $this->_display('menus/edit.tpl');
    }

    public function updateAction()
    {
        $id = (int) $this->_request->id;
        $name = trim($this->_request->name);
        $description = strip_tags(trim($this->_request->description));

        if (!$id)
            $this->_redirect('/manager/menus/');

        if (!$name) {
            $this->_request->setParam('errors', $this->errors->name_must_be_set);
            $this->_forward('edit');
        } else {
            $id = $this->_menus->update(array(
                        'name' => $name,
                        'description' => $description,
                        'locked' => (int) $this->_request->locked
                            ), $id);

            $this->_redirect('/manager/menus/');
        }
    }

    public function deleteAction()
    {
        $id = (int) $this->_request->id;

        if (!$id)
            $this->_redirect('/manager/menus/');

        $this->_menus->delete($id);
        $this->_menus->deleteItems($id);

        $this->_redirect('/manager/menus/');
    }

    public function itemsAction()
    {
        $id = (int) $this->_request->id;

        if (!$id)
            $this->_redirect('/manager/menus/');

        $menu = $this->_menus->load($id);
        $items = $this->_menus->getItems($id);

        $this->_assign('menu', $menu);
        $this->_assign('items', $items);

        $this->_display('menus/items.tpl');
    }

    public function addItemAction()
    {
        $id = (int) $this->_request->id;

        $menu = $this->_menus->load($id);

        if (!$menu)
            $menus = $this->_menus->getAll();

        $this->_assign('contentPages', $this->_pages->getAll());
        $this->_assign('menu', $menu);
        $this->_assign('menus', $menus);
        $this->_assign('request', $this->_request->request);
        $this->_assign('errors', $this->_request->errors);
        $this->_assign('tab', 'add-item');
        $this->_display('menus/add-item.tpl');
    }

    public function createItemAction()
    {       
        $menuId = (int) $this->_request->menu_id;
        $name = $this->_request->name;
        $description = $this->_request->description;
        $link = $this->_request->link;
        $inNewTab = (int) $this->_request->in_new_tab;
        $enabled = (int) $this->_request->enabled;

        $errors = array();

        if (!$menuId)
            $errors[] = $this->errors->manager->no_menu;

        if (!$name)
            $errors[] = $this->errors->no_name;

        if ($errors) {
            $this->_request->setParam('id', $menuId);
            $this->_request->setParam('errors', $errors);
            $this->_request->setParam('request', $this->_request);
            $this->_forward('add-item');
        } else {
            $bind = array(
                'name' => $name,
                'description' => $description,
                'link' => $link,
                'in_new_tab' => $inNewTab,
                'menu_id' => $menuId,
                'enabled' => 1,
                'item_position' => $this->_menus->getNextPosition($menuId)
            );

            if ($_FILES['icon']['name']) {
                $uploader = new Zend_File_Transfer_Adapter_Http();
                $uploader->setDestination($this->_dir_icons);
                $uploader->addValidator('IsImage', true);
                $uploader->addFilter('Rename', array(
                    'target' => $this->_dir_icons . rand(1000, 9999) . '_' . time() . '_' . $uploader->getFileName(null, false),
                    'overwrite' => true
                ));
                $icon = $uploader->receive();

                if ($icon) {
                    $icon = $uploader->getFileName(null, false);
                    $bind['icon'] = $icon;

                    if (file_exists($this->_dir_icons . $item->icon))
                        unlink($this->_dir_icons . $item->icon);
                }
            }

            $this->_menus->addItem($bind);

            $this->_redirect('/manager/menus/items/id/' . $menuId);
        }
    }

    public function editItemAction()
    {
        $id = (int) $this->_request->id;

        if (!$id)
            $this->_redirect('/manager/menus/');

        $item = $this->_menus->loadItem($id);
        $menus = $this->_menus->getAll();
        $menu = $this->_menus->load($item->menu_id);

        $this->_assign('contentPages', $this->_pages->getAll());
        $this->_assign('cmenu', $menu);
        $this->_assign('menus', $menus);
        $this->_assign('errors', $this->_request->errors);
        $this->_assign('item', $item);
        $this->_display('menus/edit-item.tpl');
    }

    public function updateItemAction()
    {
        $id = (int) $this->_request->id;

        $menuId = (int) $this->_request->menu_id;
        $name = $this->_request->name;
        $description = $this->_request->description;
        $link = $this->_request->link;
        $enabled = (int) $this->_request->enabled;
        $inNewTab = (int) $this->_request->in_new_tab;
        $errors = array();

        if (!$id || !$item = $this->_menus->loadItem($id))
            $this->_redirect('/manager/menus/');

        if (!$menuId)
            $errors[] = $this->errors->manager->no_menu;

        if (!$name)
            $errors[] = $this->errors->no_name;

        if (!$link)
            $errors[] = $this->errors->manager->no_link;

        if ($errors) {
            $this->_request->setParam('id', $menuId);
            $this->_request->setParam('errors', $errors);
            $this->_request->setParam('request', $this->_request);
            $this->_forward('edit-item');
        } else {

            $bind = array(
                'name' => $name,
                'description' => $description,
                'link' => $link,
                'in_new_tab' => $inNewTab,
                'menu_id' => $menuId,
                'enabled' => 1
            );

            if ($_FILES['icon']['name']) {
                $uploader = new Zend_File_Transfer_Adapter_Http();
                $uploader->setDestination($this->_dir_icons);
                $uploader->addValidator('IsImage', true);
                $uploader->addFilter('Rename', array(
                    'target' => $this->_dir_icons . $this->_makeName($uploader->getFileName(null, false)),
                    'overwrite' => true
                ));
                $icon = $uploader->receive();

                if ($icon) {
                    $icon = $uploader->getFileName(null, false);
                    $bind['icon'] = $icon;

                    if (file_exists($this->_dir_icons . $item->icon))
                        unlink($this->_dir_icons . $item->icon);
                }
            }

            $this->_menus->updateItem($bind, $id);

            $this->_redirect('/manager/menus/items/id/' . $menuId);
        }
    }

    public function deleteItemAction()
    {
        $id = (int) $this->_request->id;

        if (!$id)
            $this->_redirect('/manager/menus/');

        $item = $this->_menus->loadItem($id);
        $this->_menus->deleteItem($id);

        if (file_exists($this->_dir_icons . $item->icon))
            unlink($this->_dir_icons . $item->icon);

        $this->_redirect('/manager/menus/items/id/' . $item->menu_id);
    }

    public function savePositionAction(){
        $menuId = $this->_request->menuId;
        $items = (array) $this->_request->items;

        foreach($items as $k => $v){
            $this->_menus->updateItem(array('item_position'=>$v), $k);
        }

        $this->_redirect('/manager/menus/items/id/' .$menuId);
    }

}