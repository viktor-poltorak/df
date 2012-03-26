{include file='pages/inc/tabs.tpl'}
<div class="manager-content">

	<div class="manager-header">
		<div class="fix">
			<img src="/images/admin/icons/articles.png" alt="" />
			<span>Последние записи</span>
		</div>
	</div>
	<div class="manager-list-holder">
	{foreach from=$pages item=page}
		<div class="manager-list{cycle values=', gray-bg'}">

			<div class="manager-list-image">
				<img src="/images/admin/star.png" alt="" />
			</div>

			<div class="manager-list-content">
				<a href="/manager/pages/view/id/{$page->page_id}/">{$page->title|stripslashes}</a><br />
				<span class="manager-list-meta">{$page->added_date|date_format}</span>
			</div>

			<div class="manager-list-controls">
				<a href="/manager/pages/edit/id/{$page->page_id}">
					<img src="/images/admin/edit.png" alt="Редактировать" />
				</a>
				{if !$page->locked}
                <a href="/manager/pages/delete/id/{$page->page_id}">
                    <img src="/images/admin/delete.png" alt="Удалить" />
                </a>
				{/if}
			</div>            
		</div>
	{foreachelse}
	<div class="manager-list{cycle values=', gray-bg'}">

			<div class="manager-list-image">
				<img src="/images/admin/star-off.png" alt="" />
			</div>

			<div class="manager-list-content star-down">
				Пока никаких страниц нет.
			</div>
	
	</div>
	{/foreach}

	{if $paginate->totalPages > 1}
	<div class="paginate">
		{if $category_id}
		{html_paginate paginate=$paginate text_prev='назад' text_next='вперед' custom_link="/manager/pages/by-category/`$category_id`/page/?/"}
		{else}
		{html_paginate paginate=$paginate text_prev='назад' text_next='вперед' custom_link="/manager/pages/page/?/"}
		{/if}
	</div>
	{/if}


	</div>
</div>