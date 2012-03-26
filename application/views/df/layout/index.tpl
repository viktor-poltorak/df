<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>{$globalTitle}</title>
	<link href="/css/styles.css" rel="stylesheet" type="text/css" />
	<link href="/css/jScrollPane.css" rel="stylesheet" type="text/css" />
	<script src="/js/libs/jquery.js"></script>
	<script src="/js/jquery.mousewheel.min.js"></script>
	<script src="/js/main.js"></script>
	<script src="/js/jcarousellite.pack.js"></script>
	<script src="/js/jScrollPane.js"></script>
	<script src="/js/agile.js"></script>
    <link href="/css/facebox.css" media="screen" rel="stylesheet" type="text/css"/>
    <script src="/js/facebox.js" type="text/javascript"></script>
	<link rel="icon" href="/favicon-eve.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="/favicon-eve.ico" type="image/x-icon" />
    {foreach from=$siteMeta item=meta}
    <meta content="{$meta->content}" name="{$meta->name}" />
    {/foreach}
    {$additionMetaTags}
</head>
<body>
	<div class="header">
		<div class="logo">
			<a href="/"><img src="/images/logo.png" alt="" /></a>
		</div>
		<div class="header-menu">
			<div class="menu-line">
				<div class="menu">
					<ul>
                        <li><img src="/images/menu-left.png" alt="" /></li>
                        {foreach from=$mainMenu item=item}
                        <li{if $item->selected} class="selected"{/if}><a href="{$item->link}">{$item->name}</a></li>
                        {/foreach}
						{*
						<li{if $tab == 'index'} class="selected"{/if}><a href="/">Главная</a></li>
						<li{if $tab == 'about'} class="selected"{/if}><a href="/pages/about.htm">О компании</a></li>
						<li{if $tab == 'business'} class="selected"{/if}><a href="/pages/business.htm">Бизнес</a></li>
						<li{if $tab == 'catalog'} class="selected"{/if}><a href="/catalog/">Каталог</a></li>
						<li{if $tab == 'info'} class="selected"{/if}><a href="/pages/info.htm">Полезная информация</a></li>
						<li{if $tab == 'partners'} class="selected"{/if}><a href="/pages/partners.htm">Партнеры</a></li>
						<li{if $tab == 'contacts'} class="selected"{/if}><a href="/pages/contacts.htm">Контакты</a></li>
                        *}
						<li><img src="/images/menu-right.png" alt="" /></li>
					</ul>
				</div>
				<div class="menu-highlight">
					<img src="/images/highlited-left.png" alt="" />
					<a href="/upload/pricelist.xls">Скачать прайс</a>
					<img src="/images/highlited-right.png" alt="" />
				</div>
			</div>
			<div class="phone-line">
				<div class="phone">
					(017) <strong>505-27-44</strong>, (017) <strong>280-50-82</strong>
				</div>
				<div class="phone-highlight">
					<img src="/images/highlited-left.png" alt="" />
					<a href="/upload/catalog.pdf">Скачать каталог</a>
					<img src="/images/highlited-right.png" alt="" />
				</div>
			</div>
		</div>
	</div>
	<div class="content">
		{if $tab == 'index'}
		{include file='default/inc/home-banner.tpl'}
		{/if}

		<table class="search">
			<tr>
				<td class="search-left"></td>
				<td class="search-dark">Поиск по названию</td>
				<td class="search-hint">Введите название интересующего Вас товара</td>
				<td class="search-area">
					<form action="/search/" method="get" autocomplete="off">
						<input type="text" name="q" id="q" value="{$smarty.get.q|strip_tags|trim}" />
						<input type="image" src="/images/search-button.png" />
					</form>
					<div id="autocomplete" class="autocomplete"></div>
				</td>
				<td class="search-clean"><a href="javascript:" id="clear-search">очистить форму поиска</a></td>
				<td class="search-right"></td>
			</tr>
		</table>
		<div class="content-left">
			{include file='inc/catalog.tpl'}
			<div class="address">
				<h1>Добро пожаловать!</h1>
				<img src="/images/address-top.png" alt="" />
                <div class="address-content">
                    <p>
                        <a href="/pages/map.htm"><img src="/images/map.png" alt="" /></a>
                        Республика <br />
                        Беларусь,<br />
                        Минский р-он,<br />
                        АХЗ ООО "Инфаст" каб. 43<br />                       
                        <strong>info@dfarb.by</strong><br />
                    </p>

                </div>
				<img src="/images/address-bottom.png" alt="" />
			</div>
		</div>
		<div class="content-right">
			{include file=`$template`}
		</div>
	</div>
</body>
</html>