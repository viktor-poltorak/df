{include file='menus/inc/tabs.tpl'}
<div class="manager-content">

    <div class="manager-header">
        <div class="fix">
            <img src="/images/admin/icons/menu.png" alt="" />
            <span>Содержание меню</span>
            <div class="manager-add">                
                <a href="/manager/menus/add-item/{if $menu}id/{$menu->menu_id}/{/if}">
                    <img src="/images/admin/add.png" alt="" />
                    <span>Добавить пункт меню</span>
                </a>
            </div>
        </div>
    </div>
    <form action="/manager/menus/save-position" method="POST">
        <input type="hidden" name="menuId" value="{$menu->menu_id}" />
        <div class="manager-list-holder">
            {foreach from=$items item=item name="items"}
            <div class="manager-list{cycle values=', gray-bg'}">

                <div class="manager-list-image">
				{if $item->enabled}
                    <img src="/images/admin/star.png" alt="" />
				{else}
                    <img src="/images/admin/star-off.png" alt="" />
				{/if}
                </div>

                <div class="manager-list-content">
                    <a href="/manager/menus/edit-item/id/{$item->menu_item_id}/">{$item->name|stripslashes}</a><br />
                    <span class="manager-list-meta">
					на новой странице: {if $item->in_new_tab}да{else}нет{/if} |
					ссылка: {$item->link}
                    </span>
                </div>
                <div class="manager-list-controls">
                    <div class="label">Позиция: </div>
                    <input type="text" name="items[{$item->menu_item_id}]" value="{$item->item_position}" size="2" style=""/>
                    <a href="/manager/menus/edit-item/id/{$item->menu_item_id}"><img src="/images/admin/edit.png" alt="Редактировать" /></a>
                    <a href="/manager/menus/delete-item/id/{$item->menu_item_id}"><img src="/images/admin/delete.png" alt="Удалить" /></a>
                </div>
            </div>
            {foreachelse}
            <div class="manager-list{cycle values=', gray-bg'}">
                <div class="manager-list-image">
                    <img src="/images/admin/star-off.png" alt="" />
                </div>
                <div class="manager-list-content star-down">
				Это меню не содержит пунктов. <a href="/manager/menus/add-item/{if $menu}id/{$menu->menu_id}/{/if}">Добавить?</a>
                </div>
            </div>
            {/foreach}
            {if $items}
            <div><input type="submit" value="Сохранить порядок" /></div>
            {/if}
        </div>
    </form>
</div>