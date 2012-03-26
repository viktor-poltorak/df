$(function () {

    $('#latest_tab').bind('click', function() {
        $('.tabs > li[class="selected"]').removeClass('selected');
        $(this).addClass('selected');
        $('.hp-catalog').hide();
        $('#latest').show();
    });

    $('#stock_tab').bind('click', function() {
        $('.tabs > li[class="selected"]').removeClass('selected');
        $(this).addClass('selected');
        $('.hp-catalog').hide();
        $('#stock').show();
    });

    $('#featured_tab').bind('click', function() {
        $('.tabs > li[class="selected"]').removeClass('selected');
        $(this).addClass('selected');
        $('.hp-catalog').hide();
        $('#featured').show();
    });

    $('#clear-search').bind('click', function () {
        $('#q').val('');
    });

    $('#by-category').bind('click', function () {
        $('#by-manufacturer-content').hide();
        $('#by-category-content').show();
        $('#by-manufacturer').attr('class', 'by-category');
        $(this).attr('class', 'by-manufacturer');
    });

    $('#by-category-content a').bind('click', function(){
        //Kostul i'm sorry
        var id = $(this).attr('rel');
        if(id == '') return;

        $('#by-category-content li').removeClass('target');
        $(this).parent().addClass('target');        
        $.get('/catalog/subcategory/id/' + id,{}, function(data){
            if(data.length > 0){
                $('#by-category-content li[class=target]').append(data);
            }
        })
    })

    $('#by-manufacturer').bind('click', function () {
        $('#by-category-content').hide();
        $('#by-manufacturer-content').show();
        $('#by-category').attr('class', 'by-category');
        $(this).attr('class', 'by-manufacturer');
    });

    $('#q').bind('keyup', function (){
        var val = $('#q').val();
        if(val.length > 3){
            $.get('/search/', {
                'q' : $('#q').val()
                } , function(data){
                if($.trim(data) != ''){
                    $('#autocomplete').html(data).show();
                } else {
                    $('#autocomplete').html('').hide();
                }
            });
        } else {
            $('#autocomplete').html('').hide();
        }
    });

    $('#autocomplete').bind('mouseleave', function(){
        setTimeout(function(){
            $('#autocomplete').empty().hide();
        }, 300);
    });

    $('#by-category-content').hide();

    $('#carousel').jCarouselLite({
        auto: 1,
        speed: 2000,
        mouseWheel: true,
        visible: 5,
        scroll: 1,
        btnNext: '#carousel-next',
        btnPrev: '#carousel-prev',
        stopOnMouse : true
    });
   
    $('a[rel*=facebox]').facebox();

});