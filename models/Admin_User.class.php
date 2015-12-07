<?php

class Admin_User {

  public function __construct(){
    session_start();
  }

  private $loggedIn = false;

  public function isLoggedIn(){
    print "checking is logged in";
    $sessionIsSet = isset( $_SESSION['logged_in'] );
    if ( $sessionIsSet ){
      $out = $_SESSION['logged_in'];
    } else {
      $out = false;
    }
    return $out;
  }

  public function login(){
    print "logging in";
    $_SESSION['logged_in'] = true;
  }

  public function logout(){

    print "logging out";
    $_SESSION['logged_in'] = false;
  }
}

