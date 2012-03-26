<?php
/**
 *
 *Примеры:
 * {array('q', 'p1', 'p2', 'perpage' => 5)|get_query:'p'} — выведет строчку "?q=...&p1=...&p2=...&perpage=5", вместо троеточий будут текущие значения этих параметров.
 * {array('foo' => 'bar')|get_query:'ap'} — выведет все текущие параметры, установив параметр в «foo» в значение «bar».
 *
 * Дополнительный параметр с флагами режима:
 * «a» (от all) — сохранить все переданные get-параметры.
 * «p» (от plain) — использовать в качестве разделителя & а не &amp;
 *
 *
 * @param mixed $params
 * @param string $mode
 * @return string
 */
function smarty_function_get_query($params, &$smarty) {

    $mode = isset($params['mode']) ? $params['mode'] : '';

    $q = '';
    $all = strpos($mode, 'a') !== FALSE;
    $plain = strpos($mode, 'p') !== FALSE;
    $d = $plain?'&':'&amp;';

    if(isset($params['val'])){
        $params['params'][$params['var']] = (isset($params['val'])) ? $params['val'] : false;
    }

    $params = isset($params['params']) ? $params['params'] : array();
        
    if ($all) {
        $params = array_unique(array_merge(array_keys($_GET), $params));
    }

    foreach ($params as $k => $v) {
        $q .= is_int($k)
                ?(isset($_REQUEST[$v]) && (!array_key_exists($v, $params))?($q !== ''?$d:'?') . $v . '=' . urlencode($_REQUEST[$v]):'')
                :($v !== NULL?($q !== ''?$d:'?') . $k . '=' . urlencode($v):'')
        ;
    }
    return $q;
}
