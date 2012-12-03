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
//mb_regex_set_options("sr"); // for the followign regex operation, period(.) should not recognize "\n"
include_once "inc/data.inc.php";
$xlationArray=array("1"=>"[１一]","2"=>"[二２]","3"=>"[三３]","4"=>"[四４]","5"=>"[五５]","6"=>"[六６]",
    "7"=>"[七７]","8"=>"[八８]","9"=>"[九９]","p"=>"歩","P"=>"と",'L'=>"成香","l"=>"香",'N'=>'成桂',
    'n'=>'桂','S'=>'成銀','s'=>'銀','r'=>'飛',"R"=>"[竜龍]","b"=>"角","B"=>"馬","k"=>"玉","g"=>"金",
    "00"=>"同　","d"=>"打","J"=>"\+","+"=>"成","x"=>"(投了|中断)","C"=>"変化：",
    );

$match=array();
//$pattern="(?:(\d+)\s+([\w\s]+)(?:\((\d+)\))?[ /():0-9]*(\+?))";
$header="手数----指手";
$pattern='(?:(\d+)\s+([\w\s]+)(?:\((\d+)\))?[ /():0-9]*(\+?))|(?:\n(?:\*)([\w\s]+))|(?:\n変化：[\w]+)';
$parsed="";
$movesLines="";
mb_ereg_search_init($src,$header);
mb_ereg_search(); //forward to the start of move list
mb_ereg_search_regs($pattern); //load regs with move parsing $pattern for the first time
do{
$match=mb_ereg_search_getregs();
if ($match[2]){ //
    $parsed="\n";
    $parsed.=(($match[1] & 1)?"s-":"g-");
$parsed.=(trim($match[2]).$match[3].$match[4]."=".$match[1]);
//echo $parsed;

foreach($xlationArray as $key=>$pat){
    $parsed=mb_ereg_replace($pat,$key,$parsed);
}
$parsed.=(":".trim($match[2]));
} else if ($match[5]) $parsed="*".$match[5];//regex is matching *comment line, the second alternate
  else $parsed=$match[0];//regex is matching the last catch all alternate so spit out as is

    $movesLines.=$parsed;
}
while(mb_ereg_search_regs());// until next result returns false. note that mb_ereg is caching $string and $pattern


$movesLines=mb_ereg_replace("J=","J",$movesLines); // replace = with J for jump point
$movesLines=mb_ereg_replace('(?<=\d\d)[pPlLnNsSgkrRbB](?=.?\d\d)',"",$movesLines); //remove piece info not needed for drawboard
$movesLines=mb_ereg_replace('-(..)\+','+\1',$movesLines); // s-nn+ => s+nn
$movesLines=mb_ereg_replace('-(...)d','d\1',$movesLines); // s-68sd => sd68s etc.,

var_dump($movesLines);
