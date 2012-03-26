{include file='pages/inc/tabs.tpl'}
<div class="manager-content">

	<div class="manager-header">
		<img src="/images/admin/icons/news.png" alt="" />
		<span>{$page->title|stripslashes|truncate:300}</span>

		<div class="manager-add">
			<a href="/manager/pages/">
				<img src="/images/admin/next.png" alt="" />
				<span>Все страницы</span>
			</a>
			<a href="/manager/pages/edit/id/{$page->page_id}">
				<img src="/images/admin/edit.png" alt="" />
				<span>Править страницу</span>
			</a>
		</div>
	</div>
	<div class="manager-list-holder page">
		{$page->body|stripslashes}
	</div>
</div>