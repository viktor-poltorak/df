<?php
	$boot->addRoute('viewObject', 'objects/view/id/([\d]+)', 'objects', 'index', 'view', array (1 => 'id'));