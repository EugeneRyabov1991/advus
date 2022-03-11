<?php
/*---------------------------------------------------------------------------------------------------------------------
//
//  Добавляем запись в базу заявок
//  Вызов из: js/bid.js
//
//---------------------------------------------------------------------------------------------------------------------
//   @Author: E. Ryabov
//   @Date:   18.11.2021
//---------------------------------------------------------------------------------------------------------------------
*/
include("../db_connect.php");

  $cIdUser = $_POST["gnCurrentUserId"];

//  $dDate = date('Y-m-d');
  $dDate = date('d.m.Y');

  $sSQL = "INSERT INTO bids (num, custName, status, dt, custDocType) Values ('9999', '!!!Новый заказчик !!!', 0, '$dDate', 'Устава')";

  if (!mysqli_query($link, $sSQL)) echo mysqli_error($link);
  $nId = mysqli_insert_id($link);

  echo "<tr id='trRecord$nId'>
            <td id='tdBidNum$nId'>9999</td>
            <td id='tdBidDt$nId'>$dDate</td>
            <td id='tdCustName$nId'>!!!Новый заказчик !!!</td>
            <td id='tdBidPrice$nId'>0<span class='label label-danger'>(Нет оплаты)</span></td>
            <td id='tdUsers$nId'>Менеджер: Не назначен<br/>Подписант: Не назначен</td>
            <td id='tdStatus$nId'>Не определен</td>".
    "<td nowrap>" .
      "<a class='marginR10 btn btn-primary btn-sm' role='button' title='Редактировать...' onClick='showBidEditForm($nId);'><i class='fa fa-lg fa-edit'></i></a>" .
      "<a class='marginR10 btn btn-primary btn-sm' role='button' title='Предмет договора...' onClick='BidDetails($nId);'><i class='fa fa-lg fa-file'></i></a>" .
      "<a class='marginR10 btn btn-primary btn-sm' role='button' title='Сотрудники...' onClick='BidUsersForm($nId);'><i class='fa fa-lg fa-users'></i></a>" .
      "<a class='marginR10 btn btn-primary btn-sm' role='button' title='Удалить...' onClick='DeleteBidRecord($nId);'><i class='fa fa-lg fa-trash-o'></i></a>".
    "</td></tr>";
