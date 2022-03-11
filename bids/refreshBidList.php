<?php
/*---------------------------------------------------------------------------------------------------------------------
//
//  Генерируем HTML-разметку списка договоров
//
//---------------------------------------------------------------------------------------------------------------------
//   @Author: E. Ryabov
//   Date:   17.11.2021
---------------------------------------------------------------------------------------------------------------------*/

include("../db_connect.php");

$cIdUser = $_POST["gnCurrentUserId"];

?>
<table class="table table-bordered table-hover table-striped">

<?php

 $sSQL = "Select * FROM bids Order By id DESC";

$arStatus = array ("Не определен", "Зарегистрирован", "В работе", "Согласование расчета", "Проверока отчета", "Сдан", "Архив");

$arPayStatus = array ("Нет оплаты", "Внесен аванс", "Оплачен");


echo "<tr id='trBidHeader'><th>№</th><th>Дата</th><th>Клиент</th><th>Цена</th><th>Команда</th><th>Статус</th><th>&nbsp;</th>";

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
      if ($nUserId == $nIdSign) $cSign = $rowUser["name"];
    }

    echo "<tr id='trRecord$nId'><td id='tdBidNum$nId'>$nNum</td>
                                <td id='tdBidDt$nId'>$cDt</td>
                                <td id='tdCustName$nId'>$cCustName</td>
                                <td id='tdBidPrice$nId'>$nPrice <span class='label label-$payStatusClass'>(".$arPayStatus[$nPayStatus].")</span></td>
                                <td id='tdUsers$nId'>Менеджер: $cManager<br/>Подписант: $cSign</td>
                                <td id='tdBidStatus$nId'>$cStatus</span></td>".
            "<td nowrap>" .
            "<a class='marginR10 btn btn-primary btn-sm' role='button' title='Редактировать...' onClick='showBidEditForm($nId);'><i class='fa fa-lg fa-edit'></i></a>" .
            "<a class='marginR10 btn btn-primary btn-sm' role='button' title='Предмет договора...' onClick='BidDetails($nId);'><i class='fa fa-lg fa-file'></i></a>" .
            "<a class='marginR10 btn btn-primary btn-sm' role='button' title='Сотрудники...' onClick='BidUsersForm($nId);'><i class='fa fa-lg fa-users'></i></a>" .
            "<a class='marginR10 btn btn-primary btn-sm' role='button' title='Удалить...' onClick='DeleteBidRecord($nId);'><i class='fa fa-lg fa-trash-o'></i></a>".
            "</td></tr>";
  }

?>
</table>

