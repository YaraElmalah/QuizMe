<?php
    
    //Routes
    $templates = 'includes/templates/';
    $func      = 'includes/functions/';
    $css  = 'layout/css/';
    $js  = 'layout/js/';
    //Include The Important Files
    include 'connect.php';
    include $func      . 'functions.php';
    include $templates . 'header.php';
    ini_set("max_execution_time", 360);
