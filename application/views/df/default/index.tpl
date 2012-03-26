<ul class="tabs">
	<li id="latest_tab" class="selected"><a href="javascript:void(0)">Новинки</a></li>
	<li id="stock_tab"><a href="javascript:void(0)">Акции</a></li>
	<li id="featured_tab"><a href="javascript:void(0)">Рекомендуем</a></li>
</ul>
<div class="page main">
	<div class="hp-catalog" id="latest">
		<div class="hp-catalog-cont">
			{foreach from=$latest item=prod name=latest}
			<div class="hp-catalog-item">
				<div class="hp-catalog-item-image">
                    {if $prod->image}
                    <a href="/catalog/product/id/{$prod->product_id}">
                        <img src="/images/products/{$prod->image}" alt="{$prod->img_alt}"/>
                    </a>
                    {else}
                    <a href="/catalog/product/id/{$prod->product_id}">
                        <img src="/images/default135.gif" alt="{$prod->img_alt}" />
                    </a>
                    {/if}
				</div>
				<div class="hp-catalog-item-content">
					<h1><a href="/catalog/product/id/{$prod->product_id}">{$prod->title}</a></h1>
					<p>
                        {$prod->description|truncate:125:"..."}
                        {if $prod->description|@mb_strlen > 125}
                            <a class="next-link" href="/catalog/product/id/{$prod->product_id}">далее</a>
                        {/if}
                    </p>
					<div class="details">
                        {if $prod->color}
						<strong>Цвет:</strong>{$prod->color|truncate:100}<br />
                        {/if}
                        {if $prod->consumption}
						<strong>Расход:</strong> {$prod->consumption|truncate:40}<br />
                        {/if}
                        {if $prod->storage_time}
						<strong>Cрок хранения:</strong> {$prod->storage_time|truncate:40} мес<br />
                        {/if}
                        {if $prod->durability}
						<strong>Долговечность:</strong> {$prod->durability|truncate:40}
                        {/if}
					</div>
				</div>
			</div>
			{if $smarty.foreach.latest.iteration %2 == 0}<div class="divider"></div>{/if}
			{/foreach}
		</div>
	</div>
	<div class="hp-catalog" id="stock" style="display: none;">
		<div class="hp-catalog-cont">
			{foreach from=$stock item=prod name=stock}
			<div class="hp-catalog-item">
				<div class="hp-catalog-item-image">
					{if $prod->image}
                    <a href="/catalog/product/id/{$prod->product_id}">
                        <img src="/images/products/{$prod->image}" alt="{$prod->img_alt}"/>
                    </a>
                    {else}
                    <a href="/catalog/product/id/{$prod->product_id}">
                        <img src="/images/default135.gif" alt="{$prod->img_alt}" />
                    </a>
                    {/if}
				</div>
				<div class="hp-catalog-item-content">
					<h1><a href="/catalog/product/id/{$prod->product_id}">{$prod->title}</a></h1>
					<p>
                        {$prod->description|truncate:125:"..."}
                        {if $prod->description|@mb_strlen > 125}
                            <a class="next-link" href="/catalog/product/id/{$prod->product_id}">далее</a>
                        {/if}
                    </p>
					<div class="details">
                        {if $prod->color}
						<strong>Цвет:</strong>{$prod->color|truncate:100}<br />
                        {/if}
                        {if $prod->consumption}
						<strong>Расход:</strong> {$prod->consumption|truncate:40}<br />
                        {/if}
                        {if $prod->storage_time}
						<strong>Cрок хранения:</strong> {$prod->storage_time|truncate:40} мес<br />
                        {/if}
                        {if $prod->durability}
						<strong>Долговечность:</strong> {$prod->durability|truncate:40}
                        {/if}
					</div>
				</div>
			</div>
			{if $smarty.foreach.stock.iteration %2 == 0}<div class="divider"></div>{/if}
			{/foreach}
		</div>
	</div>
	<div class="hp-catalog" id="featured" style="display: none;">
		<div class="hp-catalog-cont">
			{foreach from=$featured item=prod name=featured}
			<div class="hp-catalog-item">
				<div class="hp-catalog-item-image">
					{if $prod->image}
                    <a href="/catalog/product/id/{$prod->product_id}">
                        <img src="/images/products/{$prod->image}" alt="{$prod->img_alt}"/>
                    </a>
                    {else}
                    <a href="/catalog/product/id/{$prod->product_id}">
                        <img src="/images/default135.gif" alt="{$prod->img_alt}" />
                    </a>
                    {/if}
				</div>
				<div class="hp-catalog-item-content">
					<h1><a href="/catalog/product/id/{$prod->product_id}">{$prod->title}</a></h1>
					<p>
                        {$prod->description|truncate:125:"..."}
                        {if $prod->description|@mb_strlen > 125}
                            <a class="next-link" href="/catalog/product/id/{$prod->product_id}">далее</a>
                        {/if}
                    </p>
					<div class="details">
                        {if $prod->color}
						<strong>Цвет:</strong>{$prod->color|truncate:100}<br />
                        {/if}
                        {if $prod->consumption}
						<strong>Расход:</strong> {$prod->consumption|truncate:40}<br />
                        {/if}
                        {if $prod->storage_time}
						<strong>Cрок хранения:</strong> {$prod->storage_time|truncate:40} мес<br />
                        {/if}
                        {if $prod->durability}
						<strong>Долговечность:</strong> {$prod->durability|truncate:40}
                        {/if}
					</div>
				</div>
			</div>
			{if $smarty.foreach.featured.iteration %2 == 0}<div class="divider"></div>{/if}
			{/foreach}
		</div>
	</div>
</div>
<div class="page-corners"><div></div></div>
<div class="banner">
	{include file='inc/bottom-banner.tpl'}
</div>