{include file='seo/inc/tabs.tpl'}
<div class="manager-content">
    <div class="manager-header">
        <div class="fix">
            <img src="/images/admin/icons/menu.png" alt="" />
            <span>Список ссылок</span>
        </div>
        <div class="manager-add">
            <a href="/manager/seo/edit-meta">
                <img src="/images/admin/add.png" alt="" />
                <span>Добавить ссылку</span>
            </a>
        </div>
    </div>
    <form action="/manager/seo/save-alt" method="POST">
        <div class="manager-list-holder">
            {foreach from=$meta item=item name="prod"}
            <div id="metadata_{$item->id}" class="manager-list{cycle values=', gray-bg'}">
                <div class="manager-list-content">
                    Ссылка: <a href="javascript:" onclick="metaData({$item->id})">{$item->link}</a>
                    <div>{$item->title}</div>
                </div>
                <div class="manager-list-controls">
                    <div class="label"><a href="javascript:" onclick="metaData({$item->id})">Метаданные</a></div>
                    <div class="label"><a href="javascript:" onclick="deleteAllMetaData({$item->id})">Удалить</a></div>
                </div>
                <div style="clear: both;"></div>
                <div style="display: none;" class="manager-metadata" id="edit_block_{$item->id}"></div>
            </div>
            {foreachelse}
            <div class="manager-list{cycle values=', gray-bg'}">
                <div class="manager-list-image">
                    <img src="/images/admin/star-off.png" alt="" />
                </div>
                <div class="manager-list-content star-down">
				Тут пока пусто
                </div>
            </div>
            {/foreach}
        </div>
    </form>
</div>