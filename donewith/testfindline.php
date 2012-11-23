<?php
/**
 * Created by JetBrains PhpStorm.
 * User: dutch
 * Date: 11/22/12
 * Time: 6:33 PM
 * To change this template use File | Settings | File Templates.
 */

$init_data=""; $init_array=array();
include_once "inc/initdata.inc.php";
include_once "inc/findline.php";

$init_array=explode("\r\n",$init_data);
$c=count($init_array);
echo $c."\n";
$i= findline("hey you!",$init_array);
var_dump($i);