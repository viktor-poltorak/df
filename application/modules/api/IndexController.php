<?php

class Api_IndexController extends Eve_Controller_Action
{

    public function init()
    {
        parent::init();      
    }

    public function indexAction()
    {
        
    }
    
    public function getBannersAction()
    {
        echo $this->_fetch('api/banners.tpl');
    }

}