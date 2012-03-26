<ul class="tabs">
	<li class="selected"><span>{$product->title}</span></li>
</ul>
<div class="page">
	<div class="hp-catalog">
		<div class="hp-catalog-cont">			
			<div class="hp-catalog-item">
				<div class="hp-catalog-item-image">
					{if $product->image}
                    <a rel="facebox" href="/images/products/{if $product->big_image}{$product->big_image}{else}{$product->image}{/if}">
                        <img src="/images/products/{$product->image}" alt="{$product->img_alt}" height="100"/>
                    </a>
                    {else}
                        <img src="/images/default135.gif" alt="" />
                    {/if}
				</div>
				<div class="hp-catalog-item-content">				
					<p>{$product->description}</p>
					<div class="details">
                        {if $product->use_for}
                        <strong>Область применения:</strong> {$product->use_for}<br />
                        {/if}
                        {if $product->color}<br/>
						<strong>Цвет:</strong>{$product->color}<br />
                        {/if}
                        {if $product->consumption}
						<strong>Расход:</strong> {$product->consumption}<br />
                        {/if}
                        {if $product->storage_time}
						<strong>Cрок хранения:</strong> {$product->storage_time} мес<br />
                        {/if}
                        {if $product->durability}
						<strong>Долговечность:</strong> {$product->durability}<br />
                        {/if}
                        {if $product->storage_terms}<br/>
                        <strong>Условия хранения:</strong> {$product->storage_terms}<br />
                        {/if}                        
                        {if $product->pre_packing}<br/>
                        <strong>Фасовка:</strong> {$product->pre_packing}<br />
                        {/if}
					</div>
				</div>
			</div>			
		</div>
	</div>
</div>
<div class="page-corners"><div></div></div>
<div class="banner">
	{include file='inc/bottom-banner.tpl'}
</div>
{literal}
<style>
    .hp-catalog-item {
         height: auto;
         width: auto;
    }
    .hp-catalog-item-image {
        width: 200px;
    }

    .hp-catalog-item-content{
        width: 500px;
    }
</style>
{/literal}