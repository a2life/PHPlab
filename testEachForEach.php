<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 10032268
 * Date: 11/21/12
 * Time: 3:47 PM
 * To change this template use File | Settings | File Templates.
 *
 * try each or foreach to test out character conversion

$replacements[9]="p";$patterns[9]="歩";
$replacements[10]="P";$patterns[10]="と";
$replacements[11]='L';$patterns[11]='成香';
$replacements[12]="l";$patterns[12]="香";
$replacements[13]='N';$patterns[13]='成桂';
$replacements[14]='n';$patterns[14]='桂';
$replacements[15]='S';$patterns[15]='成銀';
$replacements[16]='s';$patterns[16]='銀';
$replacements[17]='r';$patterns[17]='飛';
$replacements[18]="R";$patterns[18]="[竜龍]";
$replacements[19]="b";$patterns[19]="角";
$replacements[20]="B";$patterns[20]="馬";
$replacements[21]="k";$patterns[21]="玉";
$replacements[22]="g";$patterns[22]="金";
 */
mb_internal_encoding("UTF-8");
mb_regex_encoding( "UTF-8" );
$src="";
include_once "data2.inc.php";

$convert=["1"=>"[１一]","2"=>"[二２]","3"=>"[三３]","4"=>"[四４]","5"=>"[五５]","6"=>"[六６]",
    "7"=>"[七７]","8"=>"[八８]","9"=>"[九９]","p"=>"歩","P"=>"と",'L'=>"成香","l"=>"香",'N'=>'成桂',
    'n'=>'桂','S'=>'成銀','s'=>'銀','r'=>'飛',"R"=>"[竜龍]","b"=>"角","B"=>"馬","k"=>"玉","g"=>"金",
    "xx"=>"同　","d"=>"打","Br"=>"\+","+"=>"成",
    ""=>"\(\s[\d/:]*\)"
];
/*
 * Because of order of character conversion is per the order of this array, it is important such as "+" value
 * comes before "+" key and "成香" $value comes before "香" $value etc.,
 * */
foreach($convert as $replacement=>$pattern){
    $src=mb_ereg_replace($pattern,$replacement,$src);
}

var_dump($src);