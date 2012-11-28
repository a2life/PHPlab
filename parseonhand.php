<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 10032268
 * Date: 11/28/12
 * Time: 11:05 AM
 * routine to parse the onhand piece information
 */
mb_regex_encoding("UTF-8");
$onHand="角二　歩＋二 銀三　金　";//sample string, note this will only work the number up to 9
var_dump($onHand);
$patterns=array("10"=>"＋\s","1"=>"[１一＋]","2"=>"[二２]","3"=>"[三３]","4"=>"[四４]","5"=>"[五５]","6"=>"[六６]","7"=>"[七７]","8"=>"[八８]","9"=>"[九９]",
    "p"=>"歩","l"=>"香",'n'=>'桂','s'=>'銀','r'=>'飛',"b"=>"角","g"=>"金");

    foreach ($patterns as $replace=>$pattern){
        $onHand=mb_ereg_replace($pattern,$replace,$onHand);
    }
var_dump($onHand);
//testing string repeat function
$regs=array();
$hands="";
$pattern="([plnsgrb])(\d*)";
mb_ereg_search_init($onHand,$pattern);
    while (mb_ereg_search()){
        $regs=mb_ereg_search_getregs();
        $hands.=($regs[2]?str_repeat($regs[1],$regs[2]):$regs[1]);//if more than one, pieces are multiplied here.
    }
$regs=str_split($hands);
$onHand=implode(",",$regs);
var_dump($onHand);
