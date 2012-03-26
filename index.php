<?php
	require_once './library/Eve/Bootstrap.php';
	set_magic_quotes_runtime(false);
	
	$boot = new Bootstrap();
	$boot->init();				// initialize bootstrapper
	$boot->startSession();		//start session
	$boot->addApplications();	//add modules
	$boot->setDebugMode(file_exists('debug'));
	$boot->addRoutes();

	$templater = $boot->getTemplater();
	$db = $boot->getDb();

	Zend_Registry::set('db', $db);
	Zend_Registry::set('templater', $templater);

	if (file_exists('maintenance')) {
		$templater->display('maintenance.tpl');
		exit;
	}

	try {
		$boot->dispatch();
	} catch (Exception $e) {

		if (DEBUG) {
			if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
				echo json_encode(array(
					'error' => true,
					'message' => join('br />', (array)$e->getMessage())
				));
			} else {                
				$templater->assign('errors', (array) ($e->getMessage().'<br />'.$e->getFile().'<br />'.$e->getLine()));
				$templater->assign('template', 'error.tpl');
				$templater->setOption('template_dir', 'application/views/eve');
				$templater->display('layout/index.tpl');
			}
		} else {
			if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
				echo json_encode(array(
					'error' => true,
					'message' => 'Invalid action.'
				));
			} else {
				header('Location: /404/');
			}
		}
	}

	function __autoload($class) {
		if (class_exists('Zend_Loader')) {
			Zend_Loader::loadClass($class);
		} else {
			require_once 'Zend/Loader.php';
			Zend_Loader::loadClass($class);
		}
	}