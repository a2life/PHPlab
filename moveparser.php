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
$match=array();
$src=<<<EOT
   1 ７六歩(77)   ( 0:00/00:00:00)
   2 ８四歩(83)   ( 0:00/00:00:00)
   3 ６八銀(79)   ( 0:00/00:00:00)
   4 ３四歩(33)   ( 0:00/00:00:00)
   5 ６六歩(67)   ( 0:00/00:00:00)
   6 ６二銀(71)   ( 0:00/00:00:00)
EOT;
 $pattern="(\d+)\s+(\w+)\((\d+)\)";
mb_ereg_search_init($src,$pattern);
$match=mb_ereg_search_regs();
var_dump($match);
