<ul class="tabs">
	<li class="selected"><span>Наши объекты</span></li>
</ul>
<div class="page">
	<div class="page-content">
		<div class="objects">
			{foreach from=$objects item=item}
			<div class="object">
				<table class="label">
					<tr>
						<td class="label-corner"><img src="/images/label-top-left.png" alt="" /></td>
						<td></td>
						<td class="label-corner"><img src="/images/label-top-right.png" alt="" /></td>
					</tr>
					<tr>
						<td></td>
						<td class="label-content">
							{$item->name}
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
                    {if $item->image}
                    <a href="/objects/view/id/{$item->id}">
                        <img rel="facebox" width="190" src="/upload/objects/{$item->image->path}" />
                    </a>
                    {else}
					<li>Нет изображения</li>
					{/if}
				</ul>
			</div>
			{/foreach}
		</div>
        {if !$objects}
        <div>Список объектов пуст</div>
        {/if}
	</div>
</div>
<div class="page-corners"><div></div></div>