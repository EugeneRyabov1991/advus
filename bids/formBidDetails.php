<?php
//---------------------------------------------------------------------------------------------------------------------
//
//  Генерируем HTML-разметку формы редактирования содержания заявки и позиций в ней...
//  Вызов из: INDEX.JSP
//
//---------------------------------------------------------------------------------------------------------------------
//   @Author: E. Ryabov
//   @Date:   01.12.2021
//---------------------------------------------------------------------------------------------------------------------

include("../db_connect.php");

$cIdUser = $_POST["gnCurrentUserId"];  /** @var INTEGER $cIdUser */
$nIdRecord = $_POST["id_record"];      /** @var INTEGER  $nIdRecord */
?>

<div id="pnlSpraEdit">
  <FORM NAME='frmRecordEdit' ID='frmRecordEdit' role="form" METHOD='POST'>
    <INPUT ID='txtRecordId' NAME='txtRecordId' type='hidden' Value='<?php echo $nIdRecord; ?>'>

<?php
  $sSQL = "Select bid_details.* FROM bid_details Where bid_details.id_bid = ".$nIdRecord." Limit 1";

  $crsBidDetails = mysqli_query($link, $sSQL);
  if (!$rowBid = mysqli_fetch_array($crsBidDetails)) {
      $sInsertSQL = "INSERT INTO bid_details (id_bid, subject, p21, p22, p3, p4, p5, p6, p9) Values (".$nIdRecord.", '', 'право собственности', 'право собственности', 'определение рыночной стоимости объектов оценки', 'для принятия решения о цене сделки купли-продажи', 'рыночная', 'на дату проведения осмотра', 'устанавливается в соответствии с договором на оценку')";
      if (!mysqli_query($link, $sInsertSQL)) echo mysqli_error($link);
      $crsBidDetails = mysqli_query($link, $sSQL);
  }

  $nId   = $nIdRecord;
  $cSubject   = htmlspecialchars_decode($rowBid['subject']);
  $cP21   = htmlspecialchars_decode($rowBid['p21']);
  $cP22   = htmlspecialchars_decode($rowBid['p22']);
  $cP3    = htmlspecialchars_decode($rowBid['p3']);
  $cP4    = htmlspecialchars_decode($rowBid['p4']);
  $cP5    = htmlspecialchars_decode($rowBid['p5']);
  $cP6    = htmlspecialchars_decode($rowBid['p6']);
  $cP9    = htmlspecialchars_decode($rowBid['p9']);

    echo '<div class="form-group">';
    echo '  <div class="col-sm-4"><label class="control-label" for="txtBidSubject">Объект оценки:</label></div>';
    echo '  <div class="col-sm-8">
               <input class="form-control ctrlFormBidEdit" name="txtBidSubject" id="txtBidSubject" type="text" value="'.$cSubject.'">
            </div>';
    echo '</div>';

echo '<div class="form-group">';
echo '  <div class="col-sm-4"><label class="control-label" for="txtBidP21">2.1.	Существующие имущественные/вещные права:</label></div>';
echo '  <div class="col-sm-8">
               <input class="form-control ctrlFormBidEdit" name="txtBidP21" id="txtBidP21" type="text" value="'.$cP21.'">
            </div>';
echo '</div>';

echo '<div class="form-group">';
echo '  <div class="col-sm-4"><label class="control-label" for="txtBidP22">2.2. Оцениваемые права :</label></div>';
echo '  <div class="col-sm-8">
               <input class="form-control ctrlFormBidEdit" name="txtBidP22" id="txtBidP22" type="text" value="'.$cP22.'">
            </div>';
echo '</div>';
echo '<div class="form-group">';
echo '  <div class="col-sm-4"><label class="control-label" for="txtBidP3">3. Цель оценки:</label></div>';
echo '  <div class="col-sm-8">
               <input class="form-control ctrlFormBidEdit" name="txtBidP3" id="txtBidP3" type="text" value="'.$cP3.'">
            </div>';
echo '</div>';
echo '<div class="form-group">';
echo '  <div class="col-sm-4"><label class="control-label" for="txtBidP4">4. Предполагаемое использование результатов оценки:</label></div>';
echo '  <div class="col-sm-8">
               <input class="form-control ctrlFormBidEdit" name="txtBidP4" id="txtBidP4" type="text" value="'.$cP4.'">
            </div>';
echo '</div>';
echo '<div class="form-group">';
echo '  <div class="col-sm-4"><label class="control-label" for="txtBidP5">5. Вид стоимости :</label></div>';
echo '  <div class="col-sm-8">
               <input class="form-control ctrlFormBidEdit" name="txtBidP5" id="txtBidP5" type="text" value="'.$cP5.'">
            </div>';
echo '</div>';
echo '<div class="form-group">';
echo '  <div class="col-sm-4"><label class="control-label" for="txtBidP6">6. Дата проведения оценки:</label></div>';
echo '  <div class="col-sm-8">
               <input class="form-control ctrlFormBidEdit" name="txtBidP6" id="txtBidP6" type="text" value="'.$cP6.'">
            </div>';
echo '</div>';

$nFSOO7 = $rowBid['fso7'];
$nFSOO8 = $rowBid['fso8'];
$nFSOO9 = $rowBid['fso9'];
$nFSO10 = $rowBid['fso10'];
$nFSO11 = $rowBid['fso11'];
$nFSO12 = $rowBid['fso12'];
$nFSO13 = $rowBid['fso13'];
$cFSO07 = ($nFSOO7==1 ? "CHECKED" : "");
$cFSO08 = ($nFSOO8==1 ? "CHECKED" : "");
$cFSO09 = ($nFSOO9==1 ? "CHECKED" : "");
$cFSO10 = ($nFSO10==1 ? "CHECKED" : "");
$cFSO11 = ($nFSO11==1 ? "CHECKED" : "");
$cFSO12 = ($nFSO12==1 ? "CHECKED" : "");
$cFSO13 = ($nFSO13==1 ? "CHECKED" : "");

echo '<div class="form-group">';
echo '  <div class="col-sm-1"><INPUT TYPE="checkbox" class="ctrlFormBidCheckbox" NAME="chkDoc7" ID="chkDoc7" '.$cFSO07.'/>ФСО № 7</div>';
echo '  <div class="col-sm-1"><INPUT TYPE="checkbox" class="ctrlFormBidCheckbox" NAME="chkDoc8" ID="chkDoc8" '.$cFSO08.'/>ФСО № 8</div>';
echo '  <div class="col-sm-1"><INPUT TYPE="checkbox" class="ctrlFormBidCheckbox" NAME="chkDoc9" ID="chkDoc9" '.$cFSO09.'/>ФСО № 9</div>';
echo '  <div class="col-sm-1"><INPUT TYPE="checkbox" class="ctrlFormBidCheckbox" NAME="chkDoc10" ID="chkDoc10" '.$cFSO10.'/>ФСО № 10</div>';
echo '  <div class="col-sm-1"><INPUT TYPE="checkbox" class="ctrlFormBidCheckbox" NAME="chkDoc11" ID="chkDoc11" '.$cFSO11.'/>ФСО № 11</div>';
echo '  <div class="col-sm-1"><INPUT TYPE="checkbox" class="ctrlFormBidCheckbox" NAME="chkDoc12" ID="chkDoc12" '.$cFSO12.'/>ФСО № 12</div>';
echo '  <div class="col-sm-6"><INPUT TYPE="checkbox" class="ctrlFormBidCheckbox" NAME="chkDoc13" ID="chkDoc13" '.$cFSO13.'/>ФСО № 13</div>';
echo '</div>';

echo '<div class="form-group">';
echo '  <div class="col-sm-4"><label class="control-label" for="txtBidP9">9. Срок проведения оценки :</label></div>';
echo '  <div class="col-sm-8">
               <input class="form-control ctrlFormBidEdit" name="txtBidP9" id="txtBidP9" type="text" value="'.$cP9.'">
            </div>';
echo '</div>';
echo '
                        <div>
                            <button type="button" class="btn btn-primary" id="btnPrintBill" onclick="PrintDoc(\'CONTRACT\')"><i class="fa fa-fw fa-print"></i>Печатать договор</button>
                            <button type="button" class="btn btn-primary"  onclick="SaveBidDetails('.$nIdRecord.')" ><i class="fa fa-fw fa-save"></i>Сохранить</button>
                        </div>';


?>

  </form>
</div>
