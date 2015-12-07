<?php

include_once "models/Blog_Entry_Table.class.php";
$blogTable = new Blog_Entry_Table( $db );

$searchOutput = "";

if ( isset($_POST['search_term']) ){
  $searchTerm = $_POST['search-term'];
  $searchData = $blogTable->searchEntry( $searchTerm );
  $searchOutput = include_once "views/search-results-html.php";
}

return $searchOutput;
