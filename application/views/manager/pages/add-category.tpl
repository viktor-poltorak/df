{include file='pages/inc/tabs.tpl'}
<div class="manager-content">

	<div class="manager-header">
		<img src="/images/admin/icons/articles.png" alt="" />
		<span>Добавление категории</span>

		<div class="manager-add">
			<a href="/manager/pages/category-add/">
				<img src="/images/admin/add.png" alt="" />
				<span>Добавить категорию</span>
			</a>
		</div>
	</div>

	<form action="/manager/pages/category-create/" enctype="multipart/form-data" method="post" class="form">
		<div class="form-cols">
			<div class="form-item">
				<label>Название:</label>
				<input type="text" value="{$category->name|stripslashes}" name="name" />
			</div>
			<div class="form-item">
				<label>Родитель: </label>
				<select name="parent_id">
					<option value="0">Это корневая</option>
					{foreach from=$all_categories item=lcategory}
					<option value="{$lcategory->category_id}" {if $category->parent_id == $lcategory->category_id}selected{/if}>{$lcategory->name}</option>
					{/foreach}
				</select>
			</div>
			<div class="form-item">
				<label>Картинка:</label>
				<input type="file" name="icon" />
				<div class="form-descr">(64x64 пикселя, JPG, PNG)</div>
			</div>

		</div>
		<div class="form-item">
			<label>Описание:</label>
			<textarea name="description"></textarea>
		</div>
		<div>
			<input type="submit" value="Добавить" class="button" />
		</div>
	</form>
</div>