{if $products}
<ul>
	{foreach from=$products item=prod}
	<li><a href="/catalog/product/id/{$prod->product_id}">{$prod->title}</a></li>
	{/foreach}
</ul>
{/if}