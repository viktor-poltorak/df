{include file='uploads/inc/tabs.tpl'}
<div class="manager-content">
	<div class="manager-header">
		<img src="/images/admin/icons/pricelist.png" alt="" />
		<span>Загрузки</span>
	</div>
	<form action="/manager/uploads/save/" method="post" class="form" enctype="multipart/form-data">
		<div class="form-item">
			<label>Прайслист:</label>
			<input type="file" name="pricelist"  />
		</div>
		<div class="form-item">
			<label>Каталог:</label>
			<input type="file" name="catalog"  />
		</div>
		<!--<div class="form-item">
			<label>Верхний баннер:</label>
			<input type="file" name="topBanner"  />
		</div>-->
		<div class="form-item">
			<label>Нижний баннер:</label>
			<input type="file" name="bottomBanner"  />
		</div>
		<div>
			<input type="submit" value="Сохранить" />
		</div>
	</form>
</div>