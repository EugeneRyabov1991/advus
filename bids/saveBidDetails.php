<?php
//---------------------------------------------------------------------------------------------------------------------
//
//  Записывает в базу данные в BID_DETAILS
//
//---------------------------------------------------------------------------------------------------------------------
//   Author: E. Ryabov
//   Date:   14.03.2022
//---------------------------------------------------------------------------------------------------------------------

include("../db_connect.php");

$nId   = $_POST["id_record"];

$cSubjName = trim(htmlspecialchars($_POST["txtBidSubject"], ENT_QUOTES));
$cP21  = trim(htmlspecialchars($_POST["txtBidP21"], ENT_QUOTES));
$cP22  = trim(htmlspecialchars($_POST["txtBidP22"], ENT_QUOTES));
$cP3  = trim(htmlspecialchars($_POST["txtBidP3"], ENT_QUOTES));
$cP4  = trim(htmlspecialchars($_POST["txtBidP4"], ENT_QUOTES));
$cP5  = trim(htmlspecialchars($_POST["txtBidP5"], ENT_QUOTES));
$cP6  = trim(htmlspecialchars($_POST["txtBidP6"], ENT_QUOTES));
$cP9  = trim(htmlspecialchars($_POST["txtBidP9"], ENT_QUOTES));

$sSQL = "Update bid_details Set subject = '".$cSubjName."', p21 = '".$cP21."', p22 = '".$cP22."', p3 = '".$cP3.
                            "', p4 = '".$cP4."', p5 = '".$cP5."', p6 = '".$cP6."', p9 = '".$cP9."' Where id_bid = ".$nId." Limit 1";

if (!mysqli_query($link, $sSQL)) echo mysqli_error();

//echo $sSQL;
