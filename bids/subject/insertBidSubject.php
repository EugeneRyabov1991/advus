<<<<<<< HEAD
<?php
/*---------------------------------------------------------------------------------------------------------------------
//
//  Добавляем запись в базу состава заявок
//  Вызов из: js/bid.js
//
//---------------------------------------------------------------------------------------------------------------------
//   @Author: E. Ryabov
//   @Date:   14.03.2022
//---------------------------------------------------------------------------------------------------------------------
*/
include("../../db_connect.php");

  $cIdUser = $_POST["gnCurrentUserId"];
  $cIdBid = $_POST["id_bid"];


  $sSQL = "INSERT INTO bid_subj (num, name, id_bid) Values ('0', 'Новый объект', $cIdBid)";

  if (!mysqli_query($link, $sSQL)) echo mysqli_error($link);
  $nNewId = mysqli_insert_id($link);

echo "<tr id='trRecord$nNewId'><td class='sm' id='tdBidSubjNum$nNewId'>0</td>
                                <td id='tdBidSubjName$nNewId'>Новый объект</td>".
    "<td nowrap>" .
    "<a class='marginR10 btn btn-primary btn-sm' role='button' title='Редактировать...' onClick='showBidSubjEditForm($nNewId);'><i class='fa fa-lg fa-edit'></i></a>" .
    "<a class='marginR10 btn btn-primary btn-sm' role='button' title='Удалить...' onClick='DeleteBidSubj($nNewId);'><i class='fa fa-lg fa-trash-o'></i></a>".
    "</td></tr>";
=======
<?php
/*---------------------------------------------------------------------------------------------------------------------
//
//  Добавляем запись в базу состава заявок
//  Вызов из: js/bid.js
//
//---------------------------------------------------------------------------------------------------------------------
//   @Author: E. Ryabov
//   @Date:   14.03.2022
//---------------------------------------------------------------------------------------------------------------------
*/
include("../../db_connect.php");

  $cIdUser = $_POST["gnCurrentUserId"];
  $cIdBid = $_POST["id_bid"];


  $sSQL = "INSERT INTO bid_subj (num, name, id_bid) Values ('0', 'Новый объект', $cIdBid)";

  if (!mysqli_query($link, $sSQL)) echo mysqli_error($link);
  $nNewId = mysqli_insert_id($link);

echo "<tr id='trRecord$nNewId'><td class='sm' id='tdBidSubjNum$nNewId'>0</td>
                                <td id='tdBidSubjName$nNewId'>Новый объект</td>".
    "<td nowrap>" .
    "<a class='marginR10 btn btn-primary btn-sm' role='button' title='Редактировать...' onClick='showBidSubjEditForm($nNewId);'><i class='fa fa-lg fa-edit'></i></a>" .
    "<a class='marginR10 btn btn-primary btn-sm' role='button' title='Удалить...' onClick='DeleteBidSubj($nNewId);'><i class='fa fa-lg fa-trash-o'></i></a>".
    "</td></tr>";
>>>>>>> ed2c1893eb01616755ba2c46fb5f9eda6325adb1
