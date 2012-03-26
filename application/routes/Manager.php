<?php
	$boot->addRoute('goods', 'manager/products/page/([\d]+)', 'manager', 'products', 'index', array (1 => 'page'));