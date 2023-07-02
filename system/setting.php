<?php
spl_autoload_register(function ($class_name) {
    require_once "class/" . $class_name . ".php";
});

$sql = new SafeMySQL();
$filter = new Filter;
$site = new Site();
$times = new Times();
$user = new RegUser();