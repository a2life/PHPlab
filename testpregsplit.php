<?php
/**
 * Created by JetBrains PhpStorm.
 * User: dutch
 * Date: 11/22/12
 * Time: 6:02 PM
 * Testing Preg split to see if it can do the job
 */

/*
 * split multiple byte into array
*/
function mb_str_split( $string ) {
    # Split at all position not after the start: ^
    # and not before the end: $
    return preg_split('/(?<!^)(?!$)/u', $string );
}

$string   = '  1 ２六歩(27)   ( 0:00/00:00:00)';
$charlist = mb_str_split( $string );

var_dump($charlist);