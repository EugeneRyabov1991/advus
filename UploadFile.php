<?php

  $uploaddir = '../pics/';

  $nId = ((!isset($_POST["id_doc"]))?"0":$_POST["id_doc"]);
  $cType = ((!isset($_POST["type"]))?"":$_POST["type"]);
  $cPictureType = ((!isset($_POST["cmbPictureType"]))?"":$_POST["cmbPictureType"]);

  include("db_connect.php");

  if ($cType == "PICTURE_GROUP"){
      $cUploadDir = "../images/upload/";
      $dDate = date('Y-m-d');

      for ($i = 1; $i <= 9; $i++) {
          // Сначала делаем уменьшенную фотку ...
          $cControlName="txtFile".$i;
          if ($_FILES[$cControlName]['tmp_name'] != ""){
              $sSQL="INSERT INTO pictures () Values ()";
              if (!mysql_query($sSQL)) echo mysql_error();
              $nMaxId = mysql_insert_id();

              // ... А потом копируем полноразмерную
              $cNewFileName = "pict".$nMaxId.".jpg";

              if (!move_uploaded_file($_FILES[$cControlName]['tmp_name'], $cUploadDir.$cNewFileName)) {
                  echo "Ошибка копирования файла:".$_FILES[$cControlName]['name'];
              }else{
                  $sSQL="UPDATE `pictures` SET `url`='$cNewFileName', `type`=$cPictureType , `dt`='$dDate'  WHERE `id`=".$nMaxId;
                  if (!mysql_query($sSQL)) echo mysql_error();
              }
          }
      }
      header("Location: ".$_SERVER['HTTP_REFERER']);
  }else if ($cType == "DOCUMENT_GROUP"){
      $cUploadDir = "../documents/";
      $dDate = date('Y-m-d');
      for ($i = 1; $i <= 9; $i++) {
          // Сначала делаем уменьшенную фотку ...
          $cControlName="txtFile".$i;
          if ($_FILES[$cControlName]['tmp_name'] != ""){
              $sSQL="INSERT INTO documents () Values ()";
              if (!mysql_query($sSQL)) echo mysql_error();
              $nMaxId = mysql_insert_id();
              // ... А потом копируем полноразмерную
              $cNewFileName =$_FILES[$cControlName]['name'];

              if (!move_uploaded_file($_FILES[$cControlName]['tmp_name'], $cUploadDir.$cNewFileName)) {
                  echo "Ошибка копирования файла:".$_FILES[$cControlName]['name'];
              }else{
                  $sSQL="UPDATE `documents` SET `url`='$cNewFileName', `name`='!!! Новый документ !!!' , `dt`='$dDate'  WHERE `id`=".$nMaxId;
                  if (!mysql_query($sSQL)) echo mysql_error();
              }
          }
      }
      header("Location: ".$_SERVER['HTTP_REFERER']);
  }else if ($cType == "EVENT_DOCS")                            {  // Загрузка общих документов компании и сотрудников
    // Подгружаем фон заголовка сайта
	  $cControlName="txtFile1";
      if (!is_dir("uploads")) if (!mkdir("uploads")) echo("ОШИБКА!!! Не могу создать каталог [uploads]");
	  if ($_FILES['txtFile1']['tmp_name'] != "") {
          $cNewFileName = "Doc$nId." . getFileExtension($_FILES['txtFile1']['name']);
          if (!move_uploaded_file($_FILES['txtFile1']['tmp_name'], "uploads/" . $cNewFileName)) {
              echo "Ошибка копирования файла:" . $_FILES['txtFile1']['name'];
          } else {
              $sSQL = "UPDATE documents SET file_name='$cNewFileName' WHERE id=" . $nId;
              if (!mysqli_query($link, $sSQL)) echo mysqli_error($link);
          }
          echo($cNewFileName);
      }else{
          echo("");
	  }

  }else{
    if ($cType==2){  /*загрузка картинок на обложку*/
	  if ($_FILES['txtFile1']['tmp_name'] != ""){

        $cNewSmallFileName = "spec".$nId."s.jpg";     
        $tmpname  = $_FILES['txtFile1']['tmp_name'];
        if (!@img_resize($tmpname, 100, "", $uploaddir.$cNewSmallFileName)) {
          echo "Ошибка копирования  маленького файла:".$tmpname."|".$uploaddir.$cNewSmallFileName;
        }else{
          $sSQL="UPDATE `UNI_SPEC` SET `pic`='$cNewSmallFileName' WHERE `id`=".$nId." LIMIT 1";
          if (!mysql_query($sSQL)) echo mysql_error();
        }
	  }
      header("location: index.php?op=main&subop=PAGE_SPECEDIT&id=$nId");
    }else{
/* Загрузка фотогалереи */
      if ($cType == 3){
          for ($i=1; $i<=5; $i++) {
              // Сначала делаем уменьшенную фотку ...
              $cControlName="txtFile".$i;
              if ($_FILES[$cControlName]['tmp_name'] != ""){
                  $sSQL="INSERT INTO `UNI_LOOKBOOK` () Values ()";
                  if (!mysql_query($sSQL)) echo mysql_error();
                  $nMaxId = mysql_insert_id();

                  $cNewSmallFileName = "photo".$nMaxId."s.jpg";
                  $tmpname  = $_FILES[$cControlName]['tmp_name'];
                  if (!@img_resize($tmpname, 162, "", $uploaddir."lookbook/".$cNewSmallFileName)) {
                      echo "Ошибка копирования  маленького файла:".$tmpname."|".$uploaddir."lookbook/".$cNewSmallFileName;
                  }else{
                      $sSQL="UPDATE `UNI_LOOKBOOK` SET `pic_s`='$cNewSmallFileName', `num`=$nMaxId WHERE `id`=".$nMaxId;
                      if (!mysql_query($sSQL)) echo mysql_error();
                  }
                  // ... А потом копируем полноразмерную
                  $cNewLargeFileName = "photo".$nMaxId."l.jpg";
/*                  if (!@img_resize($tmpname, 1500, "", $uploaddir."lookbook/".$cNewLargeFileName)){*/
                  if (!move_uploaded_file($_FILES[$cControlName]['tmp_name'], $uploaddir."lookbook/".$cNewLargeFileName)) {
                      echo "Ошибка копирования файла:".$_FILES[$cControlName]['name'];
                  }else{
                      $sSQL="UPDATE `UNI_LOOKBOOK` SET `pic_l`='$cNewLargeFileName' WHERE `id`=".$nMaxId;
                      if (!mysql_query($sSQL)) echo mysql_error();
                  }
              }

          }
          header("location: index.php?op=main&subop=PAGE_LOOKBOOK");
      }else{
      }
    }
  }


  function getFileExtension($cFileName_)
  {
      $nOffset = strrpos($cFileName_, ".")+1;
      return substr($cFileName_, $nOffset);
  }


?>