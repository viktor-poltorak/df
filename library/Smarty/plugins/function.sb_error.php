<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {sb_error} render an error
 *
 * Type:     function<br>
 * Name:     sb_error<br>
 * Date:     Feb 24, 2003<br>
 * Purpose:  format HTML tags for the custon button<br>
 * Input:<br>
 *         - label = label
 *
 * @author   Alex Oleshkevich
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_sb_error($params, &$smarty)
{
    $text = array();
    $type = '';

	$errors = '';

	$text = $params['text'];

	if (!$text) {
		return false;
	}

	if (is_array($text)) {

		foreach ($text as $error) {
			$errors .= $error.'<br />';
		}

	} else {
		
		$errors .= $text;
		
	}
	
	return '
		<div class="error">
			'.$errors.'
		</div>
	';


}

/* vim: set expandtab: */

?>
