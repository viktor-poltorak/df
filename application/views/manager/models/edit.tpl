{if $error}
<div class="error">
	{$error}
</div>
{/if}
{include file='models/inc/tabs.tpl'}
<div class="manager-content">
	<div class="manager-header">
		<img src="/images/admin/icons/news.png" alt="" />
		<span>{if $model}Редактирование марки автомобиля{else}Добавление марки автомобиля{/if}</span>
	</div>
	<form action="{if $model}/manager/models/update/id/{$model->model_id}{else}/manager/models/create{/if}" method="post" class="form" enctype="multipart/form-data">
		<div class="form-item">
			<label>Название:</label>
			<input type="text" value="{$model->model_name|stripslashes}" name="title" />
		</div>
		<div class="form-item">
            <label>Иконка:{if $model->model_image}&nbsp;<img src="/images/models/{$model->model_image}" />{/if}</label>
            <input type="file" name="image" value="{$model->model_image}" />           
		</div>
		<div>
			<input type="submit" value="Сохранить" class="button" />
		</div>
	</form>
</div>