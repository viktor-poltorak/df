{if $error}
{sb_error text=$errors}
{/if}
{include file='banners/inc/tabs.tpl'}
<div class="manager-content">
	<div class="manager-header">
		<img src="/images/admin/icons/bannners.png" alt="" />
		<span>{if $request->id}Редактирование{else}Добавление{/if} баннера</span>
		<div class="manager-add">
			<a href="/manager/banners">
				<img src="/images/admin/back.png" alt="" />
				<span>Вернуться к меню</span>
			</a>
		</div>
	</div>
	<form action="/manager/banners/save/" method="post" class="form" enctype="multipart/form-data">
        {if $request->id}        
            {if $isFlash}
                <object width="912" height="206" 
                        codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" 
                        classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000">
                    <param value="/upload/{$request->file}" name="movie">
                    <param value="high" name="quality" >
                    <param value="transparent" name="wmode" >
                    <embed wmode="transparent" width="912" height="206"
                        type="application/x-shockwave-flash" 
                        pluginspage="http://www.macromedia.com/go/getflashplayer" 
                        quality="high" src="/upload/{$request->file}">
                </object>
            {else}
                <img src="/upload/banners/{$request->file}" />
                <input type="hidden" name="id" value="{$request->id}" />
            {/if}
        {/if}
        <br/><br/>
        <div class="red">Внимание: Для адекватного отображения баннера, он должен быть размером 921 на 207 пикселя</div>
        <div class="form-item">
			<label>Выберите файл</label>
			<input type="file" name="banner"  />
		</div>		
		<div>
			<input type="submit" value="Сохранить" />
		</div>
	</form>
</div>