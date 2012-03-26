<div class="eve-page">
	<div class="eve-login">
		<div class="eve-title">
			Авторизация
		</div>
		<div id="errors">
			{sb_error text=$errors}
		</div>
		{if $message}
		<div class="success">
			{$message}
		</div>
		{/if}
		<div id="login-form" {if $mode == 'restore'} class="display-none"{/if}>
			<form class="form" action="/auth/login/" method="post">
				<div class="form-item">
					<label for="username">Имя пользователя</label>
					<input type="text" name="username" value="{$username}" />
				</div>
				<div class="form-item">
					<label for="password">Пароль</label>
					<input type="password" name="password" />
				</div>
				<div>
					<input type="submit" value="Войти" /> <a href="javascript:void(0)" id="restore-link">Забыли пароль?</a>
				</div>
			</form>
		</div>
		<div id="restore-form" {if $mode == 'login'} class="display-none"{/if}>
			<form class="form" action="/reset-password/" method="post">
				<div class="form-item">
					<label for="username">Имя пользователя</label>
					<input type="text" id="username" value="{$username}" name="username" />
				</div>
				<div>
					<input type="submit" id="restore" value="Восстановить" /> <a href="javascript:void(0)" id="login-link">Войти</a>
				</div>
			</form>
		</div>
	</div>
</div>

{literal}
<script type="text/javascript">
	$(function () {

		$('#restore-link').bind('click', function () {
			$('#login-form').hide('fast');
			$('#restore-form').show('fast');
			$('div.eve-title').text('Восстановление пароля');
		});

		$('#login-link').bind('click', function () {
			$('#restore-form').hide('fast');
			$('#login-form').show('fast');
			$('div.eve-title').text('Авторизация');
		});

		var t = setTimeout(function () {
			$('div.error').fadeOut(function() {$(this).remove();})
			clearTimeout(t);
		}, 3000);
	});
</script>
{/literal}