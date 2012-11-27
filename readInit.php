<?php
/**
 * Created by JetBrains PhpStorm.
 * User: shared
 * Date: 11/20/12
 * Time: 10:26 PM
 * To change this template use File | Settings | File Templates.
 * This file will find kifu position data and parse
 */
$init_data=""; $init_array=array();
include_once "inc/initdata.inc.php";
include_once "inc/findline.php";

$init_array=explode("\r\n",$init_data);
$c=count($init_array);
echo $c."\n";
$i= findline("９ ８ ７ ６ ５ ４ ３ ２ １",$init_array);
if ($i==true){
$i=$i+2;  //start of 局面　info
$j=$i+9;  //end of 局面　info
 for ($n=$i;$n<$j;$n++){
    $m= mb_strlen($init_array[$n]);
     for($k=0;$k<$m;$k++){
         echo "($k):".mb_substr($init_array[$n],$k,1)."|";
     }
     echo "\n";
 }
$SenteOnBoard=""; $goteOnBoard="";
for ($row=$i;$row<$j;$row++){
    //$columnLength=mb_strlen($init_array[$row]);
    for ($k=2;$k<19;$k=$k+2){
        $masu=mb_substr($init_array[$row],$k,1);
        if ($masu!="・"){
            $colRow=($k/2).($row-$i+1);
            $side=mb_substr($init_array[$row],$k-1,1);

            switch($side){
                 case " ": $SenteOnBoard.=$colRow; $SenteOnBoard.=$masu; $SenteOnBoard.=" "; break;
                 case "v": $goteOnBoard.=$colRow; $goteOnBoard.=$masu;$goteOnBoard.=" ";break;
            }
        }
    }
}

var_dump($SenteOnBoard);
var_dump($goteOnBoard);
}