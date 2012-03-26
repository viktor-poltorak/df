{include file='settings/inc/tabs.tpl'}
<div class="manager-content">
	<div class="manager-header">
		<img src="/images/admin/icons/settings.png" alt="" />
		<span>Настройки</span>
	</div>
	{foreach from=$settings item=item}
	<div class="manager-list{cycle values=', gray-bg'}">
		<div class="manager-list-image">
			<img src="/images/admin/star.png" alt="" />
		</div>
		<div class="manager-list-content">
			<a href="/manager/settings/edit/id/{$item->setting_id}/">{$item->name}</a>&nbsp;&nbsp;&nbsp;
			<span class="manager-list-meta">{$item->value}</span>
			<span class="manager-list-meta">{$item->comment}</span>
		</div>
		<div class="manager-list-controls">
			<a href="/manager/settings/edit/id/{$item->setting_id}">
				<img src="/images/admin/edit.png" alt="Редактировать" />
			</a>
			{if $item->lock == 0}
			<a href="/manager/settings/delete/id/{$item->setting_id}">
				<img src="/images/admin/delete.png" alt="Удалить" />
			</a>
			{/if}
		</div>
	</div>
	{foreachelse}
	<div class="manager-list">
		<div class="manager-list-image">
			<img src="/images/admin/star-off.png" alt="" />
		</div>
		<div class="manager-list-content">
			Никаких настроек нет.
		</div>
	</div>
	{/foreach}
</div>