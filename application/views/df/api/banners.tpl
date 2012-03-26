{foreach name="banners" from=$banners item=banner}
    <li><img src="/upload/banners/{$banner->file}" alt="" /></li>
    {if $smarty.foreach.banners.total == 1}
    <li><img src="/upload/banners/{$banner->file}" alt="" /></li>
    {/if}
{/foreach}