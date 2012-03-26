<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {html_paginate} function plugin
 *
 * File:       function.html_paginate.php<br>
 * Type:       function<br>
 * Name:       html_paginate<br>
 * Date:       24.Feb.2003<br>
 * Purpose:    Prints out a page navigation<br>
 * Input:<br>
 *           - paginate       (required) - object Paginate
 *           - count_pages       (optional) - int default "10"
 *           - text_link       (optional) - string default "page"
 *           - text_next     	 (optional) - string default "next"
 *           - text_previous     (optional) - string default "previous"
 *           - text_first     (optional) - string default "text_first"
 *           - text_last     (optional) - string default "text_last"
 *           - id     (optional) - string default null
 *           - class     (optional) - string default "smarty_pagination"
 * 
 * Examples:
 * <pre>
 * {html_paginate values=$ids output=$names}
 * </pre>
 * @link http://smarty.php.net/manual/en/language.function.html.checkboxes.php {html_paginate}
 *      (Smarty online manual)
 * @author     Christopher Kvarme <christopher.kvarme@flashjab.com>
 * @author credits to Monte Ohrt <monte at ohrt dot com>
 * @version    1.0
 * @param array
 * @param Smarty
 * @return string
 * @uses smarty_function_escape_special_chars()
 */
function smarty_function_html_paginate($params, &$smarty)
{
	$paginate = null;
    $count_pages = 10;
    $text_next = 'next';
    $text_prev = 'previous';
    $text_first = 'first';
    $text_last = 'last';
    $text_link = 'page';
    $id = null;
    $class = 'smarty_pagination';
    $custom_link = null;

    foreach($params as $_key => $_val) {
        switch($_key) {
            case 'paginate':
                $$_key = $_val;
                break;
        	
            case 'count_pages':
                $$_key = (int)$_val;
                break;

            case 'text_next':
                $$_key = $_val;
                break;

            case 'text_prev':
                $$_key = $_val;
                break;

            case 'text_first':
                $$_key = $_val;
                break;

            case 'text_last':
                $$_key = $_val;
                break;
                
            case 'text_link':
                $$_key = $_val;
                break;

            case 'id':
                $$_key = $_val;
                break;

            case 'class':
                $$_key = $_val;
                break;
                
            case 'custom_link':
                $$_key = $_val;
                break;

            default:
                break;
        }
    }

    if (isset($paginate)) {
            smarty_function_html_paginate_output($paginate, $text_link, $text_first, $count_pages, $text_last, $text_next, $text_prev, $class, $id, $custom_link);
    } 

}

function splitPage($url) {
	return preg_replace("/(&|\?|)\/".$text_link."\/[\d]\//",'', $url);
}

function smarty_function_html_paginate_output($paginate, $text_link, $text_first, $count_pages, $text_last, $text_next, $text_prev, $class, $id, $custom_link) {
	$paginate->url = splitPage($paginate->url);
	
	$count_pages = ($count_pages > $paginate->totalPages) ? $paginate->totalPages : $count_pages;

    if($paginate->first){
        if($custom_link) {
			echo '<a href="'.str_replace('%page', $paginate->first, $custom_link).'">'.$text_first.'</a>';
		} else {
			echo '<a href="'.$paginate->url.''.$text_link.'/'.$paginate->first.'/">'.$text_first.'</a>';
		}
    }

	if($paginate->previous) {
		if($custom_link) {
			echo '<a href="'.str_replace('%page', $paginate->previous, $custom_link).'">'.$text_prev.'</a>';
		} else {
			echo '<a href="'.$paginate->url.''.$text_link.'/'.$paginate->previous.'/">'.$text_prev.'</a>';
		}
	}
		
	if($paginate->current > floor($count_pages / 2)) {
		if($paginate->totalPages > $count_pages) {
			$from = $paginate->current - floor($count_pages / 2);
			if($paginate->current == $paginate->totalPages) {
				$from--;
			}
		} else {
			$from = 1;
		}
			
		$to = ceil($from + $count_pages) ;
		$to = ($to >= $paginate->totalPages) ? $paginate->totalPages : $to;
		
		$from = $from <= 0 ? 1 : $from;
		
	} else {
		$from = 1;
		$to = $count_pages;
	}
	
	for ($i = $from; $i <= $to; $i++) {
		
		if($i != $paginate->current) {
			if($custom_link) {
				echo ' <a href="'.str_replace('%page', $i, $custom_link).'">'.$i.'</a> ';
			} else {
				echo ' <a href="'.$paginate->url.''.$text_link.'/'.$i.'/">'.$i.'</a> ';
			}
		} else {
			echo ' <span class="smarty_paginate_current">'.$i.'</span> ';
		}

	}
		
	if($paginate->next) {
		if($custom_link) {
			echo ' <a href="'.str_replace('%page', $paginate->next, $custom_link).'">'.$text_next.'</a> ';
		} else {
			echo ' <a href="'.$paginate->url.''.$text_link.'/'.$paginate->next.'/">'.$text_next.'</a> ';
		}
	}

    if($paginate->last){
        if($custom_link) {
			echo ' <a href="'.str_replace('%page', $paginate->last, $custom_link).'">'.$text_last.'</a> ';
		} else {
			echo ' <a href="'.$paginate->url.''.$text_link.'/'.$paginate->last.'/">'.$text_last.'</a> ';
		}
    }
}