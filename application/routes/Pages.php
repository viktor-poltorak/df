<?php
	$boot->addRoute('viewPage', 'pages/([\w\d\-\_\+\.]+)', 'pages', 'index', 'view', array (1 => 'alias'));