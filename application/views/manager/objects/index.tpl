{include file='objects/inc/tabs.tpl'}
<div class="manager-content">
	<div class="manager-header">
		<img src="/images/admin/icons/settings.png" alt="" />
		<span>Наши объекты</span>
	</div>
	{foreach from=$objects item=item}
	<div class="manager-list{cycle values=', gray-bg'}">
		<div class="manager-list-image">
			<img src="/images/admin/star.png" alt="" />
		</div>
		<div class="manager-list-content">
			<a href="/manager/objects/edit/id/{$item->id}/">{$item->name}</a>&nbsp;&nbsp;&nbsp;
		</div>
		<div class="manager-list-controls">
			<a href="/manager/objects/edit/id/{$item->id}">
				<img src="/images/admin/edit.png" alt="Редактировать" />
			</a>			
			<a href="/manager/objects/delete/id/{$item->id}">
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
				Никаких объектов нет.
		</div>
	</div>
	{/foreach}
</div>