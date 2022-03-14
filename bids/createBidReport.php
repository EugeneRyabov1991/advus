<?php

$link = "";

require '../vendor/autoload.php';

require '../num2str.php';

include("../db_connect.php");
include("../tools/UnEncodingStr.php");


$arStatus = array("Не определен", "Зарегистрирован", "В работе", "Согласование расчета", "Проверока отчета", "Архив");
$arPayStatus = array("Нет оплаты", "Внесен аванс", "Оплачен");


$xls = new PHPExcel();
// Устанавливаем индекс активного листа
$xls = PHPExcel_IOFactory::load("../templates/bidList.xls");
$xls->setActiveSheetIndex(0);
$sheet = $xls->getActiveSheet();

$curRow = 2;
$sSQL = "Select * FROM bids Order By num DESC";
$crsBids = mysqli_query($link, $sSQL);
while ($rowBid = mysqli_fetch_array($crsBids)) {
    $nId = $rowBid['id'];
    $cCustName = UnEncodingStr($rowBid['custName']);
    $nNum = $rowBid['num'];
    $nPrice = $rowBid['price'];
    $nPrice = ($nPrice == null ? 0 : $nPrice);

    $cDt = $rowBid['dt'];
    $nStatus = $rowBid['status'];
    $nPayStatus = $rowBid['payStatus'];
    $cDtAct = $rowBid['dtAct'];
    $cDtContract = $rowBid['dtContract'];
    $payStatusClass = (($nPayStatus == 0) ? "danger" : (($nPayStatus == 1) ? "warning" : (($nPayStatus == 2) ? "success" : "default")));


    $nStatus = ($nStatus == null ? 0 : $nStatus);
    $cStatus = $arStatus[$nStatus];

    $nIdManager = $rowBid['id_manager'];
    $nIdSign = $rowBid['id_sign'];
    $cManager = "Не назначен";
    $cSign = "Не назначен";
    $sUserSQL = "Select * FROM users Order By id DESC";
    $crsUsers = mysqli_query($link, $sUserSQL);
    while ($rowUser = mysqli_fetch_array($crsUsers)) {
        $nUserId = $rowUser["id"];
        if ($nUserId == $nIdManager) $cManager = $rowUser["name"];
    }

    $sheet->setCellValueByColumnAndRow(0, $curRow, $nNum);
    $sheet->setCellValueByColumnAndRow(1, $curRow, $cDt);
    $sheet->setCellValueByColumnAndRow(2, $curRow, $cCustName);
    $sheet->setCellValueByColumnAndRow(3, $curRow, $cManager);
    $sheet->setCellValueByColumnAndRow(4, $curRow, $cStatus);
    $sheet->setCellValueByColumnAndRow(5, $curRow, $cDtAct);
    $sheet->setCellValueByColumnAndRow(6, $curRow, $cDtContract);

    $curRow++;
}

//Выводим HTTP-заголовки
header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=bidReport.xls");

//Выводим содержимое файла
$objWriter = new PHPExcel_Writer_Excel5($xls);
try {
    $objWriter->save('php://output');
} catch (PHPExcel_Writer_Exception $e) {
}

