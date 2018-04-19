<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//Load Composer Dependencies
include_once __DIR__.'/vendor/autoload.php';

//Define constants
define('BOOTSTRAP_ASSETS_URI', 'vendor/twbs/bootstrap/dist/');


//Load Views
include_once 'views/header.php';
include_once 'views/page.php';
include_once 'views/footer.php';

