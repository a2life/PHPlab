<?php
/**
 * Created by JetBrains PhpStorm.
 * User: shared
 * Date: 11/20/12
 * Time: 10:23 PM
 * To change this template use File | Settings | File Templates.
 */
mb_regex_encoding ("UTF-8"); //prep to handle mb strings
mb_internal_encoding("UTF-8");//ditto
function findline($mbstring,$array){
    $c=count($array);
    $f=false;
    for ($i=0;!$f && $i<$c;$i++){
        mb_ereg_search_init($array[$i],$mbstring);
        $f=mb_ereg_search();
    }
    return --$i;
}