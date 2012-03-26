<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {sb_button} function plugin
 *
 * Type:     function<br>
 * Name:     sb_button<br>
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
function smarty_function_sb_button($params, &$smarty)
{
    $label = 'SB button';
    $type = 'submit';
    $extra = '';
	$href = 'javascript:void(0)';

    foreach($params as $_key => $_val) {
        switch($_key) {
            case 'label':
            case 'type':
            case 'extra':
			case 'href':
			case 'image':

            default:
                break;
        }
    }

	if (!$params['type']) {
		$params['type'] = $type;
	}

	if (in_array($params['type'], array('submit', 'reset', 'button'))) {
		return '<button class="sb-button" type="'.(!$params['type'] ? 'submit' : $params['type']).'" '.$params['extra'].'>
					<span class="sb-button-left">
						<span class="sb-button-right">'.$params['label'].'</span>
					</span>
				</button>';
	} elseif ($params['type'] == 'image') {
		return '<a href="'.$params['href'].'" '.$params['extra'].' class="sb-image" style="background:url('.$params['image'].') no-repeat">
			<span class="sb-button-right">'.$params['label'].'</span>
			</a>
		';
	} elseif ($params['type'] == 'link') {
		return '<a href="'.$params['href'].'" '.$params['extra'].' class="sb-link-button">
			<span class="sb-button-right">'.$params['label'].'</span>
			</a>
		';
	}
}

/* vim: set expandtab: */

?>
