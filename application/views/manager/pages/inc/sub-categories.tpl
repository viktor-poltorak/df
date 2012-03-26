{if $category->sub_categories}
	{foreach from=$category->sub_categories item=sub_category}
	<div class="manager-list manager-list-lite {cycle name=sc values='white-bg, gray-bg'}">
		<a name="{$sub_category->category_id}"></a>
		<div class="manager-list-image">
			<img src="/images/admin/right-arrow.png" alt="" />
		</div>

		<div class="manager-list-content star-down">
			{$sub_category->name}
		</div>

		<div class="manager-list-controls">
			<a href="/manager/pages/category-add/id/{$sub_category->category_id}"><img src="/images/admin/add_16.png" alt="Добавить" /></a>
			<a href="/manager/pages/category-edit/id/{$sub_category->category_id}"><img src="/images/admin/edit_16.png" alt="Редактировать" /></a>
			<a id="delete-{$sub_category->category_id}" href="/manager/pages/category-delete/id/{$sub_category->category_id}"><img src="/images/admin/delete_16.png" alt="Удалить" /></a>
		</div>
		{assign var=category value=$sub_category}
		{include file='pages/inc/sub-categories.tpl'}
	</div>
	{/foreach}
{/if}