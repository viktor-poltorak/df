{if $error}
{sb_error text=$errors}
{/if}


{include file='menus/inc/tabs.tpl'}
<div class="manager-content">
	<div class="manager-header">
		<img src="/images/admin/icons/menu.png" alt="" />
		<span>Добавление меню</span>
	</div>

	<form action="/manager/menus/create/" method="post" class="form">
		<div class="form-item">
			<label>Название:</label>
			<input type="text" name="name" />
		</div>
		<div class="form-item">
			<label>Описание:</label>
			<input type="text" name="description" />
		</div>
		<div class="form-cols gray-bg">
			<div class="form-item">
				<label>Locked?</label>
				<select name="locked">
					<option value="0">нет</option>
					<option value="1">да</option>
				</select>
			</div>
		</div>
		<div>
			<input type="submit" value="Добавить" />
		</div>
	</form>
</div>