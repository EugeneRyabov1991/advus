<?php
/*---------------------------------------------------------------------------------------------------------------------
//
//  Генерируем отчет о ходе работ с договорами
//
//---------------------------------------------------------------------------------------------------------------------
//   @Author: E. Ryabov
//   Date:   20.12.2021
---------------------------------------------------------------------------------------------------------------------*/

include("../db_connect.php");

$cIdUser = $_POST["gnCurrentUserId"];

?>
<table class="table table-bordered table-hover table-striped">

<?php

 $sSQL = "Select * FROM bids Order By num DESC";

$arStatus = array ("Не определен", "Зарегистрирован", "В работе", "Согласование расчета", "Проверока отчета", "Архив");
$arPayStatus = array ("Нет оплаты", "Внесен аванс", "Оплачен");


echo "<tr id='trBidHeader'><th>№</th><th>Дата</th><th>Клиент</th><th>Менеджер</th><th>Статус</th><th>Акт</th><th>Договор</th>";

  $crsBids = mysqli_query($link, $sSQL);
  while ($rowBid = mysqli_fetch_array($crsBids)){
    $nId   = $rowBid['id'];
    $cCustName =  htmlspecialchars_decode($rowBid['custName'], ENT_QUOTES);
    $nNum  =  $rowBid['num'];
    $nPrice  =  $rowBid['price'];
    $nPrice = ($nPrice==null ? 0 : $nPrice);

    $cDt   =  $rowBid['dt'];
    $nStatus   =  $rowBid['status'];
    $nPayStatus   =  $rowBid['payStatus'];
    $cDtAct   =  $rowBid['dtAct'];
    $cDtContract   =  $rowBid['dtContract'];
    $payStatusClass = (($nPayStatus==0) ? "danger": (($nPayStatus==1) ? "warning": (($nPayStatus==2) ? "success": "default" )));


    $nStatus = ($nStatus==null ? 0 : $nStatus);
    $cStatus = $arStatus[$nStatus];

    $nIdManager   =  $rowBid['id_manager'];
    $nIdSign   =  $rowBid['id_sign'];
    $cManager = "Не назначен";
    $cSign = "Не назначен";
    $sUserSQL = "Select * FROM users Order By id DESC";
    $crsUsers = mysqli_query($link, $sUserSQL);
    while ($rowUser = mysqli_fetch_array($crsUsers)){
      $nUserId =  $rowUser["id"];
      if ($nUserId == $nIdManager) $cManager = $rowUser["name"];
    }

    echo "<tr id='trRecord$nId'><td id='tdBidNum$nId'>$nNum</td>
                                <td id='tdBidDt$nId'>$cDt</td>
                                <td id='tdCustName$nId'>$cCustName</td>
                                <td id='tdUsers$nId'> $cManager</td>
                                <td id='tdBidStatus$nId'>$cStatus</td>
                                <td id='tdDtAct$nId'>$cDtAct</td>
                                <td id='tdDtContract$nId'>$cDtContract</td>".
            "</td></tr>";
  }

?>
</table>

