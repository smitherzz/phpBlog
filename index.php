<?php

error_reporting( E_ALL );
ini_set( "display errors", 1 );
include_once "models/Page_Data.class.php";
$pageData = new Page_Data();
$pageData->title = "PHP/MySQL blog demo example";
$pageData->addCSS("css/blog.css");


$dbInfo = "mysql:host=127.0.0.1; port=3306; dbname=simple_blog";
$dbUser = "root";
$dbPassword = "Cholate01";
$db = new PDO( $dbInfo, $dbUser, $dbPassword );
$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

$pageRequested = isset( $_GET['page'] );
$controller = "blog";
if ( $pageRequested ) {
  if ( $_GET['page'] === "search" ) {
    $controller = "search";
  }
}

$pageData->content .= include_once "views/search-form-html.php";
//$pageData->content .= include_once "controllers/blog.php";
$pageData->content .= include_once "controllers/$controller.php";

$page = include_once "views/page.php";
echo $page;
