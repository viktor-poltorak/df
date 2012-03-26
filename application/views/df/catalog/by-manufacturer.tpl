<ul class="tabs">
	<li class="selected"><span>{$producer->name}</span></li>
</ul>
<div class="page">
	<div class="page-content">
        <div class="prod_description">
            {$producer->description}
        </div>
		<div class="col-1">
			{foreach from=$col1 item=cat}
			{assign var="category" value=$cat.category }
			{assign var="items" value=$cat.items }
			<div>
				<table class="label">
					<tr>
						<td class="label-corner"><img src="/images/label-top-left.png" alt="" /></td>
						<td></td>
						<td class="label-corner"><img src="/images/label-top-right.png" alt="" /></td>
					</tr>
					<tr>
						<td></td>
						<td class="label-content">
							{$category->name}
						</td>
						<td></td>
					</tr>
					<tr>
						<td class="label-corner"><img src="/images/label-bottom-left.png" alt="" /></td>
						<td></td>
						<td class="label-corner"><img src="/images/label-bottom-right.png" alt="" /></td>
					</tr>
				</table>
				<ul class="manufacturer-list">
					{foreach from=$items item=prod}
					<li><a href="/catalog/product/id/{$prod->product_id}">{$prod->title}</a></li>
					{foreachelse}
					<li>Категория пуста</li>
					{/foreach}
				</ul>
			</div>
			{/foreach}
		</div>
		<div class="col-2">
			{foreach from=$col2 item=cat}
			{assign var="category" value=$cat.category }
			{assign var="items" value=$cat.items }
			<div>
				<table class="label">
					<tr>
						<td class="label-corner"><img src="/images/label-top-left.png" alt="" /></td>
						<td></td>
						<td class="label-corner"><img src="/images/label-top-right.png" alt="" /></td>
					</tr>
					<tr>
						<td></td>
						<td class="label-content">
							{$category->name}
						</td>
						<td></td>
					</tr>
					<tr>
						<td class="label-corner"><img src="/images/label-bottom-left.png" alt="" /></td>
						<td></td>
						<td class="label-corner"><img src="/images/label-bottom-right.png" alt="" /></td>
					</tr>
				</table>
				<ul class="manufacturer-list">
					{foreach from=$items item=prod}
					<li><a href="/catalog/product/id/{$prod->product_id}">{$prod->title}</a></li>
					{foreachelse}
					<li>Категория пуста</li>
					{/foreach}
				</ul>
			</div>
			{/foreach}
		</div>
		<div class="col-3">
			{foreach from=$col3 item=cat}
			{assign var="category" value=$cat.category }
			{assign var="items" value=$cat.items }
			<div>
				<table class="label">
					<tr>
						<td class="label-corner"><img src="/images/label-top-left.png" alt="" /></td>
						<td></td>
						<td class="label-corner"><img src="/images/label-top-right.png" alt="" /></td>
					</tr>
					<tr>
						<td></td>
						<td class="label-content">
							{$category->name}
						</td>
						<td></td>
					</tr>
					<tr>
						<td class="label-corner"><img src="/images/label-bottom-left.png" alt="" /></td>
						<td></td>
						<td class="label-corner"><img src="/images/label-bottom-right.png" alt="" /></td>
					</tr>
				</table>
				<ul class="manufacturer-list">
					{foreach from=$items item=prod}
					<li><a href="/catalog/product/id/{$prod->product_id}">{$prod->title}</a></li>
					{foreachelse}
					<li>Категория пуста</li>
					{/foreach}
				</ul>
			</div>
			{/foreach}
		</div>
        {if !$col1 && !$col2 && !$col3}
        <div>Для производителя нет категорий</div>
        {/if}
	</div>
</div>
<div class="page-corners"><div></div></div>