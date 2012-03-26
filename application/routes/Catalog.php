<?php
	$boot->addRoute('product', 'catalog/product/id/([\d]+)', 'catalog', 'index', 'product', array (1 => 'id'));
	$boot->addRoute('category', 'catalog/category/id/([\d]+)', 'catalog', 'index', 'category', array (1 => 'id'));
	$boot->addRoute('ajaxcategory', 'catalog/subcategory/id/([\d]+)', 'catalog', 'index', 'subcategory', array (1 => 'id'));
	$boot->addRoute('prodcategory', 'catalog/prodcategory/id/([\d]+)', 'catalog', 'index', 'prodcategory', array (1 => 'id'));
	$boot->addRoute('producer', 'catalog/manufacturer/id/([\d]+)', 'catalog', 'index', 'producer', array (1 => 'id'));
	$boot->addRoute('product', 'catalog/product/id/([\d]+)', 'catalog', 'index', 'product', array (1 => 'id'));
