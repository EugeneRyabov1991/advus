<?php
//---------------------------------------------------------------------------------------------------------------------
//
//  Записывает в базу данных состав исполнителей
//
//---------------------------------------------------------------------------------------------------------------------
//   Author: E. Ryabov
//   Date:   28.11.2021
//---------------------------------------------------------------------------------------------------------------------

include("../db_connect.php");

$nId   = $_POST["id_record"];

$sSQL = "Delete From bid_user Where id_bid = ".$nId;
mysqli_query($link, $sSQL);

$sSQL = "Select * From users";
$crsUsers = mysqli_query($link, $sSQL);
while ($rowUser = mysqli_fetch_array($crsUsers)){
    $nUserId = $rowUser["id"];
    if ($_POST["cmbBidRole".$nUserId]!=null){
        $sSQL = "Insert InTo bid_user (id_bid, id_user, role) Values ($nId, $nUserId, ".$_POST["cmbBidRole".$nUserId].") ";
        mysqli_query($link, $sSQL);
    }
}
