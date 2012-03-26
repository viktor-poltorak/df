{if $error}
<div class="error">
	{$error}
</div>
{/if}


{include file='users/inc/tabs.tpl'}
<div class="manager-content">
	<div class="manager-header">
		<img src="/images/admin/icons/users.png" alt="" />
		<span>Редактирование пользователя</span>
	</div>

	<form action="/manager/users/update/id/{$user->user_id}/" method="post" class="form">
		<div class="form-item">
			<label>Логин:</label>
			<input type="text" value="{$user->username}" name="username" />
		</div>

		<div class="form-item gray-bg">
			<label>Пароль:</label>
			<input type="password" value="" name="password" />
		</div>

		<div class="form-item">
			<label>Повторите пароль:</label>
			<input type="password" value="" name="password2" />
		</div>

		<div class="form-item gray-bg">
			<label>Email (для восстановления пароля):</label>
			<input type="text" value="{$user->email}" name="email" />
		</div>

		<div class="form-item">
			<label>Имя:</label>
			<input type="text" value="{$user->first_name}" name="first_name" />
		</div>

		<div class="form-item gray-bg">
			<label>Фамилия:</label>
			<input type="text" value="{$user->last_name}" name="last_name" />
		</div>

		<div>
			<input type="submit" value="Обновить" />
		</div>
	</form>
</div>