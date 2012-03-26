{if $error}
{sb_error text=$errors}
{/if}
{include file='settings/inc/tabs.tpl'}
<div class="manager-content">
	<div class="manager-header">
		<img src="/images/admin/icons/settings.png" alt="" />
		<span>{if $request->setting_id}Редактирование{else}Добавление{/if} опции</span>
		<div class="manager-add">
			<a href="/manager/settings">
				<img src="/images/admin/back.png" alt="" />
				<span>Вернуться к меню</span>
			</a>
		</div>
	</div>
	<form action="/manager/settings/{if $request->setting_id}save{else}create-item{/if}/" method="post" class="form" enctype="multipart/form-data">
		{if $request->setting_id}
		<input name="id" value="{$request->setting_id}" type="hidden" />
		{/if}
		<div class="form-item">
			<label>Название:</label>
			<input type="text" id="title" name="name" value="{$request->name}" />
		</div>
		<div class="form-item">
			<label>Значение:</label>
			<input type="text" name="value" value="{$request->value}" />
		</div>
		<div class="form-item">
			<label>Заблокировать:</label>
			<select name="lock">
				<option value="0" {if $request->lock == 0}selected{/if}>Нет</option>
				<option value="1" {if $request->lock == 1}selected{/if}>Да</option>
			</select>
		</div>
		<div>
			<input type="submit" value="Сохранить" />
		</div>
	</form>
</div>