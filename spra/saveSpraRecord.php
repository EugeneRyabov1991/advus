<?php
//---------------------------------------------------------------------------------------------------------------------
//
//  Записывает в базу данных значения, которые содержатся в форме редактирования
//
//---------------------------------------------------------------------------------------------------------------------
//   Author: E. Ryabov
//   Date:   23.06.21
//---------------------------------------------------------------------------------------------------------------------

include("../db_connect.php");

$cIdUser = $_POST["gnCurrentUserId"];  /** @var INTEGER $cIdUser */
$cMode = $_POST["gcMode"];             /** @var STRING $cMode */
$nIdRecord = $_POST["id_record"];      /** @var INTEGER  $nIdRecord */
$cName = trim(htmlspecialchars($_POST["txtName"], ENT_QUOTES));

if ($cMode == "HOUSES") {
  $cAddress = trim(htmlspecialchars($_POST["txtAddress"], ENT_QUOTES));
  $sSQL = "Update houses Set name = '" . $cName . "',  address = '" . $cAddress . "' Where id = " . $nIdRecord . " Limit 1";

}else if ($cMode == "DOCS"){
    $cName  = trim(htmlspecialchars($_POST["txtName"], ENT_QUOTES));
    $sSQL = "Update documents Set caption = '".$cName."' Where id = ".$nIdRecord." Limit 1";
}else if ($cMode == "USERS") {

    $cLogin  = trim(htmlspecialchars($_POST["txtLogin"], ENT_QUOTES));
    $cName   = trim(htmlspecialchars($_POST["txtName"], ENT_QUOTES));
    $cPhone  = trim(htmlspecialchars($_POST["txtPhone"], ENT_QUOTES));
    $cEMail  = trim(htmlspecialchars($_POST["txtEMail"], ENT_QUOTES));
    $cSRO  = trim(htmlspecialchars($_POST["txtSRO"], ENT_QUOTES));
    $cInsurance  = trim(htmlspecialchars($_POST["txtInsurance"], ENT_QUOTES));
    $cInsuranceSum  = trim(htmlspecialchars($_POST["txtInsuranceSum"], ENT_QUOTES));

    $sSQL = "Update users Set name = '" . $cName .  "', ".
                             "login = '" . $cLogin . "', ".
        "phone = '" . $cPhone . "', ".
        "email = '" . $cEMail . "', ".
        "sro = '" . $cSRO . "', ".
        "insurance = '" . $cInsurance . "', ".
        "insuranceSum = '" . $cInsuranceSum . "' ".
        " Where id = " . $nIdRecord . " Limit 1";
}else if ($cMode == "INSURANCES") {
    $cNum = trim(htmlspecialchars($_POST["txtNum"], ENT_QUOTES));
    $cName = trim(htmlspecialchars($_POST["txtName"], ENT_QUOTES));
    $cDtStart = trim(htmlspecialchars($_POST["txtDtStart"], ENT_QUOTES));
    $cDtFinish = trim(htmlspecialchars($_POST["txtDtFinish"], ENT_QUOTES));
    $cSum = trim(htmlspecialchars($_POST["txtSum"], ENT_QUOTES));

    $sSQL = "Update insurances Set  num = '$cNum', name = '$cName', dt_start = '$cDtStart', dt_finish = '$cDtFinish', sum = '$cSum' Where id = " . $nIdRecord . " Limit 1";
}

echo $sSQL;

if (!mysqli_query($link, $sSQL)) echo mysqli_error();

