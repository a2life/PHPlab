<?php
/**
 * Created by JetBrains PhpStorm.
 * User: shared
 * Date: 11/27/12
 * Time: 7:50 PM
 * Test of mb_ereg_init to see if initial setup parameter persist
 * the string is already parsed to the point of match. therefore, consequent attempt to find the pattern prior to the
 * match point will return false.
 */
mb_regex_encoding("UTF-8");
include_once "inc/data3.inc.php";
$match=array();$kifinfo=array();
$patterns=array("gotePlayer"=>"後手：(.*)(?=$)","goteOnHand"=>"後手の持駒：(.*)\n",
    "board"=>"\-\+\s+((.*\s+)+)\+","sentePlayer"=>"先手：(.*)\n","senteOnHand"=>"先手の持駒：(.*)\n",
    "tesuu"=>"手数＝(\d+)","move"=>"(\w+)");
mb_regex_set_options("r");
 mb_ereg_search_init($src);
foreach($patterns as $key=>$pattern ){
$match=mb_ereg_search_regs($patterns[$key]);
$kifinfo[$key]=trim($match[1]);
}

    var_dump ($kifinfo);


