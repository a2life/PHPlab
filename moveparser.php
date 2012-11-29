<?php
/**
 * Created by JetBrains PhpStorm.
 * User: shared
 * Date: 11/27/12
 * Time: 10:25 PM
 * To change this template use File | Settings | File Templates.
 * further tinkering of move parser
 *
 *
 */
mb_regex_encoding("UTF-8");
mb_regex_set_options("sr"); //recognize \n from .
include_once "inc/data.inc.php";
$xlationArray=array("1"=>"[１一]","2"=>"[二２]","3"=>"[三３]","4"=>"[四４]","5"=>"[五５]","6"=>"[六６]",
    "7"=>"[七７]","8"=>"[八８]","9"=>"[九９]","p"=>"歩","P"=>"と",'L'=>"成香","l"=>"香",'N'=>'成桂',
    'n'=>'桂','S'=>'成銀','s'=>'銀','r'=>'飛',"R"=>"[竜龍]","b"=>"角","B"=>"馬","k"=>"玉","g"=>"金",
    "00"=>"同　","d"=>"打","J"=>"\+","+"=>"成","x"=>"(投了|中断)","C"=>"変化：",
    );

$match=array();
$pattern="(\d+)\s+([\w\s]+)(?:\((\d+)\))?[ /():0-9]*(\+?)";
$parsed="";$parsedlines="";
mb_ereg_search_init($src,$pattern);
while (mb_ereg_search()){
$match=mb_ereg_search_getregs();
$parsed=(($match[1] & 1)?"s-":"g-");
$parsed.=(trim($match[2]).$match[3].$match[4]."=".$match[1]);
echo $parsed;

foreach($xlationArray as $key=>$pat){
    $parsed=mb_ereg_replace($pat,$key,$parsed);
}
$parsed.=(":".$match[2]."\n");
    $parsedlines.=$parsed;
}
$parsedlines=mb_ereg_replace("J=","J",$parsedlines); // replace = with J for jump point
$parsedlines=mb_ereg_replace("(?<=\d\d)[pPlLnNsSgkrRbB](?=.?\d\d)","",$parsedlines); //remove piece info (not needed for drawboard)
$parsedlines=mb_ereg_replace("-(..)\+","+\\1",$parsedlines); // s-nn+ => s+nn
$parsedlines=mb_ereg_replace("-(...)d","d\\1",$parsedlines); // s-68sd => sd68s etc.,
//$parsedlines=mb_ereg_replace("(")
var_dump($parsedlines);
