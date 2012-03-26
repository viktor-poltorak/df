{foreach from=$meta item=item name="prod"}
<div class="manager-list{cycle values=', gray-bg'}">
    <div class="manager-list-content">
        <input type="hidden" value="{$parentId}" name="parent_id_{$parentId}" />
        <select name="name" id="name_{$item->id}">
            {foreach from=$metaNames item=metaName}                
                <option {if $item->name == $metaName}selected{/if} value="{$metaName}">{$metaName}</option>
            {/foreach}
        </select>
        <textarea name="content" id="content_{$item->id}" style="width: 400px;" type="text">{$item->content}</textarea>
    </div>
    <div class="manager-list-controls">
        <div class="label"><a href="javascript:" onclick="saveMetaData({$parentId}, {$item->id})">Сохранить</a></div>
        <div class="label"><a href="javascript:" onclick="deleteItemMetaData({$parentId}, {$item->id})">Удалить</a></div>
    </div>
</div>
{/foreach}

<div class="manager-list-content">
    <input id="new_parent_id_{$parentId}" type="hidden" value="{$parentId}" name="parentId" />
    <select name="name" id="new_name_{$parentId}">
        {foreach from=$metaNames item=metaName}
            <option value="{$metaName}">{$metaName}</option>
        {/foreach}
    </select>
    <textarea id="new_content_{$parentId}" style="width: 400px;" type="text"></textarea>
</div>
<div class="manager-list-controls">
    <div class="label"><a href="javascript:" onclick="addMetaData({$parentId})">Добавить</a></div>
</div>