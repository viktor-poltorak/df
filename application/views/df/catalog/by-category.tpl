<ul class="tabs">
	<li class="selected"><span>{$category->name}</span></li>
</ul>
<div class="page">
	<div class="catalog-page">
		{foreach from=$products item=prod}
		<div class="catalog-item">
			<div class="catalog-image">                
                {if $prod->image}
                    <a href="/catalog/product/id/{$prod->product_id}">
                        <img  src="/images/products/{$prod->image}" alt="{$prod->img_alt}" height="100"/>
                    </a>
                    {else}
                    <a href="/catalog/product/id/{$prod->product_id}">
                        <img src="/images/default135.gif" alt="{$prod->img_alt}" />
                    </a>
                {/if}
			</div>
			<table class="label">
				<tr>
					<td class="label-corner"><img src="/images/label-top-left.png" alt="" /></td>
					<td></td>
					<td class="label-corner"><img src="/images/label-top-right.png" alt="" /></td>
				</tr>
				<tr>
					<td></td>
					<td class="label-content">
						<a href="/catalog/product/id/{$prod->product_id}">
							{$prod->title}
						</a>
					</td>
					<td></td>
				</tr>
				<tr>
					<td class="label-corner"><img src="/images/label-bottom-left.png" alt="" /></td>
					<td></td>
					<td class="label-corner"><img src="/images/label-bottom-right.png" alt="" /></td>
				</tr>
			</table>
		</div>
		{foreachelse}
		<h2>В данный момент в этой категории нет товаров.</h2>
		{/foreach}
	</div>
</div>
<div class="page-corners"><div></div></div>