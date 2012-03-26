{if $error}
{sb_error text=$errors}
{/if}


{include file='menus/inc/tabs.tpl'}
<div class="manager-content">
	<div class="manager-header">
		<img src="/images/admin/icons/menu.png" alt="" />
		<span>Редактирование меню</span>
		<div class="manager-add">
			<a href="/manager/menus/add-item/id/{$menu->menu_id}/">
				<img src="/images/admin/add.png" alt="" />
				<span>Добавить пункт меню</span>
			</a>
		</div>
	</div>

	<form action="/manager/menus/update/id/{$menu->menu_id}/" method="post" class="form">
		<div class="form-item">
			<label>Название:</label>
			<input type="text" name="name" value="{$menu->name}" />
		</div>
		<div class="form-item">
			<label>Описание:</label>
			<input type="text" name="description" value="{$menu->description}" />
		</div>
		<div class="form-cols gray-bg">
			<div class="form-item">
				<label>Locked?</label>
				<select name="locked">
					<option value="0" {if !$menu->locked}selected{/if}>нет</option>
					<option value="1"{if $menu->locked}selected{/if}>да</option>
				</select>
			</div>
		</div>
		<div>
			<input type="submit" value="Обновить" />
		</div>
	</form>
</div>