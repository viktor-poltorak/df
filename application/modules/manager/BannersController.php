<?php

class Manager_BannersController extends Eve_Controller_AdminAction
{

    protected $allowedRoles = array(
        'admins'
    );
    protected $_dir_upload = 'upload/banners/';

    /**
     *
     * @var Banners
     */
    protected $_banners;

    public function init()
    {
        parent::init();
        $this->_banners = new Banners();
        $this->_settings = new Settings();
    }

    public function indexAction()
    {
        if ($this->_request->isPost()) {
            $this->_settings->set('useFlashMainBanner', array('value' => (int) $this->_request->bannerType));
            $this->_redirect('/manager/banners/');
        }

        $this->_assign('banners', $this->_banners->getAll());
        $this->_assign('flashBanner', $this->_banners->getFlashBanner());
        $this->_display('banners/index.tpl');
    }

    public function saveAction()
    {
        if ($_FILES['banner']['name']) {

            if ($this->_request->id) {
                $banner = $this->_banners->load($this->_request->id);
                // Delete old file
                if (file_exists($this->_dir_upload . $banner->file)) {
                    unlink($this->_dir_upload . $banner->file);
                }
            }

            $uploader = new Zend_File_Transfer_Adapter_Http();
            $uploader->setDestination($this->_dir_upload);
            //$uploader->addValidator('IsImage', true);
            $uploader->addFilter('Rename', array(
                'target' => $this->_dir_upload . strtolower($uploader->getFileName(null, false)),
                'overwrite' => true
            ));
            $fileName = $uploader->receive();

            if ($fileName) {
                $fileName = $uploader->getFileName(null, false);

                if ($this->_request->id) {
                    $this->_banners->update(array('file' => $fileName), (int) $this->_request->id);
                } else {
                    $this->_banners->insert(array('file' => $fileName));
                }
            }
        }
        $this->_redirect('/manager/banners');
    }

    public function addAction()
    {
        $this->_display('banners/edit.tpl');
    }

    public function deleteAction()
    {
        if ($this->_request->id) {
            $banner = $this->_banners->load((int) $this->_request->id);
            if ($banner) {
                if (file_exists($this->_dir_upload . $banner->file)) {
                    unlink($this->_dir_upload . $banner->file);
                }
                $this->_banners->delete($banner->id);
            }
        }
        $this->_redirect('/manager/banners');
    }

    public function editAction()
    {
        if ($this->_request->id) {
            $banner = $this->_banners->load((int) $this->_request->id);
            $this->_assign('request', $banner);
            
            if(strpos($banner->file, '.swf')) {
                $this->_assign('isFlash', true);
            }
            
            
            $this->_display('banners/edit.tpl');
        } else {
            $this->_redirect('/manager/banners');
        }
    }

    protected function uploadTopBanner()
    {
        $_files = $_FILES;
        unset($_FILES['pricelist']);
        unset($_FILES['catalog']);
        unset($_FILES['bottomBanner']);
        /// catalog topBanner bottomBanner

        if ($_FILES['topBanner']['name']) {
            // Delete old file
            $oldFile = $this->_settings->topBanner;
            if (file_exists($this->_dir_upload . $oldFile)) {
                unlink($this->_dir_upload . $oldFile);
            }

            $uploader = new Zend_File_Transfer_Adapter_Http();
            $uploader->setDestination($this->_dir_upload);
            $uploader->addValidator('IsImage', true);
            $uploader->addFilter('Rename', array(
                'target' => $this->_dir_upload . strtolower($uploader->getFileName(null, false)),
                'overwrite' => true
            ));
            $topBanner = $uploader->receive();

            if ($topBanner) {
                $topBanner = $uploader->getFileName(null, false);
                //Resize for rigth size
                Eve_Image::resize($this->_dir_upload . $topBanner, 921, 207, $this->_dir_upload . $topBanner, false);

                //Save file name in db
                $this->_settings->update(
                        array('value' => $topBanner,
                    'comment' => 'Это поле обновляетсы автоматически. При изменение вручную могут возникнуть проблемы'), 'topBanner'
                );
            }
        } else {
            unset($_FILES['topBanner']);
        }

        $_FILES = $_files;
    }

}