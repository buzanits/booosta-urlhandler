<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';
use booosta\Framework as b;
b::croot();
 
list($dummy, $scriptname, $params) = explode('/', $_SERVER['REQUEST_URI'], 3);
#b::debug("scriptname: $scriptname, params: " . print_r($params, true));

$found_scripts = glob("vendor/booosta/*/exec/$scriptname.php");
#print_r($found_scripts);

if(sizeof($found_scripts) > 1):
  b::debug("Found several $scriptname.php!");
  b::debug($found_scripts);
endif;

$script = $found_scripts[0];
#b::debug("script: $script");
#print getcwd() . '<br>';

if($script) require $script;
elseif($scriptname == '') require 'index.php';
else print "Script not found: $scriptname";
