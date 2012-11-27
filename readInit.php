<?php
/**
 * Created by JetBrains PhpStorm.
 * User: shared
 * Date: 11/20/12
 * Time: 10:26 PM
 * To change this template use File | Settings | File Templates.
 * This file will find kifu position data and parse
 */
//$init_data=""; $init_array=array();
include_once "inc/initdata.inc.php";
include_once "inc/findline.php";
$convertArray=array("p"=>"歩","P"=>"と",'L'=>"成香|杏","l"=>"香",'N'=>'成桂|圭',
    'n'=>'桂','S'=>'成銀|全','s'=>'銀','r'=>'飛',"R"=>"[竜龍]","b"=>"角","B"=>"馬","k"=>"玉","g"=>"金",","=>"\s");
$boardMarker="９ ８ ７ ６ ５ ４ ３ ２ １";
$senteOnHand="\n先手の持駒：(\w*)\s*\n";
$goteOnHand= "\n後手の持駒：(\w*)\s*\n";
$onHands=array();
if(mb_ereg($senteOnHand,$init_data,$onHands)!=false)$senteOnHand=$onHands[1];
if(mb_ereg($goteOnHand,$init_data,$onHands)!=false)$goteOnHand=$onHands[1];

$init_array=explode("\r\n",$init_data);
$i= findline($boardMarker,$init_array);
if ($i==true){ //the string contains board chart

    $i=$i+2;  //starting row of 局面　info
$j=$i+9;  //ending row of 局面　info
 for ($n=$i;$n<$j;$n++){
    $m= mb_strlen($init_array[$n]);
     for($k=0;$k<$m;$k++){
         echo "($k):".mb_substr($init_array[$n],$k,1)."|";
     }
     echo "\n";
 }
$senteOnBoard=""; $goteOnBoard="";
for ($row=$i;$row<$j;$row++){
    //$columnLength=mb_strlen($init_array[$row]);
    for ($k=2;$k<19;$k=$k+2){
        $masu=mb_substr($init_array[$row],$k,1);
        if ($masu!="・"){
            $colRow=($k/2).($row-$i+1);
            $side=mb_substr($init_array[$row],$k-1,1);

            switch($side){
                 case " "://This is Sente's piece
                     $senteOnBoard.=$colRow;
                     $senteOnBoard.=$masu;
                     $senteOnBoard.=" ";
                     break;
                 case "v"://this is Gote's piece
                     $goteOnBoard.=$colRow;
                     $goteOnBoard.=$masu;
                     $goteOnBoard.=" "
                     ;break;
            }
        }
    }
}

    $senteOnBoard=trim($senteOnBoard);
    $goteOnBoard=trim($goteOnBoard);

foreach ($convertArray as $replacement=>$pattern){
    $senteOnBoard=mb_ereg_replace($pattern,$replacement,$senteOnBoard);
    $goteOnBoard=mb_ereg_replace($pattern,$replacement,$goteOnBoard);
}

var_dump($senteOnBoard);
var_dump($goteOnBoard);
}var_dump($senteOnHand);
var_dump($goteOnHand);