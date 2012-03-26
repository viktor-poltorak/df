{include file='users/inc/tabs.tpl'}
<div class="manager-content">

	<div class="manager-header">
		<img src="/images/admin/icons/users.png" alt="" />
		<span>Права пользователя {$user->first_name} {$user->last_name}</span>
	</div>

	<div class="fix">
		<div class="block-left">
			<h2>Текущие роли:</h2>
			<select name="user_roles" id="user_roles" multiple="multiple">
				{foreach from=$user_roles item=user_role}
				<option value="{$user_role->role_id}">{$user_role->role_name}</option>
				{/foreach}
			</select>
		</div>
		<div class="block-actions">
			<a href="javascript:addRole({$user->user_id})">&laquo; add</a>
			<a href="javascript:removeRole({$user->user_id})">delete &raquo;</a>
		</div>
		<div class="block-right">
			<h2>Добавить роль к пользователю:</h2>
			<select id="avail_roles" name="avail_roles" multiple="multiple">
				{foreach from=$roles item=role}
				<option id="option_role_{$role->role_id}" value="{$role->role_id}">{$role->role_name}</option>
				{/foreach}
			</select>
		</div>
	</div>
</div>