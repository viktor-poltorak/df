{include file='products/inc/tabs.tpl'}
<div class="manager-content">
	<div class="manager-header">
		<img src="/images/admin/icons/settings.png" alt="" />
		<span>Товары</span>
	</div>
	{foreach from=$products item=item}
	<div class="manager-list{cycle values=', gray-bg'}">
		<div class="manager-list-image">
			<img src="/images/admin/star.png" alt="" />
		</div>
		<div class="manager-list-content">
			<a href="/manager/products/edit/id/{$item->product_id}/">{$item->title}</a>&nbsp;&nbsp;&nbsp;
		</div>
		<div class="manager-list-controls">
			<a href="/manager/products/edit/id/{$item->product_id}">
				<img src="/images/admin/edit.png" alt="Редактировать" />
			</a>			
			<a href="/manager/products/delete/id/{$item->product_id}">
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
				Никаких продуктов нет.
		</div>
	</div>
	{/foreach}
</div>