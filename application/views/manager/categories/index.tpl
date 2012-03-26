{include file='categories/inc/tabs.tpl'}
<div class="manager-content">
	<div class="manager-header">
		<img src="/images/admin/icons/settings.png" alt="" />
		<span>Категории товаров</span>
	</div>
	{foreach from=$categories item=item}
	<div class="manager-list{cycle values=', gray-bg'}">
		<div class="manager-list-image">
			<img src="/images/admin/star.png" alt="" />
		</div>
		<div class="manager-list-content">
			<a href="/manager/categories/edit/id/{$item->category_id}/">{$item->name}</a>&nbsp;&nbsp;&nbsp;
		</div>
		<div class="manager-list-controls">
			<a href="/manager/categories/edit/id/{$item->category_id}">
				<img src="/images/admin/edit.png" alt="Редактировать" />
			</a>			
			<a href="/manager/categories/delete/id/{$item->category_id}">
				<img src="/images/admin/delete.png" alt="Удалить" />
			</a>
		</div>
	</div>
	{foreachelse}
	<div class="manager-list">
		<div class="manager-list-image">
			<img src="/images/admin/star-off.png" alt="" />
		</div>
		<div class="manager-list-content">
				Никаких категорий нет.
		</div>
	</div>
	{/foreach}
</div>