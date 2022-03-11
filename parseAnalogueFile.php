
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="E.Ryabov">

    <title>Прием базы аналогов</title>

</head>

<body>


<?php

require '../vendor/autoload.php';

include("db_connect.php");

$cIdUser = $_POST["gnCurrentUserId"];  /** @var INTEGER $cIdUser */
$nIdRecord = $_POST["id_record"];      /** @var INTEGER  $nIdRecord */

//    $xls = PHPExcel_IOFactory::load("../upload_docs/tmpAnalogue.xlsx");
$xls = PHPExcel_IOFactory::load("../upload_docs/analogue_sample.xls");

    $xls->setActiveSheetIndex(0);
    $sheet = $xls->getActiveSheet();

    //echo "<p>".$sheet->getHighestRow()."</p>";
    echo "<table class='table-bordered table-hover table-striped'>";

    $nColumn = PHPExcel_Cell::columnIndexFromString($sheet->getHighestColumn());

    $dDate = date('Y-m-d');

    for ($i = 1; $i <= $sheet->getHighestRow(); $i++) {
      $cGoodNum = trim(htmlspecialchars($sheet->getCellByColumnAndRow(1, $i)->getValue(), ENT_QUOTES));
      if ($cGoodNum != "") {
        $cGroupId = trim(htmlspecialchars($sheet->getCellByColumnAndRow(0, $i)->getValue(), ENT_QUOTES));
        $cGoodName = trim(htmlspecialchars($sheet->getCellByColumnAndRow(2, $i)->getValue(), ENT_QUOTES));
        $cGoodGOST = trim(htmlspecialchars($sheet->getCellByColumnAndRow(3, $i)->getValue(), ENT_QUOTES));
        $cGoodEdIzm = trim(htmlspecialchars($sheet->getCellByColumnAndRow(4, $i)->getValue(), ENT_QUOTES));
        $cGoodNDS = trim(htmlspecialchars($sheet->getCellByColumnAndRow(5, $i)->getValue(), ENT_QUOTES));
        $cAnaloguePrice = trim(htmlspecialchars($sheet->getCellByColumnAndRow(6, $i)->getValue(), ENT_QUOTES));
        $cAnalogueHTTP = trim(htmlspecialchars($sheet->getCellByColumnAndRow(7, $i)->getValue(), ENT_QUOTES));

        echo "<tr><td> $cGoodName</td><td>";
/*        $sSQL = "Select * From goods Where `name` = '".$cGoodName."'";
        echo $sSQL."<br/>";
        $crsFindGood = mysqli_query($link, $sSQL);
        if ($rowFindGood = mysqli_fetch_array($crsFindGood)){
           $nFoundGoodId = $rowFindGood["id"];
        }else{
           $sSQL = "INSERT INTO goods (name, gost, id_part, id_edizm, nds) Values ('$cGoodName', '$cGoodGOST', $cGroupId, 0, $cGoodNDS)";
           echo $sSQL."<br/>";
           if (!mysql_query($sSQL)) echo mysql_error();
           $nFoundGoodId = mysql_insert_id();
        }

        // Теперь ищем, не было ли раньше в базе такого аналога?
        $sSQL = "Select * From analogue Where id_good=$nFoundGoodId And `http` Like ('".$cAnalogueHTTP."')";
        echo $sSQL."<br/>";
        $crsFindAnalogue = mysql_query($sSQL);
        if ($rowFindAnalogue = mysql_fetch_array($crsFindAnalogue)) {
            echo "Аналог найден!<br/>";

        }else{
          $sSQL = "INSERT INTO analogue (id_reg, id_good, http, price, ed_izm, dt_cr) Values (2, $nFoundGoodId, '$cAnalogueHTTP', $cAnaloguePrice, '$cGoodEdIzm', '$dDate')";
          echo $sSQL."<br/>";
          if (!mysql_query($sSQL)) echo mysql_error();
        }
*/
        echo "</td></tr>";

      }

    }
    echo "</table>";


?>

  </body>
</html>
