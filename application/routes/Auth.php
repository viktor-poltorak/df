<?php
	$boot->addRoute('loginScreen', 'login', 'auth', 'index', 'index');
	$boot->addRoute('loginPerform', 'auth/login', 'auth', 'index', 'login');
	$boot->addRoute('logoutAction', 'logout', 'auth', 'index', 'logout');
	$boot->addRoute('lostPassword', 'lost-password', 'auth', 'index', 'lost-password');
	$boot->addRoute('resetPassword', 'reset-password', 'auth', 'index', 'reset-password');
	$boot->addRoute('passwordSent', 'password-sent', 'auth', 'index', 'password-sent');