{include file='menus/inc/tabs.tpl'}
<div class="manager-content">

	<div class="manager-header">
		<div class="fix">
			<img src="/images/admin/icons/menu.png" alt="" />
			<span>Доступные меню</span>
		</div>
	</div>
	<div class="manager-list-holder">
	{foreach from=$menus item=menu}
		<div class="manager-list{cycle values=', gray-bg'}">

			<div class="manager-list-image">
				<img src="/images/admin/star.png" alt="" />
			</div>

			<div class="manager-list-content">
				<a href="/manager/menus/items/id/{$menu->menu_id}/">{$menu->name|stripslashes}</a><br />
				<span class="manager-list-meta">{$menu->description}</span>
			</div>

			<div class="manager-list-controls">
				<a href="/manager/menus/items/id/{$menu->menu_id}"><img src="/images/admin/items-32.png" alt="Пункты меню" /></a>				
			</div>
			
		</div>
	{foreachelse}
	<div class="manager-list{cycle values=', gray-bg'}">

			<div class="manager-list-image">
				<img src="/images/admin/star-off.png" alt="" />
			</div>

			<div class="manager-list-content star-down">
				Никаких меню нет.
			</div>
	
	</div>
	{/foreach}

	</div>
</div>