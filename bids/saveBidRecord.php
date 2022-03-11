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

$nId   = $_POST["id_record"];
$nStatus   = $_POST["cmbStatus"];
if ($nStatus == "") $nStatus = 0;
$nSubjType   = $_POST["cmbSubjType"];
if ($nSubjType == "") $nSubjType = 0;

$cNum   = trim(htmlspecialchars($_POST["txtBidCode"], ENT_QUOTES));
if ($cNum == "") $cNum = 0;

$cDtBid  = trim(htmlspecialchars($_POST["txtBidDate"], ENT_QUOTES));
$cCustName  = trim(htmlspecialchars($_POST["txtCustName"], ENT_QUOTES));
$cCustFullName  = trim(htmlspecialchars($_POST["txtCustFullName"], ENT_QUOTES));
$cCustAddress  = trim(htmlspecialchars($_POST["txtCustAddress"], ENT_QUOTES));
$cCustINN   = $_POST["txtCustINN"];
$cCustKPP   = $_POST["txtCustKPP"];
$cCustOGRN   = $_POST["txtCustOGRN"];
$cCustBIK  = $_POST["txtCustBIK"];
$cCustINN   = $_POST["txtCustINN"];
$cCustRS  = trim(htmlspecialchars($_POST["txtCustRS"], ENT_QUOTES));
$cCustKS  = trim(htmlspecialchars($_POST["txtCustKS"], ENT_QUOTES));
$cCustBank  = trim(htmlspecialchars($_POST["txtCustBank"], ENT_QUOTES));
$cCustBoss  = trim(htmlspecialchars($_POST["txtCustBoss"], ENT_QUOTES));
$cCustBossFullName  = trim(htmlspecialchars($_POST["txtCustBossFullName"], ENT_QUOTES));

$cCustDocType = trim(htmlspecialchars($_POST["txtCustDocType"], ENT_QUOTES));
$cSubjName = trim(htmlspecialchars($_POST["txtSubjName"], ENT_QUOTES));

$nPrice = $_POST["txtBidPrice"];
if ($nPrice == "") $nPrice = 0;
$nPrepaid = $_POST["txtBidPrepaid"];
if ($nPrepaid == "") $nPrepaid = 0;

$nEstimateDt = $_POST["txtEstimateDt"];
if ($nEstimateDt == "") $nEstimateDt = 0;
$nEstimatePaid = $_POST["txtEstimatePaid"];
if ($nEstimatePaid == "") $nEstimatePaid = 0;

$nIdInsurance   = $_POST["cmbInsurance"];
if ($nIdInsurance == "") $nIdInsurance = 0;

$nIdFirm   = $_POST["cmbFirm"];
if ($nIdFirm == "") $nIdFirm = 0;


$nIdType   = $_POST["cmbType"];
if ($nIdType == "") $nIdType = 0;

$nPayStatus   = $_POST["cmbPayStatus"];
if ($nPayStatus == "") $nPayStatus = 0;

$nManager   = $_POST["cmbManager"];
if ($nManager == "") $nManager = 0;

$nSign   = $_POST["cmbSign"];
if ($nSign == "") $nSign = 0;

$cNumDog   = $_POST["txtNumDog"];

$cDtAct  = trim(htmlspecialchars($_POST["txtDtAct"], ENT_QUOTES));
$cDtContract  = trim(htmlspecialchars($_POST["txtDtContract"], ENT_QUOTES));
$cDtDone  = trim(htmlspecialchars($_POST["txtDtDone"], ENT_QUOTES));


$sSQL = "Update bids Set num = '".$cNum."', price = ".$nPrice.",  prepaid = ".$nPrepaid.", estimateDt = ".$nEstimateDt.
                      ", estimatePaid = ".$nEstimatePaid.", custName = '".$cCustName."', custFullName = '".$cCustFullName."', custAddress = '".$cCustAddress.
                     "', custINN = '".$cCustINN."', custKPP = '".$cCustKPP."', custOGRN = '".$cCustOGRN."', dt = '".$cDtBid."', dtDone = '".$cDtDone."', dtAct = '".$cDtAct."', dtContract = '".$cDtContract.
                     "', custBIK = '".$cCustBIK."', custRS = '".$cCustRS."', custKS = '".$cCustKS."', custBank = '".$cCustBank."', custBoss = '".$cCustBoss."', custBossFullName = '".$cCustBossFullName.
                     "', custDocType ='".$cCustDocType."', comments ='".$cSubjName."', num_dog ='".$cNumDog."', status  = ".$nStatus.", subjType  = ".$nSubjType.
                     ", id_insurance = ".$nIdInsurance.", id_firm = ".$nIdFirm.", id_manager = ".$nManager.", id_sign = ".$nSign.", payStatus = ".$nPayStatus.", id_type = ".$nIdType." Where id = ".$nId." Limit 1";

if (!mysqli_query($link, $sSQL)) echo mysqli_error();

echo $sSQL;
