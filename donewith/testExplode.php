<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 10032268
 * Date: 11/19/12
 * Time: 5:03 PM
 * To change this template use File | Settings | File Templates.
 * testing php explode function to see if it can explode and put multiple lines of text into arrays.
 * use of mbstring replace function to convert kanji kifu information to alpha numeric only psudo kifu code
 * that drawboard will recognize.
 */
mb_internal_encoding("UTF-8");
mb_regex_encoding( "UTF-8" );
$src="";
include_once "data2.inc.php"; /*
  * reassign $src
  */

$replacements=array();
$patterns=array();
$replacements[0]="1";$patterns[0]="[一１]";
$replacements[1]="2";$patterns[1]="[二２]";
$replacements[2]="3";$patterns[2]="[三３]";
$replacements[3]='4';$patterns[3]='[四４]';
$replacements[4]='5';$patterns[4]='[五５]';
$replacements[5]='6';$patterns[5]='[六６]';
$replacements[6]='7';$patterns[6]='[七７]';
$replacements[7]='8';$patterns[7]='[八８]';
$replacements[8]='9';$patterns[8]='[九９]';
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

for($i=0;$i<count($replacements);$i++)
   $src=mb_ereg_replace($patterns[$i],$replacements[$i],$src);


$array=explode("\n",$src);

if (isset($array)) {
    for ($i=0;$i<count($array);$i++)
    {
        /** @var $array string of kifu lines*/
        echo "$i :". $array[$i]."\n";
    }
}