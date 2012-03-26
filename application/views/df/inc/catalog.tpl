<div class="catalog">
	<h1>Каталог товаров</h1>
	<div class="catalog-accord">
		<img src="/images/catalog-top.png" alt="" id="catalog-corners" />
		<div class="catalog-content">
			<a href="javascript:" class="by-category" id="by-category">По категориям товаров</a>
			<a href="javascript:" class="by-manufacturer" id="by-manufacturer">По производителям</a>
			<div id="by-category-content" class="catalog-list">
				<ul>
					{foreach from=$side_categories item=cat}
					<li>
                        <a {if $curCategory==$cat->category_id}class="cur"{/if} href="/catalog/category/id/{$cat->category_id}" onclick="javascript:void(0);">{$cat->name}</a>
                    </li>
					{/foreach}
				</ul>
			</div>
			<div id="by-manufacturer-content" class="catalog-list">
				<ul>
					{foreach from=$producers item=prod}
					<li>
                        <a {if $prodId==$prod->category_id}class="cur"{/if} href="/catalog/manufacturer/id/{$prod->category_id}">{$prod->name}</a>
                    </li>
					{/foreach}
				</ul>
			</div>
		</div>
		<img src="/images/catalog-bottom.png" alt="" />
	</div>
</div>
{if $curCategory}
<script>
    {literal}
    //Customer kill yourself
    $(function () {
        $('#by-category').click();
    });
    
    {/literal}
</script>
{/if}