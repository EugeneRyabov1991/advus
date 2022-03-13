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

$cFSO07 = ($_POST["chkDoc7"] == "on" ? 1 : 0);
$cFSO08 = ($_POST["chkDoc8"] == "on" ? 1 : 0);
$cFSO09 = ($_POST["chkDoc9"] == "on" ? 1 : 0);
$cFSO10 = ($_POST["chkDoc10"] == "on" ? 1 : 0);
$cFSO11 = ($_POST["chkDoc11"] == "on" ? 1 : 0);
$cFSO12 = ($_POST["chkDoc12"] == "on" ? 1 : 0);
$cFSO13 = ($_POST["chkDoc13"] == "on" ? 1 : 0);

$sSQL = "Update bid_details Set subject = '".$cSubjName."', p21 = '".$cP21."', p22 = '".$cP22."', p3 = '".$cP3.
                            "', p4 = '".$cP4."', p5 = '".$cP5."', p6 = '".$cP6."', p9 = '".$cP9."', ".
                            "fso7 = ".$cFSO07.", "."fso8 = ".$cFSO08.", "."fso9 = ".$cFSO09.", ".
                            "fso10 = ".$cFSO10.", "."fso11 = ".$cFSO11.", "."fso12 = ".$cFSO12.", "."fso13 = ".$cFSO13.
                            " Where id_bid = ".$nId." Limit 1";

if (!mysqli_query($link, $sSQL)) echo mysqli_error();

//echo $sSQL;
