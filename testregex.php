<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 10032268
 * Date: 11/26/12
 * Time: 6:43 PM
 * Test regex expression and back reference?
 * To change this template use File | Settings | File Templates.
 */


$temp_input="-36C";
$rxPattern="^([-+]?[0-9]+)([CF])$";

$i=mb_ereg($rxPattern,$temp_input,$matches);
/*
 * what happens here is that the matches string itself is in $matches[0].  The  subexpression in the first () is in
 * $matches[1] and second () in $matches[2].
 * in the above example, "36c" is in $matches[0], "36", which matches ([0-9]+) is in $matches[1] and
 * "C" that mathces ([CF]) is in $matches[2]
*/
var_dump($matches);