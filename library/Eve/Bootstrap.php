<?php
	/**
	 *	Bootstrapper script
	 *
	 * @author Alex Oleshkevich <alex.oleshkevich@gmail.com>
	 * @version 0.2
	 * @copyright  Copyright (c) 2009 Alex Oleshkevich
	 * @package Eve
	 * @license  GPLv3
	 */

	class Bootstrap {
		/**
		 * @var Zend_Controller_Front
		 */
		protected $_controller;

		/**
		 * @var Zend_Controller_Router_Rewrite
		 */
		protected $_router;

		/**
		 * @var SimpleXMLObject
		 */
		protected $_project_config;

		public function  __construct() {
			$this->_project_config = simplexml_load_file('configs/project.xml')->project;
			$this->_setIncludes();
			
			$this->_controller = Zend_Controller_Front::getInstance();
			$this->_router = $this->_controller->getRouter();
		}

		public function init() {
			set_magic_quotes_runtime((int) $this->_project_config->templater->magic_quotes_runtime);

			if ((int) $this->_project_config->templater->disable_internal_renderer)
				$this->disableInternalRenderer();

			$this->setLocale((string) $this->_project_config->global->locale);
		}

		public function setDebugMode($mode = false) {
			if ($mode) {
				define('DEBUG', true);
				error_reporting(E_ALL^E_NOTICE); // all errors exept notices
			} else {
				error_reporting(0);				// no any errors
				define('DEBUG', false);
			}
		}

		public function setLocale($locale) {
			setlocale(LC_ALL, $locale);
		}
		
		public function getController() {
			return $this->_controller;
		}
		
		public function disableInternalRenderer() {
			Zend_Controller_Action_HelperBroker::removeHelper('viewRenderer');
			$this->_controller->setParam('noViewRenderer', true);
		}
		
		public static function getConfig($file, $section = 'configuration') {
			trigger_error('Deprecated. Use Eve_ConfigLoader instead');
			$index = str_replace('.', '', $file);
			if (Zend_Registry::isRegistered($index)) {
				return Zend_Registry::get($index);
			}
			
			Zend_Loader::loadClass('Zend_Config_Xml');
			$config = new Zend_Config_Xml('configs/'.$file, $section);
			Zend_Registry::set($index, $config);
			
			return $config;
		}
		
		private function _setIncludes() {
			foreach ($this->_project_config->paths->path as $path) {
				$paths[] = (string) $path;
			}

			$paths = PATH_SEPARATOR.implode(PATH_SEPARATOR, $paths);

			set_include_path(get_include_path().$paths);
		}
		
		public function startSession() {
			Zend_Session::setOptions(array(
				'save_path' => 'tmp/session',
				'remember_me_seconds' => 864000      // Remember me 10 days
			));
			Zend_Session::start();
		}
		
		public function getDb() {
			if (file_exists('_server'))
				$postfix = trim(file_get_contents('_server'));

			$config = Eve_Helper_ConfigLoader::get('database.xml', 'database'.$postfix);
			
			$adapter = Zend_Db::factory($config);
			$adapter->setFetchMode(Zend_Db::FETCH_OBJ);

		    Zend_Db_Table_Abstract::setDefaultAdapter($adapter);
			$adapter->query('SET NAMES utf8');

		    return $adapter;
		}
		
		public function getTemplater() {

			$adapter = (string) $this->_project_config->templater->adapter;

			if (file_exists('library/Eve/Templater/Adapter/'.$adapter.'.php')) {

				$options = (array) $this->_project_config->templater->options;

				$class = 'Eve_Templater_Adapter_'.$adapter;
				$adapter = new $class($options);

				Zend_Registry::set('templater', $adapter);

				return $adapter;
			} else {
				throw new Exception('No adapter found.');
			}
				
		}
		
		public function addApplications() {
			$moduleSession = new Zend_Session_Namespace('modules');
			$modules = $moduleSession->modules;
         
			if (!$modules || @DEBUG) {
				$dir = opendir('application/modules/');
                $modules = array();
				while ($subDir = readdir($dir)) {
					if (!strstr($subDir, '.') && $subDir != 'default')                       
                        $modules[] = $subDir;
				}
				$moduleSession->modules = $modules;
			}

			$this->_controller->setControllerDirectory('application/modules/default/', 'default');
          
			foreach ((array) $modules as $module) {
				$this->_controller->addControllerDirectory('application/modules/'.$module.'/', $module);
			}
			
		}
		
		public function addRoute($name, $route, $module, $controller, $action, $varNames = array()) {
			$this->_router->addRoute($name, new Zend_Controller_Router_Route_Regex(
			    $route,
			    array(
					'module'=>$module,
					'controller'=>$controller,
					'action'=>$action
				), $varNames
			));
		}

		public function addRoutes() {
			$boot = $this;
			$routes = Eve_File::getFiles('application/routes/', false);
			foreach ($routes as $route) {
				require_once 'application'.DIRECTORY_SEPARATOR.'routes'.DIRECTORY_SEPARATOR.$route;
			}
		}
		
		public function dispatch() {
			$this->_controller->throwExceptions(true);
		    $this->_controller->returnResponse(true);

			// plugins
			$plugins = Eve_File::getFiles('application/plugins/', false);
			foreach ($plugins as $plugin) {
				require_once 'application'.DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.$plugin;

				$plugin = explode('.', $plugin);
				array_pop($plugin);
				$plugin = join('.', $plugin);

				$this->_controller->registerPlugin(new $plugin);
			}

			$this->_controller->registerPlugin(new Zend_Controller_Plugin_ErrorHandler(array(
				'module'     => 'error',
				'controller' => 'index',
				'action'     => 'page-not-found'
			)));

		    $afterDispatching = $this->_controller->dispatch();

		    return $afterDispatching->sendResponse();
		}

	}