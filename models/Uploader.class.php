<?php

class Uploader {
  private $filename;
  private $fileData;
  private $destination;
  private $errorMessage;
  private $errorCode;

  public function __construct($key){
    $this->filename = $_FILES[$key]['name'];
    $this->fileData = $_FILES[$key]['tmp_name'];
    $this->errorCode = ( $_FILES[$key]['error'] );
  }

  public function readyToUpload(){
    $folderIsWriteAble = is_writeable ($this->destination);
    if ($folderIsWriteAble === false){
      $this->errorMessage = "Error: destination folder is ";
      $this->errorMessage .= "not writable, change permissions";
      $canUpload = false;
    } else if ($this->errorCode === 1) {
      $maxSize = ini_get( 'upload_max_filesize');
      $this->errorMessage = "Error: File is too big. i";
      $this->errorMessage .= "Max file size is $maxSize";
      $canUpload = false;
    } else if ($this->errorCode > 1) {
      $this->errorMessage = "Something went wrong!";
      $this->errorMessage .= "Error code: $this->errorCode";
      $canUpload = false;
    } else {
      $canUpload = true;
    }
    return $canUpload;
  }

  public function saveIn($folder){
    $this->destination = $folder;
  }

  public function save(){
    if ($this->readyToUpload()){
      move_uploaded_file(
        $this->fileData,
        "$this->destination/$this->filename" );
    } else {
      $exc = new Exception( $this->errorMessage );
      throw $exc;
    }
  }

}
