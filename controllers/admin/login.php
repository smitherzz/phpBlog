<?php

include_once "models/Admin_Table.class.php";

$loginFormSubmitted = isset( $_POST['log-in'] );

if ( $loginFormSubmitted ) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $adminTable = new Admin_Table($db);
  try {
    $adminTable->checkCredentials( $email, $password );
    $admin->login();
  } catch ( Exception $e) {
    //login failed
  }
}

$loggingOut = isset( $_POST['log-out'] );
if ( $loggingOut ){
  $admin->logout();
}

return $view;
