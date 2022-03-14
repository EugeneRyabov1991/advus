<?php
//---------------------------------------------------------------------------------------------------------------------
//
//  Записывает в базу данные в BID_SUBJ
//
//---------------------------------------------------------------------------------------------------------------------
//   Author: E. Ryabov
//   Date:   14.03.2022
//---------------------------------------------------------------------------------------------------------------------

include("../../db_connect.php");

$nId   = $_POST["id_record"];
$cNum = trim(htmlspecialchars($_POST["txtBidSubjNum"], ENT_QUOTES));
$cName = trim(htmlspecialchars($_POST["txtBidSubjName"], ENT_QUOTES));

$sSQL = "Update bid_subj Set num = '".$cNum."', name = '".$cName."' Where id = ".$nId." Limit 1";

if (!mysqli_query($link, $sSQL)) echo mysqli_error();

echo $sSQL;
