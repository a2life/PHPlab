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
 * in case of branch, then = will be replaced by J.  for instance "g+2837J16:３七銀成*comment added"
 *current 11/2012 drawboard wil only parse g+2837 and *comment potion
  * This snippet
 * 1. find comment line and divert to different handling
 * 2. find the start of movement record
 */
mb_internal_encoding("UTF-8");
mb_regex_encoding( "UTF-8" );
//$src="";
include_once "inc/findline.php";
include_once "inc/data2.inc.php"; // string variable $src is defined in separate file

$delim="手数----指手---------消費時間--";
$player1="先手：";
$player2="後手：";
$startDate="開始日時：";
$finishDate="終了日時：";
$version="#KIF";
$hc="手合割：";
$brCatcher="C------";
$moveNumber="^\s*\d*\s";
$convert=array("1"=>"[１一]","2"=>"[二２]","3"=>"[三３]","4"=>"[四４]","5"=>"[五５]","6"=>"[六６]",
    "7"=>"[七７]","8"=>"[八８]","9"=>"[九９]","p"=>"歩","P"=>"と",'L'=>"成香","l"=>"香",'N'=>'成桂',
    'n'=>'桂','S'=>'成銀','s'=>'銀','r'=>'飛',"R"=>"[竜龍]","b"=>"角","B"=>"馬","k"=>"玉","g"=>"金",
    "xx"=>"同　","d"=>"打","J"=>"\+","+"=>"成","x"=>"(投了|中断)","$brCatcher"=>"変化：",
    "-"=>"$moveNumber",
    ""=>"\(\s[\d/:]*\)"
);
$sniffer="[１２３４５６７８９同].*[歩と香桂銀金王玉飛竜龍角馬成打直引行]";



/*
 * Because of order of character conversion is per the order of this
 * array, it is important such as "+" value
 * comes before "+" key and "成香" $value comes before "香" $value etc.,
 * */

$srcArray=array();
$srcArray=explode($delim,$src);
/*$srcarray[0] contains header info.  $srcarray[1] contains kifu info */
function getHeaderInfo($key,$src){
    $i=findline($key,$src);
    if (isset($i))
    { $split=mb_split($key,$src[$i]);
    return $split[1];}
    else return false;
}
$headerArray=explode("\r\n",$srcArray[0]);
//split up by lines
$kifHeader['player1']=trim(getHeaderInfo($player1,$headerArray));
$kifHeader['player2']=trim(getHeaderInfo($player2,$headerArray));
$kifHeader['KIF info']=trim(getHeaderInfo($version,$headerArray));
$kifHeader['Start Date']=getHeaderInfo($startDate,$headerArray);
$kifHeader['Finish Date']=getHeaderInfo($finishDate,$headerArray);
$kifHeader['Handycap']=trim(getHeaderInfo($hc,$headerArray));



$moves=explode("\r\n",$srcArray[1]);


$c=count($moves);$i=0;
    for (++$i; $i<$c; $i++) {

        $pos=strpos($moves[$i],'*');
        if ($pos===false) {    //The line is not a comment. its either move or branch label
            $matches =array();
            $nMatches=array();
            $pMatches=array();



            mb_ereg($sniffer,$moves[$i],$matches);
            mb_ereg($moveNumber,$moves[$i],$nMatches);
         foreach($convert as $replacement=>$pattern){
             $moves[$i]=mb_ereg_replace($pattern,$replacement,$moves[$i]);
            }

            if (isset($nMatches[0])){

                if (trim($nMatches[0]) & 1 )$side="s"; else $side="g";
                $moves[$i]=$side.$moves[$i];
                mb_ereg("\+",$moves[$i],$pMatches);//check for promotion move
                if (isset($pMatches[0])){
                    $moves[$i]=mb_ereg_replace("\+","",$moves[$i]);
                    $moves[$i]=mb_ereg_replace("\-","+",$moves[$i]);
                    unset($pMatches);
                }
                mb_ereg("d",$moves[$i],$pMatches);//check for drop move
                if (isset($pMatches[0])){

                   $moves[$i]=mb_ereg_replace("d","",$moves[$i]);
                   $moves[$i]=mb_ereg_replace("-","d",$moves[$i]);
                    unset($pMatches);
                }
                mb_ereg('\(\d{2}\)\s*',$moves[$i],$pMatches);// detect (nn)=previous position info
                if (isset($pMatches[0])){
                    $moves[$i]=mb_ereg_replace(".\(","",$moves[$i]);// removes piece info (p,l etc.,) and opening paren.
                    $moves[$i]=mb_ereg_replace("\)\s*","",$moves[$i]);//remove closing paren and traiilng space.
                    unset($pMatches);

                }
                mb_ereg('xx',$moves[$i],$pMatches); //handle 同駒　move
                if (isset($pMatches[0])){
                    $moves[$i]=mb_ereg_replace("xx",$prevMove,$moves[$i]);
                    unset($pMatches);
                    }
               //$moves[$i]=mb_ereg_replace("\s+$","",$moves[$i]);
               // $moves[$i]=mb_ereg_replace("\s+J","J",$moves[$i]);

                $prevMove=substr($moves[$i],2,2); // remember 同駒　coordinate for next move.
                $moves[$i].=("=".trim($nMatches[0]));
                unset($nMatches);
            }
            if (isset($matches[0])) {$moves[$i].=":"; $moves[$i].=$matches[0];unset($matches);}
            else if (strpos($moves[$i],$brCatcher)!==false) {// in case of Jump, "同駒" movement handler
               $mvnm=array();
               mb_ereg("\d+",$moves[$i],$mvnm);// echo "tesu to catch is =".$mvnm[0]."\n";
               $flag=false;
               $mvnm[0]="=".$mvnm[0];// find =n+ format, which indicates tesuu

                for ($j=$i-1; ($j>0) & (!$flag);$j--){
                    $flag=mb_ereg($mvnm[0],$moves[$j]);
                }
               // echo "target move is :$moves[$j]";
                $prevMove=substr($moves[$j],2,2); //   echo "Prev move is".$prevMove."\n";
               $moves[$i]=substr_replace($moves[$i],$prevMove,2,2);

            }
            else { //a line that includes "投了" or "中断" will be reduced to a single character of "x"
                mb_ereg("x",$moves[$i],$pMatches);
                if (isset($pMatches[0])){
                    $moves[$i]="x";
                }

            }



            $moves[$i]=mb_ereg_replace("\s+","",$moves[$i]);

        }
    }
//$input = trim( preg_replace( '/\s+/', ' ', $input ) );
$movestring=implode("\n", $moves);
$pattern="(^\s+)|(\s+$)"; $replace=""; //trim mb string
$movestring=mb_ereg_replace($pattern,$replace,$movestring);


//remove blank lines
$pattern='\n+';
$replace="\n";
$movestring=mb_ereg_replace($pattern,$replace,$movestring);

//merge comment line, but will leave initial (move 0) comment as is.
$pattern='\n\*'; $replace="*";
$movestring=mb_ereg_replace($pattern,$replace,$movestring);

//surround with quote marks and add ',' delimiter
$moves=explode("\n",$movestring);
$movestring="\"".implode("\",\n\"",$moves);
var_dump($kifHeader);
var_dump($movestring);