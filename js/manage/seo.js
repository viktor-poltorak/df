$(function () {
    $('[rel="img_alt"]').click(function(){
        id = $(this).attr('id').split('_');
        action = id[0];
        id = id[1];

        console.log(action);
        switch(action){
            case 'save' :
                saveItem(id);
                break;
            case 'edit' :
                switchToEdit(id);
                break;
        }
    });

    $('[id^="span_"]').bind('dblclick',function(){
        id = $(this).attr('id').split('_');
        action = id[0];
        id = id[1];
        switchToEdit(id);
    });

    function switchToEdit(id){
        var span = $('#span_'+id);
        var input = $('#input_'+id);
        var edit = $('#edit_'+id);
        var save = $('#save_'+id);

        span.hide();
        input.show();
        edit.parent().hide();
        save.parent().show();
    }


    function saveItem(id){
        var span = $('#span_'+id);
        var input = $('#input_'+id);
        var edit = $('#edit_'+id);
        var save = $('#save_'+id);

        span.html(input[0].value);

        span.show();
        input.hide();
        edit.parent().show();
        save.parent().hide();

        $.post('/manager/seo/save-img-alt',{
            "id": id,
            'text' : input[0].value
        }, function(){
            
            });
    }
})


function metaData(id){
    var idBlock = '#edit_block_' + id;
    if($(idBlock).css('display') != 'block'){
        $(idBlock).load('/manager/seo/get-meta', {
            'id':id
        }, function(){
            $(idBlock).show('slow');
        });
    } else {
        $(idBlock).hide('slow');
    }
}

function reloadBlock(id){
    var idBlock = '#edit_block_' + id;
    $(idBlock).load('/manager/seo/get-meta', {
        'id':id
    });
}

function deleteAllMetaData(id){
    $.post('/manager/seo/delete-all-meta-data',{
        "id": id
    }, function(){
        $('#metadata_'+id).remove();
    });
}

function deleteItemMetaData(parentId, id){
    $.post('/manager/seo/delete-item-meta-data',{
        "id": id
    }, function(){
        reloadBlock(parentId);
    });
}

function saveMetaData(parentId, id){
    var idBlock = '#edit_block_' + parentId;
    
    var name = $(idBlock + ' select[id="name_' + id +'"]').val();
    var content = $(idBlock + ' textarea[id="content_' + id +'"]').val();

    $.post('/manager/seo/save-meta',{
        "id": id,
        'name' : name,
        'content' : content
    }, function(){
        reloadBlock(parentId);
    });
}

function addMetaData(id){
    var idBlock = '#edit_block_' + id;
    var parentId = $(idBlock + ' input[id="new_parent_id_' + id +'"]').val();
    var name = $(idBlock + ' select[id="new_name_' + id +'"]').val();
    var content = $(idBlock + ' textarea[id="new_content_' + id +'"]').val();

    $.post('/manager/seo/add-meta',{
        "parentId": parentId,
        'name' : name,
        'content' : content
    }, function(){
        reloadBlock(id);
    });
}