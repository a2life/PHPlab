<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 10032268
 * Date: 11/21/12
 * Time: 3:47 PM
 * To change this template use File | Settings | File Templates.
 *
 * try each or foreach to test out character conversion
*/
mb_internal_encoding("UTF-8");
mb_regex_encoding( "UTF-8" );
$src="";
include_once "inc/data2.inc.php";

$convert=array("1"=>"[１一]","2"=>"[二２]","3"=>"[三３]","4"=>"[四４]","5"=>"[五５]","6"=>"[六６]",
    "7"=>"[七７]","8"=>"[八８]","9"=>"[九９]","p"=>"歩","P"=>"と",'L'=>"成香","l"=>"香",'N'=>'成桂',
    'n'=>'桂','S'=>'成銀','s'=>'銀','r'=>'飛',"R"=>"[竜龍]","b"=>"角","B"=>"馬","k"=>"玉","g"=>"金",
    "xx"=>"同　","d"=>"打","Br"=>"\+","+"=>"成",
    ""=>"\(\s[\d/:]*\)"
);
/*
 * Because of order of character conversion is per the order of this array, it is important such as "+" value
 * comes before "+" key and "成香" $value comes before "香" $value etc.,
 * */
foreach($convert as $replacement=>$pattern){
    $src=mb_ereg_replace($pattern,$replacement,$src);
}

var_dump($src);