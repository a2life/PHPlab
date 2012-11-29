<?php
/**
 * Created by JetBrains PhpStorm.
 * User: shared
 * Date: 11/29/12
 * Time: 12:24 AM
 * how to sniff out comment line
 *
 */
mb_regex_encoding("UTF-8");
mb_regex_set_options("sr"); //recognize \n from .
include_once "inc/data.inc.php";

$pattern="(?:(\d+)\s+([\w\s]+)(?:\((\d+)\))?[ /():0-9]*(\+?))|(?:\n(\*)[\w\s]+)";

mb_ereg_search_init($src,$pattern);


var_dump(mb_ereg_search_regs());
var_dump(mb_ereg_search_regs());
