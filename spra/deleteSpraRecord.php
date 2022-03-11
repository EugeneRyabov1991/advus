<?php
/*--
//---------------------------------------------------------------------------------------------------------------------
//
//  Удаляем запись из справочника
//  Вызов из: js/spra.js
//
//---------------------------------------------------------------------------------------------------------------------
//   @Author: E. Ryabov
//   @Date:   23.06.2021
//---------------------------------------------------------------------------------------------------------------------
--*/

include("../db_connect.php");

  $cId = ((!isset($_POST["id_record"]))?"":$_POST["id_record"]);
  $cMode = $_POST["gcMode"];  // тип справочника

  if ($cId != ""){
    $cTableName = "";

    switch ($cMode) {
        case "USERS":
            $sTableName = "users";
            break;
        case "DOCS":
            $sTableName = "documents";
            break;
        case "INSURANCES":
            $sTableName = "insurances";
            break;
    }
    if ($sTableName != "") {
      if ($sTableName == "users"){ // /Перед удаление пользователя, чистим все его документы
          $sSQL = "DELETE FROM documents WHERE id_user='$cId'";
          mysqli_query($link, $sSQL);
          echo $sSQL;
      }
      $sSQL = "DELETE FROM $sTableName WHERE id='$cId' LIMIT 1";
      mysqli_query($link, $sSQL);
      echo $sSQL;
    }
  }
