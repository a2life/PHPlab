<?php
/**
 * Created by JetBrains PhpStorm.
 * User: shared
 * Date: 11/19/12
 * Time: 9:57 PM
 * To change this template use File | Settings | File Templates.
 * prototype parser for  kifu file
 * step 1. parse header and store info into $headerInfo objects.
 * step 1a. identify initial comment and store it into $initialcomment
 * step 2. strip out header potion and blank lines
 * step 3. explode into each lines.
 * identify *comment line and dont touch during iteration of line array doing the below
 * step 3a. extract move potion such as ３七銀成　and temporary store  to $sashite
 * step 4. Do character conversions ３七銀成->37s+
 * step 4a. Do re-arrangement of string. for example,  "16 37s+(28)"->"g+2837"
 * concat $sashite with "=" prepended.  for example "16 g+2837"-> "g+2837=16:３七銀成, preserve tesuu as well.
 * step 5. tack comment line into previous move line: "g+2837=16:３七銀成"->"g+2837=16:３七銀成*comment added"
 * as a result, each move line should look like this
 * in case of branch, then = will be replaced by J.  for insance "g+2837J16:３七銀成*comment added"
 *current 11/2012 drawboard wil only parse g+2837 and *comment potion
  * This snippet
 * 1. find comment line and divert to different handling
 * 2. find the start of movement record
 */
include_once "findline.php";
include_once "data.inc.php"; // string variable $src is defined in separate file
$srcarray=array();
$srcarray=explode("\r\n",$src); //split up by lines
$c=count($srcarray); //$c is number of lines.

$i=findline("先手",$srcarray);
$split=mb_split("：",$srcarray[$i]);
$sentePlayer=$split[1];
$i=findline("後手",$srcarray);
$split=mb_split("：",$srcarray[$i]);
$GotePlayer=$split[1];


    $i=findline("手数----指手",$srcarray ); //find the start of movement records.

    for (++$i; $i<$c; $i++) {
        $pos=strpos($srcarray[$i],'*');
        if ($pos===false){
        echo $i." :".$srcarray[$i]."\n";}
        else echo $i."pos=$pos ***:".$srcarray[$i]."\n";
    }
echo $sentePlayer."\n";
echo $GotePlayer."\n";

