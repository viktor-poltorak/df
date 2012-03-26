$(function () {

    $('#producer').bind('change', function(){
        var producerId = $(this).val();
        $.post('/manager/products/categories/id/' + producerId, function(data){
            $('#categories').html(data);
            $('#categories').attr('disabled', false);
        });

    });
    
})
