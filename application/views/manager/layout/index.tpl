<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Панель управления / {$settings->site_name}</title>
		<link href="/css/manager.css" rel="stylesheet" type="text/css" />
		{foreach from=$css item=style}
			<link href="/css/{$style}.css" rel="stylesheet" type="text/css" />
		{/foreach}
		<script src="/js/libs/jquery.js"></script>
		<script src="/js/manage/admin.js"></script>
		{foreach from=$js item=script}
			<script type="text/javascript" src="/js/{$script}.js"></script>
		{/foreach}
	</head>
	<body>
	{if $isLogged}
	 {include file='inc/menu.tpl'}
	 {/if}
	<div class="main">
		{if $success}
		<div class="success">
			{foreach from=$success item=success}
			{$success}<br />
			{/foreach}
		</div>
		{/if}
		{if $errors}
		<div class="error">
			{foreach from=$errors item=error}
			{$error}<br />
			{/foreach}
		</div>
		{/if}

	{include file="`$template`"}
	</div>
	 {if $isLogged}
	<div style="text-align: center">
		<a href="/manager/settings">Настройки</a> |
		<a href="/">На сайт</a> |
		<a href="/manager/auth/logout/">Выйти</a>
	</div>
	 {/if}
</body>
</html>