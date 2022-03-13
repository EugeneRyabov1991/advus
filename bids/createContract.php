<?php

require '../vendor/autoload.php';

require '../num2str.php';

include("../db_connect.php");
include("../tools/CMakeRTF.php");
include("../tools/UnEncodingStr.php");

function CreateUserTable($link_, $nIdBid_){
    $oReport = new CMakeRTF();
    $oReport->BeginTable();
    $oReport->setColumnsCount(3);
    $oReport->m_arTblWidths[1] = CMakeRTF::Twips(6);
    $oReport->m_arTblWidths[2] = CMakeRTF::Twips(6);
    $oReport->m_arTblWidths[3] = CMakeRTF::Twips(6);
    $oReport->m_arTblBorders[1] = "dsds";
    $oReport->m_arTblBorders[2] = "ssds";
    $oReport->m_arTblBorders[3] = "sdds";
    $oReport->SetupFlexColumns(0);
    $oReport->m_arTblAlign[1] = CMakeRTF::$raCenter;
    $oReport->m_arTblAlign[2] = CMakeRTF::$raCenter;
    $oReport->m_arTblAlign[3] = CMakeRTF::$raCenter;

    $oReport->m_arTblValues[1] = "Ф.И.О. оценщика";
    $oReport->m_arTblValues[2] = "СРО";
    $oReport->m_arTblValues[3] = "Страховой полис";

    $oReport->m_cStyle = CMakeRTF::$rfsBold;
    $oReport->WriteRow();

    $oReport->m_arTblAlign[3] = CMakeRTF::$raLeft;
    $oReport->m_cStyle = CMakeRTF::$rfsDefault;

    $sSQL = "Select *, bid_user.role as user_role  FROM bid_user
                Inner Join users On users.id = bid_user.id_user
                Where id_bid = ".$nIdBid_;
    $crsUsers = mysqli_query($link_, $sSQL);
    while ($rowUser = mysqli_fetch_array($crsUsers)){
       $nRole = $rowUser["user_role"];
       $nUserId = $rowUser["id_user"];
       if ($nRole > 0) {
           $oReport->m_arTblValues[1] = $rowUser["name"];
           $oReport->m_arTblValues[2] = $rowUser["sro"];
           $oReport->m_arTblValues[3] = "Страховой полис " . $rowUser["insurance"] . ". Лимит ответственности страховщика – " . $rowUser["insuranceSum"] . " рублей.";
           $oReport->WriteRow();
       }
    }
    $oReport->EndTable();

    return $oReport->m_cTextResult;

}


$arMonths = array ("января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря");

$nIdRecord = $_GET["id_record"];      /** @var INTEGER  $nIdRecord */


$sSQL = "Select * FROM bids
           Left Join bid_details On bids.id = bid_details.id_bid 
           Where bids.id = ".$nIdRecord." Limit 1";

$crsBids = mysqli_query($link, $sSQL);

if ($rowBid = mysqli_fetch_array($crsBids)) {
    // Выбираем страховку
    $InsuranceId =$rowBid["id_insurance"];
    $cInsuranceName = "Рога и копыта";
    $cInsuranceNum  = "000";
    $cInsuranceDtStart = "";
    $cInsuranceDtFinish = "";
    $cInsuranceSum = "";
    $sInsuranceSQL = "Select * FROM insurances Where id = ".$InsuranceId." Limit 1";
    $crsInsurances = mysqli_query($link, $sInsuranceSQL);
    if ($rowInsurance = mysqli_fetch_array($crsInsurances)) {
        $cInsuranceName = $rowInsurance["name"];
        $cInsuranceNum  = $rowInsurance["num"];
        $cInsuranceDtStart = $rowInsurance["dt_start"];
        $cInsuranceDtFinish = $rowInsurance["dt_finish"];
        $cInsuranceSum = $rowInsurance["sum"];
    }

    $nSelfFirmId = $rowBid["id_firm"];

// Выводим HTTP-заголовки
    header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=newact.rtf");

// Выводим содержимое файла
    $hFile = fopen("../templates/contract.rtf", "r") or die("Unable to open file!");
    $cResult = fread($hFile, filesize("../templates/contract.rtf"));

    while (!(strpos($cResult, "@~@") === false)) {
        $nStartPos = strpos($cResult, "@~@");
        $nEndPos = strpos($cResult, "@~@", $nStartPos + 3);
        $cCommandStr = substr($cResult, $nStartPos + 3, $nEndPos - $nStartPos - 3);

        // Вычисляем значение "макроса" и подставляем его в шаблон
        $cCommandResult = $cCommandStr;
        // Скрипты
        if ($cCommandStr === "SelfFirmName") {
            if ($nSelfFirmId == 1) {
                $cCommandResult = "Общество с ограниченной ответственностью «АДВУС-НЕВА»";
            } else if ($nSelfFirmId == 2) {
                $cCommandResult = "Общество с ограниченной ответственностью «Городская служба экспертизы и кадастра»";
            } else if ($nSelfFirmId == 3) {
                $cCommandResult = "Некоммерческое партнерство «Деловой Союз Судебных Экспертов»";
            }
        }else if ($cCommandStr === "SelfFirmShortName") {
            if ($nSelfFirmId == 1) {
                $cCommandResult = "ООО «АДВУС-НЕВА»";
            }else if ($nSelfFirmId == 2) {
                $cCommandResult = "ООО «ГСЭК»";
            }else if ($nSelfFirmId == 3) {
                $cCommandResult = "НП «ДСЭК»";
            }
        }else if ($cCommandStr === "SelfFirmBossFullName") {
            if ($nSelfFirmId == 1) {
                $cCommandResult = "Фаттахова Марата Джавдатовича";
            }else if ($nSelfFirmId == 2) {
                $cCommandResult = "Киричок Светланы Александровны";
            }else if ($nSelfFirmId == 3) {
                $cCommandResult = "Ворончихина Демиана Валерьевича";
            }
        }else if ($cCommandStr === "SelfFirmBoss") {
            if ($nSelfFirmId == 1) {
                $cCommandResult = "М.Д. Фаттахов";
            }else if ($nSelfFirmId == 2) {
                $cCommandResult = "С.А. Киричок";
            }else if ($nSelfFirmId == 3) {
                $cCommandResult = "Д.В. Ворончихин";
            }
        }else if ($cCommandStr === "SelfFirmINN") {
            if ($nSelfFirmId == 1) {
                $cCommandResult = "7825470497";
            }else if ($nSelfFirmId == 2) {
                $cCommandResult = "7804518162";
            }else if ($nSelfFirmId == 3) {
                $cCommandResult = "7706470931";
            }
        }else if ($cCommandStr === "SelfFirmKPP") {
            if ($nSelfFirmId == 1) {
                $cCommandResult = "784001001";
            }else if ($nSelfFirmId == 2) {
                $cCommandResult = "770943002";
            }else if ($nSelfFirmId == 3) {
                $cCommandResult = "770601001";
            }
        }else if ($cCommandStr === "SelfFirmAddrJ") {
            if ($nSelfFirmId == 1) {
                $cCommandResult = "191023, г. Санкт-Петербург, улица Садовая, дом 28-30, корпус 4, пом.11-Н";
            }else if ($nSelfFirmId == 2) {
                $cCommandResult = "191014, г. Санкт-Петербург, Ковенский пер, дом 22-24, литера А, 6Н, офис 2";
            }else if ($nSelfFirmId == 3) {
                $cCommandResult = "119049, г. Москва, ул. Мытная, дом 28, строение 3";
            }
        }else if ($cCommandStr === "SelfFirmAddr") {
            if ($nSelfFirmId == 1) {
                $cCommandResult = "191014, г. Санкт-Петербург, ул. Радищева д.12, оф.14";
            }else if ($nSelfFirmId == 2) {
                $cCommandResult = "191014, г. Санкт-Петербург, Ковенский пер, дом 22-24, литера А, 6Н, офис 2";
            }else if ($nSelfFirmId == 3) {
                $cCommandResult = "191014, г. Санкт-Петербург, ул. Радищева, д.12";
            }
        }else if ($cCommandStr === "SelfFirmRS") {
            if ($nSelfFirmId == 1) {
                $cCommandResult = "40702810706000024587";
            }else if ($nSelfFirmId == 2) {
                $cCommandResult = "40702810103260013031";
            }else if ($nSelfFirmId == 3) {
                $cCommandResult = "40703810900000000322";
            }
        }else if ($cCommandStr === "SelfFirmBank") {
            if ($nSelfFirmId == 1) {
                $cCommandResult = "Санкт-Петербургском филиале ПАО «ПРОМСВЯЗЬБАНК»";
            }else if ($nSelfFirmId == 2) {
                $cCommandResult = "Филиале «Центральный» Банка ВТБ (ПАО) в г. Москве";
            }else if ($nSelfFirmId == 3) {
                $cCommandResult = "в ПАО «Промсвязьбанк» г. Москва";
            }
        }else if ($cCommandStr === "SelfFirmKS") {
            if ($nSelfFirmId == 1) {
                $cCommandResult = "30101810000000000920";
            }else if ($nSelfFirmId == 2) {
                $cCommandResult = "30101810145250000411";
            }else if ($nSelfFirmId == 3) {
                $cCommandResult = "30101810400000000555";
            }
        }else if ($cCommandStr === "SelfFirmBIK") {
            if ($nSelfFirmId == 1) {
                $cCommandResult = "044030920";
            }else if ($nSelfFirmId == 2) {
                $cCommandResult = "044525411";
            }else if ($nSelfFirmId == 3) {
                $cCommandResult = "044525555";
            }
        }else if ($cCommandStr === "SelfFirmOGRN") {
            if ($nSelfFirmId == 1) {
                $cCommandResult = "1037843076424 от 11.02.2003 г.";
            }else if ($nSelfFirmId == 2) {
                $cCommandResult = "1137847408016 от 24.11.2013";
            }else if ($nSelfFirmId == 3) {
                $cCommandResult = "1137799002582 от 08.02.2013 г.";
            }
        }else if ($cCommandStr === "NumDog") {
            $cCommandResult = $rowBid["num"];
        }else if ($cCommandStr === "CustName") {
            $cCommandResult = UnEncodingStr($rowBid["custName"]);
        }else if ($cCommandStr === "CustBoss") {
            $cCommandResult = UnEncodingStr($rowBid["custBoss"]);
        }else if ($cCommandStr === "CustINN") {
            $cCommandResult = $rowBid["custINN"];
        }else if ($cCommandStr === "CustKPP") {
            $cCommandResult = $rowBid["custKPP"];
        }else if ($cCommandStr === "CustAddress") {
            $cCommandResult = UnEncodingStr($rowBid["custAddress"]);
        }else if ($cCommandStr === "CustRS") {
            $cCommandResult = $rowBid["custRS"];
        }else if ($cCommandStr === "CustKS") {
            $cCommandResult = $rowBid["custKS"];
        }else if ($cCommandStr === "CustBIK") {
            $cCommandResult = $rowBid["custBIK"];
        }else if ($cCommandStr === "CustOGRN") {
            $cCommandResult = $rowBid["custOGRN"];
        }else if ($cCommandStr === "CustBank") {
            $cCommandResult = UnEncodingStr($rowBid["custBank"]);
        }else if ($cCommandStr === "CustBossFullName") {
            $cCommandResult = UnEncodingStr($rowBid["custBossFullName"]);
        }else if ($cCommandStr === "CustTypeDoc") {
            $cCommandResult = UnEncodingStr($rowBid["custDocType"]);
        }else if ($cCommandStr === "BD_P21") {
            $cCommandResult = UnEncodingStr($rowBid["p21"]);
        }else if ($cCommandStr === "BD_P22") {
            $cCommandResult = UnEncodingStr($rowBid["p22"]);
        }else if ($cCommandStr === "BD_P3") {
            $cCommandResult = UnEncodingStr($rowBid["p3"]);
        }else if ($cCommandStr === "BD_P4") {
            $cCommandResult = UnEncodingStr($rowBid["p4"]);
        }else if ($cCommandStr === "BD_P5") {
            $cCommandResult = UnEncodingStr($rowBid["p5"]);
        }else if ($cCommandStr === "BD_P6") {
            $cCommandResult = UnEncodingStr($rowBid["p6"]);
        }else if ($cCommandStr === "BD_P9") {
            $cCommandResult = UnEncodingStr($rowBid["p9"]);
        }else if ($cCommandStr === "BD_BLOCK8") {
            $cCommandResult = "Какие-то дополнительные документы!!!!!";  // ToDo ...
        }else if ($cCommandStr === "BD_BLOCK8_LASTNUM") {
            $cCommandResult = "8.x";                                     // ToDo ...
        }else if ($cCommandStr === "SubjName") {
            $cCommandResult = UnEncodingStr($rowBid["subject"]);
        }else if ($cCommandStr === "SubjDetails") {
            $cCommandResult = "Какой-то список объектов!!!!!";           // ToDo ...


        }else if ($cCommandStr === "ContractDate") {
            $сDate = $rowBid["dt"];
            $nMonth = substr($сDate, 3, 2);
            $cMonth = "";
            if ($nMonth > 0) $cMonth = $arMonths[$nMonth-1];
            $сDate = substr($сDate, 0, 2)." ".$cMonth." ".substr($сDate, 6, 4);
            $cCommandResult = $сDate;
        }else if ($cCommandStr === "InsuranceText") {
            $cCommandResult = "Деятельность Исполнителя, связанная с оценкой, производимой на территории Российской Федерации, застрахована в ".
                              UnEncodingStr($cInsuranceName).
                              ", полис страхования профессиональной ответственности юридического лица при осуществлении оценочной деятельности ".
                              UnEncodingStr($cInsuranceNum).
                              ", Период страхования с ".$cInsuranceDtStart." г. по ".$cInsuranceDtFinish." г. Страховая сумма — ".$cInsuranceSum." рублей.";
        }else if ($cCommandStr === "ReportName") {
            $сDate = substr($rowBid["report_date"], 8, 2)." ".substr($rowBid["report_date"], 5, 2)." ".substr($rowBid["report_date"], 0, 4);
            $cCommandResult = $rowBid["report_num"]." от ".$сDate;
        }else if ($cCommandStr === "BidPrice") {
            $cCommandResult = $rowBid["price"]."  (".num2str($rowBid["price"]).") руб. 00 копеек ";
        }else if ($cCommandStr === "Prepaid") {
            $cCommandResult = $rowBid["prepaid"]."  (".num2str($rowBid["prepaid"]).") руб. 00 копеек ";
        }else if ($cCommandStr === "Remainder") {
            $nRemainder = $rowBid["price"] - $rowBid["prepaid"];
            $cCommandResult = $nRemainder."  (".num2str($nRemainder).") руб. 00 копеек ";
        }else if ($cCommandStr === "EstimatePaid") {
            $cCommandResult = $rowBid["estimatePaid"];
        }else if ($cCommandStr === "EstimatePaidText") {
            $cCommandResult = num2str($rowBid["estimatePaid"]);
        }else if ($cCommandStr === "EstimateDt") {
            $cCommandResult = $rowBid["estimateDt"];
        }else if ($cCommandStr === "EstimateDtText") {
            $cCommandResult = num2str($rowBid["estimateDt"]);
        }else if ($cCommandStr === "UserList") {
            $cCommandResult = CreateUserTable($link, $nIdRecord);
        }else if ($cCommandStr === "CurDate") {
            $nYear = date('Y');
            $nMonth = date('m');
            $nDay = date('d');
            $cCommandResult = $nDay." ".$arMonths[$nMonth]." ".$nYear. " г.";

        }
        $cResult = substr($cResult, 0, $nStartPos) . iconv("UTF-8", "Windows-1251", $cCommandResult) . substr($cResult, $nEndPos+3);
    }

    echo $cResult;
    fclose($hFile);

}

