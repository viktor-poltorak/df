{literal}
<script>
    $(document).ready(function() {
        $('#contentPages').bind('change', function(){
            $('#contentPages > option:selected');
            $('#link').val($('#contentPages').val());
            $('#desc').val($('#contentPages option:selected').attr('rel'));
        });
    });
</script>
{/literal}

{include file='seo/inc/tabs.tpl'}
<div class="manager-content">
    <div class="manager-header">
        <img src="/images/admin/icons/menu.png" alt="" />
        <span>Добавление meta информации</span>
        <div class="manager-add">
            <a href="/manager/seo/meta">
                <img src="/images/admin/back.png" alt="" />
                <span>Вернуться к ссылкам</span>
            </a>
        </div>
    </div>

    <form action="/manager/seo/edit-meta/" method="post" class="form" enctype="multipart/form-data">
        {if $id}<input type="hidden" name="metaId" value="{$id}" />{/if}
        <div class="form-item">
            <label>Ссылка на контент:</label>
            <select id="contentPages" name="contentPage">
                <option value="">Выбрать</option>
                <optgroup label="Страницы">
                    {if !$isMain}
                    <option rel="Страница: Главная" value="/" {if $meta->link=="/"}selected{/if}>Главная</option>
                    {/if}
                    {foreach from=$contentPages item=page}
                    <option rel="Страница: {$page->title}" value="/pages/{$page->link}">{$page->title}</option>
                    {/foreach}
                </optgroup>
                <optgroup label="Производители">
                    {foreach from=$producers item=prod}
                    <option rel="Производитель: {$prod->name}" value="/catalog/manufacturer/id/{$prod->category_id}">{$prod->name}</option>
                    {/foreach}
                </optgroup>
                <optgroup label="Категории">
                    {foreach from=$categories item=prod}
                    <option rel="Категория: {$prod->name}" value="/catalog/category/id/{$prod->category_id}">{$prod->name}</option>
                    {/foreach}
                </optgroup>
                <optgroup label="Товары">
                    {foreach from=$products item=prod}
                    <option rel="Товар: {$prod->title}" value="/catalog/product/id/{$prod->product_id}">{$prod->title}</option>
                    {/foreach}
                </optgroup>
            </select>
        </div>        
        <div class="form-item">
            <label>Ссылка:</label>
            <input type="text" id="link" name="link" value="{$request->link}" />
        </div>
        <div class="form-item">
            <label>Описание:</label>
            <input type="text" id="desc" name="desc" value="{$request->desc}" />
        </div>
        <div>
            <input type="submit" value="Добавить" />
        </div>
    </form>
</div>