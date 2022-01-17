<?php
use booosta\Framework as b;
b::croot();
    
list($dummy, $scriptname, $params) = explode('/', $_SERVER['REQUEST_URI'], 3);

$found_scripts = glob("vendor/booosta/*/exec/$scriptname.php");
#print_r($found_scripts);

if(sizeof($found_scripts) > 1):
  b::debug("Found several $scriptname.php!";
  b::debug($found_scripts);
endif;

$script = $found_scripts[0];
if($script) require $script;
else require 'index.php';
