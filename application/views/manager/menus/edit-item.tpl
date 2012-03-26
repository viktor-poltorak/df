{if $error}
{sb_error text=$errors}
{/if}
{literal}
<script>
    $(document).ready(function() {
        $('#contentPages').bind('change', function(){           
            $('#link').val($('#contentPages').val());            
            $('#title').val($('#contentPages > option[selected]').text());
        });
    });
</script>
{/literal}

{include file='menus/inc/tabs.tpl'}
<div class="manager-content">
	<div class="manager-header">
		<img src="/images/admin/icons/menu.png" alt="" />
		<span>Редактирование пункта меню</span>
			<div class="manager-add">
				<a href="/manager/menus/items/id/{$item->menu_id}/">
					<img src="/images/admin/back.png" alt="" />
					<span>Вернуться к меню</span>
				</a>
			</div>
	</div>

	<form action="/manager/menus/update-item/id/{$item->menu_item_id}/" method="post" class="form" enctype="multipart/form-data">
		<div class="form-item">
			<label>Выберите в какое меню перенести пункт:</label>
			<select name="menu_id">
				{foreach from=$menus item=menu}
				<option value="{$menu->menu_id}" {if $menu->menu_id == $item->menu_id}selected{/if}>{$menu->name}</option>
				{/foreach}
			</select>
		</div>

		<div class="form-item">
			<label>Название:</label>
			<input type="text" name="name" id="title" value="{$item->name}" />
		</div>
		<div class="form-item">
			<label>Описание:</label>
			<input type="text" name="description" value="{$item->description}" />
		</div>
        <div class="form-item">
			<label>Ссылка на контент:</label>
            <select id="contentPages" name="contentPage">
                <option value="/" {if $item->link=="/"}selected{/if}>Главная</option>
                {foreach from=$contentPages item=page}
                <option value="/pages/{$page->link}" {if $page->link == $item->link}selected{/if}>{$page->title}</option>
                {/foreach}
            </select>
		</div>
		<div class="form-item">
			<label>Ссылка:</label>
			<input type="text" name="link" id="link" value="{$item->link}" />
		</div>		
		<div>
			<input type="submit" value="Обновить" />
		</div>
	</form>
</div>