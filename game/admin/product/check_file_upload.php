<?php
  defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
  defined('LOCAL_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));
  
  if ($_SERVER['REQUEST_METHOD'] !== 'POST')
  {
      echo "Request method must be POST.";
      die;
  }

  if (!isset($_FILES["fileupload"]))
  {
      echo "Unstructured data.";
      die;
  }

  if ($_FILES["fileupload"]['error'] != 0)
  {
    echo "Fail to upload data.";
    die;
  }

  $temp = explode(".", $_FILES["fileupload"]["name"]);
  $newfilename = round(microtime(true)) . '.' . end($temp);
  $target_dir    = LOCAL_PATH_ROOT."/game/img/game/".$newfilename;
  $target_file   = $target_dir . basename($_FILES["fileupload"]["name"]);

  $allowUpload   = true;

  $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

  $maxfilesize   = 800000;

  $allowtypes    = array('jpg', 'png', 'jpeg', 'gif');


  if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["fileupload"]["tmp_name"]);
      if($check !== false)
      {
          $allowUpload = true;
      }
      else
      {
          $allowUpload = false;
      }
  }

  if (file_exists($target_file))
  {
      echo "File exist in system, cannot override.";
      $allowUpload = false;
      die;
  }

  if ($_FILES["fileupload"]["size"] > $maxfilesize)
  {
      echo "Cannot upload image with size higher than $maxfilesize (bytes).";
      $allowUpload = false;
      die;
  }

  if (!in_array($imageFileType,$allowtypes ))
  {
      echo "Only upload with JPG, PNG, JPEG, GIF format.";
      $allowUpload = false;
      die;
  }


  if ($allowUpload)
  {
        echo "success";
  }
  else
  {
        echo "Unable to upload the file, maybe because the file is large, the file type is incorrect ...";
  }
?>