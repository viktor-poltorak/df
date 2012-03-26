<div class="manager-content manager-login">

	<div class="manager-header">
		<div class="fix">
			<img src="/images/admin/icons/auth.png" alt="" />
			<span>Авторизация</span>
		</div>
	</div>
	<form action="/manager/auth/login/" method="post" class="form">
		<div class="form-item">
			<label>Email:</label>
			<input type="text" name="username" />
		</div>
		<div class="form-item">
			<label>Пароль:</label>
			<input type="password" name="password" />
		</div>
		<div>
			<input type="submit" value="Войти" class="button" />
		</div>
	</form>
</div>