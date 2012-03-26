{include file='users/inc/tabs.tpl'}
<div class="manager-content">
	<div class="manager-header">
		<img src="/images/admin/icons/users.png" alt="" />
		<span>Добавление пользователя</span>
	</div>

	<form action="/manager/users/create/" method="post" class="form">
		<div class="form-item">
			<label>Логин:</label>
			<input type="text" autocomplete="off" value="{$request->username}" name="username" />
		</div>

		<div class="form-item gray-bg">
			<label>Пароль:</label>
			<input type="password" autocomplete="off" value="" name="pass" />
		</div>

		<div class="form-item">
			<label>Повторите пароль:</label>
			<input type="password" value="" name="pass2" />
		</div>

		<div class="form-item gray-bg">
			<label>Email (для восстановления пароля):</label>
			<input type="text" value="{$request->email}" name="email" />
		</div>

		<div class="form-item">
			<label>Имя:</label>
			<input type="text" value="{$request->first_name}" name="first_name" />
		</div>

		<div class="form-item gray-bg">
			<label>Фамилия:</label>
			<input type="text" value="{$request->last_name}" name="last_name" />
		</div>

		<div>
			<input type="submit" value="Добавить" />
		</div>
	</form>
</div>