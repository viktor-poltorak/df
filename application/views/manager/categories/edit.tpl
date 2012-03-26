{if $error}
{sb_error text=$errors}
{/if}
{include file='categories/inc/tabs.tpl'}
<div class="manager-content">
	<div class="manager-header">
		<img src="/images/admin/icons/settings.png" alt="" />
		<span>Добавление категории</span>
		<div class="manager-add">
			<a href="/manager/categories">
				<img src="/images/admin/back.png" alt="" />
				<span>Вернуться к меню</span>
			</a>
		</div>
	</div>
	<form action="/manager/categories/{if $request->category_id}save{else}create-item{/if}/" method="post" class="form" enctype="multipart/form-data">
		{if $request->category_id}
		<input name="id" value="{$request->category_id}" type="hidden" />
		{/if}
		<div class="form-item">
			<label>Название:</label>
			<input type="text" id="title" name="name" value="{$request->name}" />
		</div>
		<div class="form-item">
			<label>Изображение:</label>
			<input type="file" name="image"  />
		</div>
		<div class="form-item">
			<label>Отображать на главной:</label>
			<select name="on_home">
				<option {if $request->on_home==0}selected{/if} value="0">нет</option>
				<option {if $request->on_home==1}selected{/if} value="1">да</option>
			</select>
		</div>
		{if $request->image != ''}
			<div class="form-item">
				<img src="/images/categories/{$request->image}" />
			</div>
		{/if}
		<div>
			<input type="submit" value="Сохранить" />
		</div>
	</form>
</div>
{literal}
<script>
	$(document).ready(function(){
		$('#title').focus();
	});
</script>
{/literal}