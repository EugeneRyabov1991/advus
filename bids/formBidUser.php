<?php
//---------------------------------------------------------------------------------------------------------------------
//
//  Генерируем HTML-разметку формы редактирования позиции в базе заявок
//  Вызов из: INDEX.JSP
//
//---------------------------------------------------------------------------------------------------------------------
//   @Author: E. Ryabov
//   @Date:   11.09.18
//---------------------------------------------------------------------------------------------------------------------

include("../db_connect.php");

$cIdUser = $_POST["gnCurrentUserId"];  /** @var INTEGER $cIdUser */
$nIdRecord = $_POST["id_record"];      /** @var INTEGER  $nIdRecord */
?>

<div id="pnlBidUserEdit">
  <FORM NAME='frmRecordEdit' ID='frmRecordEdit' role="form" METHOD='POST'>
    <INPUT ID='txtRecordId' NAME='txtRecordId' type='hidden' Value='<?php echo $nIdRecord; ?>'>
      <table class="table table-bordered table-hover table-striped">
          <tr id='trSpraHeader'><th class='col-lg-3'>ФИО</th><th class='col-lg-3'>Роль</th>

<?php


  $sBidUsersSQL = "Select * FROM bid_user Where id_bid = ".$nIdRecord;

  $crsBidUsersDB = mysqli_query($link, $sBidUsersSQL);
  $crsBidUsers   =  $crsBidUsersDB->fetch_all(MYSQLI_ASSOC);

  $sUsersSQL = "Select * FROM users ";

  $crsUsers = mysqli_query($link, $sUsersSQL);
  while ($rowUser = mysqli_fetch_array($crsUsers)){
      $nId = $rowUser['id'];
      $cName = $rowUser['name'];
      $nRole = 0;
      foreach ($crsBidUsers As $rowBidUser){
          if ($rowBidUser['id_user'] == $nId){
              $nRole = $rowBidUser['role'];
          }
      }

      echo "<tr id='trRecord$nId'><td id='tdName$nId'>$cName</td><td id='tdRole$nId'>";
      echo '    <select class="form-control ctrlFormBidUser" name="cmbBidRole'.$nId.'" id="cmbBidRole'.$nId.'">';
      echo '      <option id="optRole0" Value="0" '.($nRole == 0 ? "SELECTED" : "").'>Не задействован</option>';
      echo '      <option id="optRole1" Value="1" '.($nRole == 1 ? "SELECTED" : "").'>Исполнитель</option>';
      echo '      <option id="optRole3" Value="2" '.($nRole == 2 ? "SELECTED" : "").'>Ответственный</option>';
      echo '      <option id="optRole2" Value="3" '.($nRole == 3 ? "SELECTED" : "").'>Подписант</option>';
      echo '    </select>';

      echo "</td></tr>";
  }
?>

    </table>
  </form>
</div>
