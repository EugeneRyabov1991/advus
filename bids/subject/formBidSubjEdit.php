<<<<<<< HEAD
<?php
//---------------------------------------------------------------------------------------------------------------------
//
//  Генерируем HTML-разметку формы редактирования позиции в составе договора
//  Вызов из: INDEX.JSP
//
//---------------------------------------------------------------------------------------------------------------------
//   @Author: E. Ryabov
//   @Date:   14.03.2022
//---------------------------------------------------------------------------------------------------------------------

include("../../db_connect.php");

$cIdUser = $_POST["gnCurrentUserId"];  /** @var INTEGER $cIdUser */
$nIdRecord = $_POST["id_record"];      /** @var INTEGER  $nIdRecord */
?>

<div id="pnlSpraEdit">
  <FORM NAME='frmRecordEdit' ID='frmRecordEdit' role="form" METHOD='POST'>
    <INPUT ID='txtBidSubjId' NAME='txtBidSubjId' type='hidden' Value='<?php echo $nIdRecord; ?>'>

<?php
  $sSQL = "Select * FROM bid_subj Where bid_subj.id = ".$nIdRecord." Limit 1";

  $crsBidSubj = mysqli_query($link, $sSQL);
  if ($rowBidSubj = mysqli_fetch_array($crsBidSubj)){
    $сNum   = $rowBidSubj['num'];
    $cName  = htmlspecialchars_decode($rowBidSubj['name']);

    echo '<div class="form-group">';
    echo '  <div class="col-sm-4"><label class="control-label" for="txtBidSubjNum">Номер:</label></div>';
    echo '  <div class="col-sm-8">
              <input class="form-control ctrlFormBidSubj" name="txtBidSubjNum" id="txtBidSubjNum" type="text" value="'.$сNum.'">             
            </div>';
    echo '</div>';

    echo '<div class="form-group">';
    echo '  <div class="col-sm-4"><label class="control-label" for="txtBidSubjName">Назвение:</label></div>';
    echo '  <div class="col-sm-8">
              <input class="form-control ctrlFormBidSubj" name="txtBidSubjName" id="txtBidSubjName" type="text" value="'.$cName.'">             
            </div>';
    echo '</div>';

  }
?>

  </form>
</div>
=======
<?php
//---------------------------------------------------------------------------------------------------------------------
//
//  Генерируем HTML-разметку формы редактирования позиции в составе договора
//  Вызов из: INDEX.JSP
//
//---------------------------------------------------------------------------------------------------------------------
//   @Author: E. Ryabov
//   @Date:   14.03.2022
//---------------------------------------------------------------------------------------------------------------------

include("../../db_connect.php");

$cIdUser = $_POST["gnCurrentUserId"];  /** @var INTEGER $cIdUser */
$nIdRecord = $_POST["id_record"];      /** @var INTEGER  $nIdRecord */
?>

<div id="pnlSpraEdit">
  <FORM NAME='frmRecordEdit' ID='frmRecordEdit' role="form" METHOD='POST'>
    <INPUT ID='txtBidSubjId' NAME='txtBidSubjId' type='hidden' Value='<?php echo $nIdRecord; ?>'>

<?php
  $sSQL = "Select * FROM bid_subj Where bid_subj.id = ".$nIdRecord." Limit 1";

  $crsBidSubj = mysqli_query($link, $sSQL);
  if ($rowBidSubj = mysqli_fetch_array($crsBidSubj)){
    $сNum   = $rowBidSubj['num'];
    $cName  = htmlspecialchars_decode($rowBidSubj['name']);

    echo '<div class="form-group">';
    echo '  <div class="col-sm-4"><label class="control-label" for="txtBidSubjNum">Номер:</label></div>';
    echo '  <div class="col-sm-8">
              <input class="form-control ctrlFormBidSubj" name="txtBidSubjNum" id="txtBidSubjNum" type="text" value="'.$сNum.'">             
            </div>';
    echo '</div>';

    echo '<div class="form-group">';
    echo '  <div class="col-sm-4"><label class="control-label" for="txtBidSubjName">Назвение:</label></div>';
    echo '  <div class="col-sm-8">
              <input class="form-control ctrlFormBidSubj" name="txtBidSubjName" id="txtBidSubjName" type="text" value="'.$cName.'">             
            </div>';
    echo '</div>';

  }
?>

  </form>
</div>
>>>>>>> ed2c1893eb01616755ba2c46fb5f9eda6325adb1
