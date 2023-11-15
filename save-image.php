<?php

$email=$_GET["email"];
$savedEmail=$email."."."jpg";

define("ALLOWED_SIZE",   2097152);    // CHANGE ALLOWED SIZE AS YOUR NEED
define("SAVED_DIRECTORY", "images/"); // CHANGE SAVED DIRECTORY AS YOUR NEED

$allowed_extensions = array("jpeg", "jpg", "png"); // CHANGE allowed extension AS YOUR NEED

if(isset($_FILES['image'])){
  $errors = array();

  $uploaded_file_name = $_FILES['image']['name'];
  $uploaded_file_size = $_FILES['image']['size'];
  $uploaded_file_tmp  = $_FILES['image']['tmp_name'];
  $uploaded_file_type = $_FILES['image']['type'];

  $file_compositions = explode('.', $uploaded_file_name);
  $file_ext = strtolower(end($file_compositions));
  
  $saved_file_name = $savedEmail; // CHANGE FILE NAME AS YOUR NEED

  if(in_array($file_ext, $allowed_extensions) === false)
    $errors[] = 'Extension not allowed, please choose a JPEG or PNG file';

  if($uploaded_file_size > ALLOWED_SIZE)
    $errors[] = 'File size is too big';

  if(empty($errors) == true) { // if no error, uploaded image is valid
    move_uploaded_file($uploaded_file_tmp, SAVED_DIRECTORY . $saved_file_name);
    header("location: index.php");
  } else {
    header("location: error.php");
  }
}
?>
