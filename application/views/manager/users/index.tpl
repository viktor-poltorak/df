{include file='users/inc/tabs.tpl'}
<div class="manager-content">

	<div class="manager-header">
		<img src="/images/admin/icons/users.png" alt="" />
		<span>Последние пользователи</span>
	</div>
	<div class="manager-list-holder">
	{foreach from=$users item=user}
		<div class="manager-list{cycle values=', gray-bg'}">

			<div class="manager-list-image">
				<img src="/images/admin/star{if !$user->is_online}-off{/if}.png" alt="" />
			</div>

			<div class="manager-list-content">
				<a href="/profile/{$user->user_id}/">{$user->first_name} {$user->last_name}</a><br />
				<span class="manager-list-meta">{$user->registered_date} | {$user->email}</span>
			</div>

			<div class="manager-list-controls">
				<a href="/manager/users/edit/id/{$user->user_id}/"title="Редактировать"><img src="/images/admin/edit.png" alt="Редактировать" /></a>
				{if $user->user_id != 1}
				<a href="/manager/users/delete/id/{$user->user_id}/"title="Удалить"><img src="/images/admin/delete.png" alt="Удалить" /></a>
				{/if}
			</div>
			
		</div>
	{foreachelse}
	<div class="manager-list{cycle values=', gray-bg'}">

			<div class="manager-list-image">
				<img src="/images/admin/star-off.png" alt="" />
			</div>

			<div class="manager-list-content star-down">
				Пока пользователей нет. Странно, что вы это видите...
			</div>
	
	</div>
	{/foreach}
	{if $paginate->totalPages > 1}
	<div class="paginate">
		{html_paginate paginate=$paginate text_prev='назад' text_next='вперед' custom_link="/manager/users/index/page/?/"}
	</div>
	{/if}
	</div>
</div>