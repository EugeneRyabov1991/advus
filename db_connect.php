<?php

//===  LocalHost ========================================================
 $hostName = "localhost";
 $userName = "root";
 $password = "";
 $databaseName = "advus";

//===  RealHosting   ===================================================
// $hostName = "smor.mysql";
//$databaseName = "smor_4";
//$userName = "dbu_smor_2";
//$password = "sGuVpA129ke";
//=======================================================================

if (!($link=mysqli_connect($hostName,$userName,$password))) {
    printf("Не могу подключиться к серверу!!!\n");
    exit();
}

if (!mysqli_select_db($link, $databaseName)) {
    printf("Не могу подключиться к БД!!!");
    exit();
}
mysqli_query($link, "SET NAMES utf8");
?>
