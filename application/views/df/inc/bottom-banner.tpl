{if $settings->bottomBanner != ''}
    {if $bottomBannerFlash}
        <object width="710" height="174" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000">
            <param value="/upload/{$settings->bottomBanner}" name="movie">
            <param value="high" name="quality" >
	    <param value="transparent" name="wmode" >
            <embed wmode="transparent" width="710" height="174" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" quality="high" src="/upload/{$settings->bottomBanner}">
        </object>
    {else}
        <img src="/upload/{$settings->bottomBanner}" alt="" />
    {/if}
{/if}