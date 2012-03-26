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
		<span>Добавление пункта меню</span>
			<div class="manager-add">
				<a href="/manager/menus/items/id/{$cmenu->menu_id}/">
					<img src="/images/admin/back.png" alt="" />
					<span>Вернуться к меню</span>
				</a>
			</div>
	</div>

	<form action="/manager/menus/create-item/" method="post" class="form" enctype="multipart/form-data">
		{if !$menu}
		<div class="form-item">
			<label>Выберите в какое меню добавить пункт:</label>
			<select name="menu_id">
				{foreach from=$menus item=menu}
				<option value="{$menu->menu_id}">{$menu->name}</option>
				{/foreach}
			</select>
		</div>
		{else}
		<div class="form-item display-none">
			<input type="hidden" name="menu_id" value="{$menu->menu_id}" />
		</div>
		{/if}

		<div class="form-item">
			<label>Название:</label>
			<input type="text" id="title" name="name" value="{$request->name}" />
		</div>
		<div class="form-item">
			<label>Описание:</label>
			<input type="text" name="description" value="{$request->description}" />
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
			<input type="text" id="link" name="link" value="{$request->link}" />
		</div>		
		<div>
			<input type="submit" value="Добавить" />
		</div>
	</form>
</div>