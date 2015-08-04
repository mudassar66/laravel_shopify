<?php 
session_start();

define("BASE_PATH","https://simpshopifyapps.com/pay-what-you-want/");

define("ASSETS_PATH",BASE_PATH."assets/");
define("CSS_PATH",BASE_PATH."assets/css/");
define("JS_PATH",BASE_PATH."js/");

define("SUPPORT_EMAIL","hansentaurus07@gmail.com"); 

define("DB_HOST","localhost:3306"); 
define("DB_NAME","amit2612_pwyw");
define("DB_USER_NAME","amit2_pwyw");
define("DB_USER_PASSWORD","q5Ab?t27"); 

$link = mysql_connect(DB_HOST,DB_USER_NAME,DB_USER_PASSWORD) or die("Error " . mysqli_error($link)); 

mysql_select_db(DB_NAME);

?>