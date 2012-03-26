<?php

class Manager_SeoController extends Eve_Controller_AdminAction
{

    /**
     *
     * @var Products
     */
    private $_products;
    /**
     *
     * @var Meta
     */
    private $_meta;

    /**
     *
     * @var Settings
     */
    private $_settings;
 

    protected $allowedRoles = array(
        'admins',
        'editors'
    );
   
    public function init()
    {
        parent::init();
        $this->_assign('js', array('manage/seo'));
        $this->_meta = new Meta();
        $this->_products = new Products();
        $this->_settings = new Settings();
    }

    public function indexAction()
    {
        $request = new stdClass();
        $request->commonTitle = $this->_settings->getByName('commonTitle');
        $request->metaDescription = $this->_settings->getByName('metaDescription');
        $request->metaKeywords = $this->_settings->getByName('metaKeywords');
        $request->additionMetaTags = $this->_settings->getByName('additionMetaTags');

        $this->_assign('request', $request);
        $this->_assign('tab', 'global');
        $this->_display('seo/index.tpl');
    }

    public function sitemapAction(){
        $this->_assign('tab', 'sitemap');
        $this->_display('seo/sitemap.tpl');
    }


    public function saveSettingsAction(){
        $commonTitle = strip_tags($this->_request->commonTitle);
        $metaDescription = strip_tags($this->_request->metaDescription);
        $metaKeywords = strip_tags($this->_request->metaKeywords);
        $additionMetaTags = $this->_request->additionMetaTags;

        $bind = array(
					'value' => $commonTitle,
					'lock' => 1,
                    'visible' => 0
				);
        
        $this->_settings->set('commonTitle', $bind);

        $bind['value'] = $metaDescription;
        $this->_settings->set('metaDescription', $bind);
        $bind['value'] = $metaKeywords;
        $this->_settings->set('metaKeywords', $bind);
        $bind['value'] = $additionMetaTags;
        $this->_settings->set('additionMetaTags', $bind);
        $this->_redirect('/manager/seo');
    }

    public function imagesAction()
    {
        $this->_assign('tab', 'images');
        $this->_assign('products', $this->_products->getAll());
        $this->_display('seo/img-list.tpl');
    }

    /**
     * Call from ajax
     */
    public function saveImgAltAction()
    {
        $id = $this->_request->id;
        $text = strip_tags($this->_request->text);
        $this->_products->update(array('img_alt' => $text), $id);
        echo "true";
    }

    public function metaAction()
    {
        $this->_assign('tab', 'meta');
        $this->_assign('meta', $this->_meta->getUniqueLinks());
        $this->_assign('metadata',$this->_meta->getMetaNames());
        $this->_display('seo/meta-list.tpl');
    }

    public function editMetaAction()
    {
        if($this->_request->isPost()){
            $link = $this->_request->link;
            $desc = $this->_request->desc;
            if ($link) {
                $this->_meta->insert(array('link'=>$link, 'title'=>$desc));
                $this->_redirect('/manager/seo/meta');
            } else {
                $this->_assign('errors', "Пустая ссылка");
                $this->_assign('request', $this->_request);
            }
        }

        $isMain = ($this->_meta->isExists('/')) ? true : false;
        $this->_assign('isMain', $isMain);

        $this->_assign('producers', $this->_meta->getProducersWithoutMeta());
        $this->_assign('categories', $this->_meta->getCategoriesWithoutMeta());
        $this->_assign('products', $this->_meta->getProductsWithoutMeta());
        $this->_assign('contentPages', $this->_meta->getPagesWithoutMeta());
        $this->_assign('tab', 'meta');
        $this->_display('seo/edit-meta.tpl');
    }

    /**
     * Ajax function
     */
    public function getMetaAction()
    {
        $id = $this->_request->id;
        $meta = $this->_meta->load($id);
        if($meta){
            $this->_assign('parentId', $id);
            $this->_assign('link', $meta->link);
            $this->_assign('metaNames', $this->_meta->getMetaNames());
            $this->_assign('meta', $this->_meta->getMetaByLink($meta->link));
        }
        echo $this->_fetch('seo/meta-item.tpl');
    }

    public function addMetaAction(){
        $parentId = $this->_request->parentId;
        $parent = $this->_meta->load($parentId);
        if($parent){
            $name = $this->_request->name;
            $content = $this->_request->content;
          
            if($name){
                $this->_meta->insert(
                        array(
                            'name'=>$name,
                            'content'=>$content,
                            'link'=>$parent->link,
                            'title'=>$parent->title
                        ));
            }
        }
        echo 'OK';
    }

    public function saveMetaAction(){
        $id = $this->_request->id;
        if($id){
            $name = $this->_request->name;
            $content = $this->_request->content;

            if($name){
                $this->_meta->update(array('name'=>$name,'content'=>$content),$id);
            }
        }
        echo 'OK';
    }

    public function deleteItemMetaDataAction(){
        $id = $this->_request->id;
        if($id){            
            $this->_meta->delete($id);
        }
        echo 'OK';
    }

    public function deleteAllMetaDataAction(){
        $id = $this->_request->id;

        if($id){
            $meta = $this->_meta->load($id);
            $this->_meta->deleteBy('link', $meta->link);
        }
        echo 'OK';
    }

}