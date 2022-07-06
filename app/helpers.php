<?php
/**
 * Created by PhpStorm.
 * User: aleks_new
 * Date: 05.07.2019
 * Time: 11:36
 */

/**
 * @param $text
 *
 * @return null|string|string[]
 */
function clearPhone($text) {
	return preg_replace('/[^\+0-9]/', '', $text);
}