<?php
/*--
//---------------------------------------------------------------------------------------------------------------------
//
//  Удаляем заявку
//
//---------------------------------------------------------------------------------------------------------------------
//   @Author: E. Ryabov
//   @Date:   11.09.18
//---------------------------------------------------------------------------------------------------------------------
--*/

include("../db_connect.php");

  $cId = ((!isset($_POST["id_record"]))?"":$_POST["id_record"]);

  if ($cId != ""){

      $sSQL = "DELETE FROM bids_user WHERE id_bid=$cId";
      mysqli_query($link, $sSQL);
      echo $sSQL;
      $sSQL = "DELETE FROM bids_subj WHERE id_bid=$cId";
      mysqli_query($link, $sSQL);
      echo $sSQL;
      $sSQL = "DELETE FROM bids WHERE id='$cId' LIMIT 1";
      mysqli_query($link, $sSQL);
      echo $sSQL;
  }
