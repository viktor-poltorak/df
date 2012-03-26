{include file='pages/inc/tabs.tpl'}
<div class="manager-content">

	<div class="manager-header">
		<img src="/images/admin/icons/articles.png" alt="" />
		<span>Категории</span>

		<div class="manager-add">
			<a href="/manager/pages/category-add/">
				<img src="/images/admin/add.png" alt="" />
				<span>Добавить категорию</span>
			</a>
		</div>
	</div>
	<div class="manager-list-holder">
	{foreach from=$categories item=category}
		<div class="manager-list{cycle name=category values=', gray-bg'}">
			<a name="{$category->category_id}"></a>
			<div class="manager-list-image">
				<img src="/images/admin/star.png" alt="" />
			</div>

			<div class="manager-list-content star-down">
				<strong>{$category->name}</strong>
			</div>

			<div class="manager-list-controls">
				<a href="/manager/pages/category-edit/id/{$category->category_id}"><img src="/images/admin/edit.png" alt="Редактировать" /></a>
				<a id="delete-{$sub_category->category_id}" href="/manager/pages/category-delete/id/{$category->category_id}"><img src="/images/admin/delete.png" alt="Удалить" /></a>
			</div>

			<div id="sub-categories-{$category->category_id}">
			{include file='pages/inc/sub-categories.tpl'}
			</div>
			
		</div>
	{foreachelse}
	<div class="manager-list{cycle values=', gray-bg'}">

			<div class="manager-list-image">
				<img src="/images/admin/star-off.png" alt="" />
			</div>

			<div class="manager-list-content">
				<br />
				Категорий нет.
			</div>
	
	</div>
	{/foreach}
	</div>
</div>