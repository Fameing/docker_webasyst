<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once realpath(dirname(__FILE__).'/../').'/wa-system/autoload/waAutoload.class.php';
waAutoload::register();

class SystemConfig extends waSystemConfig
{
		
}