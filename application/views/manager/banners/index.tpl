{include file='banners/inc/tabs.tpl'}
<form action="" method="POST">
    <div class="manager-content">
        <div class="manager-header">
            <img src="/images/admin/icons/settings.png" alt="" />
            <span>Баннеры</span>
        </div>
        <div class="text">            
            <input value="0" type="radio" name="bannerType" {if $settings->useFlashMainBanner != 1}checked="checked"{/if} />
            <label for="bannerType">Использовать баннеры картинки на главной странице</label>
        </div>
        {foreach from=$banners item=item}
        <div class="manager-list{cycle values=', gray-bg'}">
            <div class="manager-list-image">
                <img src="/images/admin/star.png" alt="" />
            </div>
            <div class="manager-list-content">
                <a href="/manager/banners/edit/id/{$item->id}/"><img height="38" src="/upload/banners/{$item->file}" /></a>&nbsp;&nbsp;&nbsp;
            </div>
            <div class="manager-list-controls">
                <a href="/manager/banners/edit/id/{$item->id}">
                    <img src="/images/admin/edit.png" alt="Редактировать" />
                </a>
                <a href="/manager/banners/delete/id/{$item->id}">
                    <img src="/images/admin/delete.png" alt="Удалить" />
                </a>
            </div>
        </div>
        {foreachelse}
        <div class="manager-list">
            <div class="manager-list-image">
                <img src="/images/admin/star-off.png" alt="" />
            </div>
            <div class="manager-list-content">
                Никаких баннеров нет.
            </div>
        </div>
        {/foreach}
        <br/>
        <br/>
        <br/>
        <div class="text">            
            <input value="1" type="radio" name="bannerType" {if $settings->useFlashMainBanner == 1}checked="checked"{/if} />
            <label for="bannerType">Использовать Flash баннер на главной странице</label>
        </div>
        {if $flashBanner}
        <div class="manager-list">
             <div class="manager-list-content">
                <a href="/manager/banners/edit/id/{$flashBanner->id}/">
                    <object width="912" height="206" 
                            codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" 
                            classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000">
                        <param value="/upload/{$bannerFlash->file}" name="movie">
                        <param value="high" name="quality" >
                        <param value="transparent" name="wmode" >
                        <embed wmode="transparent" width="912" height="206"
                            type="application/x-shockwave-flash" 
                            pluginspage="http://www.macromedia.com/go/getflashplayer" 
                            quality="high" src="/upload/{$flashBanner->file}">
                    </object>
                </a>&nbsp;&nbsp;&nbsp;
            </div>
            <div class="manager-list-controls">
                <a href="/manager/banners/edit/id/{$flashBanner->id}">
                    <img src="/images/admin/edit.png" alt="Редактировать" />
                </a>
                <a href="/manager/banners/delete/id/{$flashBanner->id}">
                    <img src="/images/admin/delete.png" alt="Удалить" />
                </a>
            </div>
        </div>
        {else}
        <div class="manager-list">
            <div class="manager-list-image">
                <img src="/images/admin/star-off.png" alt="" />
            </div>
            <div class="manager-list-content">
                Баннеров flash нет.
            </div>
        </div>
        {/if}
        <div>
			<input type="submit" value="Сохранить" />
		</div>
    </div>
</form>