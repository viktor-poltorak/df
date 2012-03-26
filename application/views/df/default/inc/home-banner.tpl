{if $settings->useFlashMainBanner == 0} 
    <script>
        {if $banners}
        var bannerData = {$banners};
        {else}
        var bannerData = {literal}{}{/literal};
        {/if}

        {literal}

        $(function () {
            $('#home-banners').agile_carousel({
                carousel_data: bannerData,
                carousel_outer_height: 210,
                carousel_height: 210,
                slide_height: 210,
                carousel_outer_width: 919,
                slide_width: 919,
                transition_type: "fade",
                timer: 4000
            });
        });
        {/literal}
    </script>
{/if}

<div class="home-banner">
    <table>
        <tr>
            <td><img src="/images/banner-top-left.png" alt="" /></td>
            <td class="banner-top-bg"></td>
            <td><img src="/images/banner-top-right.png" alt="" /></td>
        </tr>
        <tr>
            <td class="banner-left-bg"></td>
            <td class="banner-content">
                <div class="banner-image" id="home-banners">
                    {if $settings->useFlashMainBanner == 1 && $banners}                        
                        <object width="912" height="206" 
                                codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" 
                                classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000">
                            <param value="/upload/{$banners->file}" name="movie">
                            <param value="high" name="quality" >
                            <param value="transparent" name="wmode" >
                            <embed wmode="transparent" width="912" height="206"
                                type="application/x-shockwave-flash" 
                                pluginspage="http://www.macromedia.com/go/getflashplayer" 
                                quality="high" src="/upload/{$banners->file}">
                        </object>
                    {/if}
                </div>
                <div class="carousel-holder">
                    <a href="javascript:" id="carousel-prev"><img src="/images/button-prev.png" alt="" /></a>
                    <div class="carousel" id="carousel">
                        <ul class="scrolls">
                            {foreach from=$categoriesScroll item=cat}
                            <li class="carousel-item">
                                <div class="carousel-image">
                                    <a href="/catalog/category/id/{$cat->category_id}">
                                        {if $cat->image != ''}
                                        <img src="/images/categories/{$cat->image}" alt="{$cat->name}" />
                                        {else}
                                        <img src="/images/default100.gif" alt="{$cat->name}" />
                                        {/if}
                                    </a>
                                </div>
                                <div class="carousel-title">
                                    <a href="/catalog/category/id/{$cat->category_id}">{$cat->name}</a>
                                </div>
                            </li>
                            {/foreach}
                        </ul>
                    </div>
                    <a href="javascript:" id="carousel-next"><img src="/images/button-next.png" alt="" /></a>
                </div>
            </td>
            <td class="banner-right-bg"></td>
        </tr>
        <tr>
            <td><img src="/images/banner-bottom-left.png" alt="" /></td>
            <td class="banner-bottom-bg"></td>
            <td><img src="/images/banner-bottom-right.png" alt="" /></td>
        </tr>
    </table>
</div>