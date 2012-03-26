{include file='products/inc/tabs.tpl'}
<div class="manager-content">
	<div class="manager-header">
		<img src="/images/admin/icons/settings.png" alt="" />
		<span>{if !$request->product_id}Добавление{else}Редактирование{/if} товара</span>
		<div class="manager-add">
			<a href="/manager/categories">
				<img src="/images/admin/back.png" alt="" />
				<span>Вернуться к меню</span>
			</a>
		</div>
	</div>
	<form action="/manager/products/save/" method="post" class="form" enctype="multipart/form-data">
		{if $request->product_id}
		<input name="id" value="{$request->product_id}" type="hidden" />
		{/if}
		<div class="form-item">
			<label>Название:</label>
			<input type="text" id="title" name="title" value="{$request->title}" />
		</div>
		<div class="form-item">
			<label>Производитель:</label>
			<select name="producer_id" id="producer">
                <option>Выберите категорию</option>
				{foreach from=$producers item=prod}
				<option value="{$prod->category_id}" {if $request->producer_id == $prod->category_id}selected{/if} >{$prod->name}</option>
				{/foreach}
			</select>
		</div>
		<div class="form-item">
			<label>Категория производителя:</label>
			<select name="prod_cat" id="categories">
                <option>Выберите категорию</option>
				{foreach from=$prodCat item=cat}
				<option value="{$cat->category_id}" {if $request->prod_cat == $cat->category_id}selected{/if} >{$cat->name}</option>
				{/foreach}
			</select>
		</div>
		<div class="form-item">
			<label>Категория:</label>
			<select name="category_id" id="categories">
                <option>Выберите категорию</option>
				{foreach from=$categories item=cat}
				<option value="{$cat->category_id}" {if $request->category_id == $cat->category_id}selected{/if} >{$cat->name}</option>
				{/foreach}
			</select>
		</div>
        <div class="form-item">
			<label>Область применения:</label>
			<input type="text" id="use_for" name="use_for" value="{$request->use_for}" />
		</div>
		<div class="form-item">
			<label>Цвет:</label>
			<input type="text" id="color" name="color" value="{$request->color}" />
		</div>
		<div class="form-item">
			<label>Расход, мл/м2:</label>
			<input type="text" id="consumption" name="consumption" value="{$request->consumption}" />
		</div>
		<div class="form-item">
			<label>Cрок хранения, мес.:</label>
			<input type="text" id="storage_time" name="storage_time" value="{$request->storage_time}" />
		</div>
		<div class="form-item">
			<label>Долговечность, г:</label>
			<input type="text" id="durability" name="durability" value="{$request->durability}" />
		</div>
		<div class="form-item">
			<label>Условия хранения:</label>
			<input type="text" id="storage_terms" name="storage_terms" value="{$request->storage_terms}" />
		</div>
		<div class="form-item">
			<label>Фасовка:</label>
			<input type="text" id="storage_terms" name="pre_packing" value="{$request->pre_packing}" />
		</div>
		<div class="form-item">
			<label>Акция:</label>
			<input type="checkbox" id="stock" name="stock" {if $request->stock == 1}checked="checked"{/if} />
		</div>
		<div class="form-item">
			<label>Рекомендовать:</label>
			<input type="checkbox" id="featured" name="featured" {if $request->featured == 1}checked="checked"{/if} />
		</div>
		<div class="form-item">
			<label>Описание:</label>
			<textarea type="text" id="product_description" name="description">{$request->description}</textarea>
		</div>		
		<div class="form-item">
			<label>Изображение:</label>
			<input type="file" name="image"  />
		</div>		
		{if $request->image != ''}
			<div class="form-item">
				<img src="/images/products/{$request->image}" />
			</div>
		{/if}
		<div class="form-item">
			<label>Большая картинка:</label>
			<input type="file" name="big_image"  />
		</div>
		{if $request->big_image != ''}
			<div class="form-item">
                <img width="140" height="100" src="/images/products/{$request->big_image}" />
			</div>
		{/if}
		<div class="form-item">
			<label>Meta тег:</label>
			<input type="text" id="meta" name="meta" value="{$request->meta}" />
		</div>
		<div class="form-item">
			<label>Ключевые слова:</label>
			<input type="text" id="keywords" name="keywords" value="{$request->keywords}" />
		</div>		
		<div>
			<input type="submit" value="Сохранить" />
		</div>
	</form>
</div>