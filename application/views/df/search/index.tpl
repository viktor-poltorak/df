<ul class="tabs">
	<li class="selected"><span>Поиск</span></li>
</ul>
<div class="page">
	<h1>Результаты поиска для "{$smarty.get.q|strip_tags|trim}"</h1>
	<div class="hp-catalog" id="latest">
		<div class="hp-catalog-cont">
			{foreach from=$products item=prod name=latest}
			<div class="hp-catalog-item">
				<div class="hp-catalog-item-image">
					<img src="/images/products/{$prod->image}" alt="" />
				</div>
				<div class="hp-catalog-item-content">
					<h1><a href="/catalog/product/id/{$prod->product_id}">{$prod->title}</a></h1>
					<p>{$prod->description}</p>
					<div class="details">
						<strong>Цвет:</strong>{$prod->color}<br />
						<strong>Расход:</strong> {$prod->consumption} мл/м2<br />
						<strong>Cрок хранения:</strong> {$prod->storage_time} мес<br />
						<strong>Долговечность:</strong> {$prod->durability}
					</div>
				</div>
			</div>
			{if $smarty.foreach.latest.iteration %2 == 0}<div class="divider"></div>{/if}
			{/foreach}
		</div>
	</div>
</div>
<div class="page-corners"><div></div></div>
<div class="banner">
	{include file='inc/bottom-banner.tpl'}
</div>