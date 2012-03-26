{literal}
<script>
    function insertLink(e) {
        var linkEl = document.getElementById('link');
        var titleEl = document.getElementById('title');

        if(titleEl.value != ''){
            var linkValue = textToTranslit(titleEl.value);
            linkValue = linkValue.replace(/[^A-Za-z0-9]/g,'_');
            linkEl.value=linkValue+'.htm';

        } else {
             linkEl.value = "";
        }
    }

    function checkForm(){
        var linkEl = document.getElementById('link');
        var titleEl = document.getElementById('title');
        if (titleEl.value == '') {
            alert('Заголовок не может быть пустым.');
            return false;
        }
        if (!linkEl.value.match(/^[A-Za-z0-9_]*\.htm$/g)) {
            alert('Алиас должен содержать только латинские буквы, цифры и знак подчеркивания, алиас должен заканчиваться на ".html"');
            return false;
        }
        return true;
    }

    function textToTranslit(textar) {
        var rusLet = new Array("Э","Щ","Щ","Ч","Ч","Ш","Ш","Ё","Ё","Ё","Ё","Ю","Ю","Ю","Ю","Я","Я","Я","Я","Ж","Ж","А","Б","В","Г","Д","Е","З","ИЙ","ИЙ","ЫЙ","ЫЙ","И","Й","К","КС","Л","М","Н","О","П","Р","С","Т","У","Ф","Х","Ц","Щ","Ы","э","щ","ч","ш","ё","ё","ю","ю","я","я","ж","а","б","в","г","д","е","з","ий","ий","ый","ый","и","й","к","кс","л","м","н","о","п","р","с","т","у","ф","х","ц","щ","щ","ы","ъ","ъ","ь");
        var engReg = new Array('E',"Shch","Shch","Ch","Ch","Sh","Sh","YO","JO","Yo","Jo","YU","JU","Yu","Ju","YA","JA","Ya","Ja","ZH","Zh","A","B","V","G","D","E","Z","II","IY","YI","YY","I","J","K","X","L","M","N","O","P","R","S","T","U","F","H","C","W","Y","e'","shch","ch","sh","yo","jo","yu","ju","ya","ja","zh","a","b","v","g","d","e","z","ii","iy","yi","yy","i","j","k","x","l","m","n","o","p","r","s","t","u","f","h","c","w","#","y","`","~","'");

        if (textar) {
            for (i=0; i < engReg.length; i++){
                textar = textar.replace(rusLet[i], engReg[i]);
            }

            return textar;
        }
    }
</script>
{/literal}

{include file='pages/inc/tabs.tpl'}
<div class="manager-content">
    <div class="manager-header">
        <img src="/images/admin/icons/news.png" alt="" />
        <span>Добавление страницы</span>
    </div>
    <form action="/manager/pages/create/" method="post" class="form" autocomplete="off">
        <div class="form-item">
            <label>Заголовок (в красной закладке):</label>
            <input onkeyup="insertLink()" id="title" type="text" value="{$data->title}" name="title" />
        </div>
        <div class="form-item">
            <label>Подробное описание: <sup>*</sup>:</label>
            <input type="text" value="{$page->description|stripslashes}" name="description" />
        </div>
        <div class="form-item">
            <label>Ключевые слова:</label>
            <input type="text" value="{$page->keywords|stripslashes}" name="keywords" />
        </div>
        <div class="form-item">
            <label>Ссылка: <sup>*</sup></label>
            <input id="link" type="text" value="{$page->link}" name="link" />
        </div>
        <div class="form-item">
            <label>Текст:</label>
            <textarea id="tiny_mce" name="body">{$data->body|stripslashes}</textarea>
        </div>
        <div>
            <input onclick="return checkForm();" type="submit" value="Добавить" />
        </div>
    </form>
</div>