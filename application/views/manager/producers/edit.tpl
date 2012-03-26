{if $error}
    {sb_error text=$errors}
{/if}
{include file='producers/inc/tabs.tpl'}
<div class="manager-content">
    <div class="manager-header">
        <img src="/images/admin/icons/settings.png" alt="" />
        <span>Добавление производителя</span>
        <div class="manager-add">
            <a href="/manager/producers">
                <img src="/images/admin/back.png" alt="" />
                <span>Вернуться к меню</span>
            </a>
        </div>
    </div>
    <form id="producer-form" action="/manager/producers/{if $request->category_id}save{else}create-item{/if}/" method="post" class="form" enctype="multipart/form-data">
        {if $request->category_id}
            <input name="id" value="{$request->category_id}" type="hidden" />
        {/if}
        <div class="form-item">
            <label>Название:</label>
            <input type="text" id="title" name="name" value="{$request->name}" />
        </div>
        <div class="form-item">
            <label>Описание:</label>
            <textarea id="producer_description" name="description">{$request->description}</textarea>
        </div>             
        <div class="form-item catList">
            <span class="catList-left">
                <label>Категории:</label>
                <select id="catList-from" multiple>
                    {foreach from=$prodCategories item=item}
                        {if $item->producer_id == 0}
                            <option value="{$item->category_id}">{$item->name}</option>
                        {/if}
                    {/foreach}
                </select>
            </span>
            <span class="catList-center">
                <input id="addCat" type="button" value=">"/>
                <input id="removeCat" type="button" value="<"/>
            </span>
            <span class="catList-rigth">
                <label>Выбранные категории:</label>
                <select id="catList-selected" name="categories[]" multiple>
                    {foreach from=$prodCategories item=item}
                        {if $item->producer_id == $request->category_id}
                            <option value="{$item->category_id}">{$item->name}</option>
                        {/if}
                    {/foreach}
                </select>
            </span>
        </div>
        <div id="cat_form" class="form-item" style="display: none">
            <label>Название категории:</label>
            <input type="text" id="cat_name" name="cat_name" value="" />
            <a href="javascript:" id="cat_save">Сохранить</a>
        </div>
        <div class="form-item">
            <a href="javascript:" id="add_button">Добавить категорию</a>
            <a href="javascript:" id="delete_button">Удалить выбранные</a>
        </div>
        <div>
            <input type="submit" value="Сохранить" />
        </div>
    </form>
</div>
{literal}
    <script>
        $(document).ready(function(){
            
            $('#addCat').click(function () {
                $('#catList-selected').append($('#catList-from option[selected]'));
                $('#catList-from option[selected]').remove();
            });
            
            $('#removeCat').click(function () {
                $('#catList-from').append($('#catList-selected option[selected]'));
                $('#catList-selected option[selected]').remove();
            });
            
            $('#title').focus();

            $('#add_button').bind('click', function(){
                $("#cat_form").show('slow');
            });

            $('#delete_button').bind('click', function(){
                if(confirm('Вы уверены?')){
                    items = $('#catList-from option[selected]');
                    for(i in items){
                        id = $(items[i]).val();
                        if(id !=''){
                            $.get('/manager/producers/del-category/id/' + id, {}, function(){});
                        }
                        $(items[i]).remove();
                    }
                }
            });

            $('#cat_save').bind('click', function(){
                var catName = $('#cat_name').val();
            
                if(catName.trim() != ''){
                    $.post('/manager/producers/add-category', {'name':catName.trim()}, function(data){
                        if(data != ''){
                            var result = eval('(' + data + ')');
                            $('#catList-from').append('<option value="' + result.id +'">'+result.name+'</option>');
                            $('#cat_name').val('');
                        }
                    });
                }
            })
                
            $('#producer-form').submit(function () {
               $('#catList-selected option').attr('selected', true);            
            });

        });
    </script>
{/literal}