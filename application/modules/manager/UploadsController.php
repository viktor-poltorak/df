<?php

class Manager_UploadsController extends Eve_Controller_AdminAction {

	protected $allowedRoles = array(
		'admins'
	);
	protected $_dir_upload = 'upload/';

	/**
	 *
	 * @var Eve_Settings
	 */
	protected $_settings;

	public function init() {
		parent::init();
		$this->_settings = new Eve_Settings(array('caching'=>false));
	}

	public function indexAction() {
		$this->_display('uploads/index.tpl');
	}

	public function saveAction() {

		$this->uploadPricelist();

		$this->uploadCatalog();

		//$this->uploadTopBanner();

		$this->uploadBottomBanner();

		$this->_redirect('/manager/uploads');

	}

	/**
	 * Upload price list
	 */
	protected function uploadPricelist(){
		$_files = $_FILES;
		unset($_FILES['catalog']);
		unset($_FILES['topBanner']);
		unset($_FILES['bottomBanner']);
		///pricelist catalog topBanner bottomBanner

		if ($_FILES['pricelist']) {
			$uploader = new Zend_File_Transfer_Adapter_Http();
			$uploader->setDestination($this->_dir_upload);
			$uploader->addValidator('Extension', false, 'xls');
			$uploader->addFilter('Rename', array(
				'target' => $this->_dir_upload . 'pricelist.xls',
				'overwrite' => true)
			);
			$priceList = $uploader->receive();
		} else {
			unset($_FILES['pricelist']);
		}

		$_FILES = $_files;
	}

	protected function uploadCatalog(){
		$_files = $_FILES;
		unset($_FILES['pricelist']);
		unset($_FILES['topBanner']);
		unset($_FILES['bottomBanner']);
		///pricelist catalog topBanner bottomBanner

		if ($_FILES['catalog']['name']) {
			$uploader = new Zend_File_Transfer_Adapter_Http();
			$uploader->setDestination($this->_dir_upload);
			$uploader->addValidator('Extension', false, 'pdf');
			$uploader->addFilter('Rename', array(
				'target' => $this->_dir_upload . 'catalog.pdf',
				'overwrite' => true)
			);
			$priceList = $uploader->receive();
		} else {
			unset($_FILES['catalog']);
		}

		$_FILES = $_files;
	}

	protected function uploadTopBanner(){
		$_files = $_FILES;
		unset($_FILES['pricelist']);
		unset($_FILES['catalog']);
		unset($_FILES['bottomBanner']);
		/// catalog topBanner bottomBanner

		if ($_FILES['topBanner']['name']) {
			// Delete old file
			$oldFile = $this->_settings->topBanner;
			if(file_exists($this->_dir_upload.$oldFile)){
				unlink($this->_dir_upload.$oldFile);
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
				Eve_Image::resize($this->_dir_upload.$topBanner, 921, 207, $this->_dir_upload.$topBanner, false);

				//Save file name in db
				$this->_settings->update(
						array('value'=>$topBanner,
							'comment'=>'Это поле обновляется автоматически. При изменении вручную могут возникнуть проблемы'), 'topBanner'
					);
			}
		} else {
			unset($_FILES['topBanner']);
		}

		$_FILES = $_files;
	}

	protected function uploadBottomBanner(){
		$_files = $_FILES;
		unset($_FILES['pricelist']);
		unset($_FILES['catalog']);
		unset($_FILES['topBanner']);
		/// catalog topBanner bottomBanner

		if ($_FILES['bottomBanner']['name']) {

			// Delete old file
			$oldFile = $this->_settings->bottomBanner;
			if(file_exists($this->_dir_upload.$oldFile)){
				unlink($this->_dir_upload.$oldFile);
			}

			$uploader = new Zend_File_Transfer_Adapter_Http();
			$uploader->setDestination($this->_dir_upload);
			//$uploader->addValidator('IsImage', true);
			$uploader->addFilter('Rename', array(
				'target' => $this->_dir_upload . strtolower($uploader->getFileName(null, false)),
				'overwrite' => true
			));
			$bottomBanner = $uploader->receive();

			if ($bottomBanner) {
				$bottomBanner = $uploader->getFileName(null, false);
				//Resize for rigth size
				//Eve_Image::resize($this->_dir_upload.$bottomBanner, 736, 168, $this->_dir_upload.$bottomBanner, false);

				//Save file name in db
				$this->_settings->update(
						array('value'=>$bottomBanner,
							'comment'=>'Это поле обновляется автоматически. При изменении вручную могут возникнуть проблемы'),
						'bottomBanner'
					);
			}
		} else {
			unset($_FILES['bottomBanner']);
		}

		$_FILES = $_files;
	}
}