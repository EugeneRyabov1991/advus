<?php
//---------------------------------------------------------------------------------------------------------------------
//
//  Записывает в базу данных значения, которые содержатся в форме редактирования записи о заявке
//
//---------------------------------------------------------------------------------------------------------------------
//   Author: E. Ryabov
//   Date:   18.11.2021
//---------------------------------------------------------------------------------------------------------------------

include("../db_connect.php");

$sSQL = "Select * From options Limit 1";
$crsOption = mysqli_query($link, $sSQL);
if ($rowOption = mysqli_fetch_array($crsOption)){
   $nId = $rowOption["id"];
   $lastBidId = $rowOption["maxIdDog"];
   $lastBidId++;

   $sSQL = "Update options Set maxIdDog = ".$lastBidId." Where id = ".$nId." Limit 1";
   if (!mysqli_query($link, $sSQL)) echo mysqli_error();

   $dogNum = "15".str_pad($lastBidId, 3, "0", STR_PAD_LEFT)."/21";

   echo $dogNum;
}
