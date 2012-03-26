{if $error}
    {sb_error text=$errors}
{/if}
{include file='objects/inc/tabs.tpl'}
<div class="manager-content">
    <div class="manager-header">
        <img src="/images/admin/icons/settings.png" alt="" />
        <span>Добавление объекта</span>
        <div class="manager-add">
            <a href="/manager/objects">
                <img src="/images/admin/back.png" alt="" />
                <span>Вернуться к меню</span>
            </a>
        </div>
    </div>
    <form action="/manager/objects/{if $request->id}save{else}create-item{/if}/" method="post" class="form" enctype="multipart/form-data">
        {if $request->id}
            <input name="id" value="{$request->id}" type="hidden" />
        {/if}
        <div class="form-item">
            <label>Название:</label>
            <input type="text" id="title" name="name" value="{$request->name}" />
        </div>
        <div class="form-item">
            <label>Описание:</label>
            <textarea id="tiny_mce" name="description">
                {$request->description}
            </textarea>
        </div>
        <div class="form-item">
            <label>Изображение:</label>
            <input type="file" name="image"  />
        </div>

        {foreach from=$images item=item}
            <div class="form-item">
                <a rel="facebox" href="/upload/objects/{$item->path}">
                    <img rel="facebox" width="58" src="/upload/objects/{$item->path}" />
                </a>
                <a href="/manager/objects/deleteImage/id/{$item->id}">Удалить</a>
            </div>
        {/foreach}
        <div>
            <input type="submit" value="Сохранить" />
        </div>
    </form>
</div>
{literal}
    <script>
        $(document).ready(function(){
            $('#title').focus();
            
            $('a[rel*=facebox]').facebox();
        });
    </script>
{/literal}