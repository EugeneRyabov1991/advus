<?php
/*--
//---------------------------------------------------------------------------------------------------------------------
//
//  Удаляем строку из состава заявки
//---------------------------------------------------------------------------------------------------------------------
//   @Author: E. Ryabov
//   @Date:   11.09.18
//---------------------------------------------------------------------------------------------------------------------
--*/

include("../../db_connect.php");

  $cId = ((!isset($_POST["id_record"]))?"":$_POST["id_record"]);

  if ($cId != ""){
      $sSQL = "DELETE FROM bid_subj WHERE id=$cId";
      mysqli_query($link, $sSQL);
      echo $sSQL;
  }
