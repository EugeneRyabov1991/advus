<?php
//---------------------------------------------------------------------------------------------------------------------
//
//  Записывает в базу данных значения, которые содержатся в форме редактирования страницы настроек
//
//---------------------------------------------------------------------------------------------------------------------
//   Author: E. Ryabov
//   Date:   04.12.2021
//---------------------------------------------------------------------------------------------------------------------

include("../db_connect.php");

$nId   = $_POST["id_record"];
$nLastBidId   = $_POST["txtLastBidId"];

$sSQL = "Update options Set maxIdDog = ".$nLastBidId." Where id = ".$nId." Limit 1";

if (!mysqli_query($link, $sSQL)) echo mysqli_error();

echo $sSQL;
