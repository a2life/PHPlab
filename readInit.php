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
$i=$i+2; echo $i."\n";
$j=$i+9; echo $j."\n\n";
 for ($n=$i;$n<$j;$n++){
    $m= mb_strlen($init_array[$n]);
     for($k=0;$k<$m;$k++){
         echo "($k):".mb_substr($init_array[$n],$k,1).":";
     }
     echo "\n";
 }
