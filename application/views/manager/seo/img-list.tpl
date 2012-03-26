{include file='seo/inc/tabs.tpl'}
<div class="manager-content">
    <div class="manager-header">
        <div class="fix">
            <img src="/images/admin/icons/menu.png" alt="" />
            <span>Список картинок товаров</span>            
        </div>
    </div>
    <form action="/manager/seo/save-alt" method="POST">
        <div class="manager-list-holder">
            {foreach from=$products item=prod name="prod"}
            <div class="manager-list{cycle values=', gray-bg'}">
                <div class="manager-list-content">
                    {if $prod->image}
                        <img style="float: left;margin-right: 7px" src="/images/products/{$prod->image}" alt="{$prod->img_alt}" height="70"/>
                    {else}
                        <img style="float: left;margin-right: 7px" src="/images/default135.gif" alt="{$prod->img_alt}" height="70"/>
                    {/if}
                    <span id="span_{$prod->product_id}" style="cursor: pointer;">{$prod->img_alt}</span>
                    <textarea id="input_{$prod->product_id}" style="display: none; width: 400px;" type="text">{$prod->img_alt}</textarea>
                </div>
                <div class="manager-list-controls">
                    <div class="label"><a id="edit_{$prod->product_id}" href="javascript:" rel="img_alt">Редактировать</a></div>
                    <div class="label" style="display:none;"><a id="save_{$prod->product_id}" href="javascript:" rel="img_alt">Сохранить</a></div>
                </div>
            </div>
            {foreachelse}
            <div class="manager-list{cycle values=', gray-bg'}">
                <div class="manager-list-image">
                    <img src="/images/admin/star-off.png" alt="" />
                </div>
                <div class="manager-list-content star-down">
				Нет картинок для редактирования
                </div>
            </div>
            {/foreach}
        </div>
    </form>
</div>