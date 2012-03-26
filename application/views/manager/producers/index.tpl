{include file='producers/inc/tabs.tpl'}
<div class="manager-content">
	<div class="manager-header">
		<img src="/images/admin/icons/settings.png" alt="" />
		<span>Производители</span>
	</div>
	{foreach from=$producers item=item}
	<div class="manager-list{cycle values=', gray-bg'}">
		<div class="manager-list-image">
			<img src="/images/admin/star.png" alt="" />
		</div>
		<div class="manager-list-content">
			<a href="/manager/producers/edit/id/{$item->category_id}/">{$item->name}</a>&nbsp;&nbsp;&nbsp;
		</div>
		<div class="manager-list-controls">
			<a href="/manager/producers/edit/id/{$item->category_id}">
				<img src="/images/admin/edit.png" alt="Редактировать" />
			</a>			
			<a href="/manager/producers/delete/id/{$item->category_id}">
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
				Пусто
		</div>
	</div>
	{/foreach}
</div>